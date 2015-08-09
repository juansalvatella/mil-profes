<?php

class AdminController extends BaseController
{

    /**
     * Shows the dashboard of school.
     * @return \Illuminate\View\View
     */
    public function schoolsDashboard()
    {
        //Raw database query needs soft deleted schools to be filtered (notice the where null)
        //$schools = DB::table('schools')->whereNull('deleted_at')->orderBy('id')->paginate(10);
        $schools = School::whereNull('deleted_at')->get();
        foreach($schools as $school)
            $school->nlessons = count(SchoolLesson::where('school_id',$school->id)->get());

        return View::make('schools_dashboard', compact('schools'));
    }

    /**
     * Shows the dashboard of teacher.
     * @return \Illuminate\View\View
     */
    public function teachersDashboard()
    {
        //Raw database query needs soft deleted schools to be filtered (notice the where null)
        $users = DB::table('users')->whereNull('deleted_at')->orderBy('id')->paginate(10);

        return View::make('teachers_dashboard', compact('users'));
    }

    /**
     * Updates the school status.
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSchoolStatus()
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
    }

    /**
     * Shows the admin_teacher_reviews View.
     * @return \Illuminate\View\View
     */
    public function teacherReviews()
    {
        $reviews = TeacherLessonRating::paginate(10);
        foreach($reviews as $review) {
            $lesson_reviewed = TeacherLesson::find($review->teacher_lesson_id);
            $reviewed_user = $lesson_reviewed->teacher->user;

            $review->lesson_reviewed = $lesson_reviewed->title;
            $review->reviewed = $reviewed_user->username;
            $review->slug = $reviewed_user->slug;
            $review->reviewer = Student::find($review->student_id)->user()->withTrashed()->first()->username;
        }

        return View::make('admin_teacher_reviews', compact('reviews'));
    }

    /**
     * Shows the admin_school_reviews View.
     * @return \Illuminate\View\View
     */
    public function schoolReviews()
    {
        $reviews = DB::table('s_lesson_ratings')
            ->leftJoin('school_lessons','s_lesson_ratings.school_lesson_id','=','school_lessons.id')
            ->leftJoin('schools','school_lessons.school_id','=','schools.id')
            ->whereNull('schools.deleted_at')
            ->select('s_lesson_ratings.*','s_lesson_ratings.school_lesson_id','schools.deleted_at')
            ->paginate(10);

        foreach($reviews as $review)
        {
            $lesson_reviewed = SchoolLesson::find($review->school_lesson_id);
            $reviewed_school = $lesson_reviewed->school;
            $review->lesson_reviewed = $lesson_reviewed->title;
            $review->reviewed = $reviewed_school->name;
            $review->slug = $reviewed_school->slug;
            $review->reviewer = Student::find($review->student_id)->user()->withTrashed()->first()->username;
        }

        return View::make('admin_school_reviews', compact('reviews'));
    }

    /**
     * Shows the school_register View.
     * @return \Illuminate\View\View
     */
    public function schoolRegister()
    {
        return View::make('school_register');
    }

    /**
     * Given the parameter $school_id, and returns 'school_edit' View.
     * @param $school_id
     * @return \Illuminate\View\View
     */
    public function editSchool($school_id)
    {
        $school = School::findOrFail($school_id);

        return View::make('school_edit', compact('school'));
    }

    /**
     * Given the parameter $school_id, shows the warning before deleting school
     * @param $school_id
     * @return \Illuminate\View\View
     */
    public function deleteSchool($school_id)
    {

        $school = School::findOrFail($school_id);

        return View::make('school_confirm_delete',compact('school'));
    }

