<?php

namespace App\Imports;

use App\Modules\Product\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductsImport implements ToCollection
{
    public function collection(Collection $rows)
    {

        foreach ($rows as $key => $row)
        {
            if ($key == 0) {
                continue;
            }

            Product::create([
                'name' => $row[0],
                'price' => $row[1],
                'note' => $row[2],
                'status' => 1,
                'created_at' => Carbon::now(),
                'created_by' => Auth::id(),
                'deleted' => 0
            ]);
        }


    }
}
