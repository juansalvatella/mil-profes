<?php

class SearchController extends BaseController
{

    public function search()
    {

        //$direccion = Input::get('direccion');
        $prof_o_acad = Input::get('prof_o_acad');
        $categoria = Input::get('categoria');
        $subject = Subject::where('name', '=', $categoria)->get()->toArray();
        $subjId = $subject[0]['id'];

        if ($prof_o_acad == 'profesor')
        {
            $resultados = Subject::find($subjId)->teachers;
        }
        else //$prof_o_acad == 'academia'
        {
            $resultados = Subject::find($subjId)->schools;
        }

        $data = array('results'=>$resultados,'prof_o_acad'=>$prof_o_acad,'categoria'=>$categoria);

        return View::make('searchresults', compact('data'));

    }

}