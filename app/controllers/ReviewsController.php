<?php

class ReviewsController extends BaseController
{
    public function handleLessonReview()
    {
        if(!Auth::check())
            return Response::json(['error'=>'Reviewer not authenticated'],200);
        $input = Input::all();
        $rules = array(
            'score'         => 'required|numeric',
            'comment'       => 'required|string|max:255',
            'lessonId'      => 'required|integer',
        );
        $validator = Validator::make($input, $rules);
        if($validator->fails())
            return Response::json(['success'=>'error','msg'=>'No se pudo enviar valoración. Asegúrate de rellenar los campos correctamente.'],200);

        $user = Confide::user();
        $student = $user->student()->first();
        $lesson_id = $input['lessonId'];
        $existingRating = Rating::where('student_id','=',''.$student->id)->where('teacher_lesson_id','=',''.$lesson_id)->get();
        if ($existingRating->count() != 0)
            return Response::json(['success'=>'warning','msg'=>'No es posible valorar la misma clase dos veces.'],200);

        $rating = new Rating();
        $rating->student_id = $student->id;
        $rating->teacher_lesson_id = $lesson_id;
        $rating->value = $input['score'];
        $rating->comment = $input['comment'];
        if($rating->save())
            return Response::json(['success'=>'success','msg'=>'Muchas gracias. Tu valoración ha sido correctamente enviada.'],200);
        return Response::json(['success'=>'error','msg'=>'No se pudo enviar tu valoración. Prueba de nuevo en unos minutos.'],200);

    }

    public function handleNewReview()
    {
        if(Auth::check()) {
            $lesson_id = (int) Input::get('review_lesson_id');
            $user = Confide::user();
            $student = $user->student()->first();
            $lesson_rating = Rating::where('student_id','=',''.$student->id)->where('teacher_lesson_id','=',''.$lesson_id)->get();

            if ($lesson_rating->count() == 0) {
                if(Input::has('review_comment'))
                    $comment = (string) Input::get('review_comment');
                else
                    $comment = '';
                if(Input::get('review_rating')!='undefined')
                    $score = (float) Input::get('review_rating');
                else
                    $score = (float) 3.0;
                $rating = new Rating();
                $rating->value = $score;
                $rating->student_id = $student->id;
                $rating->comment = $comment;
                $rating->teacher_lesson_id = $lesson_id;
                $rating->save();

                return Response::json(['success'=>'success','msg'=>'Your review has been saved. Thank you'],200);
            } else {
                return Response::json(["success"=>"warning","msg"=>"You can not review a lesson more than once!"],200);
            }
        } else {
            return Response::json(['success'=>'error','msg'=>'Reviewer is not an user.'],200);
        }
    }

    public function handleSchoolLessonNewReview()
    {
        if(Auth::check())
        {
            $lesson_id = (int) Input::get('review_lesson_id');
            $user = Confide::user();
            $student = $user->student()->first();
            $lesson_rating = SchoolLessonRating::where('student_id','=',''.$student->id)->where('school_lesson_id','=',''.$lesson_id)->get();

            if ($lesson_rating->count() == 0) {
                if(Input::has('review_comment'))
                    $comment = (string) Input::get('review_comment');
                else
                    $comment = '';
                if(Input::get('review_rating')!='undefined')
                    $score = (float) Input::get('review_rating');
                else
                    $score = (float) 3.0;
                $rating = new SchoolLessonRating();
                $rating->value = $score;
                $rating->student_id = $student->id;
                $rating->comment = $comment;
                $rating->school_lesson_id = $lesson_id;
                $rating->save();

                return 'Review saved';
            } else {
                return 'Reviewer already reviewed this lesson';
            }
        }
        else
        {
            return 'Reviewer is not an user';
        }
    }

    public function handleSchoolLessonReview()
    {
        if(!Auth::check())
            return Response::json(['error'=>'Reviewer not authenticated'],200);
        $input = Input::all();
        $rules = array(
            'score'         => 'required|numeric',
            'comment'       => 'required|string|max:255',
            'lessonId'      => 'required|integer',
        );
        $validator = Validator::make($input, $rules);
        if($validator->fails())
            return Response::json(['success'=>'error','msg'=>'No se pudo enviar valoración. Asegúrate de rellenar los campos correctamente.'],200);

        $user = Confide::user();
        $student = $user->student()->first();
        $lesson_id = $input['lessonId'];
        $existingRating = SchoolLessonRating::where('student_id','=',''.$student->id)->where('school_lesson_id','=',''.$lesson_id)->get();
        if ($existingRating->count() != 0)
            return Response::json(['success'=>'warning','msg'=>'No es posible valorar la misma clase dos veces.'],200);

        $rating = new SchoolLessonRating();
        $rating->student_id = $student->id;
        $rating->school_lesson_id = $lesson_id;
        $rating->value = $input['score'];
        $rating->comment = $input['comment'];
        if($rating->save())
            return Response::json(['success'=>'success','msg'=>'Muchas gracias. Tu valoración ha sido correctamente enviada.'],200);
        return Response::json(['success'=>'error','msg'=>'No se pudo enviar tu valoración. Prueba de nuevo en unos minutos.'],200);

    }
}