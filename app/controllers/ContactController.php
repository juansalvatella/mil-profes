<?php

/**
 * Class ContactController
 */
class ContactController extends Controller {

    /**
     * Show contact info.
     * @return \Illuminate\View\View
     */
    public function contactPage()
    {
        return View::make('contact');
    }

    /**
     * Show the mini contact form
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getMiniContactForm()
    {

        $data = Input::all();

        $rules = array (
            'contact_name' => 'required|max:50',
            'contact_email' => 'required|email',
            'contact_subject' => 'required|max:50',
            'contact_message' => 'required|max:1000',
        );
        $validator = Validator::make($data, $rules);

        if ($validator -> passes()){

            Mail::queue('emails.feedback', $data, function($message) use ($data)
            {
                $message->from('info@milprofes.com' , 'milProfes.')
                    ->replyTo($data['contact_email'] , $data['contact_name'])
                    ->to('info@milprofes.com', 'milProfes.')->subject($data['contact_subject']);
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

    /**
     * Show the contact form
     * @return \Illuminate\Http\RedirectResponse
     */
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
                $message->from('info@milprofes.com' , 'milProfes.')
                    ->replyTo($data['contact_email'] , $data['contact_name'])
                    ->to('info@milprofes.com', 'milProfes.')->subject($data['contact_subject']);
            });

            return Redirect::to('contactanos')
                ->with('success', 'Tu mensaje ha sido enviado. ¡Muchas gracias!')
                ->with('Stitle','Éxito')
                ->with('Smsg','Tu mensaje ha sido enviado. ¡Muchas gracias!.');
        }
        else
        {
            //return contact form with errors
            return Redirect::to('contactanos')
                ->withInput()
                ->with('error', '¡Error! Faltan campos por rellenar.')
                ->with('Etitle', 'Error')
                ->with('Emsg', 'No se pudo enviar tu mensaje. Asegúrate de que todos los campos están rellenados correctamente.');
        }

    }

}
