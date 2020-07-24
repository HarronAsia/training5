<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTag;

use App\Repositories\Thread\Tag\TagRepositoryInterface;
use App\Repositories\User\Account\ProfileRepositoryInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;

use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

use App\Notifications\Tag\AddTagNotification;
use App\Notifications\Tag\EditTagNotification;
use App\Notifications\Tag\DeleteTagNotification;
use App\Notifications\Tag\RestoreTagNotification;

class TagController extends Controller
{

    protected $tagRepo;
    protected $profileRepo;
    protected $notiRepo;

    public function __construct(TagRepositoryInterface $tagRepo, ProfileRepositoryInterface $profileRepo, NotificationRepositoryInterface $notiRepo)
    {
        $this->middleware('auth');
        $this->tagRepo = $tagRepo;
        $this->profileRepo = $profileRepo;
        $this->notiRepo = $notiRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $notifications = $this->notiRepo->showUnread();
        $tags = $this->tagRepo->showall();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.Thread.Tag.add_tag', compact('notifications', 'tags', 'profile'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTag $request)
    {

        $data = $request->validated();


        $tag = new Tag();

        $tag->name = $data['name'];


        $tag->save();
        $tag->notify(new AddTagNotification());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = $this->tagRepo->getTag($id);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.Thread.Tag.edit', compact('tag', 'notifications', 'profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTag $request, $id)
    {

        $data = $request->validated();
        $tag = $this->tagRepo->getTag($id);

        $tag->name = $data['name'];
        $tag->update();
        $tag->notify(new EditTagNotification());
        return redirect()->route('tags.admin.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->tagRepo->deletetag($id);
        $tag = $this->tagRepo->getTrash($id);
        $tag->notify(new DeleteTagNotification());
        return redirect()->back();
    }

    public function restore($id)
    {
        $this->tagRepo->restoretag($id);
        $tag = $this->tagRepo->getTag($id);
        $tag->notify(new RestoreTagNotification());
        return redirect()->back();
    }
}
