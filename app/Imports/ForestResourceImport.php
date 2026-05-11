<?php

namespace App\Imports;

use App\Models\ForestResource;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ForestResourceImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $rows->shift();

        foreach ($rows as $row) {

            if (empty($row[0])) {
                continue;
            }

            ForestResource::create([
                'forest_name' => trim($row[0]),
                'forest_count' => (int) str_replace(',', '', $row[1] ?? 0),
                'forest_area' => (float) str_replace(',', '', $row[2] ?? 0),
            ]);
        }
    }
}