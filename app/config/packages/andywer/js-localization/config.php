<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Define the languages you want exported messages for
    |--------------------------------------------------------------------------
    */

    'locales' => ['es'],

    /*
    |--------------------------------------------------------------------------
    | Define the messages to export
    |--------------------------------------------------------------------------
    |
    | An array containing the keys of the messages you wish to make accessible
    | for the Javascript code. Limit these messages to the minimum you really need.
    |
    | Set the keys of the messages you want to use in javascript
    | 'messages' => [
    |   'reminder' => [
    |       'password', 'user', 'token'
    |   ]
    | ]
    | in short:
    | 'messages' => ['reminder'],
    | you could also use:
    | 'messages' => [
    |   'reminder.password',
    |   'reminder.user',
    |   'reminder.token'
    | ]
    |
    | The messages configuration will be cached when the JsLocalizationController is used for the first time.
    | After changing the messages configuration you will need to call
    | php artisan js-localization:refresh
    |
    | You may use Lang.get(), Lang.has(), Lang.choice(), Lang.locale() and trans() in your Javascript code.
    | ex.: document.write( Lang.get('reminder.user') );
    |
    */

    'messages' => ['js'],

];
