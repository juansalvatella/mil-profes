<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $student_role = Role::where('name','student')->first();
        $teacher_role = Role::where('name','teacher')->first();
        $admin_role = Role::where('name','admin')->first();
        $faker = Faker\Factory::create('es_ES');

        /* Create user admin (Confide prevents the use of create method
        *  so we need to use the raw DB table insert method instead */
        $adminUserData = [[
            'username' => 'admin',
            'slug' => 'admin',
            'name' => 'Administrador',
            'lastname' => 'de milPROFES',
            'email' => 'info@milprofes.com',
            'phone' => '001112233',
            'address' => 'Barcelona',
            'town' => 'Barcelona',
            'postalcode' => '08080',
            'region' => 'Barcelona',
            'date_of_birth' => '1789-08-13',
            'gender' => 'male',
            'link_web' => 'http://'.$faker->domainName(),
            'link_facebook' => 'http://'.$faker->domainName(),
            'link_twitter' => 'http://'.$faker->domainName(),
            'link_linkedin' => 'http://'.$faker->domainName(),
            'link_googleplus' => 'http://'.$faker->domainName(),
            'link_instagram' => 'http://'.$faker->domainName(),
            'description' => 'Administrador de milPROFES en entorno local',
            'lat' => '41.3850639',
            'lon' => '2.1734035',
            'password' => Hash::make('admin'),
            'confirmation_code' => '1cac4b10d9474095fe8f516a0f1ba7e5',
            'remember_token' => '2NVtAZKSDImo62EPmgMMwXB8iu7VeJpJ8m6RgT8x77kiRgrvWUujmSwmRlhx',
            'confirmed' => '1',
            'status' => 'Active',
            'origin' => 'Seeder'
        ]];
        DB::table('users')->insert($adminUserData);
        $adminUser = User::where('username','admin')->first();

        // Admin is also student and teacher
        $teacher = new Teacher();
        $teacher->user()->associate($adminUser);
        $teacher->save();

        $student = new Student();
        $student->user()->associate($adminUser);
        $student->save();

        // Attach all roles to user Admin
        $adminUser->attachRole($admin_role);
        $adminUser->attachRole($student_role);
        $adminUser->attachRole($teacher_role);

        $files = glob(public_path('img/avatars').'/*.*'); //avatars list
        for($i=0;$i<40;++$i) {
            $gender = $faker->randomElement(['male','female']);
            $username = $faker->unique()->userName();
            $street = 'Mayor';
            $number = $faker->randomDigit(2);
            $town = $faker->randomElement(['Barcelona','Badalona','Sant Just','Sant Joan','Martorell','Igualada','Castellbisbal','Manresa','Tarragona','Lleida','Girona','Sabadell','Sant Cugat','Vic']);
            $address = $street.', '.$number.', '.$town;
            $avatarFileName = basename($files[array_rand($files)]); //pick random avatar
            $geocoding = Geocoding::geocode($address);
            $newUserData = [[
                'username' => $username,
                'slug' => $username,
                'name' => $faker->firstName($gender),
                'lastname' => $faker->lastName(),
                'email' => $username.'@gmail.com',
                'phone' => $faker->randomNumber(9),
                'address' => isset($geocoding[2]) ? $geocoding[2] : 'Barcelona',
                'town' => isset($geocoding[3]['locality']) ? $geocoding[3]['locality'] : null,
                'postalcode' => isset($geocoding[3]['postal_code']) ? $geocoding[3]['postal_code'] : null,
                'region' => isset($geocoding[3]['admin_2']) ? $geocoding[3]['admin_2'] : null,
                'date_of_birth' => $faker->date(),
                'gender' => $gender,
                'avatar' => $avatarFileName,
                'link_web' => 'http://'.$faker->domainName(),
                'link_facebook' => 'http://'.$faker->domainName(),
                'link_twitter' => 'http://'.$faker->domainName(),
                'link_linkedin' => 'http://'.$faker->domainName(),
                'link_googleplus' => 'http://'.$faker->domainName(),
                'link_instagram' => 'http://'.$faker->domainName(),
                'description' => $faker->text(250),
                'lat' => isset($geocoding[0]) ? $geocoding[0] : '41.3850639',
                'lon' => isset($geocoding[1]) ? $geocoding[1] : '2.1734035',
                'password' => Hash::make('123456'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'remember_token' => '2NVtAZKSDImo62EPmgMMwXB8iu7VeJpJ8m6RgT8x77kiRgrvWUujmSwmRlhx',
                'confirmed' => true,
                'status' => 'Active',
                'origin' => 'Seeder',
            ]];
            DB::table('users')->insert($newUserData);
            $newUser = User::where('username',$username)->first();

            $case = mt_rand(0,1); // 0 = student, 1 = student+teacher
            if($case == 0) { //student
                $student = new Student();
                $student->user()->associate($newUser);
                $student->save();

                $newUser->attachRole($student_role);
            } else { //student + teacher
                $teacher = new Teacher();
                $teacher->user()->associate($newUser);
                $teacher->save();

                $student = new Student();
                $student->user()->associate($newUser);
                $student->save();

                $newUser->attachRole($student_role);
                $newUser->attachRole($teacher_role);
            }
        }
    }
}