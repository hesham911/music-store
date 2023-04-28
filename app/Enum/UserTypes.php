<?php
namespace App\Enum;

abstract class UserTypes
{
    const Admin         = 'admin' ;
    const Collaborator  = 'collaborator';
    const Artist        = 'artist';
    const Visitor       = 'visitor';
}
