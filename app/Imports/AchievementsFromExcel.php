<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\ToCollection;

use App\Models\Achievement;

class AchievementsFromExcel implements ToModel
{
    /**
    * @param Model $model
    */
    public function model(array $row)
    {
        return new Achievement([
        	'name' => $row[0],
        	'description' => 'X',
        	'intelligence_id' => $row[1]
        ]);
    }
}
