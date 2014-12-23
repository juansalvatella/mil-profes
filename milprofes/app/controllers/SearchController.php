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
            $prof_o_acad = Input::get('prof_o_acad');
            $categoria = Input::get('categoria');
            $user_lat = $geodata_array[0];
            $user_lon = $geodata_array[1];
            $user_address = $geodata_array[2];
            $default_distance = 25.0; //en km

            $subject = Subject::where('name', '=', $categoria)->get()->toArray();
            $subjId = $subject[0]['id']; //Get the selected subject ID

            if ($prof_o_acad == 'profesor') //Query the pivot tables
                $results_by_subject = Subject::find($subjId)->teachers;
            else
                $results_by_subject = Subject::find($subjId)->schools;

            $results = Geocoding::checkdistanceconstrains($user_lat,$user_lon,$default_distance,$results_by_subject);

            return View::make('searchresults', compact('results','prof_o_acad','categoria'));
        }

    }

}