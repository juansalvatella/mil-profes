<?php

class TeachersController extends BaseController
{
    public function createLesson()
    {
        $lesson = new TeacherLesson();
        $lesson->price = Input::get('price');
        $lesson->description = Input::get('description');

        $user = Auth::user();
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
}