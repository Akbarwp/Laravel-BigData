<?php

namespace App\Imports;

use App\Models\Resource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ResourceImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        return new Resource([
            'acara_tv' => $row[2],
            'jumlah_retweet' => $row[3],
            'text' => $row[4],
            'label' => $row[1],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
