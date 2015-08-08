<?php

class UsersController extends Controller
{
    /**
     * Displays the form for account creation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return Redirect::route('home')
            ->with('show_register_modal',true);
    }

    /**
     * Shows the dashboard of user
     * @return $this
     */
    public function dashboard()
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

            return View::make('userpanel_dashboard',compact('user'))
                ->nest('content_teacher', 'userpanel_tabpanel_manage_lessons',compact('teacher','lessons','subjects','picks','n_picks_set'));
        }
        else
            return View::make('userpanel_dashboard',compact('user'))
                ->nest('content_teacher', 'userpanel_tabpanel_become_teacher');
    }

//    /**
//     *
//     * @return \Illuminate\View\View
//     */
//    public function usersRegister()
//    {
//        return View::make('users_register');  //Not exists users_register in View folder !
//    }

    /**
     * Stores new account
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        //basic form validation
        $input = Input::all();
        $rules = array(
            'name' => 'required|alpha_spaces|max:50',
            'lastname' => 'alpha_spaces|max:100',
            'phone' => 'string|min:5|max:20',
            'address' => 'required|string|max:200',
            'username' => 'required|alpha_dash|min:5|max:20',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'terms' => 'required|accepted',
        );
        $validator =  Validator::make($input, $rules);

        if($validator->fails()) {
            return Redirect::route('home')
                ->withInput(Input::except('password'))
                ->with('reg-error',trans('hardcoded.userscontroller.store.reg-error'))
                ->with('show_register_modal',true);
        }

        //is it possible to geocode address?
        $geocode = Geocoding::geocode($input['address']);
        if(!$geocode) {
            return Redirect::route('home')
                ->withInput(Input::except('password'))
                ->with('reg-error',trans('hardcoded.userscontroller.store.reg-error-dir'))
                ->with('show_register_modal',true);
        }

        //geocoding done, try to register the user
        $repo = App::make('UserRepository');
        $user = $repo->signup($input, $geocode);

        if ($user->id) {
            //Make the user a student by default (add to student table and assign student role)
            $student = new Student();
            $student->user()->associate($user);
            $student->save();
            $student_role = Role::where('name','student')->first();
            $user->attachRole($student_role);
            //send a confirmation mail
            if (Config::get('confide::signup_email')) {
                Mail::queueOn(
                    Config::get('confide::email_queue'),
                    Config::get('confide::email_account_confirmation'),
                    compact('user'),
                    function ($message) use ($user) {
                        $message
                            ->to($user->email, $user->username)
                            ->subject(trans('messages.email.account_confirmation.subject'));
                    }
                );
            }

            //TODO: modificar estas líneas para implementar nuevo sistema estudiante-profesor según >0 clases existentes
            $teacher = new Teacher();
            $teacher->user()->associate($user);
            $teacher->save();
            //Añadir rol(permisos) de profesor a usuario
            $teacher_role = Role::where('name', 'teacher')->first();
            $user->attachRole($teacher_role);

            return Redirect::route('home')
                ->with('log-notice',trans('hardcoded.userscontroller.store.log-notice'))
                ->with('show_login_modal',true)
                ->with('success','')
                ->with('Stitle',trans('hardcoded.userscontroller.store.Stitle'))
                ->with('Smsg',trans('hardcoded.userscontroller.store.Smsg'));
        } else {
            $error = $user->errors()->all(':message');

            return Redirect::route('home')
                ->withInput(Input::except('password'))
                ->with('reg-error', $error)
                ->with('show_register_modal',true);
        }

    }

//    /**
//     * @return \Illuminate\View\View
//     */
//    public function UsersLogin()
//    {
//        return View::make('users_login');  //Not exists users_login in View folder !
//    }

