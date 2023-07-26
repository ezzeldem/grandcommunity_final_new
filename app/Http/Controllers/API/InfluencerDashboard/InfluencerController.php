<?php

namespace App\Http\Controllers\API\InfluencerDashboard;

use App\Http\Controllers\Controller;
use App\Models\Influencer;
use Illuminate\Http\Request;

class InfluencerController extends Controller
{
    public function getCompleteProfilePercentage(Influencer $influencer)
{
    $influencer = auth()->user()->influencers;

    $fields = [
        'classification_ids' => 8,
        'coverage_channel' => 3,
        'city_id' => 3,
        'state_id' => 3,
        'interest' => 7,
        'job' => 1,
        'marital_status' => 7,
        'nationality' => 3,
        'lang' => 4,
        'website_uname' => 1,
    ];

    $completed_percentages = [];
    foreach ($fields as $field => $percentage) {
        if (isset($influencer->$field) && $influencer->$field != null) {
            $completed_percentages[] = $percentage;
        }
    }

    $total_percentage = array_sum($completed_percentages);

    $total_percentage += 60;

    return response()->json([
        'percentage' => $total_percentage,
    ]);
}

}
