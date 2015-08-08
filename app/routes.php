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
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@showWelcome']); //Home
Route::get('contacta', ['as'=>'contact', 'uses' => 'ContactController@contactPage']); //Contact
Route::post('contactanos', ['as' => 'contactaForm', 'uses' => 'ContactController@getContactForm']);
Route::get('profe/{user_slug}', ['as' => 'profiles-teacher', 'uses' => 'ProfilesController@profilesTeacher']); //Teacher profiles
Route::get('academia/{school_slug}', ['as'=>'profiles-school', 'uses' => 'ProfilesController@profilesSchool']); //School profiles
Route::post('review/was/helpful/{review_id}', ['as' => 'review-was-helpful', 'uses' => 'ReviewsController@wasHelpful']); //Teacher review was helpful
Route::post('review/not/helpful/{review_id}', ['as' => 'review-not-helpful', 'uses' => 'ReviewsController@wasNotHelpful']); //Teacher review not helpful
Route::post('review/school/was/helpful/{review_id}', ['as' => 'review-helpful-sch', 'uses' => 'ReviewsController@wasHelpfulSchool']); //School review was helpful
Route::post('review/school/not/helpful/{review_id}', ['as' => 'review-not-helpful-sch', 'uses' => 'ReviewsController@wasNotHelpfulSchool']); //School review was not helpful
//Route::post('/reviews/handleReview','ReviewsController@handleNewReview'); //Handle reviews (old)
//Route::post('/reviews/handleSchoolLessonReview','ReviewsController@handleSchoolLessonNewReview');
Route::post('/review/lesson',['as'=>'rate.teacher.lesson','uses'=>'ReviewsController@handleLessonReview']); //Rate teacher lessons
Route::post('/review/school/lesson',['as'=>'rate.school.lesson','uses'=>'ReviewsController@handleSchoolLessonReview']); //Rate school lesson
//Mejorar el url de search tanto con input NULL como user input
Route::get('resultados',['as'=>'resultsGet','uses'=>'SearchController@search']); //Search get
Route::post('resultados',['as' => 'resultsPost', 'uses' => 'SearchController@search']); //Search post
//Route::post('resultados/async','SearchController@search');
//Route::post('/search','SearchController@search');
//Contact info requests (register requests and serve information logic)
Route::post('request/info/teacher', ['as' => 'request.teacher', 'uses' => 'RequestController@requestTeacher']);
Route::post('request/info/teacher/{lesson_id}', ['as' => 'request.teacher.lesson', 'uses' => 'RequestController@teacherLessonVisualization']);
Route::post('request/info/teacher/all/{teacher_id}', ['as' => 'request.teacher.id', 'uses' => 'RequestController@teacherVisualization']);
Route::post('request/info/school', ['as' => 'request.school', 'uses' => 'RequestController@requestSchool']);
Route::post('request/info/school/{lesson_id}', ['as' => 'request.school.lesson', 'uses' => 'RequestController@schoolLessonVisualization']);
Route::post('request/info/school/all/{school_id}', ['as' => 'request.school.id', 'uses' => 'RequestController@schoolVisualization']);
Route::get('request/persData/teacher', ['as' => 'request.teacherData', 'uses' => 'RequestController@teacherData']);

//===================
//User authentication
//===================
//Route::get('users/create', ['as' => 'user.register', 'uses' => 'UsersController@usersRegister']);
Route::post('users', ['as' => 'users', 'uses'=> 'UsersController@store']);
//Route::get('users/login',['as' => 'users.login', 'uses'=> 'UsersController@login']);
Route::post('users/login', ['as' => 'users.login', 'uses'=> 'UsersController@doLogin']);
Route::get('users/confirm/{code}', ['as' => 'users.confirm.code', 'uses' => 'UsersController@confirm']);
Route::get('users/forgot-password', ['as' => 'users.forgot.pwd', 'uses' => 'UsersController@forgotPassword']);
Route::post('users/forgot-password', ['as' => 'users.do.forgot.pwd', 'uses' => 'UsersController@doForgotPassword']);
Route::get('users/reset-password/{token}', ['as' => 'users.reset.pwd', 'uses' => 'UsersController@resetPassword']);
Route::post('users/reset-password', ['as' => 'users.do.reset.pwd', 'uses' => 'UsersController@doResetPassword']);
Route::get('users/logout', ['as' => 'users.logout', 'uses' => 'UsersController@logout']);

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
Route::get('teacher/delete/lesson/{lesson_id}', ['as' => 'teacher.delete.lesson', 'uses' => 'TeachersController@deleteLesson']);
Route::post('teacher/delete/lesson', ['as' => 'teacher.delete.lesson', 'uses' => 'TeachersController@doDeleteLesson']);
Route::post('teacher/availability/save', ['as' => 'teacher.availability.save', 'uses' => 'TeachersController@saveAvailability']);

