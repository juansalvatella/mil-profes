<?php

class ContactController extends Controller {

    public function getContactForm()
    {

        $data = Input::all();

        $rules = array (
            'contact_name' => 'required',
            'contact_email' => 'required|email',
            'contact_subject' => 'required',
            'contact_message' => 'required|min:5',
        );
        $validator = Validator::make ($data, $rules);

        if ($validator -> passes()){
            Mail::send('emails.feedback', $data, function($message) use ($data)
            {
                $message->from($data['contact_email'] , $data['contact_name']);
                $message->to('moriana.mitxel@gmail.com', 'Mitxel Moriana')->subject('milProfes feedback-form mail - '.$data['contact_subject']);
            });

            return Redirect::route('home')
                ->withInput()
                ->with('success', 'Tu mensaje ha sido enviado. ¡Muchas gracias!');
        }
        else
        {
            //return contact form with errors
            return Redirect::route('home')
                ->withInput()
                ->with('failure', '¡Error! Faltan campos por rellenar en el formulario de contacto.');
        }

    }

}
