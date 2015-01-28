<?php

class ReviewsController extends BaseController
{
    public function handleNewReview()
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $student = $user->student()->first();
            $student_id = $student->id;
        }
        else
        {
            $student_id = null;
        }

        $lesson_id = (int) Input::get('review_lesson_id');

        if(Input::get('review_comment'))
            $comment = (string) Input::get('review_comment');
        else
            $comment = '';

        if(Input::get('review_rating')!='undefined')
            $score = (float) Input::get('review_rating');
        else
            $score = (float) 0.0;

        $rating = new Rating();
        $rating->value = $score;
        $rating->student_id = $student_id;
        $rating->comment = $comment;
        $rating->teacher_lesson_id = $lesson_id;

        return (string) $rating->save();
    }
}