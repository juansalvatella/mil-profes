<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		if(App::environment() !== 'local')
			exit('Not in local environment! SEEDING ABORTED!');

		$this->call('PermissionsRolesSeeder');
		$this->call('UsersSeeder');
		$this->call('SchoolsSeeder');
		$this->call('SubjectsSeeder');
		$this->call('TeacherLessonsSeeder');
		$this->call('SchoolLessonsSeeder');
		$this->call('RatingsSeeder');
		$this->call('VisualizationsSeeder');

		$this->command->info('Done!');
	}

}
