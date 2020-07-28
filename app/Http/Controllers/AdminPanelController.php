<?php

namespace App\Http\Controllers;

use App\Models\AdminPanel;
use Illuminate\Http\Request;

use App\Http\Requests\StoreAdmin;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\StoreForum;
use App\Http\Requests\StoreThread;
use App\Http\Requests\StoreCommunity;
use App\Http\Requests\StorePost;
use App\Http\Requests\StoreComment;

use Illuminate\Support\Facades\Auth;

use App\Repositories\Admin\AdminRepositoryInterface;

use App\Repositories\User\Account\ProfileRepositoryInterface;

use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Report\ReportRepositoryInterface;

use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Forum\ForumRepositoryInterface;
use App\Repositories\Thread\ThreadRepositoryInterface;
use App\Repositories\Thread\Tag\TagRepositoryInterface;
use App\Repositories\Community\CommunityRepositoryInterface;
use App\Repositories\Post\PostRepositoryInterface;

class AdminPanelController extends Controller
{
    protected $adminRepo;

    protected $profileRepo;

    protected $notiRepo;
    protected $commRepo;
    protected $repoRepo;

    protected $cateRepo;
    protected $forumRepo;
    protected $threadRepo;
    protected $tagRepo;
    protected $commuRepo;
    protected $postRepo;

    public function __construct(
        AdminRepositoryInterface $adminRepo,
        ProfileRepositoryInterface $profileRepo,
        NotificationRepositoryInterface $notiRepo,
        ThreadRepositoryInterface $threadRepo,
        PostRepositoryInterface $postRepo,
        CommentRepositoryInterface $commRepo,
        ReportRepositoryInterface $repoRepo,
        CategoryRepositoryInterface $cateRepo,
        ForumRepositoryInterface $forumRepo,
        TagRepositoryInterface $tagRepo,
        CommunityRepositoryInterface $commuRepo
    ) {
        $this->middleware('auth');
        $this->adminRepo = $adminRepo;

        $this->profileRepo = $profileRepo;

        $this->notiRepo = $notiRepo;
        $this->commRepo = $commRepo;
        $this->repoRepo = $repoRepo;

        $this->cateRepo = $cateRepo;
        $this->forumRepo = $forumRepo;
        $this->threadRepo = $threadRepo;
        $this->tagRepo = $tagRepo;
        $this->commuRepo = $commuRepo;
        $this->postRepo = $postRepo;
    }

    public function index()
    {

        $users = $this->adminRepo->countAllUsers();
        $managers = $this->adminRepo->countAllManagers();
        $admins = $this->adminRepo->countAllAdmins();


        $categories = $this->adminRepo->countAllCategories();
        $forums = $this->adminRepo->countAllForums();

        $managers_threads = $this->adminRepo->countAllThreadsByManager();
        $admins_threads = $this->adminRepo->countAllThreadsByAdmin();

        $tags = $this->adminRepo->countAllTags();

        $communities = $this->adminRepo->countAllCommunities();
        $posts = $this->adminRepo->countAllPosts();

        $comments = $this->adminRepo->countAllComments();
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);

        $reports = $this->adminRepo->countAllReports();

        $allnotifications = $this->adminRepo->countAllNotifications();

