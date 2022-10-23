<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purpose extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['name', 'code', 'color_id'];

    protected $searchableFields = ['*'];

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function expenses()
    {
        return $this->belongsToMany(Expense::class);
    }

    public function accounts()
    {
        return $this->belongsToMany(Account::class);
    }
}
