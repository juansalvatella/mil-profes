<?php

class ContactController extends Controller {

    public function getContactForm()
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
            Mail::send('emails.feedback', $data, function($message) use ($data)
            {
                $message->from($data['contact_email'] , $data['contact_name']);
                $message->to('moriana.mitxel@gmail.com', 'Mitxel Moriana')->subject('milProfes. feedback: '.$data['contact_subject']);
            });

            return Redirect::to('/')
                ->withInput()
                ->with('success', 'Tu mensaje ha sido enviado. ¡Muchas gracias!');
        }
        else
        {
            //return contact form with errors
            return Redirect::to('/')
                ->withInput()
                ->with('failure', '¡Error! Faltan campos por rellenar en el formulario de contacto.');
        }

    }

}
