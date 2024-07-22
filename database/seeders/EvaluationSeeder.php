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
        $assets = Asset::all();

        foreach ($assets as $asset) {
            $currentYear = date('Y');
            $assetAge = $currentYear - $asset->procurement_year;
            $depreciationPercentage = ($assetAge * 0.5);
            $usefulLife = $assetAge; 

            $C1 = $asset->condition;
            $C2 = $this->getAgeScore($assetAge);
            $C3 = $this->getDepreciationScore($depreciationPercentage);
            $C4 = $this->getUsefulLifeScore($usefulLife);

            $evaluation = [
                'asset_id' => $asset->id,
                'C1' => $C1,
                'C2' => $C2,
                'C3' => $C3,
                'C4' => $C4
            ];

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

    private function getAgeScore($age)
    {
        if ($age <= 5) {
            return 1;
        } elseif ($age <= 10) {
            return 2;
        } elseif ($age <= 15) {
            return 3;
        } else {
            return 4;
        }
    }

    private function getDepreciationScore($depreciationPercentage)
    {
        if ($depreciationPercentage <= 5) {
            return 1;
        } elseif ($depreciationPercentage <= 15) {
            return 2;
        } elseif ($depreciationPercentage <= 25) {
            return 3;
        } else {
            return 4;
        }
    }

    private function getUsefulLifeScore($usefulLife)
    {
        if ($usefulLife <= 5) {
            return 1;
        } elseif ($usefulLife <= 10) {
            return 2;
        } elseif ($usefulLife <= 15) {
            return 3;
        } else {
            return 4;
        }
    }
}
