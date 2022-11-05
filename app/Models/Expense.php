<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'date',
        'date_to',
        'description',
        'cluster_id',
        'assign_id',
        'budget',
        'account_id',
        'google_id',
        'balance_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'date' => 'datetime',
        'date_to' => 'date',
    ];

    public function cluster()
    {
        return $this->belongsTo(Cluster::class);
    }

    public function assign()
    {
        return $this->belongsTo(Assign::class);
    }

    public function executeds()
    {
        return $this->hasMany(Executed::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function purposes()
    {
        return $this->belongsToMany(Purpose::class);
    }

    public function balances()
    {
        return $this->belongsToMany(Balance::class);
    }

    public function totalExecuteds()
    {
        return $this->hasMany(Executed::class)
            ->selectRaw('SUM(cost) as total')
            ->groupBy('expense_id');
    }
}
