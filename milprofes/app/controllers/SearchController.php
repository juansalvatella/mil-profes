<?php

class SearchController extends BaseController
{

    public function search()
    {
        $entered_address = Input::get('direccion');
        $geodata_array = Geocoding::geocode($entered_address);
        if ($geodata_array == false)
        {
            //devolver mensaje de error ? no se encontró dirección
            return Redirect::to('demo');
        }
        else
        {
            //Get geodata from Google API - geocode method
            $user_lat = $geodata_array[0];
            $user_lon = $geodata_array[1];
            $user_address = $geodata_array[2];
            //Get user data from the form
            $prof_o_acad = Input::get('prof_o_acad');
            $categoria = Input::get('categoria');
            $subject = Subject::where('name', '=', $categoria)->get()->toArray();
            $subjId = $subject[0]['id']; //Get the selected subject ID
            //Set search defaults
            $default_distance = 25.0; //en km

            //Filter results by teachers/schools and chosen subject
            if ($prof_o_acad == 'profesor') //Query the pivot tables
                $results_by_subject = Subject::find($subjId)->teachers;
            else
                $results_by_subject = Subject::find($subjId)->schools;
            //Filter results within distance boundaries
            $results = Geocoding::checkdistanceconstrains($user_lat,$user_lon,$default_distance,$results_by_subject);

            //Initialize google map view and add results markers
            $config = array();
            $config['center'] = $user_lat.','.$user_lon;
            $config['zoom'] = 'auto';
            Gmaps::initialize($config);

            //Student marker
            $marker = array();
            $marker['position'] = $user_lat.','.$user_lon;
            $marker['icon'] = 'http://maps.google.com/mapfiles/kml/pal3/icon48.png';
            Gmaps::add_marker($marker);

            //Teachers-Schools markers
            foreach ($results as $result)
            {
                $marker = array();
                $marker['position'] = $result['lat'].','.$result['lon'];
                $marker['infowindow_content'] = $result['name'];
                $marker['icon'] = 'http://maps.google.com/mapfiles/kml/pal4/icon47.png';
                Gmaps::add_marker($marker);
            }

            $gmap =  Gmaps::create_map();

            return View::make('searchresults', compact('results','prof_o_acad','categoria','gmap'));
        }

    }

}