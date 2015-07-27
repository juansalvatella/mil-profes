<?php

class TeachersController extends BaseController
{
    /**
     * Displays the View to create lesson.
     * @return \Illuminate\View\View
     */
    public function creteLessonForm()
    {
        $user = Auth::user();
        $teacher = $user->teacher()->first();

        return View::make('teacher_lesson_create',compact('user','teacher'));
    }
    /**
     * Requests the creation of lesson or returns errors. 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createLesson()
    {
        $input = Input::all();
        $input['price'] = str_replace(',','.',$input['price']);
        $rules = array(
            'title' => 'required|string|max:50',
            'subject' => 'required|string',
            'price' => 'numeric',
            'address' => 'required|string',
            'description' => 'required|string|max:200',
        );
        $validator = Validator::make($input, $rules);
        if($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->with('error', '¡Error! Los datos introducidos pueden no ser válidos. Asegúrate de haber rellenado los campos correctamente.')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'Los datos introducidos pueden no ser válidos. Asegúrate de haber rellenado los campos correctamente.');
        }

        $lesson = new TeacherLesson();
        $lesson->title = $input['title'];
        $lesson->price = $input['price'];
        $lesson->description = $input['description'];

        $lesson->address = $input['address'];
        $geocoding = Geocoding::geocode(Input::get('address'));
        if(!$geocoding){
            return Redirect::to('teacher/create/lesson')
                ->withInput()
                ->with('error', '¡Error! La dirección proporcionada parece no ser válida.')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'La dirección proporcionada parece no ser válida. Comprueba si está escrita correctamente.');
        }
        $lesson->lat = $geocoding[0]; //latitud
        $lesson->lon = $geocoding[1]; //longitud

        $user = Confide::user();
        $teacher = $user->teacher()->first();
        $subject_name = $input['subject'];
        $subject = Subject::where('name',$subject_name)->first();

        $lesson->subject()->associate($subject);
        $lesson->teacher()->associate($teacher);

        if($lesson->save())
            return Redirect::route('userpanel.dashboard')
                ->with('success', 'Clase creada con éxito')
                ->with('Stitle', 'Éxito')
                ->with('Smsg', 'Tu clase ha sido dada de alta y aparecerá en los resultados de las búsquedas.');
        else
            return Redirect::route('userpanel.dashboard')
                ->with('error', '¡Error! No se pudo crear la clase. Ponte en contacto con el equipo de milPROFES si el problema persiste.')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'Error al tratar de crear la clase. Ponte en contacto con el equipo de milPROFES si el problema persiste.');
    }

    /**
     * Saves the teacher lesson or returns error message.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveLesson()
    {
        $input = Input::all();
        $input['price'] = str_replace(',','.',$input['price']);
        $rules = array(
            'title' => 'required|string|max:50',
            'subject' => 'required|string',
            'price' => 'numeric',
            'address' => 'required|string',
            'description' => 'required|string|max:200',
        );
        $validator = Validator::make($input, $rules);
        if($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->with('error', '¡Error! No se pudo actualizar los datos de tu clase. Asegúrate de haber rellenado los campos correctamente.')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'No se pudo actualizar los datos de tu clase. Asegúrate de haber rellenado los campos correctamente.');
        }

        $lesson_id = $input['lesson_id'];
        $lesson = TeacherLesson::findOrFail($lesson_id);
        $lesson_teacher = $lesson->teacher()->first();
        $user = Confide::user();
        $teacher = $user->teacher()->first();
        if($teacher->id==$lesson_teacher->id) //Comprobamos que no se esté tratando de editar la clase de otros profesores
        {
            $lesson->title = $input['title'];
            $lesson->price = $input['price'];
            $lesson->description = $input['description'];
            $lesson->address = $input['address'];
            $geocoding = Geocoding::geocode($input['address']);
            if (!$geocoding) {
                return Redirect::back()
                    ->withInput()
                    ->with('error', '¡Error! La dirección proporcionada parece no ser válida.')
                    ->with('Etitle', 'Error')
                    ->with('Emsg', 'La dirección proporcionada parece no ser válida. Asegúrate de haber escrito la dirección correctamente.');
            }
            $lesson->lat = $geocoding[0]; //latitud
            $lesson->lon = $geocoding[1]; //longitud

            $subject_name = $input['subject'];
            $subject = Subject::where('name', $subject_name)->first();
            $lesson->subject()->associate($subject);

            if ($lesson->save())
                return Redirect::route('userpanel.dashboard')
                    ->with('success', 'Datos de la clase actualizados con éxito')
                    ->with('Stitle', 'Éxito')
                    ->with('Smsg', 'Se han actualizado los datos de tu clase.');
            else
                return Redirect::route('userpanel.dashboard')
                    ->with('error', '¡Error! No se pudo actualizar los datos de la clase')
                    ->with('Etitle', 'Error')
                    ->with('Emsg', 'No se pudieron actualizar los datos de tu clase. Si el problema persiste, ponte en contacto con el equipo de milPROFES.');
        } else {
            return Redirect::route('userpanel.dashboard')
                ->with('error', '¡Error! No se pudo actualizar los datos de la clase.')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'No se pudieron actualizar los datos de tu clase. Si el problema persiste, ponte en contacto con el equipo de milPROFES.');
        }
    }

    /**
     * Given the variable $lesson_id, and returns the view of teacher_lesson_edit or error message.
     * @param $lesson_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function editLesson($lesson_id)
    {
        $lesson = TeacherLesson::findOrFail($lesson_id);
        $subject = $lesson->subject()->first();
        $lesson_teacher = $lesson->teacher()->first();

        $user = Auth::user();
        $teacher = $user->teacher()->first();

        if($teacher->id==$lesson_teacher->id) //Comprobamos que no se esté tratando de editar clases de otros usuarios
            return View::make('teacher_lesson_edit', compact('lesson','subject'));
        else
            return Redirect::route('userpanel.dashboard')
                ->with('error', '¡Error! Tu clase no ha sido encontrada')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'Tu clase no ha sido encontrada. Si el problema persiste ponte en contacto con el equipo de milPROFES.');
    }

    /**
     * Given the parameter $lesson_id, deletes the lesson of this id.
     * @param $lesson_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function deleteLesson($lesson_id)
    {
        $lesson = TeacherLesson::findOrFail($lesson_id);
        $lesson_teacher = $lesson->teacher()->first();
        $subject = $lesson->subject()->first();

        $user = Auth::user();
        $teacher = $user->teacher()->first();

        if($teacher->id==$lesson_teacher->id) //Comprobamos que no se está tratando de eliminar las clases de otros usuarios
            return View::make('teacher_lesson_confirm_delete', compact('user','lesson','subject'));
        else
            return Redirect::route('userpanel.dashboard')
                ->with('error', 'Error! Tu clase no ha sido encontrada')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'Tu clase no ha sido encontrada. Si el problema persiste ponte en contacto con el equipo de milPROFES.');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doDeleteLesson()
    {
        $lesson_id = Input::get('lesson_id');
        $lesson = TeacherLesson::findOrFail($lesson_id);
        $lesson_teacher = $lesson->teacher()->first();
        $user = Confide::user();
        $teacher = $user->teacher()->first();
        if($teacher->id==$lesson_teacher->id) //Comprobamos que no se esté tratando de eliminar la clase de otros profesores
        {
            $lesson->delete();
            if($lesson->exists)
                return Redirect::route('userpanel.dashboard')
                    ->with('error', '¡Error! La clase no pudo ser eliminada')
                    ->with('Etitle', 'Error')
                    ->with('Emsg', 'La clase no pudo ser eliminada. Si el problema persiste, ponte en contacto con el equipo de milPROFES.');
            else
                return Redirect::route('userpanel.dashboard')->with('success', 'Clase eliminada con éxito')
                    ->with('Stitle', 'Éxito')
                    ->with('Smsg', 'Se ha eliminado la clase.');
        } else {
            return Redirect::route('userpanel.dashboard')->with('error', '¡Error! La clase no pudo ser eliminada.')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'La clase no pudo ser eliminada. Si el problema persiste, ponte en contacto con el equipo de milPROFES.');
        }
    }

    /**
     * Saves the availability.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveAvailability() {

        $user = Confide::user();
        $teacher = $user->teacher()->first();
        $teacher_id = $teacher->id;

        $input = Input::all();
        $rules = array(
            'day1' => array('regex:/^(LUN|MAR|MIER|JUE|VIE|SAB|DOM|)$/'),
            'day2' => array('regex:/^(LUN|MAR|MIER|JUE|VIE|SAB|DOM|)$/'),
            'day3' => array('regex:/^(LUN|MAR|MIER|JUE|VIE|SAB|DOM|)$/'),
            'day4' => array('regex:/^(LUN|MAR|MIER|JUE|VIE|SAB|DOM|)$/'),
            'day5' => array('regex:/^(LUN|MAR|MIER|JUE|VIE|SAB|DOM|)$/'),
            'day6' => array('regex:/^(LUN|MAR|MIER|JUE|VIE|SAB|DOM|)$/'),
            'day7' => array('regex:/^(LUN|MAR|MIER|JUE|VIE|SAB|DOM|)$/'),
            'day8' => array('regex:/^(LUN|MAR|MIER|JUE|VIE|SAB|DOM|)$/'),
            'day9' => array('regex:/^(LUN|MAR|MIER|JUE|VIE|SAB|DOM|)$/'),
            'start1' => array('regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'),
            'start2' => array('regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'),
            'start3' => array('regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'),
            'start4' => array('regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'),
            'start5' => array('regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'),
            'start6' => array('regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'),
            'start7' => array('regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'),
            'start8' => array('regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'),
            'start9' => array('regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'),
            'end1' => array('regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'),
            'end2' => array('regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'),
            'end3' => array('regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'),
            'end4' => array('regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'),
            'end5' => array('regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'),
            'end6' => array('regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'),
            'end7' => array('regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'),
            'end8' => array('regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'),
            'end9' => array('regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'),
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()){
            return Redirect::route('userpanel.dashboard')
                ->with('error', '¡Error! No se pudo actualizar tu disponibilidad.')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'No se pudo actualizar tu disponibilidad. Los datos introducidos no son válidos.');
        }

        $previous_picks = $teacher->availabilities()->get();
        if($previous_picks->count()!=9) //if teacher has never saved availability before, create 9 new picks with the input
        {
            for($i=1;$i<10;++$i)
            {
                $pick = new TeacherAvailability();
                $pick ->teacher_id = $teacher_id;
                $pick->pick = ''.$i;
                $pick->day = $input['day'.$i];
                $pick->start = $input['start'.$i];
                $pick->end = $input['end'.$i];
                if(!$pick->save()) {
                    return Redirect::route('userpanel.dashboard')
                        ->with('error', '¡Error! No se pudo actualizar tu disponibilidad.')
                        ->with('Etitle', 'Error')
                        ->with('Emsg', 'No se pudo actualizar tu disponibilidad. Si el problema persiste, ponte en contacto con el equipo de milPROFES.');
                }
            }
        } else { //if there exists 9 previous saved picks (even empty ones, in DB), update them with the input

            $cleanInput = array();
            $k=1;
            for($j=1;$j<10;++$j){
                if($input['day'.$j] != '') {
                    $cleanInput['day'.$k] = $input['day'.$j];
                    $cleanInput['start'.$k] = $input['start'.$j];
                    $cleanInput['end'.$k] = $input['end'.$j];
                    ++$k;
                }
            }
            for($h=$k;$h<10;++$h) {
                $cleanInput['day'.$h] = '';
                $cleanInput['start'.$h] = '15:00';
                $cleanInput['end'.$h] = '21:00';
            }
            $i = 1;
            foreach($previous_picks as $pick)
            {
                $pick = TeacherAvailability::findOrFail($pick->id);
                $pick ->teacher_id = $teacher_id;
                $pick->pick = ''.$i;
                $pick->day = $cleanInput['day'.$i];
                $pick->start = $cleanInput['start'.$i];
                $pick->end = $cleanInput['end'.$i];
                if(!$pick->save()) {
                    return Redirect::route('userpanel.dashboard')
                        ->with('error', '¡Error! No se pudo actualizar tu disponibilidad.')
                        ->with('Etitle', 'Error')
                        ->with('Emsg', 'No se pudo actualizar tu disponibilidad. Si el problema persiste, ponte en contacto con el equipo de milPROFES.');
                }
                ++$i;
            }
        }

        return Redirect::route('userpanel.dashboard')
            ->with('success', 'Tu disponibilidad ha sido actualizada con éxito')
            ->with('Stitle', 'Éxito')
            ->with('Smsg', 'Tu disponibilidad ha sido actualizada.');
    }
}
