<?php

use Illuminate\Database\Seeder;

class PermissionsRolesSeeder extends Seeder
{
    public function run()
    {
        $adminRole = new Role;
        $adminRole->name = 'admin';
        $adminRole->save();

        $teacherRole = new Role;
        $teacherRole->name = 'teacher';
        $teacherRole->save();

        $studentRole = new Role;
        $studentRole->name = 'student';
        $studentRole->save();

        $manageLessons = new Permission;
        $manageLessons->name = 'manage_lessons';
        $manageLessons->display_name = 'Manage all lessons';
        $manageLessons->save();

        $manageSchools = new Permission;
        $manageSchools->name = 'manage_schools';
        $manageSchools->display_name = 'Manage all schools';
        $manageSchools->save();

        $manageUsers = new Permission;
        $manageUsers->name = 'manage_users';
        $manageUsers->display_name = 'Manage all users';
        $manageUsers->save();

        $manageOwnAccount = new Permission;
        $manageOwnAccount->name = 'manage_own_account';
        $manageOwnAccount->display_name = 'Manage owned user account';
        $manageOwnAccount->save();

        $manageOwnLessons = new Permission;
        $manageOwnLessons->name = 'manage_own_lessons';
        $manageOwnLessons->display_name = 'Manage owned lessons';
        $manageOwnLessons->save();
        
        $studentRole->perms()->sync([$manageOwnAccount->id]);
        $teacherRole->perms()->sync([$manageOwnLessons->id]);
        $adminRole->perms()->sync([$manageLessons->id,$manageUsers->id,$manageSchools->id]);
    }
}