<?php

class ProfilesController extends BaseController
{
    /**
     * Given the variable 'user_slug', and returns the View of the teacher profile that contains:
     * - antique of the profile
     * - age
     * - last update of lessons and profile
     * - personal data etc..
     * @param $user_slug
     * @return \Illuminate\View\View
     */
    public function profilesTeacher($user_slug)
    {
        $user = User::findBySlug($user_slug);
        $teacher = $user->teacher()->first();

        //Incrementar número de visitas en uno (por visitante y sesión)
        if (!Session::has('profile_visited_' . $user_slug)) {
            $teacher->profile_visits = $teacher->profile_visits + 1;
            $teacher->save(); //increments profile visits counter, notice that this changes the updated_at column in teachers table
            Session::put('profile_visited_' . $user_slug, true);
            Session::save();
        }

        //Check if the visitor is the teacher himself
        if (Auth::check()) {
            $current_user = Confide::user();
            if ($user->id == $current_user->id)
                $teacher->itsme = true;
        }

        //Calcular antiguedad en milprofes (en array con keys years, months, etc.)
        $datetime1 = new DateTime();
        $datetime2 = new DateTime($teacher->created_at);
        $interval = $datetime1->diff($datetime2);
        $elapsed = $interval->format('%y-%m-%d-%h-%i-%S');
        $elapsedKeys = ['years', 'months', 'days', 'hours', 'minutes', 'seconds'];
        $teacher->antiguedad = array_combine($elapsedKeys, explode("-", $elapsed));

        //Calcular popularidad
        $qArray = DB::select(DB::raw("
            SELECT tranking.rank FROM (
              SELECT t5.teacher_id, t5.user_id, t5.total, @curRank := @curRank + 1 AS 'rank'
                FROM (SELECT
                        t4.teacher_id            AS 'teacher_id',
                        t4.user_id               AS 'user_id',
                        SUM(t4.count)            AS 'total'
                      FROM (SELECT
                               t1.teacher_lesson_id,
                               t2.teacher_id,
                               t3.user_id,
                               count(*) AS 'count'
                             FROM t_phone_visualizations AS t1
                               LEFT JOIN teacher_lessons AS t2
                                 ON t2.id = t1.teacher_lesson_id
                               LEFT JOIN teachers AS t3
                                 ON t3.id = t2.teacher_id
                             GROUP BY t1.teacher_lesson_id
                       ) AS t4
                      GROUP BY t4.teacher_id
                      ORDER BY total DESC
                ) AS t5, (SELECT @curRank := 0) r
                ORDER BY rank
            ) AS tranking
            WHERE tranking.user_id = ?;
        "), array($user->id));
        if (!empty($qArray))
            $teacher->rank = (int)$qArray[0]->rank;

//        Log::info('Rank query output', $qArray);

        //Fecha de última actualización es el mínimo entre las fechas de última modificación de clases y fecha de última actualización de perfil
        $dates = array();
        $lessons = $teacher->lessons()->get();
        foreach ($lessons as $l)
            $dates[] = $l->updated_at;
        $dates[] = $teacher->updated_at;
        $last_one = new DateTime(min($dates));
        if (!empty($dates))
            $teacher->last_update = $last_one->format('d/m/Y h:i');

        //Calcular edad
        if ($user->date_of_birth) {
            $birthDate = $user->date_of_birth;
            $birthDate = explode("-", $birthDate);
            $teacher->age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md") ? ((date("Y") - $birthDate[0]) - 1) : (date("Y") - $birthDate[0]));
        }

        //Otros datos (importados de user table)
        $teacher->slug = $user_slug;
        $teacher->username = $user->username;
        if ($user->lastname)
            $teacher->displayName = ucwords($user->name) . ' ' . substr(ucwords($user->lastname), 0, 1) . '.';
        else
            $teacher->displayName = ucwords($user->name);
        $teacher->displayName2 = ucwords($user->name);
        $teacher->avatar = $user->avatar;
        $teacher->email = $user->email;
        $teacher->phone = $user->phone;
        $teacher->description = $user->description;
        $teacher->town = $user->town;
        $teacher->gender = $user->gender;
        $teacher->region = $user->region;
        $teacher->postalcode = $user->postalcode;

        $teacher->link_f = $user->link_facebook;
        $teacher->link_t = $user->link_twitter;
        $teacher->link_l = $user->link_linkedin;
        $teacher->link_g = $user->link_googleplus;
        $teacher->link_i = $user->link_instagram;
        $teacher->link_w = $user->link_web;

        $teacher->availability = $teacher->availabilities()->get();
        $teacher->nReviews = $teacher->getNumberOfReviews();
        $teacher->avgRating = $teacher->getTeacherAvgRating();

        return View::make('new_teacher_details', compact('teacher', 'lessons'));
    }

    /**
     * Given the variable $school_slug, and returns the school profile
     * @param $school_slug
     * @return \Illuminate\View\View
     */
    public function profilesSchool($school_slug)
    {
        $school = School::findBySlug($school_slug);
        $lessons = $school->lessons()->get();
        foreach ($lessons as $l) {
            $l->availability = $l->availabilities()->get();
        }

        $slpics = $school->pics()->get(array('pic')); //get collection with filenames only

        $school->nReviews = $school->getNumberOfReviews();
        $school->avgRating = $school->getSchoolAvgRating();

        if (Auth::check()) { //initialize google map WITH directions
            $user = Confide::user();

            //first map -> walking directions
            $config = array();
            $config['center'] = $school->lat . ',' . $school->lon;
            $config['zoom'] = '14';
            $config['https'] = true;
            $config['disableMapTypeControl'] = true;
            $config['disableStreetViewControl'] = false;
            $config['disableDoubleClickZoom'] = false;
            $config['disableNavigationControl'] = false;
            $config['disableScaleControl'] = false;
            $config['map_height'] = '300px';
            $config['scrollwheel'] = false;
            $config['zoomControlStyle'] = 'SMALL';
            $config['zoomControlPosition'] = 'TOP_RIGHT';
            $config['center'] = '37.4419, -122.1419';
            $config['zoom'] = 'auto';
            //directions
            $config['directions'] = TRUE;
            $config['directionsStart'] = $user->lat . ',' . $user->lon;
            $config['directionsEnd'] = $school->lat . ',' . $school->lon;
            $config['directionsMode'] = 'WALKING';
            $config['directionsDivID'] = 'directionsDiv';
            Gmaps::initialize($config);

            $marker = array();
            $marker['position'] = $school->lat . ',' . $school->lon;
            //$marker['icon'] = asset('img/marcador-mapa.png');
            Gmaps::add_marker($marker); //add student marker (center)
            $gmap = Gmaps::create_map();
        } else { //simple map showing localization of the school
            $config = array();
            $config['center'] = $school->lat . ',' . $school->lon;
            $config['zoom'] = '14';
            $config['https'] = true;
            $config['disableMapTypeControl'] = true;
            $config['disableStreetViewControl'] = false;
            $config['disableDoubleClickZoom'] = false;
            $config['disableNavigationControl'] = false;
            $config['disableScaleControl'] = false;
            $config['map_height'] = '300px';
            $config['scrollwheel'] = false;
            $config['zoomControlStyle'] = 'SMALL';
            $config['zoomControlPosition'] = 'TOP_RIGHT';
            Gmaps::initialize($config);

            $marker = array();
            $marker['position'] = $school->lat . ',' . $school->lon;
            //$marker['icon'] = asset('img/marcador-mapa.png');
            Gmaps::add_marker($marker); //add student marker (center)

            $gmap = Gmaps::create_map();

            //*** pagination by slices (first page)
            //    $lessons_per_slice = 2;
            //    $total_results = $lessons->count();
            //    $max_slices = ceil($total_results/$lessons_per_slice);
            //    $slices_showing = 0;
            //    $sl_offset = $slices_showing*$lessons_per_slice;
            //    $sl_length = $lessons_per_slice;
            //    $lessons = $lessons->slice($sl_offset,$sl_length);
            //    ++$slices_showing;
            //    $display_show_more = ($total_results==0 || $slices_showing == $max_slices) ? false : true;

        }
        return View::make('new_school_details', compact('school', 'slpics', 'gmap', 'lessons'));
    }
}