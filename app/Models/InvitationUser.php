<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;

class InvitationUser extends Model
{
    use Searchable;

    protected $fillable = ['email', 'hash', 'view_link', 'user_created'];

    protected $searchableFields = ['*'];
}
