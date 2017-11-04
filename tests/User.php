<?php

namespace Tests;

use Illuminate\Foundation\Auth\User as BaseUser;
use NickyWoolf\Launch\OwnsShop;

class User extends BaseUser
{
    use OwnsShop;

    protected static $unguarded = true;
}