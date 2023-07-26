<?php
namespace App\Repository;
use App\Models\LogCamp;

/**
 * Plan Repository class
 */
class CampaignLogRepository
{
    /**
     * Get a list of all plans
     *
     * @return array  Array containing list of all plans
     */

    public function SaveDataToLog($data){
        $data['user_id'] = auth()->user()->id;
        LogCamp::create($data);
    }
    

}
