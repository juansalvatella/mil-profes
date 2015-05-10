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

    //Stores new account
    // @return  Illuminate\Http\Response
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

            //TODO: eliminar las siguientes líneas para hacerse profesor por defecto cuando se implante sistema de pago
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
                ->with('show_login_modal',true);
        } else {
            $error = $user->errors()->all(':message');

            //return Redirect::action('UsersController@create')
            return Redirect::to('/')
                ->withInput(Input::except('password'))
                ->with('reg-error', $error)
                ->with('show_register_modal', true);
        }

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

    // Attempt to do login
    // @return  Illuminate\Http\Response
    public function doLogin()
    {
        $repo = App::make('UserRepository');
        $input = Input::all();

        if ($repo->login($input)) {
            return Redirect::intended('/userpanel/dashboard');
        } else {
            if ($repo->isThrottled($input)) {
                $err_msg = trans('messages.alerts.too_many_attempts');
            } elseif ($repo->existsButNotConfirmed($input)) {
                $err_msg = trans('messages.alerts.not_confirmed');
            } else {
                $err_msg = trans('messages.alerts.wrong_credentials');
            }

            //return Redirect::action('UsersController@login')
            return Redirect::to('/')
                ->withInput(Input::except('password'))
                ->with('log-error', $err_msg)
                ->with('show_login_modal',true);
        }
    }

    // Attempt to confirm account with code
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

    // Displays the forgot password form
    // @return  Illuminate\Http\Response
    public function forgotPassword()
    {
//        return View::make(Config::get('confide::forgot_password_form'));
        return View::make('forgot_password');
    }

    // Attempt to send change password link to the given email
    // @return  Illuminate\Http\Response
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
                ->with('error', $error_msg);
//                ->with('log-error', $error_msg)
//                ->with('show_login_modal',true);
        }
    }

    // Shows the change password form with the given token
    // @param  string $token
    // @return  Illuminate\Http\Response
    public function resetPassword($token)
    {
//        return View::make(Config::get('confide::reset_password_form'))
        return View::make('reset_password')
                ->with('token', $token);
    }

    // Attempt change password of the user
    // @return  Illuminate\Http\Response
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

    // Log the user out of the application.
    // @return  Illuminate\Http\Response
    public function logout()
    {
        Confide::logout();

        return Redirect::to('/');
    }

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
                    ->with('failure','No fue posible cambiar la contraseña. Asegúrate de introducir una nueva contraseña adecuada y diferente a la actual.');
            }
            //Is the old password correct?
            if(!Hash::check(Input::get('old_password'), $user->password)){
                return Redirect::route('userpanel')
                    ->withInput()
                    ->with('failure','La contraseña actual no es la correcta.');
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
                    ->with('failure','No ha sido posible actualizar tu foto de perfil. Inténtalo de nuevo.');
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
                    return Redirect::route('userpanel')->withInput()->with('failure', 'Error al actualizar tu imagen de perfil: asegúrate de que tu imagen es del tipo PNG, JPG o GIF.');
                }
                $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
                imagecopyresampled($dst_r, $img_r, 0, 0, $input['x'], $input['y'], $targ_w, $targ_h, $input['w'], $input['h']);
                header('Content-type: image/jpeg');
                imagejpeg($dst_r, $path . $filename , $jpeg_quality);
                imagedestroy($img_r);

                $user->avatar = $filename;
                if ($user->save()) {
                    return Redirect::route('userpanel')->with('success', 'Tu imagen de perfil se ha actualizado con éxito');
                } else {
                    return Redirect::route('userpanel')->withInput()->with('failure', 'Error al actualizar tu imagen de perfil. Inténtalo de nuevo.');
                }
            }
        } else {
            return Redirect::route('/')
                ->with('log-notice', 'No ha sido posible actualizar tu imagen de perfil porque tu sesión ha caducado. Por favor, vuelve a iniciar sesión e inténtalo de nuevo.')
                ->with('show_login_modal',true);
        }
    }

    public function updateUser()
    {
        if($user = Confide::user())
        {
            $input = Input::all();
            $rules = array(
//                'avatar'        => 'image|max:200',
                'name'          => 'required|alpha_spaces|max:50',
                'lastname'      => 'alpha_spaces|max:100',
                'address'       => 'required|string|max:200',
                'email'         => 'required|email',
                'phone'         => 'string|min:5|max:20',
                'description'   => 'string|max:450',
            );
            $validator = Validator::make($input, $rules);
            if($validator->fails()) {
                return Redirect::route('userpanel')
                    ->withInput()
                    ->with('failure','No ha sido posible actualizar tus datos. Asegúrate de haber rellenado los campos correctamente.');
            }

//            if(Input::hasFile('avatar')) {
//                $file = Input::file('avatar');
//                $file_extension = Input::file('avatar')->getClientOriginalExtension();
//                $filename = Str::random(30) . '.' . $file_extension;
//                $path = public_path() . '/img/avatars/';
//                $file->move($path, $filename);
//                $user->avatar = $filename;
//            }
            if(Input::get('name') != $user->name)
            {
                $user->name = Input::get('name');
            }
            if(Input::get('lastname') != $user->lastname)
            {
                $user->lastname = Input::get('lastname');
            }
            if(Input::get('address') != $user->address)
            {
                $user->address = Input::get('address');
                $geocoding = Geocoding::geocode($user->address);
                if(!$geocoding)
                {
                    return Redirect::route('userpanel')
                        ->withInput()
                        ->with('failure','No fue posible actualizar tus datos. La dirección proporcioada no parece ser válida.');
                }
                $user->lat = $geocoding[0]; //latitud
                $user->lon = $geocoding[1]; //longitud
            }
            if(Input::get('email') != $user->email)
            {
                $user->email = Input::get('email');
            }
            if(Input::get('phone') != $user->phone)
            {
                $user->phone = Input::get('phone');
            }
            if(Input::get('description') != $user->description)
            {
                $user->description = Input::get('description');
            }
            if($user->save()) {
                return Redirect::route('userpanel')->with('success', 'Tus datos se han actualizado con éxito');
            } else {
                return Redirect::route('userpanel')->withInput()->with('failure', 'Error al actualizar tus datos');
            }
        } else {
            return Redirect::route('/')
                ->with('log-notice', 'Tu sesión ha caducado y no fue posible actualizar tus datos. Por favor, vuelve a acceder e inténtalo de nuevo.')
                ->with('show_login_modal',true);
        }
    }

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

                return Redirect::route('userpanel')->with('success', '¡Ahora ya eres profe.! ¡Publica tus clases!');
            }
        } else {
            return Redirect::route('/')
                ->with('log-notice', 'Al parece tu sesión ha caducado. Por favor, vuelve a acceder e inténtalo de nuevo.')
                ->with('show_login_modal',true);
        }
    }

}
