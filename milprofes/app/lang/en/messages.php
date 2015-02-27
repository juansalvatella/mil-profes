<?php

return array(

    //notices, errors, etc.
	'example' => 'Example',
    'user_just_registered' => 'Tu cuenta ha sido creada. En breve recibirás un correo de milProfes para confirmar tu e-mail.',
    'positive_confirmation' => 'Tu correo ha sido confirmado! Ya puedes entrar en milProfes',
    'wrong_confirmation' => 'Error al tratar de confirmar tu correo. Ponte en contacto con nosotros si persiste el problema.',

    'username'              => 'Usuario',
    'password'              => 'Contraseña',
    'password_confirmation' => 'Confirmar Contraseña',
    'e_mail'                => 'Email',
    'username_e_mail'       => 'Usuario o Email',

    'signup' => array(
        'title'                 => 'Registro',
        'desc'                  => 'Registrar una nueva cuenta',
        'confirmation_required' => 'Confirmación requerida',
        'submit'                => 'Crear nueva cuenta',
    ),

    'login' => array(
        'title'           => 'Login',
        'desc'            => 'Introduzca sus credenciales',
        'forgot_password' => '(olvidé mi contraseña)',
        'remember'        => 'Recuerdame',
        'submit'          => 'Login',
    ),

    'forgot' => array(
        'title'  => 'Olvidé contraseña',
        'submit' => 'Continuar',
    ),

    'alerts' => array(
        'account_created'        => 'Tu cuenta ha sido creada satisfactoriamente.',
        'instructions_sent'      => 'Por favor, comprueba tu e-mail para obtener las instrucciones sobre cómo confirmar su cuenta.',
        'too_many_attempts'      => 'Demasiados intentos. Inténtelo de nuevo en unos minutos.',
        'wrong_credentials'      => 'ID o contraseña incorrectos.',
        'not_confirmed'          => 'Tu cuenta puede no estar confirmada. Comprueba tu e-mail para acceder al enlace de activación.',
        'confirmation'           => '¡Tu cuenta ha sido confirmada! Puedes acceder ahora.',
        'wrong_confirmation'     => 'Código de confirmación incorrecto.',
        'password_forgot'        => 'La información sobre el restablecimiento de tu contraseña te ha sido enviada por e-mail.',
        'wrong_password_forgot'  => 'Usuario no encontrado.',
        'password_reset'         => 'Tu contraseña ha sido cambiada satisfactoriamente.',
        'wrong_password_reset'   => 'Contraseña incorrecta. Inténtalo de nuevo.',
        'wrong_token'            => 'El código para el restablecimiento de tu contraseña no es válido.',
        'duplicated_credentials' => 'El nombre de usuario o e-mail introducidos están actualmente en uso. Inténtalo con credenciales distintas.',
    ),

    'email' => array(
        'account_confirmation' => array(
            'subject'   => 'Confirmación de cuenta',
            'greetings' => 'Hola :name',
            'body'      => 'Por favor acceda al siguiente enlace para confirmar su cuenta.',
            'farewell'  => 'Saludos',
        ),

        'password_reset' => array(
            'subject'   => 'Reestablecer Contraseña',
            'greetings' => 'Hola :name',
            'body'      => 'Acceda al siguiente enlace para cambiar su contraseña',
            'farewell'  => 'Saludos',
        ),
    ),


);
