<?php

class TeachersController extends BaseController
{
    public function createLesson()
    {
        //FALTA VALIDATION DEL FORM
        //price > 0
        //description not empty, min max chars
        //subject one of the accepted 7 types
        //address found and coded by google api

        $lesson = new TeacherLesson();
        $lesson->price = Input::get('price');
        $lesson->description = Input::get('description');

        //FALTA VALIDAR LA GEOCODIFICACION
        $lesson->address = Input::get('address');
        $geocoding = Geocoding::geocode(Input::get('address'));
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
            return Redirect::route('userpanel')->with('failure', 'Error! No se pudo crear la clase');
    }

    public function saveLesson()
    {
        $lesson = TeacherLesson::findOrFail(Input::get('lesson_id'));
        $lesson->price = Input::get('price');
        $lesson->description = Input::get('description');

        $lesson->address = Input::get('address');
        $geocoding = Geocoding::geocode(Input::get('address'));
        $lesson->lat = $geocoding[0]; //latitud
        $lesson->lon = $geocoding[1]; //longitud

        $subject_name = Input::get('subject');
        $subject = Subject::where('name',$subject_name)->first();
        $lesson->subject()->associate($subject);

        if($lesson->save())
            return Redirect::route('userpanel')->with('success', 'Datos de la clase actualizados con éxito');
        else
            return Redirect::route('userpanel')->with('failure', 'Error! No se pudo actualizar los datos de la clase');
    }

    public function deleteLesson()
    {
        $lesson_id = Input::get('lesson_id');
        $lesson = TeacherLesson::findOrFail($lesson_id);
        $lesson->delete();

        if($lesson->exists)
            return Redirect::route('userpanel')->with('failure', 'Error! La clase no pudo ser eliminada');
        else
            return Redirect::route('userpanel')->with('success', 'Clase eliminada con éxito');
    }

    public function saveAvailability() {
        $user = Confide::user();
        $teacher = $user->teacher()->first();
        $teacher_id = $teacher->id;

        $input = Input::all();
//        $rules = array(
//
//        );
//        $validator = Validator::make($input, $rules);

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
                    return Redirect::route('userpanel')->with('failure', 'Error! No se pudo actualizar tu disponibilidad');
                }
            }
        } else { //if there exists 9 previous saved picks, update them with the input
            $i = 1;
            foreach($previous_picks as $pick)
            {
                $pick = TeacherAvailability::findOrFail($pick->id);
                $pick ->teacher_id = $teacher_id;
                $pick->pick = ''.$i;
                $pick->day = $input['day'.$i];
                $pick->start = $input['start'.$i];
                $pick->end = $input['end'.$i];
                if(!$pick->save()) {
                    return Redirect::route('userpanel')->with('failure', 'Error! No se pudo actualizar tu disponibilidad');
                }
                ++$i;
            }
        }

        return Redirect::route('userpanel')->with('success', 'Tu disponibilidad ha sido actualizada con éxito');

    }

}