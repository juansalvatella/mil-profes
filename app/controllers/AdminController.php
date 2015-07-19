<?php

class AdminController extends BaseController
{
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
                ->with('error', 'No se pudo crear la acadamia. Error al tratar de guardar la dirección.')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'No se pudo crear la acadamia. Se produjo un error al tratar de guardar la dirección.');
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

            //associate video
            $video = new Video();
            $video->video = $input['video'];
            $video->school()->associate($school);
            $video->save();

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
                        return Redirect::to('admin/schools')
                            ->with('warning', 'La academia fue creada pero se dieron errores en el proceso.')
                            ->with('Wtitle', 'Aviso')
                            ->with('Wmsg', 'La academia fue creada pero se dieron errores en el proceso.')
                            ->with('error', 'Error al tratar de subir la imagen de perfil: ' . $img)
                            ->with('Etitle', 'Error')
                            ->with('Emsg', 'Error al subir la imagen de perfil: ' . $img);
                    } else {
                        $file_extension = $upload->getClientOriginalExtension();
                        $filename = Str::random(30) . '.' . $file_extension;
                        $path = public_path() . '/img/pics/';
                        $upload->move($path, $filename);
                        $pic = new Pic();
                        $pic->pic = $filename;
                        $pic->school()->associate($school);
                        if(!$pic->save()){
                            return Redirect::to('admin/schools')
                                ->with('warning', 'La academia fue creada pero se dieron errores en el proceso.')
                                ->with('Wtitle', 'Aviso')
                                ->with('Wmsg', 'La academia fue creada pero se dieron errores en el proceso.')
                                ->with('error', 'Error al subir la imagen de perfil: ' . $img)
                                ->with('Etitle', 'Error')
                                ->with('Emsg', 'Error al subir la imagen de perfil: ' . $img);
                        }
                    }
                }
            }
            return Redirect::to('admin/schools')
                ->with('success', 'Academia creada con éxito')
                ->with('Stitle','Academia creada con éxito')
                ->with('Smsg','Se ha añadido la nueva academia a la base de datos.');
        }
        else
            return Redirect::to('admin/schools')
                ->withInput()
                ->with('error', 'Error al tratar de guardar la academia en base de datos')
                ->with('Etitle','Error')
                ->with('Emsg','Se ha producido un error al tratar de guardar la academia en base de datos.');
    }

    public function deleteUser() {
        $user_id = Input::get('id');
        $user = User::findOrFail($user_id);
        $teacher = $user->teacher()->first();
        $teacher->delete();
        $user->delete();

        if($user->trashed() && $teacher->trashed())
            return Redirect::to('admin/teachers')
                ->with('success', 'Usuario eliminado con éxito')
                ->with('Stitle','Usuario eliminado con éxito')
                ->with('Smsg','Se ha eliminado el usuario de la base de datos.');
        else
            return Redirect::to('admin/teachers')
                ->with('error', '¡Error! El usuario no pudo ser eliminado correctamente.')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'El usuario no pudo ser eliminado correctamente.');
    }

    public function deleteSchool()
    {
        $school_id = Input::get('id');
        $school = School::findOrFail($school_id);
        $school->delete();

        if($school->trashed())
            return Redirect::to('admin/schools')
                ->with('success', 'Academia eliminada con éxito')
                ->with('Stitle', 'Éxito')
                ->with('Smsg', 'Academia eliminada con éxito.');
        else
            return Redirect::to('admin/schools')
                ->with('error', 'Error! La academia no pudo ser eliminada')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'La academia no pudo ser eliminada.');
    }

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

        if($school->video()->first()) {
            $video = $school->video()->first();
            $video->video = $input['video'];
        } else {
            $video = new Video();
            $video->video = $input['video'];
            $video->school()->associate($school);
        }

        if(!$video->save())
            return Redirect::back()->withInput()
                ->with('error', 'Fallo al guardar el código del vídeo asociado a la academia.')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'Fallo al guardar el código del vídeo asociado a la academia.');

        if(Input::get('address') != $school->address) {
            $school->address = $input['address'];
            $geocoding = Geocoding::geocode($school->address);
            if(!$geocoding) {
                return Redirect::back()
                    ->withInput()
                    ->with('error', 'No se pudo modificar los datos de la acadamia. Fallo al guardar la dirección.')
                    ->with('Etitle', 'Error')
                    ->with('Emsg', 'Se produjo un error al tratar de guardar la dirección. No se pudo modificar los datos de la acadamia.');
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
                        ->with('error', 'Error al subir la imagen de perfil: ' . $img)
                        ->with('Etitle', 'Error')
                        ->with('Emsg', 'Error al subir la imagen de perfil: ' . $img);
                } else {
                    $file_extension = $upload->getClientOriginalExtension();
                    $filename = Str::random(30) . '.' . $file_extension;
                    $path = public_path() . '/img/pics/';
                    $upload->move($path, $filename);
                    $pic = new Pic();
                    $pic->pic = $filename;
                    $pic->school()->associate($school);
                    if(!$pic->save()){
                        return Redirect::back()
                            ->withInput()
                            ->with('error', 'Error al guardar la imagen de perfil: ' . $img)
                            ->with('Etitle', 'Error')
                            ->with('Emsg', 'Error al guardar la imagen de perfil: ' . $img);
                    }
                }
            }
        }

        if($school->save())
            return Redirect::to('admin/schools')
                ->with('success', 'Datos de academia actualizados con éxito')
                ->with('Stitle', 'Éxito')
                ->with('Smsg', 'Datos de academia actualizados con éxito');
        else
            return Redirect::to('admin/schools')
                ->with('error', '¡Error! No se pudo actualizar datos de la academia')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'No se pudo actualizar datos de la academia.');
    }

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
//            return Redirect::route('lessons', array('school_id' => $school_id))
            return Redirect::back()
                ->withInput()
                ->with('error', 'No se pudo crear nueva clase. Error al guardar la dirección.')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'No se pudo crear nueva clase. Error al guardar la dirección.');
        }
        $lesson->lat = $geocoding[0]; //latitud
        $lesson->lon = $geocoding[1]; //longitud

        $school = School::findOrFail($school_id);
        $subject_name = Input::get('subject');
        $subject = Subject::where('name',$subject_name)->first();

        $lesson->subject()->associate($subject);
        $lesson->school()->associate($school);

        if(!$lesson->save()) {
            return Redirect::route('lessons', array('school_id' => $school_id))
                ->with('error', 'Error! No se pudo crear la clase')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'No se pudo crear la clase.');
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
                    return Redirect::route('lessons', array('school_id' => $school_id))
                        ->with('warning', 'Aviso: La clase se creó con errores')
                        ->with('Wtitle', 'Aviso')
                        ->with('Wmsg', 'El curso se creó satisfactoriamente pero con errores en las disponibilidades asociadas.');
                }
            }
        }

        return Redirect::route('lessons',array('school_id' => $school_id))
            ->with('success', 'Clase creada con éxito')
            ->with('Stitle', 'Éxito')
            ->with('Smsg', 'Curso creado satisfactoriamente.');
    }

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
//            return Redirect::route('lessons', array('school_id' => $school_id))
            return Redirect::back()
                ->withInput()
                ->with('error', 'No se pudo actualizar datos. Error al guardar la nueva dirección.')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'Error al tratar de guardar la nueva dirección. No se pudieron actualizar los datos.');
        }
        $lesson->lat = $geocoding[0]; //latitud
        $lesson->lon = $geocoding[1]; //longitud

        $subject_name = Input::get('subject');
        $subject = Subject::where('name',$subject_name)->first();
        $lesson->subject()->associate($subject);

        if(!$lesson->save()) {
            return Redirect::route('lessons', array('school_id' => $school_id))
                ->with('error', 'Error! No se pudo actualizar datos de la clase')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'No se pudieron actualizar los datos de la clase.');
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
                    return Redirect::route('userpanel')
                        ->with('warning', 'Aviso! Se actualizaron los datos de la clase con errores')
                        ->with('Wtitle', 'Aviso')
                        ->with('Wmsg', 'Se actualizaron los datos de la clase con posibles errores en las disponibilidades.');
                }
                ++$i;
            }
        }

        return Redirect::route('lessons',array('school_id' => $school_id))
            ->with('success', 'Datos de la clase actualizados con éxito')
            ->with('Stitle', 'Éxito')
            ->with('Smsg', 'Los datos del curso se actualizaron con éxito.');
    }

    public function deleteLesson()
    {
        $lesson_id = Input::get('lesson_id');
        $school_id = Input::get('school_id');
        $lesson = SchoolLesson::findOrFail($lesson_id);
        $lesson->delete();

        if($lesson->exists)
            return Redirect::route('lessons',array('school_id' => $school_id))
                ->with('error', 'Error! La clase no pudo ser eliminada')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'La clase no pudo ser eliminada.');
        else
            return Redirect::route('lessons',array('school_id' => $school_id))
                ->with('success', 'Clase eliminada con éxito')
                ->with('Stitle', 'Éxito')
                ->with('Smsg', 'Clase eliminada con éxito.');
    }

    public function deleteSchoolReview($id) {
        $rating = SchoolLessonRating::findOrFail($id);
        $rating->delete();
        if($rating->exists)
            return Redirect::to('admin/school/reviews')
                ->with('error', 'Error! La valoración no pudo ser eliminada')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'La valoración no pudo ser eliminada.');
        else
            return Redirect::to('admin/school/reviews')
                ->with('success', 'Valoración eliminada con éxito')
                ->with('Stitle', 'Éxito')
                ->with('Smsg', 'Se eliminó la valoración.');
    }

    public function deleteTeacherReview($id) {
        $rating = Rating::findOrFail($id);
        $rating->delete();
        if($rating->exists)
            return Redirect::to('admin/teacher/reviews')
                ->with('error', 'Error! La valoración no pudo ser eliminada')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'La valoración no pudo ser eliminada.');
        else
            return Redirect::to('admin/teacher/reviews')
                ->with('success', 'Valoración eliminada con éxito')
                ->with('Stitle', 'Éxito')
                ->with('Smsg', 'Se eliminó la valoración.');
    }

}