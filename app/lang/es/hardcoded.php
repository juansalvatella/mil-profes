<?php

return array
(
    'admincontroller' => [
        'createSchool' => [
            'errorDir'          => 'No se pudo crear la acadamia. Error al tratar de guardar la direcci�n.',
            'Etitle'            => 'Error',
            'EmsgDir'           => 'No se pudo crear la acadamia. Se produjo un error al tratar de guardar la direcci�n.',
            'warning'           => 'La academia fue creada pero se dieron errores en el proceso.',
            'Wtitle'            => 'Aviso',
            'Wmsg'              => 'La academia fue creada pero se dieron errores en el proceso.',
            'errorProfile'      => 'Error al tratar de subir la imagen de perfil:',
            'EmsgProfile'       => 'Error al subir la imagen de perfil:',
            'successAcademy'    => 'Academia creada con �xito',
            'StitleCreate'      => 'Academia creada con �xito',
            'Smsg'              => 'Se ha a�adido la nueva academia a la base de datos.',
            'errorDB'           => 'Error al tratar de guardar la academia en base de datos',
            'EmsgDB'            => 'Se ha producido un error al tratar de guardar la academia en base de datos.',
         ],
        'deleteUser' => [
            'successUser'       => 'Usuario eliminado con �xito',
            'StitleUser'        => 'Usuario eliminado con �xito',
            'SmsgUser'          => 'Se ha eliminado el usuario de la base de datos.',
            'errorUser'         => '�Error! El usuario no pudo ser eliminado correctamente.',
            'EmsgUser'          => 'El usuario no pudo ser eliminado correctamente.',
            'Etitle'            => 'Error',
         ],
        'doDeleteSchool' => [
            'successAcademyD'   => 'Academia eliminada con �xito',
            'Stitle'            => '�xito',
            'SmsgD'             => 'Academia eliminada con �xito.',
            'errorAcademy'      => 'Error! La academia no pudo ser eliminada',
            'EmsgD'             => 'La academia no pudo ser eliminada.',
            'Etitle'            => 'Error',
        ],
        'saveSchool' => [
            'errorSaveAcademy'  => 'Fallo al guardar el c�digo del v�deo asociado a la academia.',
            'EmsgSaveAcademy'   => 'Fallo al guardar el c�digo del v�deo asociado a la academia.',
            'Etitle'            => 'Error',
            'errorDir'          => 'No se pudo modificar los datos de la acadamia. Fallo al guardar la direcci�n.',
            'EmsgDir'           => 'Se produjo un error al tratar de guardar la direcci�n. No se pudo modificar los datos de la acadamia.',
            'errorPostAvatar'   => 'Error al subir la imagen de perfil: ',
            'EmsgPostAvatar'    => 'Error al subir la imagen de perfil: ',
            'errorSaveAvatar'   => 'Error al guardar la imagen de perfil: ',
            'EmsgSaveAvatar'    => 'Error al guardar la imagen de perfil: ',
            'successUpdate'     => 'Datos de academia actualizados con �xito',
            'SmsgUpdate'        => 'Datos de academia actualizados con �xito',
            'errorUpdate'       => '�Error! No se pudo actualizar datos de la academia',
            'EmsgUpdate'        => 'No se pudo actualizar datos de la academia.',
        ],
        'createLesson' => [
            'errorLesson'       => 'No se pudo crear nueva clase. Error al guardar la direcci�n.',
            'EmsgLeesson'       => 'No se pudo crear nueva clase. Error al guardar la direcci�n.',
            'errorSave'         => 'Error! No se pudo crear la clase',
            'Etitle'            => 'Error',
            'EmsgCreate'        => 'No se pudo crear la clase.',
            'warningCreateClass'=> 'Aviso: La clase se cre� con errores',
            'Wtitle'            => 'Aviso',
            'Wmsg'              => 'El curso se cre� satisfactoriamente pero con errores en las disponibilidades asociadas.',
            'successClass'      => 'Clase creada con �xito',
            'Stitle'            => '�xito',
            'Smsg'              => 'Curso creado satisfactoriamente.',
        ],
        'saveLesson' => [
            'errorSaveDir'      => 'No se pudo actualizar datos. Error al guardar la nueva direcci�n.',
            'Etitle'            => 'Error',
            'EmsgSave'          => 'Error al tratar de guardar la nueva direcci�n. No se pudieron actualizar los datos.',
            'errorUpdate'       => 'Error! No se pudo actualizar datos de la clase',
            'EmsgUpdate'        => 'No se pudieron actualizar los datos de la clase.',
            'warningUpdate'     => 'Aviso! Se actualizaron los datos de la clase con errores',
            'Wtitle'            => 'Aviso',
            'Wmsg'              => 'Se actualizaron los datos de la clase con posibles errores en las disponibilidades.',
            'successLesson'     => 'Datos de la clase actualizados con �xito',
            'Stitle'            => '�xito',
            'Smsg'              => 'Los datos del curso se actualizaron con �xito.',
        ],

        'deleteLesson' => [
            'errorDelete'       => 'Error! La clase no pudo ser eliminada',
            'Etitle'            => 'Error',
            'EmsgDelete'        => 'La clase no pudo ser eliminada.',
            'successDelete'     => 'Clase eliminada con �xito',
            'Stitle'            => '�xito',
            'SmsgLeeson'        => 'Clase eliminada con �xito.',
        ],

        'deleteSchoolReview' => [
            'errorReview'       => 'Error! La valoraci�n no pudo ser eliminada',
            'Etitle'            => 'Error',
            'EmsgReview'        => 'La valoraci�n no pudo ser eliminada.',
            'successReview'     => 'Valoraci�n eliminada con �xito',
            'Stitle'            => '�xito',
            'SmsgReview'        => 'Se elimin� la valoraci�n.',
        ],

        'deleteTeacherReview' => [
            'errorReview'       => 'Error! La valoraci�n no pudo ser eliminada',
            'Etitle'            => 'Error',
            'Emsg'              => 'La valoraci�n no pudo ser eliminada.',
            'success'           => 'Valoraci�n eliminada con �xito',
            'Stitle'            => '�xito',
            'Smsg'              => 'Se elimin� la valoraci�n.',
        ],
    ],

    'contactcontroller' => [
        'getMiniContactForm' => [
            'minicontact-success'   => 'Tu mensaje ha sido enviado. �Muchas gracias!',
            'minicontact-error'     => 'Faltan campos por rellenar.',
        ],

        'getContactForm' => [
            'success'               => 'Tu mensaje ha sido enviado. �Muchas gracias!',
            'Stitle'                => '�xito',
            'Smsg'                  => 'Tu mensaje ha sido enviado. �Muchas gracias!.',
            'error'                 => '�Error! Faltan campos por rellenar.',
            'Etitle'                => 'Error',
            'Emsg'                  => 'No se pudo enviar tu mensaje. Aseg�rate de que todos los campos est�n rellenados correctamente.',
        ],
    ],

    'teachercontroller' => [
        'createLesson' => [
            'error'                 => '�Error! Los datos introducidos pueden no ser v�lidos. Aseg�rate de haber rellenado los campos correctamente.',
            'Etitle'                => 'Error',
            'Emsg'                  => 'Los datos introducidos pueden no ser v�lidos. Aseg�rate de haber rellenado los campos correctamente.',
            'errorDir'              => '�Error! La direcci�n proporcionada parece no ser v�lida.',
            'EmsgDir'               => 'La direcci�n proporcionada parece no ser v�lida. Comprueba si est� escrita correctamente.',
            'success'               => 'Clase creada con �xito',
            'Stitle'                => '�xito',
            'Smsg'                  => 'Tu clase ha sido dada de alta y aparecer� en los resultados de las b�squedas.',
            'errorLesson'           => '�Error! No se pudo crear la clase. Ponte en contacto con el equipo de milPROFES si el problema persiste.',
            'EmsgLesson'            => 'Error al tratar de crear la clase. Ponte en contacto con el equipo de milPROFES si el problema persiste.',
            'errorData'             => '�Error! No se pudo actualizar los datos de la clase.',
            'EmsgData'              => 'No se pudieron actualizar los datos de tu clase. Si el problema persiste, ponte en contacto con el equipo de milPROFES.',
        ],

        'saveLesson' => [
            'error'                 => '�Error! No se pudo actualizar los datos de tu clase. Aseg�rate de haber rellenado los campos correctamente.',
            'Etitle'                => 'Error',
            'Emsg'                  => 'No se pudo actualizar los datos de tu clase. Aseg�rate de haber rellenado los campos correctamente.',
            'errorDir'              => '�Error! La direcci�n proporcionada parece no ser v�lida.',
            'EmsgDir'               => 'La direcci�n proporcionada parece no ser v�lida. Aseg�rate de haber escrito la direcci�n correctamente.',
            'success'               => 'Datos de la clase actualizados con �xito',
            'Stitle'                => '�xito',
            'Smsg'                  => 'Se han actualizado los datos de tu clase.',
            'errorData'             => '�Error! No se pudo actualizar los datos de la clase',
            'EmsgData'              => 'No se pudieron actualizar los datos de tu clase. Si el problema persiste, ponte en contacto con el equipo de milPROFES.'
        ],

        'editLesson' => [
            'error'                 => '�Error! Tu clase no ha sido encontrada',
            'Etitle'                => 'Error',
            'Emsg'                  => 'Tu clase no ha sido encontrada. Si el problema persiste ponte en contacto con el equipo de milPROFES.',

        ],

        'deleteLesson' => [
            'error'                 => 'Error! Tu clase no ha sido encontrada',
            'Etitle'                => 'Error',
            'Emsg'                  => 'Tu clase no ha sido encontrada. Si el problema persiste ponte en contacto con el equipo de milPROFES.',
        ],

        'doDeleteLesson' => [
            'error'                 => '�Error! La clase no pudo ser eliminada',
            'Etitle'                => 'Error',
            'Emsg'                  => 'La clase no pudo ser eliminada. Si el problema persiste, ponte en contacto con el equipo de milPROFES.',
            'success'               => 'Clase eliminada con �xito',
            'errorDelete'           => '�Error! La clase no pudo ser eliminada.',
            'Stitle'                => '�xito',
            'Smsg'                  => 'Se ha eliminado la clase.',
            'EmsgLesson'            => 'La clase no pudo ser eliminada. Si el problema persiste, ponte en contacto con el equipo de milPROFES.',

        ],

        'saveAvailability' => [
            'error'                 => '�Error! No se pudo actualizar tu disponibilidad.',
            'Etitle'                => 'Error',
            'EmsgData'              => 'No se pudo actualizar tu disponibilidad. Los datos introducidos no son v�lidos.',
            'Emsg'                  => 'No se pudo actualizar tu disponibilidad. Si el problema persiste, ponte en contacto con el equipo de milPROFES.',
            'success'               => 'Tu disponibilidad ha sido actualizada con �xito',
            'Stitle'                => '�xito',
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
            'reg-error-dir'         => 'La direcci�n proporcionada no parece ser v�lida. Prueba escribiendo tu calle, n�mero y ciudad.',
            'log-notice'            => trans('messages.user_just_registered'),
            'success'               => '',
            'Stitle'                => 'Confirma tu e-mail',
            'Smsg'                  => 'En breve recibir�s un e-mail de milPROFES con el que podr�s confirmar tu direcci�n de correo electr�nico.',
        ],

        'updateUserPasswd'  => [
            'error'                 => 'No fue posible cambiar la contrase�a. Aseg�rate de introducir una nueva contrase�a adecuada y diferente a la actual.',
            'Etitle'                => 'Error',
            'Emsg'                  => 'No fue posible cambiar la contrase�a. Aseg�rate de introducir una nueva contrase�a adecuada y diferente a la actual.',
            'error_pwd'             => 'La contrase�a actual no es la correcta.',
            'Emsg_pwd'              => 'La vieja contrase�a proporcionada no es la correcta.',
            'log-success'           => 'Tu contrase�a se ha actualizado con �xito. Por favor, accede con tu nueva contrase�a.',
            'log-notice'            => 'No se fue posible actualizar tu contrase�a. Tu sesi�n ha caducado, por favor, vuelve a iniciar sesi�n e int�ntalo de nuevo.'
        ],

        'updateAvatar'  => [
            'error'                 => 'No ha sido posible actualizar tu foto de perfil. Int�ntalo de nuevo.',
            'Etitle'                => 'Error',
            'Emsg'                  => 'No ha sido posible actualizar tu foto de perfil. Int�ntalo de nuevo.',
            'error_image_profile'   => 'Error al actualizar tu imagen de perfil: aseg�rate de que tu imagen es del tipo PNG, JPG o GIF.',
            'Emsg_image_profile'    => 'Error al actualizar tu imagen de perfil: aseg�rate de que tu imagen es del tipo PNG, JPG o GIF.',
            'success'               => 'Tu imagen de perfil se ha actualizado con �xito',
            'Stitle'                => '�xito',
            'Smsg'                  => 'Tu imagen de perfil ha sido actualizada.',
            'error_image'           => 'Error al actualizar tu imagen de perfil. Int�ntalo de nuevo.',
            'Emsg_image'            => 'Error al actualizar tu imagen de perfil. Int�ntalo de nuevo.',
            'log-notice'            => 'No ha sido posible actualizar tu imagen de perfil porque tu sesi�n ha caducado. Por favor, vuelve a iniciar sesi�n e int�ntalo de nuevo.',
        ],

        'updateUser' => [
            'error'                 => 'No ha sido posible actualizar tus datos. Aseg�rate de haber rellenado los campos correctamente.',
            'Etitle'                => 'Error',
            'EmsgField'             => 'No ha sido posible actualizar tus datos. Aseg�rate de haber rellenado los campos correctamente.',
            'errorDir'              => 'No fue posible actualizar tus datos. La direcci�n proporcionada parece no ser v�lida.',
            'Emsg'                  => 'No fue posible actualizar tus datos. La direcci�n proporcionada parece no ser v�lida.',
            'success'               => 'Tus datos se han actualizado con �xito',
            'Stitle'                => '�xito',
            'Smsg'                  => 'Se han actualizado tus datos.',
            'errorData'             => 'Error al actualizar tus datos',
            'EmsgData'              => 'Error al tratar de actualizar tus datos. Si el problema persiste, ponte en contacto con el equipo de milPROFES.',
            'log-notice'            => 'Tu sesi�n ha caducado y no fue posible actualizar tus datos. Por favor, vuelve a acceder e int�ntalo de nuevo.',
        ],

        'updateSocial' => [
            'error'                 => 'No ha sido posible actualizar los enlaces a redes sociales. Aseg�rate de haber introducido direcciones web v�lidas.',
            'Etitle'                => 'Error',
            'Emsg'                  => 'No ha sido posible actualizar tus enlaces a redes sociales. Aseg�rate de haber introducido direcciones web v�lidas.',
            'success'               => 'Tus enlaces a redes sociales se han actualizado con �xito.',
            'Stitle'                => '�xito',
            'Smsg'                  => 'Tus enlaces a redes sociales han sido actualizados.',
            'errorData'             => 'Error al actualizar tus datos',
            'EmsgLink'              => 'Error al tratar de actualizar tus enlaces sociales.',
            'log-notice'            => 'Tu sesi�n ha caducado y no fue posible actualizar tus datos. Por favor, vuelve a acceder e int�ntalo de nuevo.',

        ],


        'becomeATeacher' => [
            'success'               => '�Ahora ya eres profe.! �Publica tus clases!',
            'Stitle'                => '�xito',
            'Smsg'                  => '�Ya eres profe.! �Publica tus clase para aparecer en los resultados de las b�squedas!',
            'log-notice'            => 'Al parece tu sesi�n ha caducado. Por favor, vuelve a acceder e int�ntalo de nuevo.',
        ],
    ],
);
