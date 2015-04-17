<?php

//Route Model Bindings
Route::model('user','User');
Route::model('teacher_review','Rating');
Route::model('school_review','SchoolLessonRating');
Route::model('teacher','Teacher');
Route::model('school','School');
Route::model('teacher_lesson','TeacherLesson');
Route::model('school_lesson','SchoolLesson');

//CSRF protection
Route::when('*', 'csrf', array('post', 'put', 'delete'));

//============
// Main Pages
//============

//Home
Route::get('/', array('as' => 'home', function()
{
    $popular_teachers = Milprofes::getPopularTeachers(4);
    $popular_schools = Milprofes::getPopularSchools(4);

    return View::make('home', compact('popular_schools','popular_teachers'));
}));

//Profiles
Route::get('profe/{user_slug}', function($user_slug) {
    $user = User::findBySlug($user_slug);
    $teacher = $user->teacher()->first();
    //if passing by ID: $user = $teacher->user()->get(array('username','avatar','email','phone','description'));
    $teacher->slug = $user_slug;
    $teacher->username = $user->username;
    $teacher->avatar = $user->avatar;
    $teacher->email = $user->email;
    $teacher->phone = $user->phone;
    $teacher->description = $user->description;
    $lessons = $teacher->lessons()->get();
    $teacher->availability = $teacher->availabilities()->get();

    return View::make('teacher_details', compact('teacher','lessons'));
});
Route::get('academia/{school_slug}', function($school_slug) {
    $school = School::findBySlug($school_slug);
    $lessons = $school->lessons()->get();
    foreach($lessons as $l) {
        $l->availability = $l->availabilities()->get();
    }

    //pagination by slices (first page)
    $lessons_per_slice = 2;
    $total_results = $lessons->count();
    $max_slices = ceil($total_results/$lessons_per_slice);
    $slices_showing = 0;
    $sl_offset = $slices_showing*$lessons_per_slice;
    $sl_length = $lessons_per_slice;
    $lessons = $lessons->slice($sl_offset,$sl_length);
    ++$slices_showing;
    $display_show_more = ($total_results==0 || $slices_showing == $max_slices) ? false : true;
    $slpics = $school->pics()->get(array('pic'));

    return View::make('school_details', compact('school','slpics','lessons','display_show_more','slices_showing','total_results'));
});
Route::post('academia/{school_slug}', function($school_slug) {
    $school = School::findBySlug($school_slug);
    $lessons = $school->lessons()->get();
    foreach($lessons as $l) {
        $l->availability = $l->availabilities()->get();
    }

    //pagination by slices
    $input = Input::all();
    $lessons_per_slice = 2;
    $total_results = $lessons->count();
    $max_slices = ceil($total_results/$lessons_per_slice);
    $slices_showing = Input::has('slices_showing') ? $input['slices_showing'] : 0;
    $sl_offset = $slices_showing*$lessons_per_slice;
    $sl_length = $lessons_per_slice;
    $lessons = $lessons->slice($sl_offset,$sl_length);
    ++$slices_showing;
    $display_show_more = ($total_results==0 || $slices_showing == $max_slices) ? false : true;
    $slpics = $school->pics()->get();

    return View::make('school_details', compact('school','slpics','lessons','display_show_more','slices_showing','total_results'));
});

//Search
Route::get('resultados','SearchController@search');
Route::post('resultados','SearchController@search');
//Route::post('resultados/async','SearchController@search');
//Route::post('/search','SearchController@search');

//Faqs
Route::get('preguntas-frecuentes', function(){
    return View::make('faqs');
});
//Who
Route::get('milprofes', function() {
    return View::make('who');
});
//Contact
Route::get('contacta', function() {
    return View::make('contact');
});
//Aviso legal
Route::get('condiciones', function() {
    return View::make('aviso_legal');
});
//Cookies
Route::get('cookies', function() {
    return View::make('cookies');
});
//Política de privacidad
Route::get('privacidad', function() {
    return View::make('politica_privacidad');
});
//Mapa del sitio
Route::get('mapa', function() {
    return View::make('mapa');
});
Route::post('contactanos','ContactController@getContactForm');
Route::post('/','ContactController@getMiniContactForm');

