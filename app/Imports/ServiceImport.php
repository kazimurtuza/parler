<?php

namespace App\Imports;

use App\Modules\Service\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;

class ServiceImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {

        foreach ($rows as $key => $row)
        {
            if ($key == 0) {
                continue;
            }
            Service::create([
                'name' => $row[0],
                'price' => $row[1],
                'discount_type' => $row[2],
                'discount_value' => $row[3],
                'description' => $row[4],
                'status' => 1,
                'created_at' => Carbon::now(),
                'created_by' => Auth::id(),
                'deleted' => 0,

            ]);
        }
    }
}
