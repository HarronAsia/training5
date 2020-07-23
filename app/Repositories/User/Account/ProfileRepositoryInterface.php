<?php
namespace App\Repositories\User\Account;

interface ProfileRepositoryInterface
{
    public function getProfile($id);

    public function showProfile($id);
}