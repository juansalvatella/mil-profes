<?php

use Illuminate\Support\Collection;

class SearchController extends BaseController
{
    public function search()
    {
        if (Input::has('user_lon')) //check if user longitude input exists (implies no need of geo-coding)
        {
            $user_lat = Input::get('user_lat');
            $user_lon = Input::get('user_lon');
            $user_address = Input::get('user_address');
        }
        else //geo-coding is needed by passing user address (user address input is needed)
        {
            $geodata_array = Geocoding::geocode(Input::get('user_address'));
            if ($geodata_array == false) //if geo-coding fails
            {
                return Redirect::route('home')->with('failure', 'Error! Tu dirección no ha sido encontrada. ¿Seguro que la escribiste bien?');
            }
            else
            {
                $user_lat = $geodata_array[0];
                $user_lon = $geodata_array[1];
                $user_address = $geodata_array[2];
            }
        } //obtained latitude, longitude and formatted addresss

        //Get other relevant user data
        $prof_o_acad = Input::get('prof_o_acad');
        $category = Input::get('category');

        if (Input::has('subj_id')) //if subject ID is known, no need to query database to obtain it
        {
            $subj_id = Input::get('subj_id');
        }
        else //we need to query database to obtain subject ID by passing subject by name
        {
            $subject = Subject::where('name', $category)->get()->toArray();
            $subj_id = $subject[0]['id'];
        } //obtained subject ID

        //set maximum distance for results, defaults to 10 km
        $search_distance = Input::get('distance', 10);

        //validar distance
        //...

        //filter results by teachers/schools lessons and chosen subject
        if ($prof_o_acad == 'profesor') //Query the pivot tables
        {
            //Estructura del SQL select:
            // SELECT * FROM `teacher_lessons`
            // INNER JOIN `teachers` ON `teachers.id` = `teacher_lessons`.`teacher_id`
            // INNER JOIN `users` ON `teachers.id` = `teachers`.`user_id`
            // WHERE `subject_id` = 7
            $results_by_subject_array = DB::table('teacher_lessons')
                ->join('teachers', 'teachers.id', '=', 'teacher_lessons.teacher_id')
                ->join('users','users.id','=','teachers.user_id')
                ->where('subject_id',$subj_id)
                ->get(array('teacher_lessons.*','users.lat','users.lon','users.name','users.email','users.phone','users.avatar','users.address','users.availability','users.username'));
            // Muy importante NO escoger las columnas id de las tablas joined o de lo contrario la columna id resultante será la de la última tabla joined, en lugar de la de la tabla original
        }
        else
        {
            //Estructura del SQL select:
            // SELECT * FROM `school_lessons`
            // INNER JOIN `school` ON `schools.id` = `school_lessons`.`school_id`
            // WHERE `subject_id` = 7
            $results_by_subject_array = DB::table('school_lessons')
                ->join('schools', 'schools.id', '=', 'school_lessons.school_id')
                ->where('subject_id',$subj_id)
                ->get(array('school_lessons.*','schools.lat','schools.lon','schools.name','schools.email','schools.phone','schools.logo','schools.address'));
            // Muy importante NO escoger las columnas id de las tablas joined o de lo contrario la columna id resultante será la de la última tabla joined, en lugar de la de la tabla original
        }
        $results_by_subject = new Collection($results_by_subject_array); //pasamos array a collection

        //filter results within distance boundaries
        $results = Geocoding::findWithinDistance($user_lat,$user_lon,$search_distance,$results_by_subject);

        //Obtener número de reviews y los ratings de los profesores y las clases
        if($prof_o_acad=='profesor')
        {
            foreach($results as $result)
            {
                $teacher = Teacher::findOrFail($result->teacher_id);
                $result->teacher_rating = $teacher->getTeacherAvgRating();
                $lesson = TeacherLesson::findOrFail($result->id);
                $result->lesson_rating = $lesson->getLessonAvgRating();
                $result->number_of_reviews = $lesson->getNumberOfReviews();
            }
        }

//The last two steps can be avoided in future if we pass to the search method the results collection
//from a previous search. In this case is necessary to record the distances of every result within the
//maximum distance allowed by the slider

        //Telephone trimmer (this does not validate, so get sure that the phones were validated at the input form (more than 4 digits, no spaces, letters, etc.)
        foreach($results as $result)
        {
            if ($result->phone) //if exists, trim the last numbers
            {
                $phone_pieces = str_split(trim($result->phone));
                $trimmered_phone = '';
                $i = 0;
                foreach ($phone_pieces as $piece)
                { //Remove last 4 digits and fill with * instead
                    if($i < (count($phone_pieces)-4)) { $trimmered_phone .= $piece; }
                    else { $trimmered_phone .='*'; }
                    ++$i;
                }
                $result->trimmered_phone = $trimmered_phone;
            }
        }

        //set google map config, initialize google map view and add results markers
        $config = array();
        $config['center'] = $user_lat.','.$user_lon;
        $config['zoom'] = '10';
        Gmaps::initialize($config);

        $marker = array();
        $marker['position'] = $user_lat.','.$user_lon;
        $marker['icon'] = url(asset('/img/target_icon.png'));//'http://maps.google.com/mapfiles/kml/pal3/icon48.png';
        Gmaps::add_marker($marker); //add student marker (center) into the map

        $circle_radius = (string) ($search_distance*1000);
        $circle = array();
        $circle['center'] = $user_lat.','.$user_lon;
        $circle['radius'] = $circle_radius;
        Gmaps::add_circle($circle);

// Por ahora hemos decididio (Joan, Mitxel) no implementar marcadores de localización de los resultados
//        foreach ($results as $result)
//        {
//            $marker = array();
//            $marker['position'] = $result->lat.','.$result->lon;
//            $marker['infowindow_content'] = $result->name;
//            $marker['icon'] = 'http://maps.google.com/mapfiles/kml/pal4/icon47.png';
//            Gmaps::add_marker($marker);
//        } //add found locations markers into the map

        $gmap =  Gmaps::create_map(); //create map with given options

        return View::make('searchresults', compact('gmap','results','prof_o_acad','category','user_lat','user_lon','user_address','subj_id','search_distance'));

    }

}