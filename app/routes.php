<?php

//Route Model Bindings
Route::model('user','User');
Route::model('teacher_review','Rating');
Route::model('school_review','SchoolLessonRating');
Route::model('teacher','Teacher');
Route::model('school','School');
Route::model('teacher_lesson','TeacherLesson');
Route::model('school_lesson','SchoolLesson');

//CSRF protection for all POST, PUT and DELETE
Route::when('*', 'csrf', array('post', 'put', 'delete'));

//===============================
// Test routes (debug mode only)
//===============================
if(Config::get('app.debug')) { //if debug mode is TRUE
    Route::get('/sociallogin', ['as' => 'home', 'uses' => 'SocialController@showLoginButtons']);
    Route::get('/fbLogin', ['as' => 'fb.login', 'uses' => 'SocialController@loginWithFacebook']);
    Route::get('/twLogin', ['as' => 'tw.login', 'uses' => 'SocialController@loginWithTwitter']);
    Route::get('/gpLogin', ['as' => 'gp.login', 'uses' => 'SocialController@loginWithGoogle']);
}

//============
// Home
//============
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@showWelcome']); //Home

//============
// Profiles
//============
Route::get('profe/{user_slug}', ['as' => 'profiles-teacher', 'uses' => 'ProfilesController@profilesTeacher']); //Teacher profiles
Route::get('academia/{school_slug}', ['as'=>'profiles-school', 'uses' => 'ProfilesController@profilesSchool']); //School profiles

//Register info requests and provide teacher info
Route::post('request/info/teacher', ['as' => 'request.teacher', 'uses' => 'RequestController@requestTeacher']);
Route::post('request/info/school', ['as' => 'request.school', 'uses' => 'RequestController@requestSchool']);
Route::get('request/persData/teacher', ['as' => 'request.teacherData', 'uses' => 'RequestController@teacherData']);

//to be deleted
//Route::post('request/info/teacher/{lesson_id}', ['as' => 'request.teacher.lesson', 'uses' => 'RequestController@teacherLessonVisualization']);
//Route::post('request/info/teacher/all/{teacher_id}', ['as' => 'request.teacher.id', 'uses' => 'RequestController@teacherVisualization']);
//Route::post('request/info/school/{lesson_id}', ['as' => 'request.school.lesson', 'uses' => 'RequestController@schoolLessonVisualization']);
//Route::post('request/info/school/all/{school_id}', ['as' => 'request.school.id', 'uses' => 'RequestController@schoolVisualization']);

//Review: was it helpful?
Route::post('review/was/helpful/{review_id}', ['as' => 'review-was-helpful', 'uses' => 'ReviewsController@wasHelpful']); //Teacher review was helpful
Route::post('review/not/helpful/{review_id}', ['as' => 'review-not-helpful', 'uses' => 'ReviewsController@wasNotHelpful']); //Teacher review not helpful
Route::post('review/school/was/helpful/{review_id}', ['as' => 'review-helpful-sch', 'uses' => 'ReviewsController@wasHelpfulSchool']); //School review was helpful
Route::post('review/school/not/helpful/{review_id}', ['as' => 'review-not-helpful-sch', 'uses' => 'ReviewsController@wasNotHelpfulSchool']); //School review was not helpful

//Do a review
Route::post('/review/lesson', ['as'=>'rate.teacher.lesson', 'uses'=>'ReviewsController@handleLessonReview']); //Rate teacher lessons
Route::post('/review/school/lesson', ['as'=>'rate.school.lesson', 'uses'=>'ReviewsController@handleSchoolLessonReview']); //Rate school lesson

//============
// Results
//============
Route::get('resultados', ['as'=>'resultsGet', 'uses'=>'SearchController@search']); //Search get
Route::post('resultados', ['as' => 'resultsPost', 'uses' => 'SearchController@search']); //Search post

