<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::create(['name' => 'Admin']);
        $permissionShowDosen = Permission::create(['name' => 'show_dosen']);
        $permissionCreateDosen = Permission::create(['name' => 'create_dosen']);
        $permissionUpdateDosen = Permission::create(['name' => 'update_dosen']);
        $permissionDeleteDosen = Permission::create(['name' => 'delete_dosen']);
        $permissionShowMhs = Permission::create(['name' => 'show_mhs']);
        $permissionCreateMhs = Permission::create(['name' => 'create_mhs']);
        $permissionUpdateMhs = Permission::create(['name' => 'update_mhs']);
        $permissionDeleteMhs = Permission::create(['name' => 'delete_mhs']);
        $permissionShowMatkul = Permission::create(['name' => 'show_matkul']);
        $permissionCreateMatkul = Permission::create(['name' => 'create_matkul']);
        $permissionUpdateMatkul = Permission::create(['name' => 'update_matkul']);
        $permissionDeleteMatkul = Permission::create(['name' => 'delete_matkul']);
        $permissionShowNilai = Permission::create(['name' => 'show_nilai']);
        $permissionCreateNilai = Permission::create(['name' => 'create_nilai']);
        $permissionUpdateNilai = Permission::create(['name' => 'update_nilai']);
        $permissionShowLoogbook = Permission::create(['name' => 'show_loogbok']);
        $permissionCreateLoogbook = Permission::create(['name' => 'create_loogbok']);
        $permissionShowLaporan = Permission::create(['name' => 'show_laporan']);
        $permissionCreaateLaporan = Permission::create(['name' => 'create_laporan']);
        $permissionUpdateLaporan = Permission::create(['name' => 'update_laporan']);
        $permissionDeleteLaporan = Permission::create(['name' => 'delete_laporan']);
        $permissionShowSeminar = Permission::create(['name' => 'show_seminar']);
        $permissionCreateSeminar = Permission::create(['name' => 'create_seminar']);
        $permissionUpdateSeminar = Permission::create(['name' => 'update_seminar']);
        $permissionDeleteSeminar = Permission::create(['name' => 'delete_seminar']);

        $roleAdmin->givePermissionTo([
            $permissionShowDosen,
            $permissionCreateDosen,
            $permissionUpdateDosen,
            $permissionDeleteDosen,
            $permissionShowMhs,
            $permissionCreateMhs,
            $permissionUpdateMhs,
            $permissionDeleteMhs,
            $permissionShowMatkul,
            $permissionCreateMatkul,
            $permissionUpdateMatkul,
            $permissionDeleteMatkul,
        ]);

        $roleDosen = Role::create(['name' => 'Dosen']);
        $roleDosen->givePermissionTo([
            $permissionShowMhs,
            $permissionShowMatkul,
            $permissionCreateNilai,
            $permissionUpdateNilai,
            $permissionShowNilai
        ]);

         $roleMhs = Role::create(['name' => 'Mahasiswa']);
         $roleMhs->givePermissionTo([
            $permissionShowMatkul,
            $permissionCreateNilai,
            $permissionCreateLoogbook,
            $permissionShowLoogbook,
            $permissionShowLaporan,
            $permissionCreaateLaporan,
            $permissionUpdateLaporan,
            $permissionDeleteLaporan,
            $permissionShowSeminar,
            $permissionCreateSeminar,
            $permissionUpdateSeminar,
            $permissionDeleteSeminar
        ]);
    }
}
