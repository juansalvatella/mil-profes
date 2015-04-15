<?php

return array(

    //notices, errors, etc.
	'example' => 'Example',
    'user_just_registered' => 'Tu cuenta ha sido creada. En breve recibirás un correo de milProfes para confirmar tu e-mail.',
    'positive_confirmation' => 'Tu correo ha sido confirmado! Ya puedes entrar en milProfes',
    'wrong_confirmation' => 'Error al tratar de confirmar tu correo. Ponte en contacto con nosotros si persiste el problema.',


    //confide, entrust kind of errors
    'username'              => 'Usuario',
    'password'              => 'Contraseña',
    'password_confirmation' => 'Confirmar contraseña',
    'e_mail'                => 'E-mail',
    'username_e_mail'       => 'E-mail o Nombre de usuario',

    'signup' => array(
        'title'                 => 'Registrarse',
        'desc'                  => 'Registrar una nueva cuenta',
        'confirmation_required' => 'Confirmación requerida',
        'submit'                => 'Crear nueva cuenta',
    ),

    'login' => array(
        'title'           => 'Entrar',
        'desc'            => 'Introduce tus credenciales',
        'forgot_password' => '¿Has olvidado tu contraseña?',
        'remember'        => 'Recuérdame',
        'submit'          => 'Entrar',
    ),

    'forgot' => array(
        'title'  => 'Restablecer contraseña',
        'submit' => 'Continuar',
    ),

    'alerts' => array(
        'account_created'        => 'Tu cuenta ha sido creada satisfactoriamente.',
        'instructions_sent'      => 'Por favor, comprueba tu e-mail para obtener las instrucciones sobre cómo confirmar tu cuenta.',
        'too_many_attempts'      => 'Demasiados intentos consecutivos. Inténtalo de nuevo en unos minutos.',
        'wrong_credentials'      => 'ID o contraseña incorrectos.',
        'not_confirmed'          => 'Tu cuenta parece no estar confirmada. Comprueba tu e-mail para acceder al correo de confirmación.',
        'confirmation'           => '¡Tu cuenta ha sido confirmada. ¡Ya puedes acceder!',
        'wrong_confirmation'     => 'El enlace para la confirmación de tu cuenta parece no ser válido.',
        'password_forgot'        => 'Te hemos enviado un correo con información sobre el restablecimiento de tu contraseña.',
        'wrong_password_forgot'  => 'Usuario no encontrado.',
        'password_reset'         => 'Tu contraseña ha sido restablecida satisfactoriamente.',
        'wrong_password_reset'   => 'Contraseña incorrecta. Inténtalo de nuevo.',
        'wrong_token'            => 'El enlace para el restablecimiento de tu contraseña parece no ser válido.',
        'duplicated_credentials' => 'El nombre de usuario o e-mail introducidos están actualmente en uso. Inténtalo con credenciales distintas.',
    ),

    'email' => array(
        'account_confirmation' => array(
            'subject'   => 'Confirma tu cuenta en milProfes.',
            'greetings' => 'Hola :name',
            'body'      => 'Por favor, accede al siguiente enlace para confirmar tu cuenta. Para evitar posibles errores, te recomendamos que lo copies directamente sobre la barra de direcciones de tu navegador.',
            'farewell'  => '¡Saludos!',
        ),

        'password_reset' => array(
            'subject'   => 'Restablecer contraseña de milProfes.',
            'greetings' => 'Hola :name',
            'body'      => 'Accede al siguiente enlace para restablecer tu contraseña. Para evitar posibles errores, te recomendamos que lo copies directamente sobre la barra de direcciones de tu navegador.',
            'farewell'  => '¡Saludos!',
        ),
    ),


);
