<?php

// namespace Database\Seeders;

// use App\Models\User;
// use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Permission;
// use Spatie\Permission\Models\Role;

// class PermissionSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */
//     public function run(): void
//     {
//         // Buat role jika belum ada
//         $role_admin = Role::updateOrCreate(['name' => 'admin']);
//         $role_anggota = Role::updateOrCreate(['name' => 'anggota']);
//         $role_pengurus = Role::updateOrCreate(['name' => 'pengurus']);

//         // Buat permission jika belum ada
//         $permissions = [
//             'view_dashboard', 
//             'manage_divisi', 
//             'manage_jadwal', 
//             'manage_pendaftar', 
//             'transaksi', 
//             'view_anggota', 
//             'view_jadwal', 
//             'manage_pengurus'
//         ];

//         foreach ($permissions as $perm) {
//             Permission::updateOrCreate(['name' => $perm]);
//         }

//         // Assign permission ke role
//         $role_admin->syncPermissions(['view_dashboard', 'manage_divisi', 'manage_jadwal', 'transaksi', 'manage_pengurus']);
//         $role_pengurus->syncPermissions(['view_dashboard', 'manage_pendaftar', 'transaksi']);
//         $role_anggota->syncPermissions(['view_anggota', 'view_jadwal']);

//         // Assign role ke user
//         $user = User::find(1); // Ambil user dengan ID 1
//         $user2 = User::find(2);

//         if ($user) {
//             $user->assignRole('admin');
//         }

//         if ($user2) {
//             $user2->assignRole(['anggota', 'pengurus']); // Menggunakan array untuk multi-role
//         }
//     }
// }

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::updateOrCreate(['name' => 'admin']);
        $role_pengurus = Role::updateOrCreate(['name' => 'pengurus']);
        $role_anggota = Role::updateOrCreate(['name' => 'anggota']);

        ////////////////////////////////////////////////////////////////////////////

        $permission = Permission::updateOrCreate(['name' => 'view_dashboard']);
        $permission2 = Permission::updateOrCreate(['name' => 'manage_divisi']);
        $permission3 = Permission::updateOrCreate(['name' => 'manage_jadwal']);

        $permission4 = Permission::updateOrCreate(['name'=> 'manage_pendaftar']);
        $permission5 = Permission::updateOrCreate(['name'=> 'transaksi']);

        $permission6 = Permission::updateOrCreate(['name'=> 'view_anggota']);
        $permission7 = Permission::updateOrCreate(['name'=> 'view_jadwal']);
        $permission8 = Permission::updateOrCreate(['name'=> 'manage_pengurus']);

        ////////////////////////////////////////////////////////////////////////////

        $role_admin -> givePermissionTo($permission);
        $role_admin -> givePermissionTo($permission2);
        $role_admin -> givePermissionTo($permission3);
        // $role_admin -> givePermissionTo($permission5);
        $role_admin -> givePermissionTo($permission8);

        $role_pengurus -> givePermissionTo($permission);
        $role_pengurus -> givePermissionTo($permission4);
        $role_pengurus -> givePermissionTo($permission5);


        $role_anggota -> givePermissionTo($permission6);
        $role_anggota -> givePermissionTo($permission7);

        ////////////////////////////////////////////////////////////////////////////

        $user  = User::find(1); //yg ada pada table user nomer 1
        // $user2 = User::find(2);
        // $user3 = User::find(3);
        // $user4 = User::find(4);

        $user->assignRole('admin');
        // $user2->assignRole('pengurus');
        // $user3->assignRole('anggota');
        // $user2->assignRole('anggota', 'pengurus');
        // $user->assignRole('admin', 'anggota'); // kalau 1 user 2 role
    }
}