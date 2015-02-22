<?php

use Illuminate\Support\Collection;

class SearchController extends BaseController
{

    public function search()
    {
        //to config file
        $results_per_slice = 6;

        $input = Input::all();
        $address = Input::has('user_address') ? $input['user_address'] : '';
        $check_address = ($address=='') ? false : true;
        $prof_o_acad = Input::has('prof_o_acad') ? $input['prof_o_acad'] : 'academia';
        $subject = Input::has('subject') ? $input['subject'] : 'all';
        if($subject=='all') {
            $check_subject = false;
            $subj_id = null;
        } else {
            $check_subject = true;
        }
        $keywords = Input::has('keywords') ? $input['keywords'] : '';
        $check_keywords = ($keywords=='') ? false : true;
        $search_distance = Input::has('search_distance') ? $input['search_distance'] : 'rang0';
        $price = Input::has('price') ? $input['price'] : 'all';

        //OBTAIN USER ADDRESS, LATITUDE and LONGITUDE
        if($check_address) { //if address provided, geocode address
            $geodata = Geocoding::geocode($address);
            if($geodata) {
                $user_address = $geodata[2];
                $user_lat = $geodata[0];
                $user_lon = $geodata[1];
            } else { //if geocoding fails
                $check_address = false;
            }
        }
        if(!$check_address) { //if address not provided or geocoding fails default to Barcelona
            $user_address = 'Barcelona';
            $user_lat = 41.3850639;
            $user_lon = 2.1734035;
        }

        //new db search
        if($prof_o_acad=='profesor') {
            if ($check_subject) { //filter by subject
                $subj_id = Subject::where('name', $subject)->pluck('id');
                if($check_keywords) {
                    $results = DB::table('teacher_lessons')
                        ->leftJoin('teachers', 'teachers.id', '=', 'teacher_lessons.teacher_id')
                        ->leftJoin('users', 'users.id', '=', 'teachers.user_id')
                        ->leftJoin('teachers_average_ratings','teachers_average_ratings.teacher_id','=','teachers.id')
                        ->leftJoin('ratings','ratings.teacher_lesson_id','=','teacher_lessons.id')
                        ->groupBy('teacher_lessons.id')
                        ->where('subject_id', $subj_id)
                        ->whereRaw("MATCH(teacher_lessons.description) AGAINST(? IN BOOLEAN MODE)", array($keywords))
                        ->orderBy('lesson_avg_rating', 'DESC')
                        ->orderBy('teacher_avg_rating', 'DESC')
                        ->get(array('teacher_lessons.*', 'users.email', 'users.phone', 'users.avatar', 'users.username', DB::raw('AVG(ratings.value) as lesson_avg_rating'), 'teachers_average_ratings.teacher_avg_rating'));
                } else {
                    $results = DB::table('teacher_lessons')
                        ->leftJoin('teachers', 'teachers.id', '=', 'teacher_lessons.teacher_id')
                        ->leftJoin('users', 'users.id', '=', 'teachers.user_id')
                        ->leftJoin('teachers_average_ratings','teachers_average_ratings.teacher_id','=','teachers.id')
                        ->leftJoin('ratings','ratings.teacher_lesson_id','=','teacher_lessons.id')
                        ->groupBy('teacher_lessons.id')
                        ->where('subject_id', $subj_id)
                        ->orderBy('lesson_avg_rating', 'DESC')
                        ->orderBy('teacher_avg_rating', 'DESC')
                        ->get(array('teacher_lessons.*', 'users.email', 'users.phone', 'users.avatar', 'users.username',DB::raw('AVG(ratings.value) as lesson_avg_rating'),'teachers_average_ratings.teacher_avg_rating'));
                }
            } else { //search all subjects
                if($check_keywords) {
                    $results = DB::table('teacher_lessons')
                        ->leftJoin('teachers', 'teachers.id', '=', 'teacher_lessons.teacher_id')
                        ->leftJoin('users', 'users.id', '=', 'teachers.user_id')
                        ->leftJoin('teachers_average_ratings','teachers_average_ratings.teacher_id','=','teachers.id')
                        ->leftJoin('ratings','ratings.teacher_lesson_id','=','teacher_lessons.id')
                        ->groupBy('teacher_lessons.id')
                        ->whereRaw("MATCH(teacher_lessons.description) AGAINST(? IN BOOLEAN MODE)", array($keywords))
                        ->orderBy('lesson_avg_rating', 'DESC')
                        ->orderBy('teacher_avg_rating', 'DESC')
                        ->get(array('teacher_lessons.*', 'users.email', 'users.phone', 'users.avatar', 'users.username',DB::raw('AVG(ratings.value) as lesson_avg_rating'),'teachers_average_ratings.teacher_avg_rating'));
                } else {
                    $results = DB::table('teacher_lessons')
                        ->leftJoin('teachers', 'teachers.id', '=', 'teacher_lessons.teacher_id')
                        ->leftJoin('users', 'users.id', '=', 'teachers.user_id')
                        ->leftJoin('teachers_average_ratings','teachers_average_ratings.teacher_id','=','teachers.id')
                        ->leftJoin('ratings','ratings.teacher_lesson_id','=','teacher_lessons.id')
                        ->groupBy('teacher_lessons.id')
                        ->orderBy('lesson_avg_rating', 'DESC')
                        ->orderBy('teacher_avg_rating', 'DESC')
                        ->get(array('teacher_lessons.*', 'users.email', 'users.phone', 'users.avatar', 'users.username', DB::raw('AVG(ratings.value) as lesson_avg_rating'), 'teachers_average_ratings.teacher_avg_rating'));
                }
            }
        } else {
            if ($check_subject) { //filter by subject
                $subj_id = Subject::where('name', $subject)->pluck('id');
                if($check_keywords) {
                    $results = DB::table('school_lessons')
                        ->leftJoin('schools', 'schools.id', '=', 'school_lessons.school_id')
                        ->leftJoin('schools_average_ratings','schools_average_ratings.school_id','=','schools.id')
                        ->leftJoin('school_lesson_ratings','school_lesson_ratings.school_lesson_id','=','school_lessons.id')
                        ->groupBy('school_lessons.id')
                        ->where('subject_id', $subj_id)
                        ->whereRaw("MATCH(school_lessons.description) AGAINST(? IN BOOLEAN MODE)", array($keywords))
                        ->orderBy('lesson_avg_rating', 'DESC')
                        ->orderBy('school_avg_rating', 'DESC')
                        ->get(array('school_lessons.*', 'schools.name', 'schools.email', 'schools.phone', 'schools.logo',DB::raw('AVG(school_lesson_ratings.value) as lesson_avg_rating'),'schools_average_ratings.school_avg_rating'));
                } else {
                    $results = DB::table('school_lessons')
                        ->leftJoin('schools', 'schools.id', '=', 'school_lessons.school_id')
                        ->leftJoin('schools_average_ratings','schools_average_ratings.school_id','=','schools.id')
                        ->leftJoin('school_lesson_ratings','school_lesson_ratings.school_lesson_id','=','school_lessons.id')
                        ->groupBy('school_lessons.id')
                        ->where('subject_id', $subj_id)
                        ->orderBy('lesson_avg_rating', 'DESC')
                        ->orderBy('school_avg_rating', 'DESC')
                        ->get(array('school_lessons.*', 'schools.name', 'schools.email', 'schools.phone', 'schools.logo',DB::raw('AVG(school_lesson_ratings.value) as lesson_avg_rating'),'schools_average_ratings.school_avg_rating'));
                }
            } else { //search all subjects
                if($check_keywords) {
                    $results = DB::table('school_lessons')
                        ->leftJoin('schools', 'schools.id', '=', 'school_lessons.school_id')
                        ->leftJoin('schools_average_ratings','schools_average_ratings.school_id','=','schools.id')
                        ->leftJoin('school_lesson_ratings','school_lesson_ratings.school_lesson_id','=','school_lessons.id')
                        ->groupBy('school_lessons.id')
                        ->whereRaw("MATCH(school_lessons.description) AGAINST(? IN BOOLEAN MODE)", array($keywords))
                        ->orderBy('lesson_avg_rating', 'DESC')
                        ->orderBy('school_avg_rating', 'DESC')
                        ->get(array('school_lessons.*', 'schools.name', 'schools.email', 'schools.phone', 'schools.logo',DB::raw('AVG(school_lesson_ratings.value) as lesson_avg_rating'),'schools_average_ratings.school_avg_rating'));
                } else {
                    $results = DB::table('school_lessons')
                        ->leftJoin('schools', 'schools.id', '=', 'school_lessons.school_id')
                        ->leftJoin('schools_average_ratings','schools_average_ratings.school_id','=','schools.id')
                        ->leftJoin('school_lesson_ratings','school_lesson_ratings.school_lesson_id','=','school_lessons.id')
                        ->groupBy('school_lessons.id')
                        ->orderBy('lesson_avg_rating', 'DESC')
                        ->orderBy('school_avg_rating', 'DESC')
                        ->get(array('school_lessons.*', 'schools.name', 'schools.email', 'schools.phone', 'schools.logo',DB::raw('AVG(school_lesson_ratings.value) as lesson_avg_rating'),'schools_average_ratings.school_avg_rating'));
                }
            }
        }
        $results = new Collection($results); //array to collection

        //===============================================================================
        //  Filter results that belong to teachers whose payments are not up to date
        //  TO BE IMPLEMENTED LATER
        //===============================================================================
        //        if ($prof_o_acad == 'profesor') {
        //            $results_by_subject = $results_by_subject->filter(function ($result) {
        //                $lesson = TeacherLesson::findOrFail($result->id);
        //                $teacher = $lesson->teacher()->first();
        //                $user = $teacher->user()->first();
        //
        //                return $user->thisUserPaymentIsCurrent();
        //            });
        //        }

        // Filter by distance and price
        $results = Geocoding::findWithinDistance($user_lat,$user_lon,$search_distance,$results); //filter results within distance boundaries
        $results = Milprofes::findWithinPrice($price,$prof_o_acad,$results);

        if($prof_o_acad=='profesor'){
            foreach($results as $result)
            {
                //round teacher avg rating
                if($result->teacher_avg_rating)
                    $result->teacher_avg_rating = round((float) $result->teacher_avg_rating,1);
                else
                    $result->teacher_avg_rating = (float) 3.0;
                //get availabilities
                $teacher = TeacherLesson::findOrFail($result->id)->teacher()->first();
                $result->availability = $teacher->availabilities()->get();
                //get number of reviews and lesson avg rating
                $result->number_of_reviews = TeacherLesson::findOrFail($result->id)->getNumberOfReviews();
                if(!$result->number_of_reviews)
                    $result->lesson_avg_rating = (float) 3.0;
                else
                    $result->lesson_avg_rating = round((float) $result->lesson_avg_rating,1);
            }
        } else {
            foreach($results as $result)
            {
                //get school avg rating
                if($result->school_avg_rating)
                    $result->school_avg_rating = round((float) $result->school_avg_rating,1);
                else
                    $result->school_avg_rating = (float) 3.0;
                //get availabilities
                $result->availability = SchoolLesson::findOrFail($result->id)->availabilities()->get();
                //get number of reviews and lesson avg rating
                $result->number_of_reviews = SchoolLesson::findOrFail($result->id)->getNumberOfReviews();
                if(!$result->number_of_reviews)
                    $result->lesson_avg_rating = (float) 3.0;
                else
                    $result->lesson_avg_rating = round((float) $result->lesson_avg_rating,1);
            }
        }

        //no more filters, results sorted >>>> pagination of results
        $total_results = $results->count();
        $max_slices = ceil($total_results/$results_per_slice);
        $slices_showing = Input::has('slices_showing') ? $input['slices_showing'] : 0;
        $sl_offset = $slices_showing*6;
        $sl_length = $results_per_slice;
        $results = $results->slice($sl_offset,$sl_length);
        ++$slices_showing;
        $display_show_more = ($total_results==0 || $slices_showing == $max_slices) ? false : true;

        //set GoogleMap
        if ($search_distance=='rang2') {
//            $min_radius = (string) 5*1000;
            $max_radius = (string) 20*1000;
        } else if ($search_distance=='rang1') {
//            $min_radius = (string) 2*1000;
            $max_radius = (string) 5*1000;
        } else { //if rang0, any other case also defaults to rang0
//            $min_radius = (string) 0;
            $max_radius = (string) 2*1000;
        }
        $config = array();
        $config['center'] = $user_lat.','.$user_lon;
        if($search_distance=='rang2')
            $config['zoom'] = '9';
        else if($search_distance=='rang1')
            $config['zoom'] = '11';
        else //rang0
            $config['zoom'] = '12';
        $config['disableMapTypeControl'] = true;
        $config['disableStreetViewControl'] = true;
        $config['disableDoubleClickZoom'] = true;
        $config['disableNavigationControl'] = true;
        $config['disableScaleControl'] = true;
        $config['map_height'] = '175px';
        $config['scrollwheel'] = false;
        $config['zoomControlStyle'] = 'SMALL';
        $config['zoomControlPosition'] = 'TOP_RIGHT';
        Gmaps::initialize($config);
        $marker = array();
        $marker['position'] = $user_lat.','.$user_lon;
        $marker['icon'] = 'http://www.google.com/mapfiles/marker.png';
        Gmaps::add_marker($marker); //add student marker (center)
        $circle = array();
        $circle['center'] = $user_lat.','.$user_lon;
        $circle['radius'] = $max_radius;
        $circle['strokeColor'] = '#d20500';
        $circle['strokeOpacity'] = '0.7';
        $circle['strokeWeight'] = '1';
        $circle['fillColor'] = '#d20500';
        $circle['fillOpacity'] = '0.3';
        $circle['clickable'] = false;
        Gmaps::add_circle($circle);

        $gmap =  Gmaps::create_map(); //generate map view code with given options

        //Registrar búsqueda en base de datos
        $search = new Search();
        $search->address = $user_address;
        $search->subject_id = $subj_id;
        $search->subject = $subject;
        $search->keywords = $keywords;
        $search->type = $prof_o_acad;
        $search->results = $total_results;
        $search->save();

        return View::make('searchresults', compact(
            'gmap',
            'total_results',
            'slices_showing',
            'display_show_more',
            'results',
            'prof_o_acad',
            'subject',
            'user_lat',
            'user_lon',
            'user_address',
            'subj_id',
            'search_distance',
            'keywords',
            'price'
        ));

    }

}