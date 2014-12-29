<?php

class SearchController extends BaseController
{
    public function search()
    {
        if (Input::has('user_lon')) //check if user longitude exists (implies no need of geo-coding)
        {
            $user_lat = Input::get('user_lat');
            $user_lon = Input::get('user_lon');
            $user_address = Input::get('user_address');
        }
        else //geo-coding is needed by passing user address
        {
            $geodata_array = Geocoding::geocode(Input::get('user_address'));
            if ($geodata_array == false) //if geo-coding fails
            {
                //Falta mostrar algún mensaje de error
                return Redirect::to('demo');
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
            $subject = Subject::where('name', '=', $category)->get()->toArray();
            $subj_id = $subject[0]['id'];
        } //obtained subject ID

        //set maximum distance for results, defaults to 10
        $search_distance = Input::get('distance', 10); //en km. Si no existe input de distancia, default a 10 km

//Será necesario comprobar que la distancia esté dentro de los límites que consideremos aceptable (validar distance)

        //filter results by teachers/schools and chosen subject
        if ($prof_o_acad == 'profesor') //Query the pivot tables
            $results_by_subject = Subject::find($subj_id)->teachers;
        else
            $results_by_subject = Subject::find($subj_id)->schools;

        //filter results within distance boundaries
        $results = Geocoding::findWithinDistance($user_lat,$user_lon,$search_distance,$results_by_subject);

//The last two steps can be avoided in future if we pass to the search method the results collection
//from a previous search. In this case is necessary to record the distances of every result within the
//maximum distance allowed by the slider

        //set google map config, initialize google map view and add results markers
        $config = array();
        $config['center'] = $user_lat.','.$user_lon;
        $config['zoom'] = 'auto';
        Gmaps::initialize($config);

        $marker = array();
        $marker['position'] = $user_lat.','.$user_lon;
        $marker['icon'] = 'http://maps.google.com/mapfiles/kml/pal3/icon48.png';
        Gmaps::add_marker($marker); //add student marker (center) into the map

        foreach ($results as $result)
        {
            $marker = array();
            $marker['position'] = $result['lat'].','.$result['lon'];
            $marker['infowindow_content'] = $result['name'];
            $marker['icon'] = 'http://maps.google.com/mapfiles/kml/pal4/icon47.png';
            Gmaps::add_marker($marker);
        } //add found locations markers into the map

        $gmap =  Gmaps::create_map(); //create map with given options

        return View::make('searchresults', compact('gmap','results','prof_o_acad','category','user_lat','user_lon','user_address','subj_id','search_distance'));

    }

}