//====================
//Admin dashboard
//====================
Route::get('admin/schools', ['as' => 'schools.dashboard', 'uses' => 'AdminController@schoolsDashboard']);
Route::get('admin/delete/school/{school_id}', ['as' => 'show.delete.school', 'uses' => 'AdminController@deleteSchool']);
Route::post('admin/delete/school', ['as' => 'delete.school', 'uses' => 'AdminController@doDeleteSchool']);
Route::get('admin/delete/school/review/{id}', ['as' => 'delete.school.review', 'uses' => 'AdminController@deleteSchoolReview']);
Route::get('admin/create/school', ['as' => 'school.register', 'uses' => 'AdminController@schoolRegister']);
Route::post('admin/create/school', ['as' => 'create.school', 'uses' => 'AdminController@createSchool']);
Route::get('admin/edit/school/{school_id}', ['as' => 'edit.school', 'uses' => 'AdminController@editSchool']);
Route::post('admin/edit/school', ['as' => 'save.school', 'uses' => 'AdminController@saveSchool']);
Route::get('admin/school/reviews', ['as' => 'school.reviews', 'uses' => 'AdminController@schoolReviews']);
Route::post('admin/updateSchoolStatus', ['as' => 'update.school.status', 'uses' => 'AdminController@updateSchoolStatus']);
Route::get('admin/teachers', ['as' => 'teachers.dashboard', 'uses' => 'AdminController@teachersDashboard']);
Route::get('admin/teacher/reviews', ['as' => 'teacher.reviews', 'uses' => 'AdminController@teacherReviews']);
Route::get('admin/delete/teacher/review/{id}',  ['as' => 'delete.teacher.review', 'uses' => 'AdminController@deleteTeacherReview']);
Route::get('admin/delete/teacher/{user_id}', ['as' => 'delete.teacher', 'uses' => 'AdminController@deleteTeacher']);
Route::post('admin/delete/teacher', ['as' => 'delete.user.teacher', 'uses' => 'AdminController@deleteUser']);
Route::get('admin/create/lesson/{school_id}', ['as' => 'show.create.lesson', 'uses' => 'AdminController@showCreateLesson']);
Route::post('admin/create/lesson', ['as' => 'create.lesson', 'uses' =>'AdminController@createLesson']);
Route::get('admin/edit/lesson/{lesson_id}', ['as' => 'edit.lesson', 'uses' =>'AdminController@editLesson']);
Route::get('admin/lessons/{school_id}', ['as' => 'lessons', 'uses' => 'AdminController@lesssonDashboard']);
Route::post('admin/edit/lesson', ['as' => 'save.lessons', 'uses' => 'AdminController@saveLesson']);
Route::get('admin/delete/lesson/{lesson_id}', ['as' => 'show.delete.lessons', 'uses' => 'AdminController@showDeleteLesson']);
Route::post('admin/delete/lesson', ['as' => 'delete.lessons', 'uses' => 'AdminController@deleteLesson']);
//Ya no existía la función loadProfilePics !
Route::post('load-school-profile-pics', ['as' => 'load.school.profile', 'uses' => 'AdminController@loadProfilePics']);

//====================
// Sitemap
//====================
Route::get('render-sitemaps', ['as' => 'render.sitemaps', 'uses' => 'SitemapsController@milprofes']);
Route::get('sitemap', ['as' => 'show.sitemap', 'uses' => 'SitemapsController@showSitemap']);
Route::get('sitemaps/{xmlfile?}', ['as' => 'show.sitemap.xml', 'uses' => 'SitemapsController@showSitemapXML']);

//====================
// Payments
//====================
//Route::get('lastpayment', 'UsersController@paymentIsCurrent');
//Route::get('ihavejustpaid', 'UsersController@updateLastPaymentDate');

//======================
// Other pages
//======================
Route::get('preguntas-frecuentes',['as'=>'faqs', 'uses' => 'StuffController@showFaqs']); //faqs
Route::get('servicios',['as'=>'services', 'uses' => 'StuffController@showServices']); //Services
Route::get('milprofes',['as'=>'who', 'uses' => 'StuffController@showWho']); //Who
Route::get('condiciones',['as'=>'terms', 'uses' => 'StuffController@showTerms']); //Aviso legal
Route::get('cookies',['as'=>'cookies', 'uses' => 'StuffController@showCookies']); //Cookies
Route::get('privacidad',['as'=>'privacy', 'uses' => 'StuffController@showPrivacy']); //Política de privacidad
Route::get('mapa', ['as'=>'sitemap', 'uses' => 'StuffController@showSitemap']); //Mapa del sitio (sitemap)
