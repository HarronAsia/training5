<?php

namespace App\Repositories\Report;

use App\Repositories\BaseRepository;
use App\Models\Report;


class ReportRepository extends BaseRepository implements ReportRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Report::class;
    }

    public function showall()
    {
        return $this->model = Report::withTrashed()->paginate(5);
    }

    public function deleteReport($id)
    {
        $this->model = Report::findOrFail($id);

        return $this->model->delete();
    }

    public function restorereport($id)
    {
        return $this->model = Report::onlyTrashed()->where('id', $id)->restore();
    }
}
