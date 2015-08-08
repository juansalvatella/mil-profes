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

            return Redirect::route('contact')
                ->with('success','')
                ->with('Stitle',trans('hardcoded.contactcontroller.getContactForm.Stitle'))
                ->with('Smsg',trans('hardcoded.contactcontroller.getContactForm.Smsg'));
        }
        else
        {
            //return contact form with errors
            return Redirect::route('contact')
                ->withInput()
                ->with('error','')
                ->with('Etitle',trans('hardcoded.contactcontroller.getContactForm.Etitle'))
                ->with('Emsg',trans('hardcoded.contactcontroller.getContactForm.Emsg'));
        }

    }

}
