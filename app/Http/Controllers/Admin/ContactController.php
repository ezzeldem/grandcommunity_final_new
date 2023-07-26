<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Country;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){
        $statistics['totalContacts'] = ['title'=>'Total Contacts','count'=>Contact::count(),'icon'=>'fab fa-bandcamp'];

        return view('admin.dashboard.setting.contact.index',get_defined_vars());
    }
    public function getContacts(){
        $contacts = Contact::all();
        foreach ($contacts as $contact){
            $countries = Country::where('id', (int)$contact->country_id)->select('name','code')->first();
            $contact['country_id']=@$countries->name;
        }
        return datatables($contacts)->make(true);
    }
    public function destroy($id){
        Contact::findOrFail($id)->delete();
        return response()->json(['status'=>'true','data'=>'data'],200);
    }
    public function delete_all(Request $request){
        $selected_ids_new = explode(',',$request->selected_ids);

        $contacts = Contact::whereIn('id',$selected_ids_new)->get();
        if($contacts){
            foreach ($contacts as $contact){
                $contact->delete();
            }
        }
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);

    }
}
