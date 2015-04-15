<?php

class ReviewsController extends BaseController
{
    public function handleNewReview()
    {
        if(Auth::check())
        {
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
}