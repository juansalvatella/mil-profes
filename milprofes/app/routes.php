<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//Home page
Route::get('/', array('as' => 'home', function()
{
    return View::make('home');
}));
Route::get('demo', function()
{
    return View::make('home');
});

//Search controller calls
Route::post('demo','SearchController@search');
Route::post('/demo/ajaxsearch','SearchController@search');

//Register telephone visualizations
Route::post('/phoneHandler/t_phone/{lesson_id}', function($lesson_id) {
    if (!Session::has('teacher_tlf_'.$lesson_id)) //if this Tlf visualization hasn't been recorded before (during the session)
    {
        Session::put('teacher_tlf_'.$lesson_id, true); //record the visualization in the session array
        Session::save();
        $visualization = new TeacherPhoneVisualization(); //register the visualization in database
        if ($observer = Auth::user()) //if user is authenticated relate the user id with the visualization
            $visualization->user_id = $observer->id;
        $visualization->teacher_lesson_id = $lesson_id;
        $visualization->save();
    }
    //Obtain telephone to be displayed >>> Obtain the school table that has the telephone field
    $lesson = TeacherLesson::findOrFail($lesson_id);
    $teacher = $lesson->teacher()->first();
    $observed_user = $teacher->user()->first();

    return $observed_user->phone;
});
Route::post('/phoneHandler/s_phone/{lesson_id}', function($lesson_id) {

    if (!Session::has('school_tlf_'.$lesson_id)) //if this Tlf visualization hasn't been recorded before (during the session)
    {
        Session::put('school_tlf_'.$lesson_id, true); //record the visualization in the session array
        Session::save();
        $visualization = new SchoolPhoneVisualization(); //register the visualization in database
        if ($observer = Auth::user()) //if user is authenticated relate the user id with the visualization
            $visualization->user_id = $observer->id;
        $visualization->school_lesson_id = $lesson_id;
        $visualization->save();
    }
    //Obtain telephone to be displayed >>> Obtain the school table that has the telephone field
    $lesson = SchoolLesson::findOrFail($lesson_id);
    $observed_school = $lesson->school()->first();

    return $observed_school->phone;
});

//Handle reviews
Route::post('/reviews/handleReview','ReviewsController@handleNewReview');

//Populate and view tables. Database test tools. FOR TEST PURPOSES ONLY!!!
Route::get('populate', 'PopulateController@populate');
Route::get('unpopulate', 'PopulateController@unpopulate');
Route::get('/list/{table}', function($table)
{
    if($table=='students' || $table=='estudiantes')
    {
        $rows = Student::all();
        $columns = Schema::getColumnListing('students');
    }
    elseif($table=='users' || $table=='usuarios')
    {
        $rows = User::all();
        $columns = Schema::getColumnListing('users');
    }
    elseif($table=='teachers' || $table=='profesores')
    {
        $rows = Teacher::all();
        $columns = Schema::getColumnListing('teachers');
    }
    elseif($table=='schools' || $table=='academias')
    {
        $rows = School::all();
        $columns = Schema::getColumnListing('schools');
    }
    elseif($table=='teacherlessons' || $table=='clasesdeprofesores')
    {
        $rows = TeacherLesson::all();
        $columns = Schema::getColumnListing('teacher_lessons');
    }
    elseif($table=='schoollessons' || $table=='clasesdeacademias')
    {
        $rows = SchoolLesson::all();
        $columns = Schema::getColumnListing('school_lessons');
    }
    elseif($table=='subjects' || $table=='materias')
    {
        $rows = Subject::all();
        $columns = Schema::getColumnListing('subjects');
    }
    elseif($table=='ratings')
    {
        $rows = Rating::all();
        $columns = Schema::getColumnListing('ratings');
    }
    elseif($table=='teacherphones' || $table=='telefonosprofesores')
    {
        $rows = TeacherPhoneVisualization::all();
        $columns = Schema::getColumnListing('teacher_lessons_phone_visualizations');
    }
    elseif($table=='schoolphones' || $table=='telefonosacademias')
    {
        $rows = SchoolPhoneVisualization::all();
        $columns = Schema::getColumnListing('school_lessons_phone_visualizations');
    }
    else
        return $table.' table not found';

    return View::make('show_table_contents', compact('table','rows','columns'));
});
Route::get('lastpayment', 'UsersController@paymentIsCurrent');
Route::get('ihavejustpaid', 'UsersController@updateLastPaymentDate');

// Confide routes
Route::get('users/create', function(){ return View::make('users_register'); });
Route::post('users', 'UsersController@store');
Route::get('users/login', function(){ return View::make('users_login'); });
Route::post('users/login', 'UsersController@doLogin');
Route::get('users/confirm/{code}', 'UsersController@confirm');
Route::get('users/forgot_password', 'UsersController@forgotPassword');
Route::post('users/forgot_password', 'UsersController@doForgotPassword');
Route::get('users/reset_password/{token}', 'UsersController@resetPassword');
Route::post('users/reset_password', 'UsersController@doResetPassword');
Route::get('users/logout', 'UsersController@logout');


