<?php

namespace App\Models;

use App\Models\Account;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Balance extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['date', 'account_id', 'total', 'description', 'reported'];

    protected $searchableFields = ['*'];

    protected $casts = ['date' => 'date'];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
