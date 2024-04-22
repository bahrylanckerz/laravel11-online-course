<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ownerRole = Role::create([
            'name' => 'owner'
        ]);
        $teacherRole = Role::create([
            'name' => 'teacher'
        ]);
        $studentRole = Role::create([
            'name' => 'student'
        ]);

        $userOwner = User::create([
            'name'       => 'Saepul Bahri',
            'email'      => 'bahri@gmail.com',
            'password'   => bcrypt('bahri123'),
            'occupation' => 'Educator',
            'avatar'     => 'avatars/default.png',
        ]);
        $userOwner->assignRole($ownerRole);
    }
}
