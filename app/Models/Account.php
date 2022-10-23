<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'number',
        'type',
        'owner',
        'bank_id',
    ];

    protected $searchableFields = ['*'];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function assigns()
    {
        return $this->belongsToMany(Assign::class);
    }

    public function clusters()
    {
        return $this->belongsToMany(Cluster::class);
    }

    public function purposes()
    {
        return $this->belongsToMany(Purpose::class);
    }
}
