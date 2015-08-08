<?php

class ReviewsController extends BaseController
{
    /**
     * Returns message that if user has sent off the assessment about lesson personal, otherwise returns error message.
     * @return \Illuminate\Http\JsonResponse
     */
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
            return Response::json(['success'=>'error','msg'=>trans('hardcoded.reviewsController.handleLessonReview.Emsg')],200);

        $user = Confide::user();
        $student = $user->student()->first();
        $lesson_id = $input['lessonId'];
        $existingRating = TeacherLessonRating::where('student_id','=',''.$student->id)->where('teacher_lesson_id','=',''.$lesson_id)->get();
        if ($existingRating->count() != 0)
            return Response::json(['success'=>'warning','msg'=>trans('hardcoded.reviewsController.handleLessonReview.Wmsg')],200);

        $rating = new Rating();
        $rating->student_id = $student->id;
        $rating->teacher_lesson_id = $lesson_id;
        $rating->value = $input['score'];
        $rating->comment = $input['comment'];
        if($rating->save())
            return Response::json(['success'=>'success','msg'=>trans('hardcoded.reviewsController.handleLessonReview.Smsg')],200);
        return Response::json(['success'=>'error','msg'=>trans('hardcoded.reviewsController.handleLessonReview.Emsg2')],200);

    }

    /**
     * Returns whether if the the review has been saved or not, otherwise returns error message.
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleNewReview()
    {
        if(Auth::check()) {
            $lesson_id = (int) Input::get('review_lesson_id');
            $user = Confide::user();
            $student = $user->student()->first();
            $lesson_rating = TeacherLessonRating::where('student_id','=',''.$student->id)->where('teacher_lesson_id','=',''.$lesson_id)->get();

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

                return Response::json(['success'=>'success','msg'=>trans('hardcoded.reviewsController.handleNewReview.Smsg')],200);
            } else {
                return Response::json(["success"=>"warning","msg"=>trans('hardcoded.reviewsController.handleNewReview.Wmsg')],200);
            }
        } else {
            return Response::json(['success'=>'error','msg'=>trans('hardcoded.reviewsController.handleNewReview.Emsg')],200);
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

                return trans('hardcoded.reviewsController.handleSchoolLessonReview.Smsg');
            } else {
                return trans('hardcoded.reviewsController.handleSchoolLessonReview.Wmsg');
            }
        }
        else
        {
            return trans('hardcoded.reviewsController.handleSchoolLessonReview.Emsg');
        }
    }

    /**
     * Returns message that if user has sent off the assessment about school lesson, otherwise returns error message.
     * @return \Illuminate\Http\JsonResponse
     */
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
            return Response::json(['success'=>'error','msg'=>trans('hardcoded.reviewsController.handleSchoolLessonNewReview.Emsg')],200);

        $user = Confide::user();
        $student = $user->student()->first();
        $lesson_id = $input['lessonId'];
        $existingRating = SchoolLessonRating::where('student_id','=',''.$student->id)->where('school_lesson_id','=',''.$lesson_id)->get();
        if ($existingRating->count() != 0)
            return Response::json(['success'=>'warning','msg'=>trans('hardcoded.reviewsController.handleSchoolLessonNewReview.Wmsg')],200);

        $rating = new SchoolLessonRating();
        $rating->student_id = $student->id;
        $rating->school_lesson_id = $lesson_id;
        $rating->value = $input['score'];
        $rating->comment = $input['comment'];
        if($rating->save())
            return Response::json(['success'=>'success','msg'=>trans('hardcoded.reviewsController.handleSchoolLessonNewReview.Smsg')],200);
        return Response::json(['success'=>'error','msg'=>trans('hardcoded.reviewsController.handleSchoolLessonNewReview.Emsg2')],200);

    }


    /**
     * Given a variable 'review_id' and return object JsonResponse that means if the user has given the opinion,
     * otherwise returns a warning or error message.
     * @param $review_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function wasHelpful($review_id)
    {
        if(!Auth::check())
            return Response::json(['error'=>'Reviewer is not authenticated.'],200);
        if (!Session::has('r_helpful_'.$review_id)) {
            Session::put('r_helpful_'.$review_id, true);
            Session::save();
            $review = TeacherLessonRating::findOrFail($review_id);
            $review->yes_helpful = $review->yes_helpful + 1;
            $review->total_helpful = $review->total_helpful + 1;
            if($review->save())
                return Response::json(['success'=>'success','msg'=>trans('hardcoded.reviewsController.wasHelpful.Smsg')],200);
        } else {
            return Response::json(['success'=>'warning','msg'=>trans('hardcoded.reviewsController.wasHelpful.Wmsg')],200);
        }
        return Response::json(['success'=>'error','msg'=>trans('hardcoded.reviewsController.wasHelpful.Emsg')],200);
    }

    /**
     * Given a variable 'review_id' and return object JsonResponse that means if the user has given the opinion,
     * otherwise returns a warning or error message.
     * @param $review_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function wasNotHelpful($review_id)
    {
        if(!Auth::check())
            return Response::json(['error'=>'Reviewer is not authenticated.'],200);
        if (!Session::has('r_helpful_'.$review_id)) {
            Session::put('r_helpful_'.$review_id, true);
            Session::save();
            $review = TeacherLessonRating::findOrFail($review_id);
            $review->total_helpful = $review->total_helpful + 1;
            if($review->save())
                return Response::json(['success'=>'success','msg'=>trans('hardcoded.reviewsController.wasNotHelpful.Smsg')],200);
        } else {
            return Response::json(['success'=>'warning','msg'=>trans('hardcoded.reviewsController.wasNotHelpful.Wmsg')],200);
        }
        return Response::json(['success'=>'error','msg'=>trans('hardcoded.reviewsController.wasNotHelpful.Emsg')],200);
    }

    /**
     * Given the variable $review_id, returns message that means if the user has given the opinion about school,
     * otherwise returns a warning or error message.
     * @param $review_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function wasHelpfulSchool($review_id)
    {
        if(!Auth::check())
            return Response::json(['error'=>'Reviewer is not authenticated.'],200);
        if (!Session::has('s_helpful_'.$review_id)) {
            Session::put('s_helpful_'.$review_id, true);
            Session::save();
            $review = SchoolLessonRating::findOrFail($review_id);
            $review->yes_helpful = $review->yes_helpful + 1;
            $review->total_helpful = $review->total_helpful + 1;
            if($review->save())
                return Response::json(['success'=>'success','msg'=>trans('hardcoded.reviewsController.wasHelpful.Smsg')],200);
        } else {
            return Response::json(['success'=>'warning','msg'=>trans('hardcoded.reviewsController.wasHelpful.Wmsg')],200);
        }
        return Response::json(['success'=>'error','msg'=>trans('hardcoded.reviewsController.wasHelpful.Emsg')],200);
    }

    /**
     * Given the variable $review_id, returns message that means if the user has given the opinion about school,
     * otherwise returns a warning or error message.
     * @param $review_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function wasNotHelpfulSchool($review_id)
    {

        if(!Auth::check())
            return Response::json(['error'=>'Reviewer is not authenticated.'],200);
        if (!Session::has('s_helpful_'.$review_id)) {
            Session::put('s_helpful_'.$review_id, true);
            Session::save();
            $review = SchoolLessonRating::findOrFail($review_id);
            $review->total_helpful = $review->total_helpful + 1;
            if($review->save())
                return Response::json(['success'=>'success','msg'=>trans('hardcoded.reviewsController.wasNotHelpful.Smsg')],200);
        } else {
            return Response::json(['success'=>'warning','msg'=>trans('hardcoded.reviewsController.wasNotHelpful.Wmsg')],200);
        }
        return Response::json(['success'=>'error','msg'=>trans('hardcoded.reviewsController.wasNotHelpful.Emsg')],200);
    }
}