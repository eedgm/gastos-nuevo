<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\AssignController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\ClusterController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PurposeController;
use App\Http\Controllers\ExecutedController;
use App\Http\Controllers\PermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});

Route::get('/register/user/{email}/{permission}', [UserController::class, 'register'])->name('register');
Route::post('/register/user/{email}/{permission}', [UserController::class, 'newUserInvited'])->name('newUserInvited');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/', [EventsController::class, 'dashboard'])
    ->name('dashboard');

Route::prefix('/')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::post('expenses/search', [ExpenseController::class, 'search'])->name('expenses.search');
        Route::get('gastos', [ExpenseController::class, 'home'])->name('gastos');
        Route::get('events', [EventsController::class, 'events'])->name('events');
        Route::get('events/all/{month}/{year}', [EventsController::class, 'getEvents'])->name('events.all');
        Route::post('events/add', [EventsController::class, 'add'])->name('events.add');
        Route::put('events/update/{expense}', [EventsController::class, 'update'])->name('events.update');
        Route::delete('events/delete/{expense}', [EventsController::class, 'delete'])->name('events.delete');
        Route::get('events/accounts/details/{account}', [EventsController::class, 'getAccountDetails'])->name('events.account_details');
        Route::get('user/accounts', [EventsController::class, 'getAccounts'])->name('events.user_accounts');

        Route::get('events/executeds/{expense}', [EventsController::class, 'getExecuteds'])->name('events.executeds');
        Route::post('events/executeds/add/{expense}', [EventsController::class, 'addExecuteds'])->name('events.addExecuteds');
        Route::put('events/executeds/update/{executed}', [EventsController::class, 'updateExecuted'])->name('events.updateExecuted');
        Route::delete('events/executeds/delete/{executed}', [EventsController::class, 'deleteExecuted'])->name('events.deleteExecuted');

        Route::get('events/list', [EventsController::class, 'list'])->name('events.list');

        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('accounts', AccountController::class);
        Route::resource('assigns', AssignController::class);
        Route::resource('banks', BankController::class);
        Route::resource('clusters', ClusterController::class);
        Route::resource('colors', ColorController::class);
        Route::resource('executeds', ExecutedController::class);
        Route::resource('expenses', ExpenseController::class);
        Route::resource('incomes', IncomeController::class);
        Route::resource('purposes', PurposeController::class);
        Route::resource('types', TypeController::class);
        Route::resource('users', UserController::class);
        Route::resource('balances', BalanceController::class);
    });
