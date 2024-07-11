<?php

namespace Database\Seeders;

use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Database\Seeder;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        static $id = 1;

        // Kriteria Kondisi Aset
        $kondisiAset = Criteria::create([
            'criteria_code' => 'C' . $id++,
            'name' => 'Kondisi Aset',
            'attribute' => 'benefit',
            'weight' => 4
        ]);
        SubCriteria::insert([
            ['criteria_id' => $kondisiAset->id, 'name' => 'Baik', 'score' => 4],
            ['criteria_id' => $kondisiAset->id, 'name' => 'Rusak Ringan', 'score' => 3],
            ['criteria_id' => $kondisiAset->id, 'name' => 'Rusak Berat', 'score' => 2],
            ['criteria_id' => $kondisiAset->id, 'name' => 'Barang Tidak Ada', 'score' => 1],
        ]);

        // Kriteria Usia Aset
        $usiaAset = Criteria::create([
            'criteria_code' => 'C' . $id++,
            'name' => 'Usia Aset',
            'attribute' => 'cost',
            'weight' => 3
        ]);
        SubCriteria::insert([
            ['criteria_id' => $usiaAset->id, 'name' => 'C2 <= 5 Tahun', 'score' => 1],
            ['criteria_id' => $usiaAset->id, 'name' => '6 - 10 Tahun', 'score' => 2],
            ['criteria_id' => $usiaAset->id, 'name' => '11 - 15 Tahun', 'score' => 3],
            ['criteria_id' => $usiaAset->id, 'name' => '>= 16 Tahun', 'score' => 4],
        ]);

        // Kriteria Depresiasi Aset
        $depresiasiAset = Criteria::create([
            'criteria_code' => 'C' . $id++,
            'name' => 'Depresiasi Aset',
            'attribute' => 'cost',
            'weight' => 2
        ]);
        SubCriteria::insert([
            ['criteria_id' => $depresiasiAset->id, 'name' => 'C3 <= 5%', 'score' => 1],
            ['criteria_id' => $depresiasiAset->id, 'name' => '5% - 15%', 'score' => 2],
            ['criteria_id' => $depresiasiAset->id, 'name' => '15% - 25%', 'score' => 3],
            ['criteria_id' => $depresiasiAset->id, 'name' => '>= 25%', 'score' => 4],
        ]);

        // Kriteria Masa Manfaat Aset
        $masaManfaatAset = Criteria::create([
            'criteria_code' => 'C' . $id++,
            'name' => 'Masa Manfaat Aset',
            'attribute' => 'benefit',
            'weight' => 1
        ]);
        SubCriteria::insert([
            ['criteria_id' => $masaManfaatAset->id, 'name' => 'C4 <= 5 Tahun', 'score' => 1],
            ['criteria_id' => $masaManfaatAset->id, 'name' => '6 - 10 Tahun', 'score' => 2],
            ['criteria_id' => $masaManfaatAset->id, 'name' => '11 - 15 Tahun', 'score' => 3],
            ['criteria_id' => $masaManfaatAset->id, 'name' => '>= 16 Tahun', 'score' => 4],
        ]);
    }
}