        return view('admin.dashboard', compact(
            'users',
            'managers',
            'admins',
            'categories',
            'forums',
            'managers_threads',
            'admins_threads',
            'tags',
            'communities',
            'posts',
            'comments',
            'notifications',
            'profile',
            'reports',
            'allnotifications'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AdminPanel  $adminPanel
     * @return \Illuminate\Http\Response
     */
    public function show(AdminPanel $adminPanel)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AdminPanel  $adminPanel
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminPanel $adminPanel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AdminPanel  $adminPanel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminPanel $adminPanel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AdminPanel  $adminPanel
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminPanel $adminPanel)
    {
        //
    }

    //*===============For User=============================*//
    public function users()
    {
        $users = $this->adminRepo->getAllUsers();
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.users_list', compact('users', 'notifications', 'profile'));
    }

    public function editmember($id)
    {
        $user = $this->adminRepo->findAccount($id);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.users.edit_user', compact('user', 'notifications', 'profile'));
    }

    public function confirmMember(StoreAdmin $request, $id)
    {

        $value = $this->adminRepo->findAccount($id);

        $user = $this->adminRepo->confirmAdmin($request, $value->id);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.admin.edituser', compact('user', 'notifications', 'profile'));
    }

    public function updateusers($id)
    {
        $user = $this->adminRepo->findAccount($id);

        $this->adminRepo->editforAdmin($user->id);

        return redirect()->route('user.list');
    }

    public function destroyusers($id)
    {
        $user = $this->adminRepo->findAccount($id);
        $user->delete();
        return redirect()->back();
    }
    //*===============For User=============================*//

    //*===============For Manager=============================*//
    public function managers()
    {
        $users = $this->adminRepo->getAllManagers();
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.managers_lists', compact('users', 'notifications', 'profile'));
    }

    public function editmanager($id)
    {
        $user = $this->adminRepo->findAccount($id);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.managers.edit_manager', compact('user', 'notifications', 'profile'));
    }

    public function confirmManager(StoreAdmin $request, $id)
    {
        $value = $this->adminRepo->findAccount($id);

        $user = $this->adminRepo->confirmAdmin($request, $value->id);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.admin.editmanager', compact('user', 'notifications', 'profile'));
    }

    public function updatemanagers($id)
    {
        $user = $this->adminRepo->findAccount($id);
        $this->adminRepo->editforAdmin($user->id);

        return redirect()->route('manager.list');
    }

    public function destroymanagers($id)
    {
        $user = $this->adminRepo->findAccount($id);
        $user->delete();
        return redirect()->back();
    }
    //*===============For Manager=============================*//

    //*===============For Admin=============================*//
    public function admins()
    {
        $users = $this->adminRepo->getAllAdmins();
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.admins_lists', compact('users', 'notifications', 'profile'));
    }

    public function editadmin($id)
    {
        $user = $this->adminRepo->findAccount($id);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.admins.edit_admin', compact('user', 'notifications', 'profile'));
    }

    public function confirmforAdmin(StoreAdmin $request, $id)
    {
        $value = $this->adminRepo->findAccount($id);

        $user = $this->adminRepo->confirmAdmin($request, $value->id);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.admin.edit', compact('user', 'notifications', 'profile'));
    }

    public function updateadmins($id)
    {
        $user = $this->adminRepo->findAccount($id);

        $this->adminRepo->editforAdmin($user->id);

        return redirect()->route('admin.list', ['id' => Auth::user()->id]);
    }

    public function destroyadmins($id)
    {
        $user = $this->adminRepo->findAccount($id);
        $user->delete();
        return redirect()->back();
    }

    //*===============For Admin=============================*//

    //*===============For Admins Categories=============================*//
    public function Categories()
    {

        $categories = $this->cateRepo->getAllCategories();

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.Category.categories_lists', compact('categories', 'notifications', 'profile'));
    }

    public function CategoriesEdit($categoryid)
    {
        $category = $this->cateRepo->showcategory($categoryid);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.admin.Category.edit_Category', compact('category', 'notifications', 'profile'));
    }
    public function CategoriesUpdate(StoreCategory $request, $categoryid)
    {
        $data = $request->validated();

        $category = $this->cateRepo->showcategory($categoryid);

        $category->name = $data['name'];
        $category->detail = $data['detail'];

        $category->save();

        return redirect()->route('categories.admin.list');
    }
    public function CategoriesDelete($categoryid)
    {
        $this->cateRepo->deletecategory($categoryid);

        return redirect()->back();
    }

    public function CategoriesRestore($categoryid)
    {
        $this->cateRepo->restorecategory($categoryid);

        return redirect()->back();
    }
    //*===============For Admins Categories=============================*//

    //*===============For Admins Forums=============================*//
    public function Forums()
    {

        $forums = $this->forumRepo->getAllForums();

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.Forum.forums_lists', compact('forums', 'notifications', 'profile'));
    }

    public function ForumsEdit( $forumid)
    {

        $forum = $this->forumRepo->showforum($forumid);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.Forum.edit', compact('forum', 'notifications', 'profile'));
    }
    
    public function ForumsUpdate(StoreForum $request,  $forumid)
    {

        $data = $request->validated();

        $forum = $this->forumRepo->showforum($forumid);

        $forum->title = $data['title'];
        $forum->user_id = Auth::user()->id;
        dd($forum);
        $forum->update();
        
        return redirect()->route('forums.admin.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ForumsDelete($forumid)
    {
        $this->forumRepo->deleteForums($forumid);
        return redirect()->back();
    }

    public function ForumsRestore( $forumid)
    {
        $this->forumRepo->restoreForums($forumid);

        return redirect()->back();
    }
    //*===============For Admins Forums=============================*//

    //*===============For Admins Threads=============================*//
    public function AdminsThreads()
    {

        $threads = $this->threadRepo->getAllThreadsByAdmin();

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.Thread.AdminThreads.admins_lists', compact('threads', 'notifications', 'profile'));
    }

    public function AdminsThreadsEdit($threadid)
    {
        $thread = $this->threadRepo->showThread($threadid);

        $tags = $this->tagRepo->showall();
        $threadtag = $this->tagRepo->getTag($thread->tag_id);

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);

        return view('confirms.admin.Thread.edit_Thread(Admin)', compact('thread', 'tags', 'threadtag', 'notifications', 'profile'));
    }

    public function AdminsThreadsUpdate(StoreThread $request, $threadid)
    {
        $data = $request->validated();
        $thread = $this->threadRepo->showThread($threadid);


        $thread->title = $data['title'];
        $thread->tag_id = $data['tag_id'];

        $thread->detail = $data['detail'];
        $thread->status = $data['status'];

        $old_thumbnail = $thread->thumbnail;

        if ($request->hasFile('thumbnail')) {

            $thread->thumbnail = $request->file('thumbnail');

            $extension = $data['thumbnail']->getClientOriginalExtension();
            $filename =  $data['title'] . '.' . $extension;

            $path = storage_path('app/public/thread/' . $data['title'] . '/');

            if (!file_exists($path . $filename)) {

                $thread->thumbnail->move($path, $filename);
            } else if (!file_exists($path . $old_thumbnail)) {

                $thread->thumbnail->move($path, $filename);
            } else {

                unlink($path . $old_thumbnail);
                $thread->thumbnail->move($path, $filename);
            }
        }
        $data['thumbnail'] = $filename;
        $thread->thumbnail  = $data['thumbnail'];

        $thread->update();
        return redirect()->route('admins.threads.list');
    }

    public function AdminsThreadsDelete($threadid)
    {

        $this->threadRepo->deleteThreads($threadid);

        return redirect()->route('admins.threads.list');
    }

    public function AdminsThreadsRestore($threadid)
    {

        $this->threadRepo->restoreThreads($threadid);

        return redirect()->route('admins.threads.list');
    }
    //*===============For Admins Threads=============================*//

    //*===============For Manager Threads=============================*//
    public function ManagersThreads()
    {

        $threads = $this->threadRepo->getAllThreadsByManager();

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.Thread.ManagerThreads.managers_lists', compact('threads', 'notifications', 'profile'));
    }

    public function ManagersThreadsEdit($threadid)
    {
        $thread = $this->threadRepo->showThread($threadid);

        $tags = $this->tagRepo->showall();
        $threadtag = $this->tagRepo->getTag($thread->tag_id);

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);

        return view('confirms.admin.Thread.edit_Thread(Manager)', compact('thread', 'tags', 'threadtag', 'notifications', 'profile'));
    }

    public function ManagersThreadsUpdate(StoreThread $request, $threadid)
    {
        $data = $request->validated();
        $thread = $this->threadRepo->showThread($threadid);


        $thread->title = $data['title'];
        $thread->tag_id = $data['tag_id'];

        $thread->detail = $data['detail'];
        $thread->status = $data['status'];

        $old_thumbnail = $thread->thumbnail;

        if ($request->hasFile('thumbnail')) {

            $thread->thumbnail = $request->file('thumbnail');

            $extension = $data['thumbnail']->getClientOriginalExtension();
            $filename =  $data['title'] . '.' . $extension;

            $path = storage_path('app/public/thread/' . $data['title'] . '/');

            if (!file_exists($path . $filename)) {

                $thread->thumbnail->move($path, $filename);
            } else if (!file_exists($path . $old_thumbnail)) {

                $thread->thumbnail->move($path, $filename);
            } else {

                unlink($path . $old_thumbnail);
                $thread->thumbnail->move($path, $filename);
            }
        }
        $data['thumbnail'] = $filename;
        $thread->thumbnail  = $data['thumbnail'];

        $thread->update();
        return redirect()->route('managers.threads.list');
    }

    public function ManagersThreadsDelete($threadid)
    {

        $this->threadRepo->deleteThreads($threadid);

        return redirect()->route('managers.threads.list');
    }

    public function ManagersThreadsRestore($threadid)
    {

        $this->threadRepo->restoreThreads($threadid);

        return redirect()->route('managers.threads.list');
    }
    //*===============For Manager Threads=============================*//

    //*===============For Admins Tags=============================*//
    public function Tags()
    {
        $tags = $this->tagRepo->getAllTags();

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.Tag.tags_lists', compact('tags', 'notifications', 'profile'));
    }

    //*===============For Admins Tags=============================*//

    //*===============For Admins Communities=============================*//
    public function Communities()
    {
        $communities = $this->commuRepo->getAllCommunities();

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.Community.communities_lists', compact('communities', 'notifications', 'profile'));
    }

    public function CommunitiesEdit($id)
    {
        $community = $this->commuRepo->showcommunity($id);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.admin.Community.edit_Community', compact('community', 'notifications', 'profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function CommunitiesUpdate(StoreCommunity $request, $id)
    {
        $data = $request->validated();

        $community = $this->commuRepo->showcommunity($id);

        $community->title = $data['title'];

        $old_banner = $community->banner;

        if ($request->hasFile('banner')) {

            $community->banner =  $data['banner'];

            $extension =  $community->banner->getClientOriginalExtension();


            $filename =  $data['title'] . '.' . $extension;

            $path = storage_path('app/public/community/' . $data['title'] . '/');

            if (!file_exists($path . $filename)) {

                $community->banner->move($path, $filename);
            } else if (!file_exists($path . $old_banner)) {

                $community->banner->move($path, $filename);
            } else {

                unlink($path . $old_banner);
                $community->banner->move($path, $filename);
            }
        }
        $community->banner = $filename;
        $community->update();

        return redirect()->route('communities.admin.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function CommunitiesDelete($id)
    {

        $this->commuRepo->deletecommunity($id);

        return redirect()->back();
    }

    public function CommunitiesRestore($id)
    {

        $this->commuRepo->restorecommunity($id);

        return redirect()->back();
    }
    //*===============For Admins Communities=============================*//

    //*===============For Admins Posts=============================*//
    public function Posts()
    {

        $posts = $this->postRepo->getAllPosts();

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.Post.posts_lists', compact('posts', 'notifications', 'profile'));
    }

    public function PostsEdit($postid)
    {

        $notifications  = $this->notiRepo->showUnread();
        $post = $this->postRepo->showpost($postid);
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.admin.Post.edit_Post', compact('post', 'profile','notifications'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function PostsUpdate(StorePost $request, $postid)
    {
        $data = $request->validated();

        $post = $this->postRepo->showpost($postid);

        $post->detail = $data['detail'];

        $old_image = $post->image;

        if ($request->hasFile('image')) {

            $post->image =  $data['image'];

            $extension =  $post->image->getClientOriginalExtension();


            $filename =  $post->user_id . '.' . $extension;

            $path = storage_path('app/public/post/' . $post->user_id . '/');

            if (!file_exists($path . $filename)) {

                $post->image->move($path, $filename);
            } else if (!file_exists($path . $old_image)) {

                $post->image->move($path, $filename);
            } else {

                unlink($path . $old_image);
                $post->image->move($path, $filename);
            }
        }
        $post->image = $filename;

        $post->update();

        return redirect()->route('posts.admin.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function PostsDelete($postid)
    {

        $this->postRepo->deletepost($postid);
        return redirect()->back();
    }

    public function PostsRestore($postid)
    {
        $this->postRepo->restorepost($postid);
        return redirect()->back();
    }
    //*===============For Admins Posts=============================*//

    //*===============For Admins Comments=============================*//
    public function Comments()
    {

        $comments = $this->commRepo->getAllComments();

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.Comment.comments_lists', compact('comments', 'notifications', 'profile'));
    }


     public function CommentsEdit($commentid)
     {
 
         $comment = $this->commRepo->showComment($commentid);
 
         $notifications = $this->notiRepo->showUnread();
         $profile = $this->profileRepo->getProfile(Auth::user()->id);
         return view('confirms.admin.Comment.edit_Comment', compact('comment', 'notifications', 'profile'));
     }
 
     public function CommentsUpdate(StoreComment $request, $commentid)
     {
 
         $data = $request->validated();
 
         $comment = $this->commRepo->showComment($commentid);
         $old_image = $comment->comment_image;
 
         if ($request->hasFile('comment_image')) {
 
             $comment->comment_image =  $data['comment_image'];
 
             $extension =  $comment->comment_image->getClientOriginalExtension();
 
 
             $filename =  Auth::user()->name . '.' . $extension;

             if($comment->commentable_type == 'App\Post')
             {
                $path = storage_path('app/public/comment/post/' . $data['comment_detail'] . '/');
             }   
             else
             {
                $path = storage_path('app/public/comment/thread/' . $data['comment_detail'] . '/');
             }
             
 
             if (!file_exists($path . $filename)) {
 
                 $comment->comment_image->move($path, $filename);
             } else if (!file_exists($path . $old_image)) {
 
                 $comment->comment_image->move($path, $filename);
             } else {
 
                 unlink($path . $old_image);
                 $comment->comment_image->move($path, $filename);
             }
         }
         $comment->comment_image = $filename;
         $comment->comment_detail = $data['comment_detail'];
         $comment->user_id = Auth::user()->id;
 
         $comment->update();
 
         $comment = $this->commRepo->showComment($comment->id);
 
         return redirect()->route('comments.admin.list');
     }
 
     public function CommentsDelete($commentid)
     {
 
         $this->commRepo->deletecomment($commentid);
         return redirect()->back();
     }
 
     public function CommentsRestore($commentid)
     {
 
         $this->commRepo->restorecomment($commentid);
         return redirect()->back();
     }

    //*===============For Admins Comments=============================*//

    //*===============For Admins Reports=============================*//
    public function Reports()
    {

        $reports = $this->repoRepo->showall();

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.Report.reports_lists', compact('reports', 'notifications', 'profile'));
    }

    //*===============For Admins Reports=============================*//

     //*===============For Admins Reports=============================*//
     public function Notifications()
     {
 
         $Allnotifications = $this->notiRepo->showall();
 
         $notifications = $this->notiRepo->showUnread();
         $profile = $this->profileRepo->getProfile(Auth::user()->id);
         return view('admin.lists.Notification.notifications_lists', compact('Allnotifications', 'notifications', 'profile'));
     }
 
     //*===============For Admins Reports=============================*//
}
