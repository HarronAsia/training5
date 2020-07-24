<?php

namespace App\Repositories\Report;

interface ReportRepositoryInterface
{
    public function showall();
    public function deleteReport($id);
    public function restorereport($id);
}
