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
Route::get('/', ['as' => 'home', function()
{
    $popular_teachers = Milprofes::getPopularTeachers(4);
    $popular_schools = Milprofes::getPopularSchools(4);

    return View::make('home', compact('popular_schools','popular_teachers'));
}]);

//Profiles
Route::get('profe/{user_slug}',['as' => 'profiles-teacher', function($user_slug) {
    $user = User::findBySlug($user_slug);
    $teacher = $user->teacher()->first();

    //Incrementar número de visitas en uno (por visitante y sesión)
    if (!Session::has('profile_visited_'.$user_slug)) {
        $teacher->profile_visits = $teacher->profile_visits + 1;
        $teacher->save(); //increments profile visits counter, notice that this changes the updated_at column in teachers table
        Session::put('profile_visited_' . $user_slug, true);
        Session::save();
    }

    //Check if the visitor is the teacher himself
    if(Auth::check()) {
        $current_user = Confide::user();
        if($user->id == $current_user->id)
            $teacher->itsme = true;
    }

    //Calcular antiguedad en milprofes (en array con keys years, months, etc.)
    $datetime1 = new DateTime();
    $datetime2 = new DateTime($teacher->created_at);
    $interval = $datetime1->diff($datetime2);
    $elapsed = $interval->format('%y-%m-%d-%h-%i-%S');
    $elapsedKeys = ['years','months','days','hours','minutes','seconds'];
    $teacher->antiguedad = array_combine($elapsedKeys, explode("-", $elapsed));

    //Calcular popularidad
    $qArray = DB::select(DB::raw("
        SELECT tranking.rank FROM (
          SELECT
            t4.teacher_id,
            t4.user_id,
            SUM(t4.count)            AS 'total',
            @curRank := @curRank + 1 AS rank
          FROM (
                 SELECT
                   t1.teacher_lesson_id,
                   t2.teacher_id,
                   t3.user_id,
                   count(*) AS 'count'
                 FROM teacher_lessons_phone_visualizations AS t1
                   LEFT JOIN teacher_lessons AS t2
                     ON t2.id = t1.teacher_lesson_id
                   LEFT JOIN teachers AS t3
                     ON t3.id = t2.teacher_id
                 GROUP BY t1.teacher_lesson_id
               ) AS t4, (SELECT @curRank := 0) r
          GROUP BY t4.teacher_id
        ) AS tranking
        WHERE tranking.user_id = ?;
    "),array($user->id));
    if(!empty($qArray))
        $teacher->rank = (int) $qArray[0]->rank;

    //Fecha de última actualización es el mínimo entre las fechas de última modificación de clases y fecha de última actualización de perfil
    $dates = array();
    $lessons = $teacher->lessons()->get();
    foreach($lessons as $l)
        $dates[] = $l->updated_at;
    $dates[] = $teacher->updated_at;
    $last_one = new DateTime(min($dates));
    if(!empty($dates))
        $teacher->last_update = $last_one->format('d/m/Y h:i');

    //Calcular edad
    if ($user->date_of_birth) {
        $birthDate = $user->date_of_birth;
        $birthDate = explode("-", $birthDate);
        $teacher->age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md") ? ((date("Y") - $birthDate[0]) - 1) : (date("Y") - $birthDate[0]));
    }

    //Otros datos (importados de table user)
    $teacher->slug = $user_slug;
    $teacher->username = $user->username;
    $teacher->displayName = ucwords($user->name).' '.substr(ucwords($user->lastname),0,1).'.';
    $teacher->avatar = $user->avatar;
    $teacher->email = $user->email;
    $teacher->phone = $user->phone;
    $teacher->description = $user->description;
    $teacher->town = $user->town;
    $teacher->gender = $user->gender;

    $teacher->link_f = $user->link_facebook;
    $teacher->link_t = $user->link_twitter;
    $teacher->link_l = $user->link_linkedin;
    $teacher->link_g = $user->link_googleplus;
    $teacher->link_i = $user->link_instagram;
    $teacher->link_w = $user->link_web;

    $teacher->availability = $teacher->availabilities()->get();

    $geocoding = Geocoding::geocode($user->address);
    if($geocoding) {
        if(isset($geocoding[3]['admin_1']))
            $teacher->region = $geocoding[3]['admin_1'];
        if(isset($geocoding[3]['postal_code']))
            $teacher->postalcode = $geocoding[3]['postal_code'];
    }

    return View::make('new_teacher_details', compact('teacher','lessons'));
}]);

Route::post('review/was/helpful/{review_id}', function($review_id){
    if(!Auth::check())
        return Response::json(['error'=>'Reviewer is not authenticated.'],200);
    if (!Session::has('r_helpful_'.$review_id)) {
        Session::put('r_helpful_'.$review_id, true);
        Session::save();
        $review = Rating::findOrFail($review_id);
        $review->yes_helpful = $review->yes_helpful + 1;
        $review->total_helpful = $review->total_helpful + 1;
        if($review->save())
            return Response::json(['success'=>'success','msg'=>'Muchas gracias por compartir tu opinión.'],200);
    } else {
        return Response::json(['success'=>'warning','msg'=>'No es posible evaluar el mismo comentario más de una vez.'],200);
    }
    return Response::json(['success'=>'error','msg'=>'Se ha producido un Error. Prueba de nuevo en unos minutos.'],200);
});

Route::post('review/not/helpful/{review_id}', function($review_id){
    if(!Auth::check())
        return Response::json(['error'=>'Reviewer is not authenticated.'],200);
    if (!Session::has('r_helpful_'.$review_id)) {
        Session::put('r_helpful_'.$review_id, true);
        Session::save();
        $review = Rating::findOrFail($review_id);
        $review->total_helpful = $review->total_helpful + 1;
        if($review->save())
            return Response::json(['success'=>'success','msg'=>'Muchas gracias por compartir tu opinión.'],200);
    } else {
        return Response::json(['success'=>'warning','msg'=>'No es posible evaluar el mismo comentario más de una vez.'],200);
    }
    return Response::json(['success'=>'error','msg'=>'Se ha producido un Error. Prueba de nuevo en unos minutos.'],200);
});

Route::get('academia/{school_slug}', ['as'=>'profiles-school', function($school_slug) {
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
}]);

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
Route::get('resultados',['as'=>'results','uses'=>'SearchController@search']);

Route::post('resultados','SearchController@search');
//Route::post('resultados/async','SearchController@search');
//Route::post('/search','SearchController@search');

//Faqs
Route::get('preguntas-frecuentes',['as'=>'faqs', function(){
    return View::make('faqs');
}]);

//Who
Route::get('milprofes',['as'=>'who', function() {
    return View::make('who');
}]);

//Contact
Route::get('contacta',['as'=>'contact', function() {
    return View::make('contact');
}]);

//Aviso legal
Route::get('condiciones',['as'=>'terms', function() {
    return View::make('aviso_legal');
}]);

//Cookies
Route::get('cookies',['as'=>'cookies', function() {
    return View::make('cookies');
}]);

//Política de privacidad
Route::get('privacidad',['as'=>'privacy', function() {
    return View::make('politica_privacidad');
}]);

//Mapa del sitio (sitemap)
Route::get('mapa', ['as'=>'sitemap', function() {
    return View::make('mapa');
}]);

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

Route::post('request/info/teacher/all/{teacher_id}', function($teacher_id) {
    if (!Session::has('t_visualized_all_'.$teacher_id)) //if this Tlf visualization hasn't been recorded before (during the session)
    {
        Session::put('t_visualized_all_'.$teacher_id, true); //record the visualization in the session array
        Session::save();
        $visualization = new TeacherPhoneVisualization(); //register the visualization in database
        if (Auth::check()) { //if user is authenticated relate the user id with the visualization
            $observer = Confide::user();
            $visualization->user_id = $observer->id;
        }
        //we choose the first lesson of this teacher as the receipt of the visualization (temporary fix)
        $teacher = Teacher::where('id',$teacher_id)->first();
        $first_lesson = $teacher->lessons()->first();
        if(!$first_lesson)
            return  'No lessons found';
        $lesson_id = $first_lesson->id;
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

Route::post('/review/lesson','ReviewsController@handleLessonReview');

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

// Authentication routes
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

Route::post('userpanel/dashboard/update/social', 'UsersController@updateSocial');

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
    //Raw database query needs soft deleted schools to be filtered (where null)
    $schools = DB::table('schools')->whereNull('deleted_at')->orderBy('id')->paginate(10);
    foreach($schools as $school)
        $school->nlessons = count(SchoolLesson::where('school_id',$school->id)->get());

    return View::make('schools_dashboard', compact('schools'));
});
Route::post('admin/updateSchoolStatus', function()
{
    $input = Input::all();
    $school = School::findOrFail($input['schoolId']);
    if($input['activeStatus']=='true')
        $school->status = 'Active';
    else
        $school->status = 'Crawled';

    if($school->save())
        return Response::json('School (id:'.$input['schoolId'].') status updated to '.$school->status, 200);

    return Response::json('Error!', 400);
});

Route::get('admin/teacher/reviews', function() {
    $reviews = Rating::paginate(10);
    foreach($reviews as $review) {
        $lesson_reviewed = TeacherLesson::find($review->teacher_lesson_id);
        $reviewed_user = $lesson_reviewed->teacher->user;

        $review->lesson_reviewed = $lesson_reviewed->title;
        $review->reviewed = $reviewed_user->username;
        $review->slug = $reviewed_user->slug;
        $review->reviewer = Student::find($review->student_id)->user->username;
    }

    return View::make('admin_teacher_reviews', compact('reviews'));
});

Route::get('admin/school/reviews', function() {
    $reviews = DB::table('school_lesson_ratings')
        ->leftJoin('school_lessons','school_lesson_ratings.school_lesson_id','=','school_lessons.id')
        ->leftJoin('schools','school_lessons.school_id','=','schools.id')
        ->whereNull('schools.deleted_at')
        ->paginate(10);

    foreach($reviews as $review)
    {
        $lesson_reviewed = SchoolLesson::find($review->school_lesson_id);
        $reviewed_school = $lesson_reviewed->school;
        $review->lesson_reviewed = $lesson_reviewed->title;
        $review->reviewed = $reviewed_school->name;
        $review->slug = $reviewed_school->slug;
        $review->reviewer = Student::find($review->student_id)->user->username;
    }

    return View::make('admin_school_reviews', compact('reviews'));
});

Route::get('admin/delete/teacher/review/{id}', 'AdminController@deleteTeacherReview');

Route::get('admin/delete/school/review/{id}', 'AdminController@deleteSchoolReview');

Route::get('admin/create/school', function() {
    return View::make('school_register');
});

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


//Sitemaps related routes
Route::get('render-sitemaps','SitemapsController@milprofes');

Route::any('sitemaps/{xmlfile?}', function($xmlfile) {
    return 'caught ' . $xmlfile;
})->where('xmlfile', '.+');

//Route::when('sitemaps/*', 'sitemaps', array('get'));
//Route::filter('sitemaps', function($response) {
////    $response->header('X-Robots-Tag', 'noindex');
////    return Response::json(array('error' => 'Your access token is not valid'), 400);
//    return Response::make('Authentication required', 401);
////    return $response;
//});