<?php

namespace Framework\Models;

use Cartalyst\Sentinel\Users\EloquentUser;

class User extends EloquentUser
{
    protected $guarded = ['id'];
}