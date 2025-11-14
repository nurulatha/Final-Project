<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entities = ['user', 'menu', 'kategori', 'kantin'];
        $action = ['create', 'read', 'edit', 'delete'];
        foreach ($entities as $entity) {
            foreach ($action as $act) {
                Permission::create(['name' => $act . '-' . $entity]);
            }
            Permission::create(['name' => 'manage-' . $entity]);
        }
        Permission::create(['name' => 'edit-status']);

        Role::create(['name' => 'superAdmin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'pembeli']);

        $roleSuperAdmin = Role::findByName('superAdmin');
        $roleSuperAdmin->givePermissionTo(Permission::all()); 

        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo(['manage-menu', 'manage-kategori', 'edit-kantin', 'edit-status']);

        $rolePembeli = Role::findByName('pembeli');
        $rolePembeli->givePermissionTo(['read-kategori', 'read-menu']);
    }
}