//Register contact info requests
Route::post('request/info/teacher/{lesson_id}', function($lesson_id) {
    if (!Session::has('t_visualized_'.$lesson_id)) //if this Tlf visualization hasn't been recorded before (during the session)
    {
        Session::put('t_visualized_'.$lesson_id, true); //record the visualization in the session array
        Session::save();
        $visualization = new TeacherPhoneVisualization(); //register the visualization in database
        if (Auth::check()) { //if user is authenticated relate the user id with the visualization
            $observer = Confide::user();
            $visualization->user_id = $observer->id;
        }
        $visualization->teacher_lesson_id = $lesson_id;

        return (string) $visualization->save();
    }
    return 'Already saved in DB';
});
Route::post('request/info/school/{lesson_id}', function($lesson_id) {
    if (!Session::has('s_visualized_'.$lesson_id)) //if this Tlf visualization hasn't been recorded before (during the session)
    {
        Session::put('s_visualized_'.$lesson_id, true); //record the visualization in the session array
        Session::save();
        $visualization = new SchoolPhoneVisualization(); //register the visualization in database
        if (Auth::check()) { //if user is authenticated relate the user id with the visualization
            $observer = Confide::user();
            $visualization->user_id = $observer->id;
        }
        $visualization->school_lesson_id = $lesson_id;

        return (string) $visualization->save();
    }
    return 'Already saved in DB';
});

//Handle reviews
Route::post('/reviews/handleReview','ReviewsController@handleNewReview');
Route::post('/reviews/handleSchoolLessonReview','ReviewsController@handleSchoolLessonNewReview');

//Populate and view tables. Database test tools. FOR TEST PURPOSES ONLY!!!

//Route::get('populate', 'PopulateController@populate');
//Route::get('unpopulate', 'PopulateController@unpopulate');
//Route::get('/list/{table}', function($table)
//{
//    if($table=='students' || $table=='estudiantes')
//    {
//        $rows = Student::all();
//        $columns = Schema::getColumnListing('students');
//    }
//    elseif($table=='users' || $table=='usuarios')
//    {
//        $rows = User::all();
//        $columns = Schema::getColumnListing('users');
//    }
//    elseif($table=='teachers' || $table=='profesores')
//    {
//        $rows = Teacher::all();
//        $columns = Schema::getColumnListing('teachers');
//    }
//    elseif($table=='schools' || $table=='academias')
//    {
//        $rows = School::all();
//        $columns = Schema::getColumnListing('schools');
//    }
//    elseif($table=='teacherlessons' || $table=='clasesdeprofesores')
//    {
//        $rows = TeacherLesson::all();
//        $columns = Schema::getColumnListing('teacher_lessons');
//    }
//    elseif($table=='schoollessons' || $table=='clasesdeacademias')
//    {
//        $rows = SchoolLesson::all();
//        $columns = Schema::getColumnListing('school_lessons');
//    }
//    elseif($table=='subjects' || $table=='materias')
//    {
//        $rows = Subject::all();
//        $columns = Schema::getColumnListing('subjects');
//    }
//    elseif($table=='ratings')
//    {
//        $rows = Rating::all();
//        $columns = Schema::getColumnListing('ratings');
//    }
//    elseif($table=='teacherphones' || $table=='telefonosprofesores')
//    {
//        $rows = TeacherPhoneVisualization::all();
//        $columns = Schema::getColumnListing('teacher_lessons_phone_visualizations');
//    }
//    elseif($table=='schoolphones' || $table=='telefonosacademias')
//    {
//        $rows = SchoolPhoneVisualization::all();
//        $columns = Schema::getColumnListing('school_lessons_phone_visualizations');
//    }
//    else
//        return $table.' table not found';
//
//    return View::make('show_table_contents', compact('table','rows','columns'));
//});

//payment handlers. future implementation

//Route::get('lastpayment', 'UsersController@paymentIsCurrent');
//Route::get('ihavejustpaid', 'UsersController@updateLastPaymentDate');

// Confide routes
Route::get('users/create', function(){ return View::make('users_register'); });
Route::post('users', 'UsersController@store');
Route::get('users/login', function(){ return View::make('users_login'); });
Route::post('users/login', 'UsersController@doLogin');
Route::get('users/confirm/{code}', 'UsersController@confirm');
Route::get('users/forgot-password', 'UsersController@forgotPassword');
Route::post('users/forgot-password', 'UsersController@doForgotPassword');
Route::get('users/reset-password/{token}', 'UsersController@resetPassword');
Route::post('users/reset-password', 'UsersController@doResetPassword');
Route::get('users/logout', 'UsersController@logout');


