<?php
namespace App\Repositories\Admin;

use App\Http\Requests\StoreAdmin;

interface AdminRepositoryInterface
{
    //Count//
    public function countAllUsers();
    public function countAllManagers();
    public function countAllAdmins();
    public function countAllThreadsByManager();
    public function countAllThreadsByAdmin();

    //Count//


    //*===============For User=============================*//
    public function getAllUsers();
    //*===============For User=============================*//

    //*===============For Managerr=============================*//
    public function getAllManagers();
    //*===============For Manager=============================*//

    //*===============For Admin=============================*//
    public function getAllAdmins();
    //*===============For Admin=============================*//

    //*===============Main Edit=============================*//
    public function findAccount($id);
    
    public function confirmAdmin(StoreAdmin $request, $id);
    
    //*===============Main Edit=============================*//

    //*===============Main Update=============================*//
    public function editforAdmin($id);
    //*===============Main Update=============================*//
}