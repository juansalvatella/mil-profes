<?php

/**
 * Class StuffController
 */
class StuffController extends BaseController
{

    /**
     * Shows Faqs
     * @return \Illuminate\View\View
     */
    public function showFaqs()
    {
        return View::make('faqs');
    }

    /**
     * Shows services.
     * @return \Illuminate\View\View
     */
    public function showServices()
    {
        return View::make('servicios');
    }

    /**
     * Shows who
     * @return \Illuminate\View\View
     */
    public function showWho()
    {
        return View::make('who');
    }

    /**
     * Shows terms conditional.
     * @return \Illuminate\View\View
     */
    public function showTerms()
    {
        return View::make('aviso_legal');
    }

    /**
     * Shows cookies.
     * @return \Illuminate\View\View
     */
    public function showCookies()
    {
        return View::make('cookies');
    }

    /**
     * Shows the privacy policy.
     * @return \Illuminate\View\View
     */
    public function showPrivacy()
    {
        return View::make('politica_privacidad');
    }

    /**
     * Makes the 'mapa' View.
     * @return \Illuminate\View\View
     */
    public function showSitemap()
    {
        return View::make('mapa');
    }
}