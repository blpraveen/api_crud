<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use DB;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
                   ['id' => '1','name'=> 'Author','guard_name'=>'web'],
                   ['id' => '2','name'=>'User','guard_name'=>'web'],
                ];
            
        foreach ($roles as $role) {
            $role_set = Role::updateOrCreate(['id' => $role['id']], $role);
        }
    }
}
