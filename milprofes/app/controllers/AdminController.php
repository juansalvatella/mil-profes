<?php

class AdminController extends BaseController
{
    public function createSchool()
    {
        $school = new School();
        if(Input::hasFile('logo'))
        {
            $file = Input::file('logo');
            $file_extension = Input::file('logo')->getClientOriginalExtension();
            $filename = Str::random(20).'.'.$file_extension;
            $path = public_path().'/img/logos/';
            $file->move($path, $filename);
            $school->logo = $filename;
        } else {
            $school->logo = 'default_logo.png';
        }
        $school->name = Input::get('name');
        $school->address = Input::get('address');
        $school->cif = Input::get('cif');
        $school->email = Input::get('email');
        $school->phone = Input::get('phone');
        $school->phone2 = Input::get('phone2');
        $school->description = Input::get('description');
        $geocoding = Geocoding::geocode($school->address);
        if(!$geocoding){
            return Redirect::to('admin/schools')->with('failure', 'No se pudo crear la acadamia. Fallo al guardar la dirección.');
        }
        $school->lat = $geocoding[0]; //latitud
        $school->lon = $geocoding[1]; //longitud

        if($school->save())
            return Redirect::to('admin/schools')->with('success', 'Academia creada con éxito');
        else
            return Redirect::to('admin/schools')->with('failure', 'Error! No se pudo crear la academia');
    }

    public function deleteSchool()
    {
        $school_id = Input::get('id');
        $school = School::findOrFail($school_id);
        $school->lessons()->delete();
        $school->delete();

        if($school->exists)
            return Redirect::to('admin/schools')->with('failure', 'Error! La academia no pudo ser eliminada');
        else
            return Redirect::to('admin/schools')->with('success', 'Academia eliminada con éxito');
    }

    public function saveSchool()
    {
        $school = School::findOrFail(Input::get('id'));
        if(Input::hasFile('logo')) {
            $file = Input::file('logo');
            $file_extension = Input::file('logo')->getClientOriginalExtension();
            $filename = Str::random(20) . '.' . $file_extension;
            $path = public_path() . '/img/logos/';
            $file->move($path, $filename);
            $school->logo = $filename;
        }
        $school->name = Input::get('name');
        $school->cif = Input::get('cif');
        $school->email = Input::get('email');
        $school->phone = Input::get('phone');
        $school->phone2 = Input::get('phone2');
        $school->description = Input::get('description');
        if(Input::get('address') != $school->address)
        {
            $school->address = Input::get('address');
            $geocoding = Geocoding::geocode($school->address);
            if(!$geocoding){
                return Redirect::to('admin/schools')->with('failure', 'No se pudo modificar los datos de la acadamia. Fallo al guardar la dirección.');
            }
            $school->lat = $geocoding[0]; //latitud
            $school->lon = $geocoding[1]; //longitud
        }
        if($school->save())
            return Redirect::to('admin/schools')->with('success', 'Datos de academia actualizados con éxito');
        else
            return Redirect::to('admin/schools')->with('failure', 'Error! No se pudo actualizar datos de la academia');
    }

    public function createLesson()
    {
        $input = Input::all();
        $lesson = new SchoolLesson();
        $lesson->price = Input::get('price');
        $lesson->description = Input::get('description');
        $lesson->address = Input::get('address');
        $geocoding = Geocoding::geocode(Input::get('address'));
        $school_id = Input::get('school_id');
        if(!$geocoding){
            return Redirect::route('lessons', array('school_id' => $school_id))->with('failure', 'Error al guardar la dirección de la clase');
        }
        $lesson->lat = $geocoding[0]; //latitud
        $lesson->lon = $geocoding[1]; //longitud

        $school = School::findOrFail($school_id);
        $subject_name = Input::get('subject');
        $subject = Subject::where('name',$subject_name)->first();

        $lesson->subject()->associate($subject);
        $lesson->school()->associate($school);

        if(!$lesson->save()) {
            return Redirect::route('lessons', array('school_id' => $school_id))->with('failure', 'Error! No se pudo crear la clase');
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
                    return Redirect::route('lessons', array('school_id' => $school_id))->with('failure', 'Aviso: La clase se creó con errores');
                }
            }
        }

        return Redirect::route('lessons',array('school_id' => $school_id))->with('success', 'Clase creada con éxito');
    }

    public function saveLesson()
    {
        $input = Input::all();
        $school_id = Input::get('school_id');
        $lesson = SchoolLesson::findOrFail(Input::get('lesson_id'));
        $lesson->price = Input::get('price');
        $lesson->description = Input::get('description');
        $lesson->address = Input::get('address');
        $geocoding = Geocoding::geocode(Input::get('address'));
        if(!$geocoding){
            return Redirect::route('lessons', array('school_id' => $school_id))->with('failure', 'Error al guardar la dirección de la clase');
        }
        $lesson->lat = $geocoding[0]; //latitud
        $lesson->lon = $geocoding[1]; //longitud

        $subject_name = Input::get('subject');
        $subject = Subject::where('name',$subject_name)->first();
        $lesson->subject()->associate($subject);

        if(!$lesson->save()) {
            return Redirect::route('lessons', array('school_id' => $school_id))->with('failure', 'Error! No se pudo actualizar datos de la clase');
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
                    return Redirect::route('userpanel')->with('failure', 'Aviso! Se actualizaron los datos de la clase con errores');
                }
                ++$i;
            }
        }

        return Redirect::route('lessons',array('school_id' => $school_id))->with('success', 'Datos de la clase actualizados con éxito');

    }

    public function deleteLesson()
    {
        $lesson_id = Input::get('lesson_id');
        $school_id = Input::get('school_id');
        $lesson = SchoolLesson::findOrFail($lesson_id);
        $lesson->delete();

        if($lesson->exists)
            return Redirect::route('lessons',array('school_id' => $school_id))->with('failure', 'Error! La clase no pudo ser eliminada');
        else
            return Redirect::route('lessons',array('school_id' => $school_id))->with('success', 'Clase eliminada con éxito');
    }

    public function deleteReview($type,$id)
    {
        if($type=='Profesor') {
            $rating = Rating::findOrFail($id);
        } else {
            $rating = SchoolLessonRating::findOrFail($id);
        }
        $rating->delete();
        if($rating->exists)
            return Redirect::to('admin/reviews')->with('failure', 'Error! La valoración no pudo ser eliminada');
        else
            return Redirect::to('admin/reviews')->with('success', 'Valoración eliminada con éxito');
    }

}