//========================
// User register and auth
//========================
Route::post('users', ['as' => 'users', 'uses'=> 'UsersController@store']); //register user
Route::post('users/login', ['as' => 'users.login', 'uses'=> 'UsersController@doLogin']); //do login
Route::get('users/logout', ['as' => 'users.logout', 'uses' => 'UsersController@logout']); //do logout
Route::get('users/confirm/{code}', ['as' => 'users.confirm.code', 'uses' => 'UsersController@confirm']); //do confirm mail
Route::get('users/forgot-password', ['as' => 'users.forgot.pwd', 'uses' => 'UsersController@forgotPassword']); //show forgot pwd view
Route::post('users/forgot-password', ['as' => 'users.do.forgot.pwd', 'uses' => 'UsersController@doForgotPassword']); //send forgot pwd request
Route::get('users/reset-password/{token}', ['as' => 'users.reset.pwd', 'uses' => 'UsersController@resetPassword']); //show reset pwd view
Route::post('users/reset-password', ['as' => 'users.do.reset.pwd', 'uses' => 'UsersController@doResetPassword']); //send reset pwd request

//to be deleted
//Route::get('users/login',['as' => 'users.login', 'uses'=> 'UsersController@login']);
//Route::get('users/create', ['as' => 'user.register', 'uses' => 'UsersController@usersRegister']);

//======================
// User dashboard
//======================
Route::get('userpanel/dashboard', ['as' => 'userpanel.dashboard', 'uses' => 'UsersController@dashboard']);
Route::post('userpanel/dashboard/update/info', ['as' => 'userpanel.dashboard.update.info', 'uses' => 'UsersController@updateUser']);
Route::post('userpanel/dashboard/update/social', ['as' => 'userpanel.dashboard.update.social', 'uses' => 'UsersController@updateSocial']);
Route::post('userpanel/dashboard/update/avatar', ['as' => 'userpanel.dashboard.update.avatar', 'uses' => 'UsersController@updateAvatar']);
Route::post('userpanel/dashboard/update/passwd', ['as' => 'userpanel.dashboard.update.passwd', 'uses' => 'UsersController@updateUserPasswd']);
Route::get('userpanel/become/teacher', ['as' => 'userpanel.become.teacher', 'uses' => 'UsersController@becomeATeacher']);

//======================
// Teacher dashboard
//======================
Route::get('teacher/create/lesson', ['as' => 'teacher.create.lesson', 'uses' => 'TeachersController@createLessonForm']);
Route::post('teacher/create/lesson', ['as' => 'teacher.request.create.lesson', 'uses' => 'TeachersController@createLesson']);
Route::get('teacher/edit/lesson/{lesson_id}', ['as' => 'teacher.edit.lesson', 'uses' => 'TeachersController@editLesson']);
Route::post('teacher/save/lesson', ['as' => 'teacher.save.lesson', 'uses' =>'TeachersController@saveLesson']);
Route::get('teacher/delete/lesson/{lesson_id}', ['as' => 'show.teacher.delete.lesson', 'uses' => 'TeachersController@deleteLesson']);
Route::post('teacher/delete/lesson', ['as' => 'teacher.delete.lesson', 'uses' => 'TeachersController@doDeleteLesson']);
Route::post('teacher/availability/save', ['as' => 'teacher.availability.save', 'uses' => 'TeachersController@saveAvailability']);

//====================
//Admin dashboard
//====================

//Admin schools
Route::get('admin/schools', ['as' => 'schools.dashboard', 'uses' => 'AdminController@schoolsDashboard']); //Schools dashboard
Route::post('admin/updateSchoolStatus', ['as' => 'update.school.status', 'uses' => 'AdminController@updateSchoolStatus']); //Update school status
Route::get('admin/create/school', ['as' => 'show.create.school', 'uses' => 'AdminController@schoolRegister']); //Show create school
Route::post('admin/create/school', ['as' => 'create.school', 'uses' => 'AdminController@createSchool']); //Do create school
Route::get('admin/edit/school/{school_id}', ['as' => 'show.edit.school', 'uses' => 'AdminController@editSchool']); //Show school edit
Route::post('admin/edit/school', ['as' => 'save.school', 'uses' => 'AdminController@saveSchool']); //Do school edit
Route::get('admin/delete/school/{school_id}', ['as' => 'show.delete.school', 'uses' => 'AdminController@deleteSchool']); //Show delete school
Route::post('admin/delete/school', ['as' => 'delete.school', 'uses' => 'AdminController@doDeleteSchool']); //Do delete school

