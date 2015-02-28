<?php

class ContactController extends Controller {

    public function getMiniContactForm()
    {

        $data = Input::all();

        $rules = array (
            'contact_name' => 'required|max:50',
            'contact_email' => 'required|email',
            'contact_subject' => 'required|max:50',
            'contact_message' => 'required|max:1000',
        );
        $validator = Validator::make ($data, $rules);

        if ($validator -> passes()){

            Mail::queue('emails.feedback', $data, function($message) use ($data)
            {
                $message->from('mitxel@network30.com' , $data['contact_name']);
//                $message->from($data['contact_email'] , $data['contact_name']);
                $message->to('mitxel@network30.com', 'Mitxel Moriana')->subject('milProfes. feedback: '.$data['contact_subject']);
            });

            return Redirect::back()
                ->with('minicontact-success', 'Tu mensaje ha sido enviado. ¡Muchas gracias!');
        }
        else
        {
            //return contact form with errors
            return Redirect::back()
                ->with('minicontact-error', 'Faltan campos por rellenar.');
        }

    }


    public function getContactForm()
    {

        $data = Input::all();

        $rules = array (
            'contact_name' => 'required|max:50',
            'contact_lastname' => 'max:100',
            'contact_email' => 'required|email',
            'contact_subject' => 'required|max:50',
            'contact_message' => 'required|max:1000',
        );
        $validator = Validator::make ($data, $rules);

        if ($validator -> passes()){
            Mail::queue('emails.feedback_full', $data, function($message) use ($data)
            {
                $message->from('mitxel@network30.com' , $data['contact_name']);
//                $message->from($data['contact_email'] , $data['contact_name']);
                $message->to('mitxel@network30.com', 'Mitxel Moriana')->subject('milProfes. feedback: '.$data['contact_subject']);
            });

            return Redirect::to('contactanos')
                ->with('success', 'Tu mensaje ha sido enviado. ¡Muchas gracias!');
        }
        else
        {
            //return contact form with errors
            return Redirect::to('contactanos')
                ->with('error', '¡Error! Faltan campos por rellenar.');
        }

    }

}
