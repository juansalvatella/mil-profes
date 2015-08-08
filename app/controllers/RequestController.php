<?php

/**
 * Class RequestController
 */
class RequestController extends BaseController
{
    /**
     * Requests teacher
     * @return \Illuminate\Http\JsonResponse
     */
    public function requestTeacher()
    {
        $input = Input::all();
        if(Input::has('lessonId')) {
            if (!Session::has('t_'.$input['teacherId'].'_visualized_'.$input['lessonId'])) //if this Tlf visualization hasn't been recorded before (during the session)
            {
                Session::put('t_'.$input['teacherId'].'_visualized_'.$input['lessonId'], true); //record the visualization in the session array
                Session::save();

                $visualization = new TeacherPhoneVisualization(); //register the visualization in database
                if (Auth::check()) { //if user is authenticated relate the user id with the visualization
                    $observer = Confide::user();
                    $visualization->user_id = $observer->id;
                }
                $visualization->teacher_lesson_id = $input['lessonId'];
                $visualization->teacher_id = $input['teacherId'];
                $save = $visualization->save();

                return Response::json(['saved' => ''.$save], '200');
            }
        } else {
            if (!Session::has('t_'.$input['teacherId'].'_visualized_null')) //if this Tlf visualization hasn't been recorded before (during the session)
            {
                Session::put('t_'.$input['teacherId'].'_visualized_null', true); //record the visualization in the session array
                Session::save();

                $visualization = new TeacherPhoneVisualization(); //register the visualization in database
                if (Auth::check()) { //if user is authenticated relate the user id with the visualization
                    $observer = Confide::user();
                    $visualization->user_id = $observer->id;
                }
                $visualization->teacher_id = $input['teacherId'];
                $save = $visualization->save();

                return Response::json(['saved' => ''.$save], '200');
            }
        }

        return Response::json(['warning' => trans('hardcoded.requestController.Wmsg')], '200');
    }

    /**
     * Given the variable $lesson_id, and saves the lesson visualization of user.
     * @param $lesson_id
     * @return string
     */
    public function teacherLessonVisualization($lesson_id)
    {
        if (!Session::has('t_visualized_'.$lesson_id)) //if this Tlf visualization hasn't been recorded before (during the session)
        {
            Session::put('t_visualized_'.$lesson_id, true); //record the visualization in the session array
            Session::save();
            $visualization = new TeacherPhoneVisualization(); //register the visualization in database
            if (Auth::check()) { //if user is authenticated relate the user id with the visualization
                $observer = Confide::user();
                $visualization->user_id = $observer->id;
            }
            $visualization->teacher_lesson_id = $lesson_id;

            return (string) $visualization->save();
        }
        return trans('hardcoded.requestController.Wmsg');
    }

    /**
     * Given the variable $teacher_id, and saves the visualization of user to the teacher with this id.
     * @param $teacher_id
     * @return string
     */
    public function teacherVisualization($teacher_id)
    {
        if (!Session::has('t_visualized_all_'.$teacher_id)) //if this Tlf visualization hasn't been recorded before (during the session)
        {
            Session::put('t_visualized_all_'.$teacher_id, true); //record the visualization in the session array
            Session::save();
            $visualization = new TeacherPhoneVisualization(); //register the visualization in database
            if (Auth::check()) { //if user is authenticated relate the user id with the visualization
                $observer = Confide::user();
                $visualization->user_id = $observer->id;
            }
            //we choose the first lesson of this teacher as the receipt of the visualization (temporary fix)
            $teacher = Teacher::where('id',$teacher_id)->first();
            $first_lesson = $teacher->lessons()->first();
            if(!$first_lesson)
                return  'No lessons found';
            $lesson_id = $first_lesson->id;
            $visualization->teacher_lesson_id = $lesson_id;

            return (string) $visualization->save();
        }
        return trans('hardcoded.requestController.Wmsg');
    }

