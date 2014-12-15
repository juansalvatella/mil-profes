<?php

class SearchController extends BaseController
{

    public function search()
    {
        //$direccion = Input::get('direccion');
        $prof_o_acad = Input::get('prof_o_acad');
        $categoria = Input::get('categoria');

        if ($prof_o_acad == 'profesor')
        {
            $resultados = Profesor::whereCategoria($categoria)->get();
        }
        else // $prof_o_acad == academia
        {
            $resultados = Academia::whereCategoria($categoria)->get();
        }

        $data = array('results'=>$resultados,'prof_o_acad'=>$prof_o_acad,'categoria'=>$categoria);

        return View::make('searchresults', compact('data'));
    }

}