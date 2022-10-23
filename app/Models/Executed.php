<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Executed extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['cost', 'description', 'expense_id', 'type_id'];

    protected $searchableFields = ['*'];

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
