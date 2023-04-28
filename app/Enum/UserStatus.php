<?php
namespace App\Enum;


abstract class UserStatus
{
    const Active   = 'active';
    const Inactive = 'inactive';
    const Blocked  = 'blocked';
    const Deleted  = 'deleted';
}
