<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Type;
use App\Models\Assign;
use App\Models\Account;
use App\Models\Cluster;
use App\Models\Expense;
use App\Models\Purpose;
use App\Models\Executed;
use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExpenseStoreRequest;
use App\Http\Requests\ExpenseUpdateRequest;

class EventsController extends Controller
{
    public function events(Request $request) {
        $this->authorize('view-any', Expense::class);

        $user_obj = Auth::user();
        $user_id = $user_obj->id;

        return view('app.expenses.events', compact('user_id'));
    }

    public function dashboard(Request $request) {
        $user_obj = Auth::user();

        // dump($user_obj->isSuperAdmin());
        return view('app.expenses.dashboard');
    }

    public function getEvents(Request $request, $month, $year) {
        $user_obj = Auth::user();

        $results = Expense::orderBy('date', 'DESC')
            ->join('accounts', 'expenses.account_id', '=', 'accounts.id')
            ->join('account_user', 'account_user.account_id', '=', 'accounts.id')
            ->where('account_user.user_id', $user_obj->id)
            ->where('expenses.date', '>=', $year.'-'.($month + 1).'-1')
            ->where('expenses.date', '<=', $year.'-'.($month + 1).'-'.$this->getLastDayByMonth($year, $month))
            ->select('expenses.*')
            ->get();

        $clusters = Cluster::join('account_cluster', 'clusters.id', '=', 'account_cluster.account_id')
            ->join('accounts', 'account_cluster.account_id', '=', 'accounts.id')
            ->join('account_user', 'account_user.account_id', '=', 'accounts.id')
            ->where('account_user.user_id', $user_obj->id)
            ->pluck('clusters.name', 'clusters.id');

        $assigns = Assign::join('account_assign', 'assigns.id', '=', 'account_assign.assign_id')
            ->join('accounts', 'account_assign.account_id', '=', 'accounts.id')
            ->join('account_user', 'account_user.account_id', '=', 'accounts.id')
            ->where('account_user.user_id', $user_obj->id)
            ->pluck('assigns.name', 'assigns.id');

        $purposes = Purpose::join('account_purpose', 'purposes.id', '=', 'account_purpose.purpose_id')
            ->join('accounts', 'account_purpose.account_id', '=', 'accounts.id')
            ->join('account_user', 'account_user.account_id', '=', 'accounts.id')
            ->where('account_user.user_id', $user_obj->id)
            ->pluck('purposes.name', 'purposes.id');
        $types = Type::pluck('name', 'id');

        $accounts = Account::join('account_user', 'account_user.account_id', '=', 'accounts.id')
            ->where('account_user.user_id', $user_obj->id)
            ->pluck('accounts.name', 'accounts.id');

        $events = [];
        foreach ($results as $r) {
            $events['events'][$r->id]['id'] = $r->id;
            $events['events'][$r->id]['date'] = $r->date ? $r->date->format('Y-m-d H:i:s') : '';
            $events['events'][$r->id]['date_to'] = $r->date_to ? $r->date_to->format('Y-m-d H:i:s') : '';
            $events['events'][$r->id]['description'] = $r->description;
            $events['events'][$r->id]['cluster'] = $r->cluster_id;
            $events['events'][$r->id]['assign'] = $r->assign_id;
            $events['events'][$r->id]['account'] = $r->account_id;
            $events['events'][$r->id]['user'] = $r->user_id;
            $events['events'][$r->id]['google_calendar'] = $r->google_id ? true : false;

            if ($r->purposes) {
                foreach($r->purposes as $purpose) {
                    $events['events'][$r->id]['purpose'] = $purpose->color->color;
                    $events['events'][$r->id]['purpose_id'] = $purpose->id;
                }
            } else {
                $events['events'][$r->id]['purpose'] = 'border-blue-200 text-blue-800 bg-blue-100';
            }
            $events['events'][$r->id]['budget'] = $r->budget ?? '';
        }

        $colors = [];
        $purposes_colors = Purpose::get();
        foreach ($purposes_colors as $p) {
            $colors[$p->id] = $p->color->color;
        }

        $events['clusters'] = $clusters;
        $events['assigns'] = $assigns;
        $events['purposes'] = $purposes;
        $events['colors'] = $colors;
        $events['types'] = $types;
        $events['accounts'] = $accounts;

        return json_encode($events);
    }

