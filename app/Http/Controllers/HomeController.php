<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use App\Repositories\Thread\ThreadRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\User\Account\ProfileRepositoryInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\True_;

class HomeController extends Controller
{
    protected $cateRepo;
    protected $threadRepo;
    protected $profileRepo;
    protected $notiRepo;

    public function __construct(CategoryRepositoryInterface $cateRepo, ThreadRepositoryInterface $threadRepo, ProfileRepositoryInterface $profileRepo, NotificationRepositoryInterface $notiRepo)
    {

        $this->cateRepo = $cateRepo;
        $this->threadRepo = $threadRepo;
        $this->profileRepo = $profileRepo;
        $this->notiRepo = $notiRepo;
    }

    public function admin(Request $req)
    {
        return view('unauthorized')->withMessage("Admin");
    }
    public function manager(Request $req)
    {
        return view('unauthorized')->withMessage("Manager");
    }
    public function member(Request $req)
    {
        return view('unauthorized')->withMessage("Member");
    }

    public function index()
    {

        if (Auth::guest() == True) {
            $categories = $this->cateRepo->showall();
            return view('home', compact('categories'));
        } else {
            $categories = $this->cateRepo->showall();
            $profile = $this->profileRepo->getProfile(Auth::user()->id);
            $notifications = $this->notiRepo->showUnread();
            return view('home', compact('categories', 'notifications', 'profile'));
        }
    }

    public function readAt($id)
    {
        $this->notiRepo->readAt($id);

        return redirect()->back();
    }

    public function readAll()
    {

        $this->notiRepo->readAll();
        return redirect()->back();
    }

    public function showAllNotifications()
    {
        $allnotifications = $this->notiRepo->showallUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        $notifications = $this->notiRepo->showUnread();
        return view('Notifications.lists', compact('notifications', 'profile', 'allnotifications'));
    }

    public function destroy($id)
    {
        $this->notiRepo->deleteNotification($id);

        return redirect()->back();
    }
}