//Admin school lessons
Route::get('admin/lessons/{school_id}', ['as' => 'school.lessons', 'uses' => 'AdminController@lesssonDashboard']); //Show school lessons dashboard
Route::get('admin/create/lesson/{school_id}', ['as' => 'show.create.school.lesson', 'uses' => 'AdminController@showCreateLesson']); //Show create school lesson
Route::post('admin/create/lesson', ['as' => 'create.school.lesson', 'uses' =>'AdminController@createLesson']); //Do create school lesson
Route::get('admin/edit/lesson/{lesson_id}', ['as' => 'edit.school.lesson', 'uses' =>'AdminController@editLesson']); //Show edit school lesson
Route::post('admin/edit/lesson', ['as' => 'save.lessons', 'uses' => 'AdminController@saveLesson']); //Do edit school lesson
Route::get('admin/delete/lesson/{lesson_id}', ['as' => 'show.delete.school.lesson', 'uses' => 'AdminController@showDeleteLesson']); //Show delete school lesson
Route::post('admin/delete/lesson', ['as' => 'delete.school.lesson', 'uses' => 'AdminController@deleteLesson']); //Do delete school lesson

//Admin school reviews
Route::get('admin/school/reviews', ['as' => 'school.reviews', 'uses' => 'AdminController@schoolReviews']); //Show school reviews dashboard
Route::get('admin/delete/school/review/{id}', ['as' => 'delete.school.review', 'uses' => 'AdminController@deleteSchoolReview']); //Do delete school review

//Admin teachers
Route::get('admin/teachers', ['as' => 'teachers.dashboard', 'uses' => 'AdminController@teachersDashboard']); //Show teachers dashboard
Route::get('admin/delete/teacher/{user_id}', ['as' => 'show.delete.teacher', 'uses' => 'AdminController@deleteTeacher']); //Show delete teacher
Route::post('admin/delete/teacher', ['as' => 'delete.user.teacher', 'uses' => 'AdminController@deleteUser']); //Do delete teacher

//Admin teacher reviews
Route::get('admin/teacher/reviews', ['as' => 'teacher.reviews', 'uses' => 'AdminController@teacherReviews']); //Show teacher reviews dashboard
Route::get('admin/delete/teacher/review/{id}',  ['as' => 'delete.teacher.review', 'uses' => 'AdminController@deleteTeacherReview']); //Do delete teacher review

//to be deleted
//Route::post('load-school-profile-pics', ['as' => 'load.school.profile', 'uses' => 'AdminController@loadProfilePics']);

//==============
// XML sitemaps
//==============
Route::get('render-sitemaps', ['as' => 'render.sitemaps', 'uses' => 'SitemapsController@milprofes']); //TODO: pasar a python scripts
Route::get('sitemap', ['as' => 'show.sitemap', 'uses' => 'SitemapsController@showSitemap']);
Route::get('sitemaps/{xmlfile?}', ['as' => 'show.sitemap.xml', 'uses' => 'SitemapsController@showSitemapXML']);

//============================
// Payments (not implemented)
//============================
//Route::get('lastpayment', 'UsersController@paymentIsCurrent');
//Route::get('ihavejustpaid', 'UsersController@updateLastPaymentDate');

//==============
// Contact form
//==============
Route::get('contacta', ['as'=>'contact', 'uses' => 'ContactController@contactPage']); //Contact
Route::post('contactanos', ['as' => 'contactaForm', 'uses' => 'ContactController@getContactForm']); //Send contact form

//====================
// Other simple views
//====================
Route::get('preguntas-frecuentes', ['as'=>'faqs', 'uses' => 'StuffController@showFaqs']); //FAQs
Route::get('servicios', ['as'=>'services', 'uses' => 'StuffController@showServices']); //Servicios
Route::get('milprofes', ['as'=>'who', 'uses' => 'StuffController@showWho']); //Who
Route::get('condiciones', ['as'=>'terms', 'uses' => 'StuffController@showTerms']); //Aviso legal
Route::get('cookies', ['as'=>'cookies', 'uses' => 'StuffController@showCookies']); //Cookies
Route::get('privacidad', ['as'=>'privacy', 'uses' => 'StuffController@showPrivacy']); //Política de privacidad
Route::get('mapa', ['as'=>'sitemap', 'uses' => 'StuffController@showSitemap']); //TODO: Mapa del sitio (sitemap)
