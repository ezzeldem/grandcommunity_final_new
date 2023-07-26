<?php

namespace App\Imports;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SalesImport implements ToCollection,WithHeadingRow,WithValidation
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
      
        foreach ($collection as $row)
        {
            
            $sales = Admin::create([
                'name'=> $row['name'],
                'username'=> $row['username'],
                'email'=> $row['email'],
                'active'=> (int)$row['status'],
                'role' => 'sales',
                'password' => $row['password'],
            ]);
            $role = Role::where('name',$row['role'])->where('type','sales')->first();
            if($role){
                $permissions = $role->permissions;
                $sales->syncRoles($role);
                $sales->syncPermissions($permissions);
            }
        }
    }

    public function rules(): array
    {
        return [
            'name'=>'required|string|max:100',
            'username'=>'required|string|max:100|unique:admins,username',
            'email'=>'required|email|unique:admins,email',
            'status'=>'required|in:0,1',
            'role' => 'required|string|exists:roles,name',
            'password' => 'required|min:6',
        ];
    }
}
