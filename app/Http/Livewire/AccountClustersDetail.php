<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Account;
use App\Models\Cluster;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AccountClustersDetail extends Component
{
    use AuthorizesRequests;

    public Account $account;
    public Cluster $cluster;
    public $clustersForSelect = [];
    public $cluster_id = null;
    public $cluster_name = null;

    public $showingModal = false;
    public $modalTitle = 'New Cluster';

    protected $rules = [
        'cluster_id' => ['nullable', 'exists:clusters,id'],
        'cluster_name' => ['nullable', 'string'],
    ];

    public function mount(Account $account)
    {
        $this->account = $account;
        $this->clustersForSelect = Cluster::pluck('name', 'id');
        $this->resetClusterData();
    }

    public function resetClusterData()
    {
        $this->cluster = new Cluster();

        $this->cluster_id = null;

        $this->cluster_name = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newCluster()
    {
        $this->modalTitle = trans('crud.account_clusters.new_title');
        $this->resetClusterData();

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        $this->authorize('create', Cluster::class);

        if ($this->cluster_name) {
            $cluster = Cluster::create(['name' => $this->cluster_name]);
            $this->cluster_id = $cluster->id;
        }

        $this->account->clusters()->attach($this->cluster_id, []);

        $this->hideModal();
    }

    public function detach($cluster)
    {
        $this->authorize('delete-any', Cluster::class);

        $this->account->clusters()->detach($cluster);

        $this->resetClusterData();
    }

    public function render()
    {
        return view('livewire.account-clusters-detail', [
            'accountClusters' => $this->account
                ->clusters()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
