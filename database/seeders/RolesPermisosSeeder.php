<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'ver_usuarios']);
        Permission::create(['name' => 'crear_usuarios']);
        Permission::create(['name' => 'editar_usuarios']);

        $role = Role::create(['name' => 'Administrator']);
        $role->givePermissionTo('ver_usuarios');
        $role->givePermissionTo('crear_usuarios');
        $role->givePermissionTo('editar_usuarios');
    }
}
