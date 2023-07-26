<?php
namespace App\Imports;
use App\Models\Brand;
use App\Models\GroupList;
use App\Models\Influencer;
use App\Models\InfluencerGroup;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
class GroupListInflueImport  implements ToCollection,WithHeadingRow
{

    public $messages_success = [];
    public function __construct($messages_success = [])
    {
        $this->messages_success = $messages_success;
    }
    //fixme::favoritesUpdates
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $created_by=auth()->user()->id;

        $group = GroupList::find(request()->groupId);
        $brand = Brand::find(request()->brand_id);
        $add = 0;
        $fail = 0;
        foreach ($rows as $row)
        {
            if(!$brand){
                $this->messages_success[]=['message'=>'Not found brand',"Name"=>"All","status"=>"faild"];
                continue;
            }

            if(!isset($row['user_name'])){
                $this->messages_success[]=['message'=>'Not found username',"Name"=>"None","status"=>"faild"];
                continue;
            }
            $groupsListsNames = [];
            if(!empty($row['groups'])){
                $groupsListsNames = explode(',', $row['groups']);
            }
            $influencer = Influencer::whereHas('user', function ($q) use ($row) {
                $q->where('user_name', $row['user_name']);
            })->first();
            if(!$influencer){
                $this->messages_success[]=['message'=>'Not found influencer with this username',"Name"=>$row['user_name'],"status"=>"faild"];
                continue;
            }

            $dislike = DB::table('brand_dislikes')->where('influencer_id', $influencer->id)->where('brand_id', $brand->id)->first();
            if($dislike){
                $this->messages_success[]=['message'=>'Influencer in dislike list',"Name"=>$row['user_name'],"status"=>"faild"];
                continue;
            }


            if(count($groupsListsNames) > 0){
                foreach ($groupsListsNames as $gName){
                    $gRow = GroupList::where('name', trim($gName))->where('brand_id', $brand->id)->first();
                    if(!$gRow){
                        if(!in_array($influencer->country_id,(is_array($brand->country_id)?$brand->country_id:[]))){
                            $fail++;
                            $this->messages_success[]=['message'=>'Not in brand suppoerted countries',"Name"=>$row['user_name'],"status"=>"faild"];
                            continue;
                        }
                        $gRow = GroupList::create(['brand_id' => $brand->id, 'name' => trim($gName), 'country_id' => $brand->country_id, 'color' => '#ffffff']);
                    }
//                    dump($influencer->country_id, $gRow->country_id);
                    if(!in_array($influencer->country_id,(is_array($gRow->country_id)?$gRow->country_id:[]))){
                        $fail++;
                        $this->messages_success[]=['message'=>'Not in brand group supported countries',"Name"=>$row['user_name'],"status"=>"faild"];
                        continue;
                    }
                    $add++;
                    $this->messages_success[]=["status"=>"success"];
                    InfluencerGroup::updateOrCreate(['brand_id' => $brand->id, 'influencer_id' => $influencer->id, 'group_list_id' => $gRow->id, 'deleted_at' => null, 'group_deleted_at' => null], ['brand_id' => $brand->id, 'influencer_id' => $influencer->id, 'date'=>now()->format('Y-m-d'), 'group_list_id' => $gRow->id, 'created_by' => $created_by]);
                }
            }elseif($group){
                //fixme::groupWithCountry
                if(!in_array($influencer->country_id,(is_array($group->country_id)?$group->country_id:[]))){
                    $fail++;
                    $this->messages_success[]=['message'=>'Not in brand group supported countries',"Name"=>$row['user_name'],"status"=>"faild"];
                    continue;
                }
                $add++;
                $this->messages_success[]=["status"=>"success"];
                InfluencerGroup::updateOrCreate(['brand_id' => $group->brand_id, 'influencer_id' => $influencer->id, 'group_list_id' => $group->id, 'group_deleted_at' => null], ['brand_id' => $group->brand_id, 'influencer_id' => $influencer->id, 'date'=>now()->format('Y-m-d'), 'group_list_id' => $group->id, 'created_by' => $created_by]);
            }else{
                if(!in_array($influencer->country_id,(is_array($brand->country_id)?$brand->country_id:[]))){
                    $fail++;
                    $this->messages_success[]=['message'=>'Not in brand supported countries',"Name"=>$row['user_name'],"status"=>"faild"];
                    continue;
                }
                $add++;
                $this->messages_success[]=["status"=>"success"];
                InfluencerGroup::updateOrCreate(['brand_id' => $brand->id, 'influencer_id' => $influencer->id, 'deleted_at' => null, 'group_list_id' => null], ['brand_id' => $brand->id, 'influencer_id' => $influencer->id, 'date'=>now()->format('Y-m-d'), 'created_by' => $created_by]);
            }

        }
        return $this->messages_success;
    }

}
