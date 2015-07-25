<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	/**
	 * Show the main page of milprofes
	 * @return \Illuminate\View\View
	 */
	public function showWelcome()
	{
		$popular_teachers = Milprofes::getPopularTeachers(15);
		$popular_schools = Milprofes::getPopularSchools(15);

		foreach($popular_teachers as $teacher)
		{
			$teacher->avgRating = Teacher::find($teacher->teacher_id)->getTeacherAvgRating();
		}

		foreach($popular_schools as $school)
		{
			$school->avgRating = $school->getSchoolAvgRating();
			$school->category = $school->lessons()->first()->subject()->first();
		}

		return View::make('home', compact('popular_schools','popular_teachers'));
	}

}
