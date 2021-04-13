<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'news-create' => ['Author','User'],
            'news-edit' => ['Author'],
            'news-delete' => ['Author'],
            'events-create' => ['Author','User'],
            'events-read' => ['Author','User'],
            'events-edit' => ['Author'],
            'events-delete' => ['Author'],       
            'comments-create' => ['Author','User'], 
            'comments-delete' => ['Author'], 
            
         ];
            
        foreach ($permissions as $permission_name => $roles) {
            $permission = Permission::updateOrCreate(['name' => $permission_name]);
            DB::table('role_has_permissions')->where('permission_id',$permission->id)->delete();
            foreach($roles as $role){
                $role_data  = Role::where('name',$role)->first();
                if($role_data){
                    // $permission->attach(['role_id' => $role_data->id]);
                    DB::table('role_has_permissions')->updateOrInsert(['permission_id' => $permission->id, 'role_id' => $role_data->id]);
                }
            }
        }
    }
}
