<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Criteria;
use App\Models\SubCriteria;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $updatedAt = Asset::latest('updated_at')->value('updated_at');
        $totalAsset = Asset::count();
        $totalUsers = User::count();
        $totalAssetValue = $this->formatAssetValue(Asset::sum('acquisition_cost'));
        $averageAssetDepreciation = $this->formatDepreciation(Asset::avg('total_depreciation'));

        return view('home', compact(
            'updatedAt',
            'totalAsset',
            'totalUsers',
            'totalAssetValue',
            'averageAssetDepreciation'
        ));
    }

    private function formatAssetValue($value)
    {
        if ($value >= 1000000000) {
            return number_format($value / 1000000000, 1) . 'B';
        } elseif ($value >= 1000000) {
            return number_format($value / 1000000, 1) . 'M';
        } elseif ($value >= 1000) {
            return number_format($value / 1000, 1) . 'K';
        } else {
            return $value;
        }
    }

    private function formatDepreciation($value)
    {
        return number_format($value, 2) . '%';
    }
}
