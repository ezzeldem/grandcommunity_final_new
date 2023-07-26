<?php

namespace App\Imports;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AdminsImport implements ToCollection,WithHeadingRow,WithValidation
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        
        foreach ($rows as $row)
        {
            $admin = Admin::withTrashed()->where('username',$row['username'])->first();
            if($admin){
                $admin->restore();
            }else{
                $admin = Admin::create([
                    'name'=> $row['name'],
                    'username'=> $row['username'],
                    'email'=> $row['email'],
                    'active'=> (int)$row['status'],
                    'role' => 'admin',
                    'password' => $row['password'],
                ]);
                $role = Role::where('name',$row['role_id'])->where('type','admin')->first();
                if($role){
                    $permissions = $role->permissions;
                    $admin->syncRoles($role);
                    $admin->syncPermissions($permissions);
                }
            }



        }

    }

    public function rules(): array
    {
        return [
            'name'=>'required|string|max:100',
            'username'=>'required|string|max:100',
            'email'=>'required|email',
            'status'=>'required|in:0,1',
            'role' => 'required|string|exists:roles,name',
            'password' => 'required|min:6',
        ];
    }
}
