<?php

class TeachersController extends BaseController
{
    public function createLesson()
    {
        $input = Input::all();
        $rules = array(
            'subject' => array('regex:/^(escolar|cfp|musica|idiomas|artes|deportes|universitario)$/'),
            'price' => 'numeric',
            'address' => 'required|string',
            'description' => 'required|string|max:200',
        );
        $validator = Validator::make($input, $rules);
        if($validator->fails()) {
            return Redirect::to('teacher/create/lesson')
                ->withInput()
                ->with('error', '¡Error! Los datos introducidos parecen no ser válidos. Asegúrate de haber rellenado bien los campos');
        }

        $lesson = new TeacherLesson();
        $lesson->price = Input::get('price');
        $lesson->description = Input::get('description');

        $lesson->address = Input::get('address');
        $geocoding = Geocoding::geocode(Input::get('address'));
        if(!$geocoding){
            return Redirect::to('teacher/create/lesson')
                ->withInput()
                ->with('error', '¡Error! La dirección proporcionada parece no ser válida.');
        }
        $lesson->lat = $geocoding[0]; //latitud
        $lesson->lon = $geocoding[1]; //longitud

        $user = Confide::user();
        $teacher = $user->teacher()->first();
        $subject_name = Input::get('subject');
        $subject = Subject::where('name',$subject_name)->first();

        $lesson->subject()->associate($subject);
        $lesson->teacher()->associate($teacher);

        if($lesson->save())
            return Redirect::route('userpanel')->with('success', 'Clase creada con éxito');
        else
            return Redirect::route('userpanel')->with('failure', '¡Error! No se pudo crear la clase. Ponte en contacto con nosotros si el problema persiste.');
    }

    public function saveLesson()
    {
        $input = Input::all();
        $rules = array(
            'subject' => array('regex:/^(escolar|cfp|musica|idiomas|artes|deportes|universitario)$/'),
            'price' => 'numeric',
            'address' => 'required|string',
            'description' => 'required|string|max:200',
        );
        $validator = Validator::make($input, $rules);
        if($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->with('error', '¡Error! No se pudo actualizar los datos de tu clase. Comprueba que todos los campos tengan valores válidos.');
        }

        $lesson_id = Input::get('lesson_id');
        $lesson = TeacherLesson::findOrFail($lesson_id);
        $lesson_teacher = $lesson->teacher()->first();
        $user = Auth::user();
        $teacher = $user->teacher()->first();
        if($teacher->id==$lesson_teacher->id) //Comprobamos que no se esté tratando de editar la clase de otros profesores
        {
            $lesson->price = Input::get('price');
            $lesson->description = Input::get('description');
            $lesson->address = Input::get('address');
            $geocoding = Geocoding::geocode(Input::get('address'));
            if (!$geocoding) {
                return Redirect::back()
                    ->withInput()
                    ->with('error', '¡Error! La dirección proporcionada parece no ser válida.');
            }
            $lesson->lat = $geocoding[0]; //latitud
            $lesson->lon = $geocoding[1]; //longitud

            $subject_name = Input::get('subject');
            $subject = Subject::where('name', $subject_name)->first();
            $lesson->subject()->associate($subject);

            if ($lesson->save())
                return Redirect::route('userpanel')->with('success', 'Datos de la clase actualizados con éxito');
            else
                return Redirect::route('userpanel')->with('failure', '¡Error! No se pudo actualizar los datos de la clase');
        } else {
            return Redirect::route('userpanel')->with('failure', '¡Error! No se pudo actualizar los datos de la clase.');
        }

    }

    public function deleteLesson()
    {
        $lesson_id = Input::get('lesson_id');
        $lesson = TeacherLesson::findOrFail($lesson_id);
        $lesson_teacher = $lesson->teacher()->first();
        $user = Auth::user();
        $teacher = $user->teacher()->first();
        if($teacher->id==$lesson_teacher->id) //Comprobamos que no se esté tratando de eliminar la clase de otros profesores
        {
            $lesson->delete();
            if($lesson->exists)
                return Redirect::route('userpanel')->with('failure', '¡Error! La clase no pudo ser eliminada');
            else
                return Redirect::route('userpanel')->with('success', 'Clase eliminada con éxito');
        } else {
            return Redirect::route('userpanel')->with('failure', '¡Error! La clase no pudo ser eliminada.');
        }

    }

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
            return Redirect::route('userpanel')->with('failure', '¡Error! No se pudo actualizar tu disponibilidad.');
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
                    return Redirect::route('userpanel')->with('failure', '¡Error! No se pudo actualizar tu disponibilidad.');
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
                    return Redirect::route('userpanel')->with('failure', '¡Error! No se pudo actualizar tu disponibilidad.');
                }
                ++$i;
            }
        }

        return Redirect::route('userpanel')->with('success', 'Tu disponibilidad ha sido actualizada con éxito');

    }

}