//    /**
//     * Displays the login form
//     * @return \Illuminate\Http\RedirectResponse
//     */
//    public function login()
//    {
//        if (Confide::user()) {
//            return Redirect::route('home')->with('show_login_modal',true);
//        } else {
//            return Redirect::route('home')->with('show_login_modal',true);
//        }
//    }

    /**
     * Attempts to do login.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doLogin()
    {
        $repo = App::make('UserRepository');
        $input = Input::all();

        if ($repo->login($input)) { //if login successful
            if(URL::previous() == Request::root() || URL::previous() == Request::root().'/')
                return Redirect::intended('/userpanel/dashboard');
            else
                return Redirect::back();
        } else { //login unsuccesful -> catch errors
            if ($repo->isThrottled($input))
                $err_msg = trans('messages.alerts.too_many_attempts');
            elseif ($repo->existsButNotConfirmed($input))
                $err_msg = trans('messages.alerts.not_confirmed');
            else
                $err_msg = trans('messages.alerts.wrong_credentials');

            //return Redirect::action('UsersController@login')
            return Redirect::route('home') //redirect to home and show login modal with errors
                ->withInput(Input::except('password'))
                ->with('log-error', $err_msg)
                ->with('show_login_modal',true);
        }
    }

    /**
     * Attempts to confirm account with code
     * @param $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm($code)
    {
        if (Confide::confirm($code)) {
            $notice_msg = trans('messages.positive_confirmation');
            //return Redirect::action('UsersController@login')
            return Redirect::route('home')
                ->with('log-notice', $notice_msg)
                ->with('show_login_modal',true);
        } else {
            $error_msg = trans('messages.wrong_confirmation');
            //return Redirect::action('UsersController@login')
            return Redirect::route('home')
                ->with('log-error', $error_msg)
                ->with('show_login_modal',true);
        }
    }

    /**
     * Displays the forgot password form.
     * @return \Illuminate\View\View
     */
    public function forgotPassword()
    {
        return View::make('forgot_password');
    }

    /**
     * Attempts to send change password link to the given email.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doForgotPassword()
    {
        if (Confide::forgotPassword(Input::get('email'))) {
            $notice_msg = trans('messages.alerts.password_forgot');
            return Redirect::route('home')
                ->with('log-notice', $notice_msg)
                ->with('show_login_modal',true);
        } else {
            $error_msg = trans('messages.alerts.wrong_password_forgot');
            return Redirect::back()
                ->withInput()
                ->with('error', '')
                ->with('Etitle', trans('hardcoded.userscontroller.forgotPassword.Etitle'))
                ->with('Emsg', $error_msg);
        }
    }

    /**
     * Shows the change password form with the given token.
     * @param $token
     * @return $this
     */
    public function resetPassword($token)
    {
        return View::make('reset_password')
                ->with('token', $token);
    }

    /**
     * Attempts change password of the user.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doResetPassword()
    {
        $repo = App::make('UserRepository');
        $input = array(
            'token'                 =>Input::get('token'),
            'password'              =>Input::get('password'),
            'password_confirmation' =>Input::get('password_confirmation'),
        );

        // By passing an array with the token, password and confirmation
        if ($repo->resetPassword($input)) {
            $notice_msg = trans('messages.alerts.password_reset');
            //return Redirect::action('UsersController@login')
            return Redirect::route('home')
                ->with('log-notice', $notice_msg)
                ->with('show_login_modal',true);
        } else {
            $error_msg = trans('messages.alerts.wrong_password_reset');
            return Redirect::action('UsersController@resetPassword', array('token'=>$input['token']))
                ->withInput()
                ->with('log-error', $error_msg)
                ->with('show_login_modal',true);
        }
    }

    /**
     * Logs the user out of the application.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Confide::logout();

        if(Request::is('userpanel/*') || Request::is('admin/*'))
            return Redirect::route('home');
        else
            return Redirect::back();
    }

    /**
     * Updates the password of user.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateUserPasswd()
    {
        if($user = Confide::user()){

            $input = Input::all();
            $rules = array(
                'old_password'                  => 'required',
                'new_password'                  => 'required|min:6|confirmed|different:old_password',
                'new_password_confirmation'     => 'required|min:6|different:old_password|same:new_password'
            );
            $validator = Validator::make($input, $rules);
            //Is the input valid? new_password confirmed and meets requirements
            if ($validator->fails()) {
                Session::flash('validationErrors', $validator->messages());
                return Redirect::route('userpanel.dashboard')
                    ->withInput()
                    ->with('error','')
                    ->with('Etitle',trans('hardcoded.userscontroller.updateUserPasswd.Etitle'))
                    ->with('Emsg',trans('hardcoded.userscontroller.updateUserPasswd.Emsg'));
            }
            //Is the old password correct?
            if(!Hash::check(Input::get('old_password'), $user->password)){
                return Redirect::route('userpanel.dashboard')
                    ->withInput()
                    ->with('error','')
                    ->with('Etitle',trans('hardcoded.userscontroller.updateUserPasswd.Etitle'))
                    ->with('Emsg',trans('hardcoded.userscontroller.updateUserPasswd.Emsg_pwd'));
            }
            //Set new password
            $user->password = Input::get('new_password');
            $user->password_confirmation = Input::get('new_password_confirmation');

            $user->touch();
            $user->save();
            Confide::logout();

            return Redirect::route('home')
                ->with('log-success',trans('hardcoded.userscontroller.updateUserPasswd.log-success'))
                ->with('show_login_modal',true);

        } else {

            return Redirect::route('home')
                ->with('log-notice',trans('hardcoded.userscontroller.updateUserPasswd.log-notice'))
                ->with('show_login_modal',true);

        }
    }

    /**
     * Updates the avatar of user.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAvatar() {
        if($user = Confide::user())
        {
            $input = Input::all();

            $rules = array(
                'avatar' => 'required|string',
                'x' => 'required|string',
                'y' => 'required|string',
                'w' => 'required|string',
                'h' => 'required|string'
            );
            $validator = Validator::make($input, $rules);

            if($validator->fails()) {
                return Redirect::route('userpanel.dashboard')
                    ->with('error','')
                    ->with('Etitle',trans('hardcoded.userscontroller.updateAvatar.Etitle'))
                    ->with('Emsg',trans('hardcoded.userscontroller.updateAvatar.Emsg'));
            } else {
                $targ_w = $targ_h = 160;
                $jpeg_quality = 90;
                $file = preg_replace('#^data:image/[^;]+;base64,#', '', $input['avatar']);
                $file = base64_decode($file);
                $path = public_path() . '/img/avatars/';
                $filename = Str::random(30) . '.jpg';
                $user->avatar = $filename;

                $img_r = imagecreatefromstring($file);
                if ($img_r == false)
                    return Redirect::route('userpanel.dashboard')->withInput()
                        ->with('error','')
                        ->with('Etitle',trans('hardcoded.userscontroller.updateAvatar.Etitle'))
                        ->with('Emsg',trans('hardcoded.userscontroller.updateAvatar.Emsg_image_profile'));

                $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
                imagecopyresampled($dst_r, $img_r, 0, 0, $input['x'], $input['y'], $targ_w, $targ_h, $input['w'], $input['h']);
                header('Content-type: image/jpeg');
                imagejpeg($dst_r, $path . $filename , $jpeg_quality);
                imagedestroy($img_r);

                if ($user->save()) {
                    return Redirect::route('userpanel.dashboard')
                        ->with('success','')
                        ->with('Stitle',trans('hardcoded.userscontroller.updateAvatar.Stitle'))
                        ->with('Smsg',trans('hardcoded.userscontroller.updateAvatar.Smsg'));
                } else {
                    return Redirect::route('userpanel.dashboard')->withInput()
                        ->with('error','')
                        ->with('Etitle',trans('hardcoded.userscontroller.updateAvatar.Etitle'))
                        ->with('Emsg',trans('hardcoded.userscontroller.updateAvatar.Emsg_image'));
                }
            }
        } else {
            return Redirect::route('home')
                ->with('log-notice',trans('hardcoded.userscontroller.updateAvatar.log-notice'))
                ->with('show_login_modal',true);
        }
    }

    /**
     * Updates the user data.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateUser()
    {
        if($user = Confide::user())
        {
            $input = Input::all();
            $rules = array(
                'name'          => 'required|alpha_spaces|max:50',
                'lastname'      => 'alpha_spaces|max:100',
                'gender'        => 'in:male,female,other',
                'day'           => 'integer|between:1,31',
                'month'         => 'integer|between:1,12',
                'year'          => 'integer|between:1800,9999',
                'address'       => 'required|string|max:200',
                'email'         => 'required|email',
                'phone'         => 'string|min:5|max:20',
                'description'   => 'string|max:450',
            );
            $validator = Validator::make($input, $rules);

            if($validator->fails()) {
                return Redirect::route('userpanel.dashboard')
                    ->withInput()
                    ->with('error','')
                    ->with('Etitle',trans('hardcoded.userscontroller.updateUser.Etitle'))
                    ->with('Emsg',trans('hardcoded.userscontroller.updateUser.EmsgField'));
            }

            if($input['name'] != $user->name)
                $user->name = $input['name'];

            if($input['lastname'] != $user->lastname)
                $user->lastname = $input['lastname'];

            if($input['gender'] != $user->gender)
                $user->gender = $input['gender'];

            $month = ($input['month']<10) ? '0'.$input['month'] : $input['month'];
            $day = ($input['day']<10) ? '0'.$input['day'] : $input['day'];
            $birthdate = $input['year'].'-'.$month.'-'.$day;
            if($birthdate != $user->date_of_birth)
                $user->date_of_birth = $birthdate;

            if($input['address'] != $user->address)
            {
                $user->address = $input['address'];
                $geocoding = Geocoding::geocode($user->address);
                if(!$geocoding) {
                    return Redirect::route('userpanel.dashboard')
                        ->withInput()
                        ->with('error','')
                        ->with('Etitle',trans('hardcoded.userscontroller.updateUser.Etitle'))
                        ->with('Emsg',trans('hardcoded.userscontroller.updateUser.Emsg'));
                }
                $user->lat = $geocoding[0]; //guargar latitud
                $user->lon = $geocoding[1]; //guardar longitud
                $user->town = $geocoding[3]['locality']; //guardar municipio
                $user->region = $geocoding[3]['admin_2']; //guardar provincia
                if(isset($geocoding[3]['postal_code']))
                    $user->postalcode = $geocoding[3]['postal_code']; //guardar código postal
            }

            if($input['email'] != $user->email)
                $user->email = $input['email'];

            if($input['phone'] != $user->phone)
                $user->phone = $input['phone'];

            if($input['description'] != $user->description)
                $user->description = $input['description'];

            if($user->save()) {
                return Redirect::route('userpanel.dashboard')
                    ->with('success','')
                    ->with('Stitle',trans('hardcoded.userscontroller.updateUser.Stitle'))
                    ->with('Smsg',trans('hardcoded.userscontroller.updateUser.Smsg'));
            } else {
                return Redirect::route('userpanel.dashboard')->withInput()
                    ->with('error','')
                    ->with('Etitle',trans('hardcoded.userscontroller.updateUser.Etitle'))
                    ->with('Emsg',trans('hardcoded.userscontroller.updateUser.EmsgData'));
            }
        } else {
            return Redirect::route('/')
                ->with('log-notice',trans('hardcoded.userscontroller.updateUser.log-notice'))
                ->with('show_login_modal',true);
        }
    }

    /**
     * Updates the social media data of user.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSocial()
    {
        if($user = Confide::user()) {
            $input = Input::all();
            $rules = array(
                'facebook' => 'url',
                'twitter' => 'url',
                'googleplus' => 'url',
                'instagram' => 'url',
                'linkedin' => 'url',
                'web' => 'url',
            );
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                return Redirect::route('userpanel.dashboard')
                    ->withInput()
                    ->with('error','')
                    ->with('Etitle',trans('hardcoded.userscontroller.updateSocial.Etitle'))
                    ->with('Emsg',trans('hardcoded.userscontroller.updateSocial.Emsg'));
            }

            if ($input['facebook'] != $user->link_facebook)
                $user->link_facebook = $input['facebook'];
            if ($input['twitter'] != $user->link_twitter)
                $user->link_twitter = $input['twitter'];
            if ($input['googleplus'] != $user->link_googleplus)
                $user->link_googleplus = $input['googleplus'];
            if ($input['instagram'] != $user->link_instagram)
                $user->link_instagram = $input['instagram'];
            if ($input['linkedin'] != $user->link_linkedin)
                $user->link_linkedin = $input['linkedin'];
            if ($input['web'] != $user->link_web)
                $user->link_web = $input['web'];

            if($user->save())
                return Redirect::route('userpanel.dashboard')
                    ->with('success','')
                    ->with('Stitle',trans('hardcoded.userscontroller.updateSocial.Stitle'))
                    ->with('Smsg',trans('hardcoded.userscontroller.updateSocial.Smsg'));
            else
                return Redirect::route('userpanel.dashboard')->withInput()
                    ->with('error','')
                    ->with('Etitle',trans('hardcoded.userscontroller.updateSocial.Etitle'))
                    ->with('Emsg',trans('hardcoded.userscontroller.updateSocial.EmsgLink'));

        } else {
            return Redirect::route('/')
                ->with('log-notice',trans('hardcoded.userscontroller.updateSocial.log-notice'))
                ->with('show_login_modal',true);
        }
    }

    /**
     * Realizes the action of becoming to teacher.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function becomeATeacher()
    {
        if($user = Confide::user())
        {
            if($user->hasRole('teacher'))
            { //Advertir de que ya es profesor!
                return Redirect::route('userpanel.dashboard')
                    ->with('info','')
                    ->with('Ititle',trans('hardcoded.userscontroller.becomeATeacher.Ititle'))
                    ->with('Imsg',trans('hardcoded.userscontroller.becomeATeacher.Imsg'));
            } else { //Añadir a tabla de profesores
                $teacher = new Teacher();
                $teacher->user()->associate($user);
                $teacher->save();

                //Añadir rol(permisos) de profesor a usuario
                $teacher_role = Role::where('name', 'teacher')->first();
                $user->attachRole($teacher_role);

                return Redirect::route('userpanel.dashboard')
                    ->with('success','')
                    ->with('Stitle',trans('hardcoded.userscontroller.becomeATeacher.Stitle'))
                    ->with('Smsg',trans('hardcoded.userscontroller.becomeATeacher.Smsg'));
            }
        } else {
            return Redirect::route('/')
                ->with('log-notice',trans('hardcoded.userscontroller.becomeATeacher.log-notice'))
                ->with('show_login_modal',true);
        }
    }
}
