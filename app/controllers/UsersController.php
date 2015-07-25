<?php

class UsersController extends Controller
{

    // Displays the form for account creation
    // @return  Illuminate\Http\Response
    public function create()
    {
//        return View::make(Config::get('confide::signup_form'));
        return Redirect::to('/')
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

            return View::make('userpanel_dashboard',compact('user'))->nest('content_teacher', 'userpanel_tabpanel_manage_lessons',compact('teacher','lessons','subjects','picks','n_picks_set'));
        }
        else
            return View::make('userpanel_dashboard',compact('user'))->nest('content_teacher', 'userpanel_tabpanel_become_teacher');
    }

    /**
     *
     * @return \Illuminate\View\View
     */
    public function usersRegister()
    {
        return View::make('users_register');  //Not exists users_register in View folder !
    }

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
            return Redirect::to('/')
                ->withInput(Input::except('password'))
                ->with('reg-error', 'No se cumplimentaron los campos correctamente. Vuelve a intentarlo.')
                ->with('show_register_modal', true);
        }

        //is it possible to geocode address?
        $geocode = Geocoding::geocode($input['address']);
        if(!$geocode) {
            return Redirect::to('/')
                ->withInput(Input::except('password'))
                ->with('reg-error', 'La dirección proporcionada no parece ser válida. Prueba escribiendo tu calle, número y ciudad.')
                ->with('show_register_modal', true);
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

            //TODO: eliminar las siguientes líneas para hacerse profesor por defecto, cuando se implante sistema de pago
            //HACERSE PROFESOR POR DEFECTO
            $teacher = new Teacher();
            $teacher->user()->associate($user);
            $teacher->save();
            //Añadir rol(permisos) de profesor a usuario
            $teacher_role = Role::where('name', 'teacher')->first();
            $user->attachRole($teacher_role);
            //ELIMINAR HASTA AQUÍ

            return Redirect::to('/')
                ->with('log-notice', trans('messages.user_just_registered'))
                ->with('show_login_modal',true)
                ->with('success','')
                ->with('Stitle','Confirma tu e-mail')
                ->with('Smsg','En breve recibirás un e-mail de milPROFES con el que podrás confirmar tu dirección de correo electrónico.');
        } else {
            $error = $user->errors()->all(':message');

            //return Redirect::action('UsersController@create')
            return Redirect::to('/')
                ->withInput(Input::except('password'))
                ->with('reg-error', $error)
                ->with('show_register_modal', true);
        }

    }

    /**
     * @return \Illuminate\View\View
     */
    public function UsersLogin()
    {
        return View::make('users_login');  //Not exists users_login in View folder !
    }

    // Displays the login form
    // @return  Illuminate\Http\Response
    public function login()
    {
        if (Confide::user()) {
            return Redirect::to('/')->with('show_login_modal',true);
        } else {
//            return View::make(Config::get('confide::login_form'));
            return Redirect::to('/')->with('show_login_modal',true);
        }
    }

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
            return Redirect::to('/') //redirect to home and show login modal with errors
                ->withInput(Input::except('password'))
                ->with('log-error', $err_msg)
                ->with('show_login_modal',true);
        }
    }

    // Attempts to confirm account with code
    // @param  string $code
    // @return  Illuminate\Http\Response
    public function confirm($code)
    {
        if (Confide::confirm($code)) {
            $notice_msg = trans('messages.positive_confirmation');
            //return Redirect::action('UsersController@login')
            return Redirect::to('/')
                ->with('log-notice', $notice_msg)
                ->with('show_login_modal',true);
        } else {
            $error_msg = trans('messages.wrong_confirmation');
            //return Redirect::action('UsersController@login')
            return Redirect::to('/')
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
//        return View::make(Config::get('confide::forgot_password_form'));
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
            //return Redirect::action('UsersController@login')
            return Redirect::to('/')
                ->with('log-notice', $notice_msg)
                ->with('show_login_modal',true);
        } else {
            $error_msg = trans('messages.alerts.wrong_password_forgot');
//            return Redirect::action('UsersController@doForgotPassword')
            return Redirect::back()
                ->withInput()
                ->with('error', $error_msg)
                ->with('Etitle', 'Error')
                ->with('Emsg', $error_msg);
//                ->with('log-error', $error_msg)
//                ->with('show_login_modal',true);
        }
    }

    /**
     * Shows the change password form with the given token.
     * @param $token
     * @return $this
     */
    public function resetPassword($token)
    {
//        return View::make(Config::get('confide::reset_password_form'))
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
            return Redirect::to('/')
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
            return Redirect::to('/');
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
                return Redirect::route('userpanel')
                    ->withInput()
                    ->with('error','No fue posible cambiar la contraseña. Asegúrate de introducir una nueva contraseña adecuada y diferente a la actual.')
                    ->with('Etitle', 'Error')
                    ->with('Emsg', 'No fue posible cambiar la contraseña. Asegúrate de introducir una nueva contraseña adecuada y diferente a la actual.');
            }
            //Is the old password correct?
            if(!Hash::check(Input::get('old_password'), $user->password)){
                return Redirect::route('userpanel')
                    ->withInput()
                    ->with('error','La contraseña actual no es la correcta.')
                    ->with('Etitle', 'Error')
                    ->with('Emsg', 'La vieja contraseña proporcionada no es la correcta.');
            }
            //Set new password
            $user->password = Input::get('new_password');
            $user->password_confirmation = Input::get('new_password_confirmation');

            $user->touch();
            $user->save();
            Confide::logout();

            return Redirect::to('/')
                ->with('log-success','Tu contraseña se ha actualizado con éxito. Por favor, accede con tu nueva contraseña.')
                ->with('show_login_modal',true);

        } else {

            return Redirect::route('/')
                ->with('log-notice', 'No se fue posible actualizar tu contraseña. Tu sesión ha caducado, por favor, vuelve a iniciar sesión e inténtalo de nuevo.')
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
//            dd($input);
//            dd($validator->passes());
            if($validator->fails()) {
                return Redirect::route('userpanel')
                    ->with('error','No ha sido posible actualizar tu foto de perfil. Inténtalo de nuevo.')
                    ->with('Etitle', 'Error')
                    ->with('Emsg', 'No ha sido posible actualizar tu foto de perfil. Inténtalo de nuevo.');
            } else {
                $targ_w = $targ_h = 160;
                $jpeg_quality = 90;
//                dd($input['avatar']);
                $file = preg_replace('#^data:image/[^;]+;base64,#', '', $input['avatar']);
//                dd($file);
                $file = base64_decode($file);
//                dd($file);
                $path = public_path() . '/img/avatars/';
                $filename = Str::random(30) . '.jpg';

                $img_r = imagecreatefromstring($file);
                if ($img_r == false) {
                    return Redirect::route('userpanel')->withInput()
                        ->with('error', 'Error al actualizar tu imagen de perfil: asegúrate de que tu imagen es del tipo PNG, JPG o GIF.')
                        ->with('Etitle', 'Error')
                        ->with('Emsg', 'Error al actualizar tu imagen de perfil: asegúrate de que tu imagen es del tipo PNG, JPG o GIF.');
                }
                $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
                imagecopyresampled($dst_r, $img_r, 0, 0, $input['x'], $input['y'], $targ_w, $targ_h, $input['w'], $input['h']);
                header('Content-type: image/jpeg');
                imagejpeg($dst_r, $path . $filename , $jpeg_quality);
                imagedestroy($img_r);

                $user->avatar = $filename;
                if ($user->save()) {
                    return Redirect::route('userpanel')
                        ->with('success', 'Tu imagen de perfil se ha actualizado con éxito')
                        ->with('Stitle', 'Éxito')
                        ->with('Smsg', 'Tu imagen de perfil ha sido actualizada.');
                } else {
                    return Redirect::route('userpanel')->withInput()
                        ->with('error', 'Error al actualizar tu imagen de perfil. Inténtalo de nuevo.')
                        ->with('Etitle', 'Error')
                        ->with('Emsg', 'Error al actualizar tu imagen de perfil. Inténtalo de nuevo.');
                }
            }
        } else {
            return Redirect::route('/')
                ->with('log-notice', 'No ha sido posible actualizar tu imagen de perfil porque tu sesión ha caducado. Por favor, vuelve a iniciar sesión e inténtalo de nuevo.')
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
                return Redirect::route('userpanel')
                    ->withInput()
                    ->with('error','No ha sido posible actualizar tus datos. Asegúrate de haber rellenado los campos correctamente.')
                    ->with('Etitle', 'Error')
                    ->with('Emsg', 'No ha sido posible actualizar tus datos. Asegúrate de haber rellenado los campos correctamente.');
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
                    return Redirect::route('userpanel')
                        ->withInput()
                        ->with('error','No fue posible actualizar tus datos. La dirección proporcionada parece no ser válida.')
                        ->with('Etitle', 'Error')
                        ->with('Emsg', 'No fue posible actualizar tus datos. La dirección proporcionada parece no ser válida.');
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
                return Redirect::route('userpanel')
                    ->with('success', 'Tus datos se han actualizado con éxito')
                    ->with('Stitle', 'Éxito')
                    ->with('Smsg', 'Se han actualizado tus datos.');
            } else {
                return Redirect::route('userpanel')->withInput()
                    ->with('error', 'Error al actualizar tus datos')
                    ->with('Etitle', 'Error')
                    ->with('Emsg', 'Error al tratar de actualizar tus datos. Si el problema persiste, ponte en contacto con el equipo de milPROFES.');
            }
        } else {
            return Redirect::route('/')
                ->with('log-notice', 'Tu sesión ha caducado y no fue posible actualizar tus datos. Por favor, vuelve a acceder e inténtalo de nuevo.')
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
                return Redirect::route('userpanel')
                    ->withInput()
                    ->with('error', 'No ha sido posible actualizar los enlaces a redes sociales. Asegúrate de haber introducido direcciones web válidas.')
                    ->with('Etitle', 'Error')
                    ->with('Emsg', 'No ha sido posible actualizar tus enlaces a redes sociales. Asegúrate de haber introducido direcciones web válidas.');
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
                return Redirect::route('userpanel')
                    ->with('success', 'Tus enlaces a redes sociales se han actualizado con éxito.')
                    ->with('Stitle', 'Éxito')
                    ->with('Smsg', 'Tus enlaces a redes sociales han sido actualizados.');
            else
                return Redirect::route('userpanel')->withInput()
                    ->with('error', 'Error al actualizar tus datos')
                    ->with('Etitle', 'Error')
                    ->with('Emsg', 'Error al tratar de actualizar tus enlaces sociales.');

        } else {
            return Redirect::route('/')
                ->with('log-notice', 'Tu sesión ha caducado y no fue posible actualizar tus datos. Por favor, vuelve a acceder e inténtalo de nuevo.')
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
                return Redirect::route('userpanel')->with('success', '¡Ya eres profe.! ¡Publica tus clases!');
            } else { //Añadir a tabla de profesores
                $teacher = new Teacher();
                $teacher->user()->associate($user);
                $teacher->save();

                //Añadir rol(permisos) de profesor a usuario
                $teacher_role = Role::where('name', 'teacher')->first();
                $user->attachRole($teacher_role);

                return Redirect::route('userpanel')
                    ->with('success', '¡Ahora ya eres profe.! ¡Publica tus clases!')
                    ->with('Stitle', 'Éxito')
                    ->with('Smsg', '¡Ya eres profe.! ¡Publica tus clase para aparecer en los resultados de las búsquedas!');
            }
        } else {
            return Redirect::route('/')
                ->with('log-notice', 'Al parece tu sesión ha caducado. Por favor, vuelve a acceder e inténtalo de nuevo.')
                ->with('show_login_modal',true);
        }
    }
}
