<?php

namespace App\Repositories\Community;

use App\Repositories\BaseRepository;
use App\Community;
use Illuminate\Support\Facades\DB;

class CommunityRepository extends BaseRepository implements CommunityRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Community::class;
    }

    public function showall()
    {
        return $this->model = DB::table('communities')->paginate(10);
    }

    public function showcommunity($id)
    {
        return $this->model = Community::findOrFail($id);
    }
   
    public function deletecommunity($id)
    {
        
        $this->model = Community::findOrFail($id);
        
        return $this->model->delete();
    }

    public function restorecommunity($id)
    {
       
        return $this->model = Community::onlyTrashed()->where('id',$id)->restore();
            
        
    }
}
