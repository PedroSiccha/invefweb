<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.premission.cache');

        //Permission list
        Permission::create(['name' => 'products.index']);
        Permission::create(['name' => 'products.edit']);
        Permission::create(['name' => 'products.show']);
        Permission::create(['name' => 'products.create']);
        Permission::create(['name' => 'products.destroy']);

        //Admin
        $admin = Role::create(['name' => 'Admin']);

        $admin->givePermissionTo([
            'products.index',
            'products.edit',
            'products.show',
            'products.create',
            'products.destroy'
        ]);

        //Editor
        $edit = Role::create(['name' => 'Editor']);

        $edit->givePermissionTo([
            'products.edit',
            'products.destroy'
        ]);
    }
}