    public function add(ExpenseStoreRequest $request) {
        $user_obj = Auth::user();
        $request['user_id'] = $user_obj->id;

        $google_id = null;

        if ($request->google_calendar) {
            $cluster = Cluster::where('id', $request->cluster_id)->first();

            $startDate = Carbon::parse($request->date);
            $endDate = $request->date_to ? Carbon::parse($request->date_to) : (clone $startDate)->addHour();
            config(['google-calendar.calendar_id' => Auth::user()->google_calendar_id]);
            $event = new Event;
            $event->name = $request->description;
            $event->startDateTime = $startDate;
            $event->endDateTime = $endDate;
            $event->location = $cluster->name;

            $new_event = $event->save();
            $google_id = $new_event->id;
        }

        $validated = $request->validated();
        $validated['google_id'] = $google_id;
        $expense = Expense::create($validated);

        $expense->purposes()->attach($request->purpose_id, []);

        return json_encode($expense->id);
    }

    public function update(ExpenseUpdateRequest $request, Expense $expense) {
        $user_obj = Auth::user();
        $google_id = $expense->google_id;
        $cluster = Cluster::where('id', $request->cluster_id)->first();

        if ($expense->google_id == null || $expense->google_id == '') {
            if ($request->google_calendar) {
                $startDate = Carbon::parse($request->date);
                $endDate = $request->date_to ? Carbon::parse($request->date_to) : (clone $startDate)->addHour();
                config(['google-calendar.calendar_id' => Auth::user()->google_calendar_id]);
                $event = new Event;
                $event->name = $expense->description;
                $event->startDateTime = $startDate;
                $event->endDateTime = $endDate;
                $event->location = $cluster->name;

                $new_event = $event->save();
                $google_id = $new_event->id;
            }
        } else {
            config(['google-calendar.calendar_id' => Auth::user()->google_calendar_id]);
            $event = Event::find($google_id);

            $startDate = Carbon::parse($request->date);
            $endDate = $request->date_to ? Carbon::parse($request->date_to) : (clone $startDate)->addHour();

            $event->name = $expense->description;
            $event->startDateTime = $startDate;
            $event->endDateTime = $endDate;
            $event->location = $cluster->name;
            $event->save();
        }

        $request['user_id'] = $user_obj->id;

        $validated = $request->validated();
        $validated['google_id'] = $google_id;

        $expense->update($validated);

        $expense->purposes()->sync($request->purpose_id, []);

        return json_encode($expense->id);
    }

    public function delete(Request $request, Expense $expense) {
        if ($expense->google_id) {
            $event = Event::find($expense->google_id);

            $event->delete();
        }

        $expense->delete($request->purpose_id);
        return true;
    }

    private function getLastDayByMonth($year, $month) {
        $date = new \DateTime($year.'-'.($month + 1).'-1');
        $date->modify('last day of this month');
        return $date->format('d');
    }

    public function getExecuteds(Request $request, Expense $expense) {
        $executeds = $expense->executeds()->get();
        return json_encode($executeds);
    }

    public function addExecuteds(Request $request, Expense $expense) {
        $executed = Executed::create(['expense_id' => $expense->id, 'type_id' => $request->type_id, 'cost' => $request->cost, 'description' => $request->description]);
        return json_encode($executed->id);
    }

    public function updateExecuted(Request $request, Executed $executed) {
        $executed->update(['type_id' => $request->type_id, 'cost' => $request->cost, 'description' => $request->description]);
        return json_encode($executed->id);
    }

    public function deleteExecuted(Request $request, Executed $executed) {
        $executed->delete();
        return true;
    }

    public function getAccountDetails(Request $request, Account $account) {
        $events['clusters'] = $account->clusters()->pluck('name', 'id');
        $events['assigns'] = $account->assigns()->pluck('name', 'id');
        $events['purposes'] = $account->purposes()->pluck('name', 'id');

        echo json_encode($events);
    }

    public function getAccounts(Request $request) {
        $user = Auth::user();

        $accounts = Account::join('account_user', 'account_user.account_id', '=', 'accounts.id')
            ->where('account_user.user_id', $user->id)
            ->pluck('accounts.name', 'accounts.id');

        echo json_encode($accounts);
    }
}
