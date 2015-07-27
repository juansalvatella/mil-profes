<?php

use Illuminate\Database\Seeder;
use Cocur\Slugify\Slugify;

class SchoolsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create('es_ES');
        $slugify = new Slugify();
        $files = glob(public_path('img/logos').'/*.*'); //logos list
        for($i=0;$i<40;++$i) {
            $schoolname = $faker->company();
            $street = 'Mayor';
            $number = $faker->randomDigit(1);
            $town = $faker->randomElement(['Barcelona','Badalona','Sant Just','Sant Joan','Martorell','Igualada','Castellbisbal','Manresa','Tarragona','Lleida','Girona','Sabadell','Sant Cugat','Vic']);
            $address = $street.', '.$number.', '.$town;
            $logoFileName = basename($files[array_rand($files)]); //pick random logo
            $geocoding = Geocoding::geocode($address);
            $school = School::create([
                'name' => $schoolname,
                'slug' => $slugify->slugify($schoolname),
                'address' => isset($geocoding[2]) ? $geocoding[2] : 'Barcelona',
                'town' => isset($geocoding[3]['locality']) ? $geocoding[3]['locality'] : null,
                'postalcode' => isset($geocoding[3]['postal_code']) ? $geocoding[3]['postal_code'] : null,
                'region' => isset($geocoding[3]['admin_2']) ? $geocoding[3]['admin_2'] : null,
                'cif' => strtoupper($faker->bothify('?########')), //ej.: A58818501
                'email' => $faker->companyEmail(),
                'phone' => $faker->randomNumber(9),
                'phone2' => $faker->randomNumber(9),
                'logo' => $logoFileName,
                'link_web' => 'http://'.$faker->domainName(),
                'link_facebook' => 'http://'.$faker->domainName(),
                'link_twitter' => 'http://'.$faker->domainName(),
                'link_linkedin' => 'http://'.$faker->domainName(),
                'link_googleplus' => 'http://'.$faker->domainName(),
                'link_instagram' => 'http://'.$faker->domainName(),
                'video' => '0va3F2PWBJc',
                'description' => $faker->text(250),
                'lat' => isset($geocoding[0]) ? $geocoding[0] : '41.3850639',
                'lon' => isset($geocoding[1]) ? $geocoding[1] : '2.1734035',
                'status' => 'Active',
                'origin' => 'Seeder',
            ]);

            //associate pics (for the profile carousel) to each school
            for($j=1;$j<5;++$j)
                SchoolPic::create([
                    'school_id' => $school->id,
                    'pic' => 'local'.$j.'.png'
                ]);
        }
    }
}