//===================
//User control Panels
//===================
Route::get('userpanel/dashboard', array('as' => 'userpanel', function()
{
    $user = Confide::user();

    if(Entrust::hasRole('teacher'))
    {
        $teacher = $user->teacher()->first();
        $teacher_id = $teacher->id;
        $lessons = $teacher->lessons()->get();
        $subjects = array();
        foreach($lessons as $lesson) {
            $subjects[$lesson->id] = $lesson->subject()->first();
        }
        $picks = $teacher->availabilities()->get();
        if($picks->count()!=9) //if teacher has never saved availability before, create 9 new picks with the input
        {
            for ($i = 1; $i < 10; ++$i) {
                $pick = new TeacherAvailability();
                $pick->teacher_id = $teacher_id;
                $pick->pick = '' . $i;
                $pick->day = '';
                $pick->start = '15:00:00';
                $pick->end = '21:00:00';
                $pick->save();
            }
            $picks = $teacher->availabilities()->get();
        }

        $n_picks_set = 0;
        foreach($picks as $pick) //check how many picks are not blank
        {
            if($pick->day == '') {
                break;
            }
            ++$n_picks_set;
        }
        $picks = $picks->toArray();

        return View::make('userpanel_dashboard',compact('user'))->nest('content_teacher', 'userpanel_tabpanel_manage_lessons',compact('teacher','lessons','subjects','picks','n_picks_set'));
    }
    else
        return View::make('userpanel_dashboard',compact('user'))->nest('content_teacher', 'userpanel_tabpanel_become_teacher');
}));
Route::post('userpanel/dashboard/update/info', 'UsersController@updateUser');
Route::post('userpanel/dashboard/update/avatar', 'UsersController@updateAvatar');
Route::post('userpanel/dashboard/update/passwd', 'UsersController@updateUserPasswd');
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
        return Redirect::route('userpanel')->with('failure', '¡Error! Tu clase no ha sido encontrada');
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
Route::post('teacher/availability/save', 'TeachersController@saveAvailability');


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
Route::get('admin/reviews', function()
{
    $schoolReviews = SchoolLessonRating::all();
    $teacherReviews = Rating::all();
    $reviews = $schoolReviews->merge($teacherReviews);
    $reviews->sortByDesc(function ($review) {
        return $review->created_at;
    });
    foreach($reviews as $review)
    {
        if($review->student_id) { //la valoración ha sido realizada por un usuario registrado
            $user = Student::findOrFail($review->student_id)->user->first();
            $review->valorador = $user->username;
            $review->wasUser = true;
        } else {
            $review->valorador = 'Nombre';
            $review->wasUser = false;
        }
        if($review->teacher_lesson_id) { //es una review de lesson de profesor
            $user = TeacherLesson::findOrFail($review->teacher_lesson_id)->teacher->user->first();
            $review->type = 'Profesor';
            $review->valorado = $user->name;
        } else { //es una review de lesson de academia
            $school = SchoolLesson::findOrFail($review->school_lesson_id)->school->first();
            $review->type = 'Academia';
            $review->valorado = $school->name;
        }
    }

    return View::make('admin_reviews', compact('reviews'));

});
Route::get('admin/delete/review/{type}/{id}', 'AdminController@deleteReview');
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
    $picks = $lesson->availabilities()->get();
    if($picks->count()!=9) //if the school lesson has never had availability before, create 9 new picks with the input
    {
        for ($i = 1; $i < 10; ++$i) {
            $pick = new SchoolLessonAvailability();
            $pick->school_lesson_id = $lesson_id;
            $pick->pick = '' . $i;
            $pick->day = '';
            $pick->start = '15:00:00';
            $pick->end = '21:00:00';
            $pick->save();
        }
        $picks = $lesson->availabilities()->get();
    }
    $n_picks_set = 0;
    foreach($picks as $pick) //check how many picks are not blank
    {
        if($pick->day == '') {
            break;
        }
        ++$n_picks_set;
    }
    $picks = $picks->toArray();

    return View::make('lesson_edit', compact('lesson','school','subject','picks','n_picks_set'));
});
Route::post('admin/edit/lesson/{school_id}', 'AdminController@saveLesson');
Route::get('admin/delete/lesson/{lesson_id}', function($lesson_id) {
    $lesson = SchoolLesson::findOrFail($lesson_id);
    $school = $lesson->school()->first();
    $subject = $lesson->subject()->first();

    return View::make('lesson_confirm_delete', compact('lesson','school','subject'));
});
Route::post('admin/delete/lesson/{school_id}', 'AdminController@deleteLesson');
Route::post('load-school-profile-pics','AdminController@loadProfilePics');
