<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTag;
use App\Repositories\Thread\Tag\TagRepositoryInterface;
use App\Models\Tag;
use App\Notifications\AddTagNotification;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;


class TagController extends Controller
{

    protected $tagRepo;

    public function __construct(TagRepositoryInterface $tagRepo)
    {
        $this->middleware('auth');
        $this->tagRepo = $tagRepo;
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

        $notifications = DB::table('notifications')->get()->where('read_at', '==', NULL);
        $tags = $this->tagRepo->showall();
        return view('confirms.Thread.Tag.add_tag',compact('notifications','tags'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