//===================
//User control Panels
//===================
Route::get('userpanel/dashboard', array('as' => 'userpanel', function()
{
    $user = Auth::user();

    if(Entrust::hasRole('teacher'))
    {
        $teacher = $user->teacher()->first();
        $lessons = $teacher->lessons()->get();
        $subjects = array();
        foreach($lessons as $lesson)
        {
            $subjects[$lesson->id] = $lesson->subject()->first();
        }
        return View::make('userpanel_dashboard',compact('user'))->nest('content_teacher', 'userpanel_tabpanel_manage_lessons',compact('teacher','lessons','subjects'));
    }
    else
        return View::make('userpanel_dashboard',compact('user'))->nest('content_teacher', 'userpanel_tabpanel_become_teacher');
}));
Route::group(array('before' => 'csrf'), function() {
    Route::post('userpanel/dashboard', 'UsersController@updateUser');
});
Route::get('userpanel/become/teacher','UsersController@becomeATeacher');



//======================
//Teacher control panels
//======================
Route::get('teacher/create/lesson', function()
{
    $user = Auth::user();
    $teacher = $user->teacher()->first();

    return View::make('teacher_lesson_create',compact('user','teacher'));
});
Route::post('teacher/create/lesson', 'TeachersController@createLesson');
Route::get('teacher/edit/lesson/{lesson_id}', function($lesson_id)
{
    $lesson = TeacherLesson::findOrFail($lesson_id);
    $subject = $lesson->subject()->first();
    $lesson_teacher = $lesson->teacher()->first();

    $user = Auth::user();
    $teacher = $user->teacher()->first();

    if($teacher->id==$lesson_teacher->id) //Comprobamos que no se esté tratando de editar clases de otros usuarios
        return View::make('teacher_lesson_edit', compact('lesson','subject'));
    else
        return Redirect::route('userpanel')->with('failure', 'Error! Tu clase no ha sido encontrada');
});
Route::post('teacher/edit/lesson/{teacher_id}', 'TeachersController@saveLesson');
Route::get('teacher/delete/lesson/{lesson_id}', function($lesson_id)
{
    $lesson = TeacherLesson::findOrFail($lesson_id);
    $lesson_teacher = $lesson->teacher()->first();
    $subject = $lesson->subject()->first();

    $user = Auth::user();
    $teacher = $user->teacher()->first();

    if($teacher->id==$lesson_teacher->id) //Comprobamos que no se está tratando de eliminar las clases de otros usuarios
        return View::make('teacher_lesson_confirm_delete', compact('user','lesson','subject'));
    else
        return Redirect::route('userpanel')->with('failure', 'Error! Tu clase no ha sido encontrada');
});
Route::post('teacher/delete/lesson/{teacher_id}', 'TeachersController@deleteLesson');



//====================
//Admin control Panels
//====================
Route::get('admin/schools', function()
{
    $schools = School::orderBy('name')->get();
    $lessons = array();
    foreach($schools as $school)
    {
        $lessons[$school->id] = SchoolLesson::where('school_id',$school->id)->get();
    }

    return View::make('schools_dashboard', compact('schools','lessons'));
});

Route::get('admin/create/school', function(){ return View::make('school_register'); });
Route::post('admin/create/school', 'AdminController@createSchool');
Route::get('admin/edit/school/{school_id}', function($school_id)
{
    $school = School::findOrFail($school_id);

    return View::make('school_edit', compact('school'));
});
Route::post('admin/edit/school/{school_id}','AdminController@saveSchool');
Route::get('admin/delete/school/{school_id}',function($school_id)
{
    $school = School::findOrFail($school_id);

    return View::make('school_confirm_delete',compact('school'));
});
Route::post('admin/delete/school/{school_id}','AdminController@deleteSchool');

Route::get('admin/lessons/{school_id}', array('as' => 'lessons', function($school_id)
{
    $school = School::findOrFail($school_id);
    $lessons = SchoolLesson::where('school_id',$school_id)->get();
    $subjects = array();
    foreach($lessons as $lesson)
    {
        $subjects[$lesson->id] = $lesson->subject()->first();
    }

    return View::make('lessons_dashboard', compact('school','lessons','subjects'));
}));

Route::get('admin/create/lesson/{school_id}', function($school_id)
{
    $school = School::findOrFail($school_id);

    return View::make('lesson_create', compact('school'));
});
Route::post('admin/create/lesson/{school_id}', 'AdminController@createLesson');
Route::get('admin/edit/lesson/{lesson_id}', function($lesson_id)
{
    $lesson = SchoolLesson::findOrFail($lesson_id);
    $school = $lesson->school()->first();
    $subject = $lesson->subject()->first();

    return View::make('lesson_edit', compact('lesson','school','subject'));
});
Route::post('admin/edit/lesson/{school_id}', 'AdminController@saveLesson');
Route::get('admin/delete/lesson/{lesson_id}', function($lesson_id)
{
    $lesson = SchoolLesson::findOrFail($lesson_id);
    $school = $lesson->school()->first();
    $subject = $lesson->subject()->first();

    return View::make('lesson_confirm_delete', compact('lesson','school','subject'));
});
Route::post('admin/delete/lesson/{school_id}', 'AdminController@deleteLesson');


//Auth filters
//Route::when('userpanel/*', 'auth');

//Not ready. To be implemented.
    //Route::get('contact', function()
    //{
    //    return View::make('contact');
    //});
    //
    //Route::get('faq', function()
    //{
    //    return View::make('faq');
    //});
    //