<?php
namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function showUser($id);
     
    public function allUsers();
}