    /**
     * Creates a school
     * @param bkg
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createSchool()
    {
        $input = Input::all();
        $school = new School();

        $school->name = $input['name'];
        $school->address = $input['address'];
        $school->cif = $input['cif'];
        $school->email = $input['email'];
        $school->phone = $input['phone'];
        $school->phone2 = $input['phone2'];
        $school->description = $input['description'];
        $school->status = 'Active'; //manually created schools are active by default because there is no need to review their data
        $school->origin = $input['origin'];
        $school->video = $input['video'];
        $school->link_web = $input['web'];
        $school->link_facebook = $input['facebook'];
        $school->link_twitter = $input['twitter'];
        $school->link_linkedin = $input['linkedin'];
        $school->link_googleplus = $input['googleplus'];
        $school->link_instagram = $input['instagram'];

        $geocoding = Geocoding::geocode($school->address);
        if(!$geocoding){
            return Redirect::back()
                ->withInput()
                ->with('error','')
                ->with('Etitle',trans('hardcoded.admincontroller.createSchool.Etitle'))
                ->with('Emsg',trans('hardcoded.admincontroller.createSchool.EmsgDir'));
        }
        $school->lat = $geocoding[0]; //latitud
        $school->lon = $geocoding[1]; //longitud
        $school->town = $geocoding[3]['locality']; //guardar municipio
        $school->region = $geocoding[3]['admin_2']; //guardar provincia
        if(isset($geocoding[3]['postal_code']))
            $school->postalcode = $geocoding[3]['postal_code']; //guardar código postal

        if(Input::hasFile('logo'))
        {
            $file = Input::file('logo');
            $file_extension = Input::file('logo')->getClientOriginalExtension();
            $filename = Str::random(30).'.'.$file_extension;
            $path = public_path().'/img/logos/';
            $file->move($path, $filename);
            $school->logo = $filename;
        } else {
            $school->logo = 'default_logo.png';
        }

        if($school->save()) {

            //associate pics
            if (Input::hasFile('pics')) {
                $all_uploads = Input::file('pics');
                if (!is_array($all_uploads)) {
                    $all_uploads = array($all_uploads);
                }

                foreach ($all_uploads as $upload) {
                    if (!is_a($upload, 'Symfony\Component\HttpFoundation\File\UploadedFile')) {
                        continue;
                    }
                    $validator = Validator::make(
                        array('file' => $upload),
                        array('file' => 'image')
                    );

                    $img = $upload->getClientOriginalName();
                    if ($validator->fails()) {
                        return Redirect::route('schools.dashboard')
                            ->with('warning','')
                            ->with('Wtitle',trans('hardcoded.admincontroller.createSchool.Wtitle'))
                            ->with('Wmsg',trans('hardcoded.admincontroller.createSchool.Wmsg'))
                            ->with('error','')
                            ->with('Etitle',trans('hardcoded.admincontroller.createSchool.Etitle'))
                            ->with('Emsg',trans('hardcoded.admincontroller.createSchool.EmsgProfile') . $img);
                    } else {
                        $file_extension = $upload->getClientOriginalExtension();
                        $filename = Str::random(30) . '.' . $file_extension;
                        $path = public_path() . '/img/pics/';
                        $upload->move($path, $filename);
                        $pic = new SchoolPic();
                        $pic->pic = $filename;
                        $pic->school()->associate($school);
                        if(!$pic->save()){
                            return Redirect::route('schools.dashboard')
                                ->with('warning','')
                                ->with('Wtitle',trans('hardcoded.admincontroller.createSchool.Wtitle'))
                                ->with('Wmsg',trans('hardcoded.admincontroller.createSchool.Wmsg'))
                                ->with('error','')
                                ->with('Etitle',trans('hardcoded.admincontroller.createSchool.Etitle'))
                                ->with('Emsg',trans('hardcoded.admincontroller.createSchool.EmsgProfile ') . $img);
                        }
                    }
                }
            }
            return Redirect::route('schools.dashboard')
                ->with('success','')
                ->with('Stitle',trans('hardcoded.admincontroller.createSchool.StitleCreate'))
                ->with('Smsg',trans('hardcoded.admincontroller.createSchool.Smsg'));
        }
        else
            return Redirect::route('schools.dashboard')
                ->withInput()
                ->with('error','')
                ->with('Etitle',trans('hardcoded.admincontroller.createSchool.Etitle'))
                ->with('Emsg',trans('hardcoded.admincontroller.createSchool.EmsgDB'));
    }

    /**
     * Deletes the user from the data base.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteUser() {
        $user_id = Input::get('id');
        $user = User::findOrFail($user_id);
        if($user->hasRole('teacher')) {
            $teacher = $user->teacher()->first();
            $teacher->delete();
            if(!$teacher->trashed())
                return Redirect::route('teachers.dashboard')
                    ->with('error','')
                    ->with('Etitle',trans('hardcoded.admincontroller.deleteUser.Etitle'))
                    ->with('Emsg',trans('hardcoded.admincontroller.deleteUser.EmsgUser'));
        }
        $user->delete();
        if($user->trashed())
            return Redirect::route('teachers.dashboard')
                ->with('success','')
                ->with('Stitle',trans('hardcoded.admincontroller.deleteUser.StitleUser'))
                ->with('Smsg',trans('hardcoded.admincontroller.deleteUser.SmsgUser'));
        else
            return Redirect::route('teachers.dashboard')
                ->with('error','')
                ->with('Etitle',trans('hardcoded.admincontroller.deleteUser.Etitle'))
                ->with('Emsg',trans('hardcoded.admincontroller.deleteUser.EmsgUser'));
    }

    /**
     * Delete school after confirmation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doDeleteSchool()
    {
        $school_id = Input::get('id');
        $school = School::findOrFail($school_id);
        $school->delete();

        if($school->trashed())
            return Redirect::route('schools.dashboard')
                ->with('success','')
                ->with('Stitle',trans('hardcoded.admincontroller.doDeleteSchool.Stitle'))
                ->with('Smsg',trans('hardcoded.admincontroller.doDeleteSchool.SmsgD'));
        else
            return Redirect::route('schools.dashboard')
                ->with('error','')
                ->with('Etitle',trans('hardcoded.admincontroller.doDeleteSchool.Etitle'))
                ->with('Emsg',trans('hardcoded.admincontroller.doDeleteSchool.EmsgD'));
    }

    /**
     * Saves the school with inputs data, otherwise returns error messages.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveSchool()
    {
        $input = Input::all();
        $school = School::findOrFail($input['id']);

        $school->name = $input['name'];
        $school->cif = $input['cif'];
        $school->email = $input['email'];
        $school->phone = $input['phone'];
        $school->phone2 = $input['phone2'];
        $school->description = $input['description'];
        $school->link_web = $input['web'];
        $school->link_facebook = $input['facebook'];
        $school->link_twitter = $input['twitter'];
        $school->link_linkedin = $input['linkedin'];
        $school->link_googleplus = $input['googleplus'];
        $school->link_instagram = $input['instagram'];
        $school->video = $input['video'];

        if(Input::get('address') != $school->address) {
            $school->address = $input['address'];
            $geocoding = Geocoding::geocode($school->address);
            if(!$geocoding) {
                return Redirect::back()
                    ->withInput()
                    ->with('error','')
                    ->with('Etitle',trans('hardcoded.admincontroller.saveSchool.Etitle'))
                    ->with('Emsg',trans('hardcoded.admincontroller.saveSchool.EmsgDir'));
            }
            if(isset($geocoding[0]))
                $school->lat = $geocoding[0]; //latitud
            if(isset($geocoding[1]))
                $school->lon = $geocoding[1]; //longitud
            if(isset($geocoding[3]['locality']))
                $school->town = $geocoding[3]['locality']; //guardar municipio
            if(isset($geocoding[3]['admin_2']))
                $school->region = $geocoding[3]['admin_2']; //guardar provincia
            if(isset($geocoding[3]['postal_code']))
                $school->postalcode = $geocoding[3]['postal_code']; //guardar código postal
        }

        if(Input::hasFile('logo')) {
            $file = Input::file('logo');
            $file_extension = Input::file('logo')->getClientOriginalExtension();
            $filename = Str::random(20) . '.' . $file_extension;
            $path = public_path() . '/img/logos/';
            $file->move($path, $filename);
            $school->logo = $filename;
        }

        if(Input::hasFile('pics')) {
            //TODO: implementar selector de modos (reemplazar o añadir)
            $school->pics()->delete(); //TODO: sólo aplicar en modo reemplazar

            $all_uploads = Input::file('pics');
            if (!is_array($all_uploads)) {
                $all_uploads = array($all_uploads);
            }
            foreach ($all_uploads as $upload) {
                if (!is_a($upload, 'Symfony\Component\HttpFoundation\File\UploadedFile')) {
                    continue;
                }
                $validator = Validator::make(
                    array('file' => $upload),
                    array('file' => 'image')
                );
                $img = $upload->getClientOriginalName();
                if ($validator->fails()) {
                    return Redirect::back()
                        ->withInput()
                        ->with('error','')
                        ->with('Etitle',trans('hardcoded.admincontroller.saveSchool.Etitle'))
                        ->with('Emsg',trans('hardcoded.admincontroller.saveSchool.EmsgSaveAvatar') . $img);
                } else {
                    $file_extension = $upload->getClientOriginalExtension();
                    $filename = Str::random(30) . '.' . $file_extension;
                    $path = public_path() . '/img/pics/';
                    $upload->move($path, $filename);
                    $pic = new SchoolPic();
                    $pic->pic = $filename;
                    $pic->school()->associate($school);
                    if(!$pic->save()){
                        return Redirect::back()
                            ->withInput()
                            ->with('error','')
                            ->with('Etitle',trans('hardcoded.admincontroller.saveSchool.Etitle'))
                            ->with('Emsg',trans('hardcoded.admincontroller.saveSchool.EmsgSaveAvatar') . $img);
                    }
                }
            }
        }

        if($school->save())
            return Redirect::route('schools.dashboard')
                ->with('success','')
                ->with('Stitle',trans('hardcoded.admincontroller.saveSchool.Stitle'))
                ->with('Smsg',trans('hardcoded.admincontroller.saveSchool.SmsgUpdate'));
        else
            return Redirect::route('schools.dashboard')
                ->with('error','')
                ->with('Etitle',trans('hardcoded.admincontroller.saveSchool.Etitle'))
                ->with('Emsg',trans('hardcoded.admincontroller.saveSchool.EmsgUpdate'));
    }

    /**
     * Given the parameter $school_id, and show the lesson_create View.
     * @param $school_id
     * @return \Illuminate\View\View
     */
    public function showCreateLesson($school_id)
    {
        $school = School::findOrFail($school_id);

        return View::make('lesson_create', compact('school'));
    }

