<?php

namespace App\Exports;

use App\Models\Thread;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ThreadsExport implements FromView
{
 
    public function view(): View
    {
        return view('admin.export.threads.threads_excel',
        [
            'threads' => Thread::all()
        ]);
    }
}