    /**
     * Given the variable $lesson_id, and saves the visualization of user to the school.
     * @return \Illuminate\Http\JsonResponse
     */
    public function requestSchool()
    {
        $input = Input::all();
        if(Input::has('courseId')) {
            if (!Session::has('s_'.$input['schoolId'].'_visualized_'.$input['courseId'])) //if this Tlf visualization hasn't been recorded before (during the session)
            {
                Session::put('s_'.$input['schoolId'].'_visualized_'.$input['courseId'], true); //record the visualization in the session array
                Session::save();

                $visualization = new SchoolPhoneVisualization(); //register the visualization in database
                if (Auth::check()) { //if user is authenticated relate the user id with the visualization
                    $observer = Confide::user();
                    $visualization->user_id = $observer->id;
                }
                $visualization->school_lesson_id = $input['courseId'];
                $visualization->school_id = $input['schoolId'];
                $save = $visualization->save();

                return Response::json(['saved' => ''.$save], '200');
            }
        } else {
            if (!Session::has('s_'.$input['schoolId'].'_visualized_null')) //if this Tlf visualization hasn't been recorded before (during the session)
            {
                Session::put('s_'.$input['schoolId'].'_visualized_null', true); //record the visualization in the session array
                Session::save();

                $visualization = new SchoolPhoneVisualization(); //register the visualization in database
                if (Auth::check()) { //if user is authenticated relate the user id with the visualization
                    $observer = Confide::user();
                    $visualization->user_id = $observer->id;
                }
                $visualization->school_id = $input['schoolId'];
                $save = $visualization->save();

                return Response::json(['saved' => ''.$save], '200');
            }
        }

        return Response::json(['warning' => trans('hardcoded.requestController.Wmsg')], '200');
    }

    /**
     * Given the variable $lesson_id, and saves the visualization of user to the lesson.
     * @param $lesson_id
     * @return string
     */
    public function schoolLessonVisualization($lesson_id)
    {
        if (!Session::has('s_visualized_'.$lesson_id)) //if this Tlf visualization hasn't been recorded before (during the session)
        {
            Session::put('s_visualized_'.$lesson_id, true); //record the visualization in the session array
            Session::save();
            $visualization = new SchoolPhoneVisualization(); //register the visualization in database
            if (Auth::check()) { //if user is authenticated relate the user id with the visualization
                $observer = Confide::user();
                $visualization->user_id = $observer->id;
            }
            $visualization->school_lesson_id = $lesson_id;

            return (string) $visualization->save();
        }
        return trans('hardcoded.requestController.Wmsg');
    }

    /**
     * Given the variable $school_id, and saves the visualization of user to the school with this id.
     * @param $school_id
     * @return string
     */
    public function schoolVisualization($school_id)
    {
        if (!Session::has('s_visualized_all_'.$school_id)) //if this Tlf visualization hasn't been recorded before (during the session)
        {
            Session::put('s_visualized_all_'.$school_id, true); //record the visualization in the session array
            Session::save();
            $visualization = new SchoolPhoneVisualization(); //register the visualization in database
            if (Auth::check()) { //if user is authenticated relate the user id with the visualization
                $observer = Confide::user();
                $visualization->user_id = $observer->id;
            }
            //we choose the first lesson of this school as the receipt of the visualization (temporary fix)
            $school = School::where('id',$school_id)->first();
            $first_lesson = $school->lessons()->first();
            if(!$first_lesson)
                return  'No lessons found';
            $lesson_id = $first_lesson->id;
            $visualization->school_lesson_id = $lesson_id;

            return (string) $visualization->save();
        }
        return trans('hardcoded.requestController.Wmsg');
    }

    /**
     * Returns the contact info of a teacher
     * @return \Illuminate\Http\JsonResponse
     */
    public function teacherData()
    {
        $input = Input::all();
        $user = Teacher::findOrFail($input['teacherId'])->user;
        $response = [];
        if($user->phone)
            $response['telephone'] = substr($user->phone,0,3).' '.substr($user->phone,3,2).' '.substr($user->phone,5,2).' '.substr($user->phone,7,strlen($user->phone)-7);
        $response['email'] = $user->email;
        $response['mailto'] = 'mailto:'.$user->email;

        return Response::json($response,200);
    }
}