    /**
     * Given the paramter $user_id, and deletes the teacher with this id.
     * @param $user_id
     * @return \Illuminate\View\View
     */
    public function deleteTeacher($user_id)
    {
        $user = User::findOrFail($user_id);

        return View::make('teacher_confirm_delete',compact('user'));
    }

    /**
     * Creates the lesson, otherwise shows the error messages.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createLesson()
    {
        $input = Input::all();
        $lesson = new SchoolLesson();
        $lesson->title = $input['title'];
        $lesson->price = str_replace(',','.',$input['price']);
        $lesson->description = Input::get('description');
        $lesson->address = Input::get('address');
        $geocoding = Geocoding::geocode(Input::get('address'));
        $school_id = Input::get('school_id');
        if(!$geocoding){
            return Redirect::back()
                ->withInput()
                ->with('error','')
                ->with('Etitle',trans('hardcoded.admincontroller.createLesson.Etitle'))
                ->with('Emsg',trans('hardcoded.admincontroller.createLesson.EmsgLeesson'));
        }
        $lesson->lat = $geocoding[0]; //latitud
        $lesson->lon = $geocoding[1]; //longitud

        $school = School::findOrFail($school_id);
        $subject_name = Input::get('subject');
        $subject = Subject::where('name',$subject_name)->first();

        $lesson->subject()->associate($subject);
        $lesson->school()->associate($school);

        if(!$lesson->save()) {
            return Redirect::route('school.lessons', array('school_id' => $school_id))
                ->with('error','')
                ->with('Etitle',trans('hardcoded.admincontroller.createLesson.Etitle'))
                ->with('Emsg',trans('hardcoded.admincontroller.createLesson.EmsgCreate'));
        }
        else {
            $lesson_id = $lesson->id;
            for($i=1;$i<10;++$i)
            {
                $pick = new SchoolLessonAvailability();
                $pick ->school_lesson_id = $lesson_id;
                $pick->pick = ''.$i;
                $pick->day = $input['day'.$i];
                $pick->start = $input['start'.$i];
                $pick->end = $input['end'.$i];
                if(!$pick->save()) {
                    return Redirect::route('school.lessons', array('school_id' => $school_id))
                        ->with('warning','')
                        ->with('Wtitle',trans('hardcoded.admincontroller.createLesson.Wtitle'))
                        ->with('Wmsg',trans('hardcoded.admincontroller.createLesson.Wmsg'));
                }
            }
        }

        return Redirect::route('school.lessons',array('school_id' => $school_id))
            ->with('success','')
            ->with('Stitle',trans('hardcoded.admincontroller.createLesson.Stitle'))
            ->with('Smsg',trans('hardcoded.admincontroller.createLesson.Smsg'));
    }

    /**
     * Shows the 'lesson_edit' View.
     * @param $lesson_id
     * @return \Illuminate\View\View
     */
    public function editLesson($lesson_id)
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
    }


    /**
     * Saves the lesson with inputs data.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveLesson()
    {
        $input = Input::all();
        $school_id = Input::get('school_id');
        $lesson = SchoolLesson::findOrFail(Input::get('lesson_id'));
        $lesson->title = $input['title'];
        $lesson->price = str_replace(',','.',$input['price']);
        $lesson->description = Input::get('description');
        $lesson->address = Input::get('address');
        $geocoding = Geocoding::geocode(Input::get('address'));
        if(!$geocoding){
            return Redirect::back()
                ->withInput()
                ->with('error','')
                ->with('Etitle',trans('hardcoded.admincontroller.saveLesson.Etitle'))
                ->with('Emsg',trans('hardcoded.admincontroller.saveLesson.EmsgSave'));
        }
        $lesson->lat = $geocoding[0]; //latitud
        $lesson->lon = $geocoding[1]; //longitud

        $subject_name = Input::get('subject');
        $subject = Subject::where('name',$subject_name)->first();
        $lesson->subject()->associate($subject);

        if(!$lesson->save()) {
            return Redirect::route('school.lessons', array('school_id' => $school_id))
                ->with('error','')
                ->with('Etitle',trans('hardcoded.admincontroller.saveLesson.Etitle'))
                ->with('Emsg',trans('hardcoded.admincontroller.saveLesson.EmsgUpdate'));
        } else { //update availabilities
            $lesson_id = $lesson->id;
            $previous_picks = $lesson->availabilities()->get();
            $i = 1;
            foreach($previous_picks as $pick)
            {
                $pick = SchoolLessonAvailability::findOrFail($pick->id);
                $pick ->school_lesson_id = $lesson_id;
                $pick->pick = ''.$i;
                $pick->day = $input['day'.$i];
                $pick->start = $input['start'.$i];
                $pick->end = $input['end'.$i];
                if(!$pick->save()) {
                    return Redirect::route('userpanel.dashboard')
                        ->with('warning','')
                        ->with('Wtitle',trans('hardcoded.admincontroller.saveLesson.Wtitle'))
                        ->with('Wmsg',trans('hardcoded.admincontroller.saveLesson.Wmsg'));
                }
                ++$i;
            }
        }

        return Redirect::route('school.lessons',array('school_id' => $school_id))
            ->with('success','')
            ->with('Stitle',trans('hardcoded.admincontroller.saveLesson.Stitle'))
            ->with('Smsg',trans('hardcoded.admincontroller.saveLesson.Smsg'));
    }

    /**
     * Given the parameter $lesson_id, and show the 'lesson_confirm_delete' View.
     * @param $lesson_id
     * @return \Illuminate\View\View
     */
    public function showDeleteLesson($lesson_id)
    {
        $lesson = SchoolLesson::findOrFail($lesson_id);
        $school = $lesson->school()->first();
        $subject = $lesson->subject()->first();

        return View::make('lesson_confirm_delete', compact('lesson','school','subject'));
    }

    /**
     * Deletes the lesson
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteLesson()
    {
        $lesson_id = Input::get('lesson_id');
        $school_id = Input::get('school_id');
        $lesson = SchoolLesson::findOrFail($lesson_id);
        $lesson->delete();

        if($lesson->exists)
            return Redirect::route('school.lessons',array('school_id' => $school_id))
                ->with('error','')
                ->with('Etitle',trans('hardcoded.admincontroller.deleteLesson.Etitle'))
                ->with('Emsg',trans('hardcoded.admincontroller.deleteLesson.EmsgDelete'));
        else
            return Redirect::route('school.lessons',array('school_id' => $school_id))
                ->with('success','')
                ->with('Stitle',trans('hardcoded.admincontroller.deleteLesson.Stitle'))
                ->with('Smsg',trans('hardcoded.admincontroller.deleteLesson.SmsgLeeson'));
    }

    /**
     * Deletes the evaluation of school with the parameter id.
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteSchoolReview($id) {
        $rating = SchoolLessonRating::findOrFail($id);
        $rating->delete();
        if($rating->exists)
            return Redirect::route('school.reviews')
                ->with('error','')
                ->with('Etitle',trans('hardcoded.admincontroller.deleteSchoolReview.Etitle'))
                ->with('Emsg',trans('hardcoded.admincontroller.deleteSchoolReview.EmsgReview'));
        else
            return Redirect::route('school.reviews')
                ->with('success','')
                ->with('Stitle',trans('hardcoded.admincontroller.deleteSchoolReview.Stitle'))
                ->with('Smsg',trans('hardcoded.admincontroller.deleteSchoolReview.SmsgReview'));
    }

    /**
     * Shows the lessons_dashboard View.
     * @return \Illuminate\View\View
     */
    public function lesssonDashboard($school_id)
    {
        $school = School::findOrFail($school_id);
        $lessons = SchoolLesson::where('school_id',$school_id)->get();
        $subjects = array();
        foreach($lessons as $lesson)
        {
            $subjects[$lesson->id] = $lesson->subject()->first();
        }

        return View::make('lessons_dashboard', compact('school','lessons','subjects'));
    }


    /**
     * Given the parameter $id, and deletes the teacher review of this id or returns error messages.
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteTeacherReview($id) {
        $rating = TeacherLessonRating::findOrFail($id);
        $rating->delete();
        if($rating->exists)
            return Redirect::route('teacher.reviews')
                ->with('error','')
                ->with('Etitle',trans('hardcoded.admincontroller.deleteTeacherReview.Etitle'))
                ->with('Emsg',trans('hardcoded.admincontroller.deleteTeacherReview.Emsg'));
        else
            return Redirect::route('teacher.reviews')
                ->with('success','')
                ->with('Stitle',trans('hardcoded.admincontroller.deleteTeacherReview.Stitle'))
                ->with('Smsg',trans('hardcoded.admincontroller.deleteTeacherReview.Smsg'));
    }

}