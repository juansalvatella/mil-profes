<?php



/**
 * UsersController Class
 *
 * Implements actions regarding user management
 */
class UsersController extends Controller
{

    /**
     * Displays the form for account creation
     *
     * @return  Illuminate\Http\Response
     */
    public function create()
    {
        return View::make(Config::get('confide::signup_form'));
    }

    /**
     * Stores new account
     *
     * @return  Illuminate\Http\Response
     */
    public function store()
    {
        $repo = App::make('UserRepository');
        $user = $repo->signup(Input::all());

        if ($user->id) {

            //Make the user a student by default (add to student table and assign student role)
            $student = new Student();
            $student->user()->associate($user);
            $student->save();
            $student_role = Role::where('name','student')->first();
            $user->attachRole($student_role);

            if (Config::get('confide::signup_email')) {
                Mail::queueOn(
                    Config::get('confide::email_queue'),
                    Config::get('confide::email_account_confirmation'),
                    compact('user'),
                    function ($message) use ($user) {
                        $message
                            ->to($user->email, $user->username)
                            ->subject(Lang::get('confide::confide.email.account_confirmation.subject'));
                    }
                );
            }

            return Redirect::to('/users/login')
                ->with('notice', Lang::get('confide::confide.alerts.account_created'));
        } else {
            $error = $user->errors()->all(':message');

            //return Redirect::action('UsersController@create')
            return Redirect::to('/users/create')
                ->withInput(Input::except('password'))
                ->with('error', $error);
        }

    }

    /**
     * Displays the login form
     *
     * @return  Illuminate\Http\Response
     */
    public function login()
    {
        if (Confide::user()) {
            return Redirect::to('/demo');
        } else {
            return View::make(Config::get('confide::login_form'));
        }
    }

    /**
     * Attempt to do login
     *
     * @return  Illuminate\Http\Response
     */
    public function doLogin()
    {
        $repo = App::make('UserRepository');
        $input = Input::all();

        if ($repo->login($input)) {
            return Redirect::intended('/demo');
        } else {
            if ($repo->isThrottled($input)) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ($repo->existsButNotConfirmed($input)) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            //return Redirect::action('UsersController@login')
            return Redirect::to('users/login')
                ->withInput(Input::except('password'))
                ->with('error', $err_msg);
        }
    }

    /**
     * Attempt to confirm account with code
     *
     * @param  string $code
     *
     * @return  Illuminate\Http\Response
     */
    public function confirm($code)
    {
        if (Confide::confirm($code)) {
            $notice_msg = Lang::get('confide::confide.alerts.confirmation');
            //return Redirect::action('UsersController@login')
            return Redirect::to('users/login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_confirmation');
            //return Redirect::action('UsersController@login')
            return Redirect::to('users/login')
                ->with('error', $error_msg);
        }
    }

    /**
     * Displays the forgot password form
     *
     * @return  Illuminate\Http\Response
     */
    public function forgotPassword()
    {
        return View::make(Config::get('confide::forgot_password_form'));
    }

    /**
     * Attempt to send change password link to the given email
     *
     * @return  Illuminate\Http\Response
     */
    public function doForgotPassword()
    {
        if (Confide::forgotPassword(Input::get('email'))) {
            $notice_msg = Lang::get('confide::confide.alerts.password_forgot');
            //return Redirect::action('UsersController@login')
            return Redirect::to('users/login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_forgot');
            return Redirect::action('UsersController@doForgotPassword')
                ->withInput()
                ->with('error', $error_msg);
        }
    }

    /**
     * Shows the change password form with the given token
     *
     * @param  string $token
     *
     * @return  Illuminate\Http\Response
     */
    public function resetPassword($token)
    {
        return View::make(Config::get('confide::reset_password_form'))
                ->with('token', $token);
    }

    /**
     * Attempt change password of the user
     *
     * @return  Illuminate\Http\Response
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
            $notice_msg = Lang::get('confide::confide.alerts.password_reset');
            //return Redirect::action('UsersController@login')
            return Redirect::to('users/login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');
            return Redirect::action('UsersController@resetPassword', array('token'=>$input['token']))
                ->withInput()
                ->with('error', $error_msg);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @return  Illuminate\Http\Response
     */
    public function logout()
    {
        Confide::logout();

        return Redirect::to('/demo');
    }

    public function updateUser()
    {
        $user = Auth::user();

        if(Input::hasFile('avatar')) {
            $file = Input::file('avatar');
            $file_extension = Input::file('avatar')->getClientOriginalExtension();
            $filename = Str::random(20) . '.' . $file_extension;
            $path = public_path() . '/img/avatars/';
            $file->move($path, $filename);
            $user->avatar = $filename;
        }
        $user->username = Input::get('username');
        $user->name = Input::get('name');
        $user->lastname = Input::get('lastname');
        $user->phone = Input::get('phone');
        $user->description = Input::get('description');
        if(Input::get('address') != $user->address)
        {
            $user->address = Input::get('address');
            $geocoding = Geocoding::geocode($user->address);
            $user->lat = $geocoding[0]; //latitud
            $user->lon = $geocoding[1]; //longitud
        }

        if($user->save())
            return Redirect::route('userpanel')->with('success', 'Tus datos se han actualizado con éxito');
        else
            return Redirect::route('userpanel')->with('failure', 'Error al actualizar tus datos!');
    }

    public function becomeATeacher()
    {
        $user = Auth::user();
        //Añadir a tabla de profesores
        $teacher = new Teacher();
        $teacher->user()->associate($user);
        $teacher->save();

        //Añadir rol(permisos) de profesor
        $teacher_role = Role::where('name','teacher')->first();
        $user->attachRole($teacher_role);

        //Redirect
        return Redirect::route('userpanel')->with('success', 'Ahora ya eres profesor! Publica tus clases!');
    }
}
