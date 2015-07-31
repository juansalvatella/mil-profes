<?php

return array
(
    'admincontroller' => [
        'createSchool' => [
            'errorDir'          => 'No se pudo crear la acadamia. Error al tratar de guardar la dirección.',
            'Etitle'            => 'Error',
            'EmsgDir'           => 'No se pudo crear la acadamia. Se produjo un error al tratar de guardar la dirección.',
            'warning'           => 'La academia fue creada pero se dieron errores en el proceso.',
            'Wtitle'            => 'Aviso',
            'Wmsg'              => 'La academia fue creada pero se dieron errores en el proceso.',
            'errorProfile'      => 'Error al tratar de subir la imagen de perfil:',
            'EmsgProfile'       => 'Error al subir la imagen de perfil:',
            'successAcademy'    => 'Academia creada con éxito',
            'StitleCreate'      => 'Academia creada con éxito',
            'Smsg'              => 'Se ha añadido la nueva academia a la base de datos.',
            'errorDB'           => 'Error al tratar de guardar la academia en base de datos',
            'EmsgDB'            => 'Se ha producido un error al tratar de guardar la academia en base de datos.',
         ],
        'deleteUser' => [
            'successUser'       => 'Usuario eliminado con éxito',
            'StitleUser'        => 'Usuario eliminado con éxito',
            'SmsgUser'          => 'Se ha eliminado el usuario de la base de datos.',
            'errorUser'         => '¡Error! El usuario no pudo ser eliminado correctamente.',
            'EmsgUser'          => 'El usuario no pudo ser eliminado correctamente.',
            'Etitle'            => 'Error',
         ],
        'doDeleteSchool' => [
            'successAcademyD'   => 'Academia eliminada con éxito',
            'Stitle'            => 'Éxito',
            'SmsgD'             => 'Academia eliminada con éxito.',
            'errorAcademy'      => 'Error! La academia no pudo ser eliminada',
            'EmsgD'             => 'La academia no pudo ser eliminada.',
            'Etitle'            => 'Error',
        ],
        'saveSchool' => [
            'errorSaveAcademy'  => 'Fallo al guardar el código del vídeo asociado a la academia.',
            'EmsgSaveAcademy'   => 'Fallo al guardar el código del vídeo asociado a la academia.',
            'Etitle'            => 'Error',
            'errorDir'          => 'No se pudo modificar los datos de la acadamia. Fallo al guardar la dirección.',
            'EmsgDir'           => 'Se produjo un error al tratar de guardar la dirección. No se pudo modificar los datos de la acadamia.',
            'errorPostAvatar'   => 'Error al subir la imagen de perfil: ',
            'EmsgPostAvatar'    => 'Error al subir la imagen de perfil: ',
            'errorSaveAvatar'   => 'Error al guardar la imagen de perfil: ',
            'EmsgSaveAvatar'    => 'Error al guardar la imagen de perfil: ',
            'successUpdate'     => 'Datos de academia actualizados con éxito',
            'SmsgUpdate'        => 'Datos de academia actualizados con éxito',
            'errorUpdate'       => '¡Error! No se pudo actualizar datos de la academia',
            'EmsgUpdate'        => 'No se pudo actualizar datos de la academia.',
        ],
        'createLesson' => [
            'errorLesson'       => 'No se pudo crear nueva clase. Error al guardar la dirección.',
            'EmsgLeesson'       => 'No se pudo crear nueva clase. Error al guardar la dirección.',
            'errorSave'         => 'Error! No se pudo crear la clase',
            'Etitle'            => 'Error',
            'EmsgCreate'        => 'No se pudo crear la clase.',
            'warningCreateClass'=> 'Aviso: La clase se creó con errores',
            'Wtitle'            => 'Aviso',
            'Wmsg'              => 'El curso se creó satisfactoriamente pero con errores en las disponibilidades asociadas.',
            'successClass'      => 'Clase creada con éxito',
            'Stitle'            => 'Éxito',
            'Smsg'              => 'Curso creado satisfactoriamente.',
        ],
        'saveLesson' => [
            'errorSaveDir'      => 'No se pudo actualizar datos. Error al guardar la nueva dirección.',
            'Etitle'            => 'Error',
            'EmsgSave'          => 'Error al tratar de guardar la nueva dirección. No se pudieron actualizar los datos.',
            'errorUpdate'       => 'Error! No se pudo actualizar datos de la clase',
            'EmsgUpdate'        => 'No se pudieron actualizar los datos de la clase.',
            'warningUpdate'     => 'Aviso! Se actualizaron los datos de la clase con errores',
            'Wtitle'            => 'Aviso',
            'Wmsg'              => 'Se actualizaron los datos de la clase con posibles errores en las disponibilidades.',
            'successLesson'     => 'Datos de la clase actualizados con éxito',
            'Stitle'            => 'Éxito',
            'Smsg'              => 'Los datos del curso se actualizaron con éxito.',
        ],

        'deleteLesson' => [
            'errorDelete'       => 'Error! La clase no pudo ser eliminada',
            'Etitle'            => 'Error',
            'EmsgDelete'        => 'La clase no pudo ser eliminada.',
            'successDelete'     => 'Clase eliminada con éxito',
            'Stitle'            => 'Éxito',
            'SmsgLeeson'        => 'Clase eliminada con éxito.',
        ],

        'deleteSchoolReview' => [
            'errorReview'       => 'Error! La valoración no pudo ser eliminada',
            'Etitle'            => 'Error',
            'EmsgReview'        => 'La valoración no pudo ser eliminada.',
            'successReview'     => 'Valoración eliminada con éxito',
            'Stitle'            => 'Éxito',
            'SmsgReview'        => 'Se eliminó la valoración.',
        ],

        'deleteTeacherReview' => [
            'errorReview'       => 'Error! La valoración no pudo ser eliminada',
            'Etitle'            => 'Error',
            'Emsg'              => 'La valoración no pudo ser eliminada.',
            'success'           => 'Valoración eliminada con éxito',
            'Stitle'            => 'Éxito',
            'Smsg'              => 'Se eliminó la valoración.',
        ],
    ],

    'contactcontroller' => [
        'getMiniContactForm' => [
            'minicontact-success'   => 'Tu mensaje ha sido enviado. ¡Muchas gracias!',
            'minicontact-error'     => 'Faltan campos por rellenar.',
        ],

        'getContactForm' => [
            'success'               => 'Tu mensaje ha sido enviado. ¡Muchas gracias!',
            'Stitle'                => 'Éxito',
            'Smsg'                  => 'Tu mensaje ha sido enviado. ¡Muchas gracias!.',
            'error'                 => '¡Error! Faltan campos por rellenar.',
            'Etitle'                => 'Error',
            'Emsg'                  => 'No se pudo enviar tu mensaje. Asegúrate de que todos los campos están rellenados correctamente.',
        ],
    ],

    'teachercontroller' => [
        'createLesson' => [
            'error'                 => '¡Error! Los datos introducidos pueden no ser válidos. Asegúrate de haber rellenado los campos correctamente.',
            'Etitle'                => 'Error',
            'Emsg'                  => 'Los datos introducidos pueden no ser válidos. Asegúrate de haber rellenado los campos correctamente.',
            'errorDir'              => '¡Error! La dirección proporcionada parece no ser válida.',
            'EmsgDir'               => 'La dirección proporcionada parece no ser válida. Comprueba si está escrita correctamente.',
            'success'               => 'Clase creada con éxito',
            'Stitle'                => 'Éxito',
            'Smsg'                  => 'Tu clase ha sido dada de alta y aparecerá en los resultados de las búsquedas.',
            'errorLesson'           => '¡Error! No se pudo crear la clase. Ponte en contacto con el equipo de milPROFES si el problema persiste.',
            'EmsgLesson'            => 'Error al tratar de crear la clase. Ponte en contacto con el equipo de milPROFES si el problema persiste.',
            'errorData'             => '¡Error! No se pudo actualizar los datos de la clase.',
            'EmsgData'              => 'No se pudieron actualizar los datos de tu clase. Si el problema persiste, ponte en contacto con el equipo de milPROFES.',
        ],

        'saveLesson' => [
            'error'                 => '¡Error! No se pudo actualizar los datos de tu clase. Asegúrate de haber rellenado los campos correctamente.',
            'Etitle'                => 'Error',
            'Emsg'                  => 'No se pudo actualizar los datos de tu clase. Asegúrate de haber rellenado los campos correctamente.',
            'errorDir'              => '¡Error! La dirección proporcionada parece no ser válida.',
            'EmsgDir'               => 'La dirección proporcionada parece no ser válida. Asegúrate de haber escrito la dirección correctamente.',
            'success'               => 'Datos de la clase actualizados con éxito',
            'Stitle'                => 'Éxito',
            'Smsg'                  => 'Se han actualizado los datos de tu clase.',
            'errorData'             => '¡Error! No se pudo actualizar los datos de la clase',
            'EmsgData'              => 'No se pudieron actualizar los datos de tu clase. Si el problema persiste, ponte en contacto con el equipo de milPROFES.'
        ],

        'editLesson' => [
            'error'                 => '¡Error! Tu clase no ha sido encontrada',
            'Etitle'                => 'Error',
            'Emsg'                  => 'Tu clase no ha sido encontrada. Si el problema persiste ponte en contacto con el equipo de milPROFES.',

        ],

        'deleteLesson' => [
            'error'                 => 'Error! Tu clase no ha sido encontrada',
            'Etitle'                => 'Error',
            'Emsg'                  => 'Tu clase no ha sido encontrada. Si el problema persiste ponte en contacto con el equipo de milPROFES.',
        ],

        'doDeleteLesson' => [
            'error'                 => '¡Error! La clase no pudo ser eliminada',
            'Etitle'                => 'Error',
            'Emsg'                  => 'La clase no pudo ser eliminada. Si el problema persiste, ponte en contacto con el equipo de milPROFES.',
            'success'               => 'Clase eliminada con éxito',
            'errorDelete'           => '¡Error! La clase no pudo ser eliminada.',
            'Stitle'                => 'Éxito',
            'Smsg'                  => 'Se ha eliminado la clase.',
            'EmsgLesson'            => 'La clase no pudo ser eliminada. Si el problema persiste, ponte en contacto con el equipo de milPROFES.',

        ],

        'saveAvailability' => [
            'error'                 => '¡Error! No se pudo actualizar tu disponibilidad.',
            'Etitle'                => 'Error',
            'EmsgData'              => 'No se pudo actualizar tu disponibilidad. Los datos introducidos no son válidos.',
            'Emsg'                  => 'No se pudo actualizar tu disponibilidad. Si el problema persiste, ponte en contacto con el equipo de milPROFES.',
            'success'               => 'Tu disponibilidad ha sido actualizada con éxito',
            'Stitle'                => 'Éxito',
            'Smsg'                  => 'Tu disponibilidad ha sido actualizada.',
        ],

    ],

    'userscontroller' => [
        'create' => [
            'show_register_modal'   => true,
        ],
        'store' => [
            'reg-error'             => 'No se cumplimentaron los campos correctamente. Vuelve a intentarlo.',
            'show_login_modal'   => true,
            'show_register_modal'   => true,
            'reg-error-dir'         => 'La dirección proporcionada no parece ser válida. Prueba escribiendo tu calle, número y ciudad.',
            'log-notice'            => trans('messages.user_just_registered'),
            'success'               => '',
            'Stitle'                => 'Confirma tu e-mail',
            'Smsg'                  => 'En breve recibirás un e-mail de milPROFES con el que podrás confirmar tu dirección de correo electrónico.',
        ],

        'updateUserPasswd'  => [
            'error'                 => 'No fue posible cambiar la contraseña. Asegúrate de introducir una nueva contraseña adecuada y diferente a la actual.',
            'Etitle'                => 'Error',
            'Emsg'                  => 'No fue posible cambiar la contraseña. Asegúrate de introducir una nueva contraseña adecuada y diferente a la actual.',
            'error_pwd'             => 'La contraseña actual no es la correcta.',
            'Emsg_pwd'              => 'La vieja contraseña proporcionada no es la correcta.',
            'log-success'           => 'Tu contraseña se ha actualizado con éxito. Por favor, accede con tu nueva contraseña.',
            'log-notice'            => 'No se fue posible actualizar tu contraseña. Tu sesión ha caducado, por favor, vuelve a iniciar sesión e inténtalo de nuevo.'
        ],

        'updateAvatar'  => [
            'error'                 => 'No ha sido posible actualizar tu foto de perfil. Inténtalo de nuevo.',
            'Etitle'                => 'Error',
            'Emsg'                  => 'No ha sido posible actualizar tu foto de perfil. Inténtalo de nuevo.',
            'error_image_profile'   => 'Error al actualizar tu imagen de perfil: asegúrate de que tu imagen es del tipo PNG, JPG o GIF.',
            'Emsg_image_profile'    => 'Error al actualizar tu imagen de perfil: asegúrate de que tu imagen es del tipo PNG, JPG o GIF.',
            'success'               => 'Tu imagen de perfil se ha actualizado con éxito',
            'Stitle'                => 'Éxito',
            'Smsg'                  => 'Tu imagen de perfil ha sido actualizada.',
            'error_image'           => 'Error al actualizar tu imagen de perfil. Inténtalo de nuevo.',
            'Emsg_image'            => 'Error al actualizar tu imagen de perfil. Inténtalo de nuevo.',
            'log-notice'            => 'No ha sido posible actualizar tu imagen de perfil porque tu sesión ha caducado. Por favor, vuelve a iniciar sesión e inténtalo de nuevo.',
        ],

        'updateUser' => [
            'error'                 => 'No ha sido posible actualizar tus datos. Asegúrate de haber rellenado los campos correctamente.',
            'Etitle'                => 'Error',
            'EmsgField'             => 'No ha sido posible actualizar tus datos. Asegúrate de haber rellenado los campos correctamente.',
            'errorDir'              => 'No fue posible actualizar tus datos. La dirección proporcionada parece no ser válida.',
            'Emsg'                  => 'No fue posible actualizar tus datos. La dirección proporcionada parece no ser válida.',
            'success'               => 'Tus datos se han actualizado con éxito',
            'Stitle'                => 'Éxito',
            'Smsg'                  => 'Se han actualizado tus datos.',
            'errorData'             => 'Error al actualizar tus datos',
            'EmsgData'              => 'Error al tratar de actualizar tus datos. Si el problema persiste, ponte en contacto con el equipo de milPROFES.',
            'log-notice'            => 'Tu sesión ha caducado y no fue posible actualizar tus datos. Por favor, vuelve a acceder e inténtalo de nuevo.',
        ],

        'updateSocial' => [
            'error'                 => 'No ha sido posible actualizar los enlaces a redes sociales. Asegúrate de haber introducido direcciones web válidas.',
            'Etitle'                => 'Error',
            'Emsg'                  => 'No ha sido posible actualizar tus enlaces a redes sociales. Asegúrate de haber introducido direcciones web válidas.',
            'success'               => 'Tus enlaces a redes sociales se han actualizado con éxito.',
            'Stitle'                => 'Éxito',
            'Smsg'                  => 'Tus enlaces a redes sociales han sido actualizados.',
            'errorData'             => 'Error al actualizar tus datos',
            'EmsgLink'              => 'Error al tratar de actualizar tus enlaces sociales.',
            'log-notice'            => 'Tu sesión ha caducado y no fue posible actualizar tus datos. Por favor, vuelve a acceder e inténtalo de nuevo.',

        ],


        'becomeATeacher' => [
            'success'               => '¡Ahora ya eres profe.! ¡Publica tus clases!',
            'Stitle'                => 'Éxito',
            'Smsg'                  => '¡Ya eres profe.! ¡Publica tus clase para aparecer en los resultados de las búsquedas!',
            'log-notice'            => 'Al parece tu sesión ha caducado. Por favor, vuelve a acceder e inténtalo de nuevo.',
        ],
    ],
);
