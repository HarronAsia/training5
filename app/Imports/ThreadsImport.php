<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;

class ThreadsImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {     
        foreach($collection as $key =>$value)
        {
            if($key >0)
            {
                //dd($value);
                DB::table('threads')->insert(['title' => $value[1],'user_id' => Auth::user()->id, 'detail' => $value[3],'created_at' => Carbon::now(),'updated_at' => Carbon::now()]);
            }
        }
    }
}

?>
