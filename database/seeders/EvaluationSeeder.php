<?php

namespace Database\Seeders;

use App\Models\Evaluation;
use App\Models\Asset;
use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Database\Seeder;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $evaluations = [
            ['asset_id' => '1', 'C1' => 1, 'C2' => 2, 'C3' => 1, 'C4' => 1],
            ['asset_id' => '2', 'C1' => 2, 'C2' => 3, 'C3' => 2, 'C4' => 1],
            ['asset_id' => '3', 'C1' => 3, 'C2' => 3, 'C3' => 2, 'C4' => 2],
            ['asset_id' => '4', 'C1' => 1, 'C2' => 2, 'C3' => 1, 'C4' => 1],
            ['asset_id' => '5', 'C1' => 4, 'C2' => 3, 'C3' => 2, 'C4' => 1],
            ['asset_id' => '6', 'C1' => 2, 'C2' => 3, 'C3' => 2, 'C4' => 1],
            ['asset_id' => '7', 'C1' => 1, 'C2' => 1, 'C3' => 1, 'C4' => 1],
            ['asset_id' => '8', 'C1' => 1, 'C2' => 1, 'C3' => 1, 'C4' => 1],
        ];

        foreach ($evaluations as $evaluation) {
            $asset = Asset::where('id', $evaluation['asset_id'])->first();

            foreach (['C1', 'C2', 'C3', 'C4'] as $criteriaCode) {
                $criteria = Criteria::where('criteria_code', $criteriaCode)->first();
                $subCriteria = SubCriteria::where('criteria_id', $criteria->id)
                                          ->where('score', $evaluation[$criteriaCode])
                                          ->first();

                Evaluation::create([
                    'asset_id' => $asset->id,
                    'criteria_id' => $criteria->id,
                    'sub_criteria_id' => $subCriteria->id,
                ]);
            }
        }
    }
}