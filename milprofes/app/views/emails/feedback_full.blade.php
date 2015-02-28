<?php

$name = Input::get('contact_name');
$lastname = Input::get('contact_lastname');
$email = Input::get('contact_email');
$subject = Input::get('contact_subject');
$message = Input::get('contact_message');
$date_time = date("F j, Y, g:i a");
$userIpAddress = Request::getClientIp();

?>

<h1>milProfes. Feedback</h1>

<p>
    Nombre: {{{ $name }}}<br>
    Apellidos: {{{ $lastname }}}<br>
    E-mail: {{{ $email }}}<br>
    Date: {{{ $date_time }}}<br>
    User IP address: {{{ $userIpAddress }}}<br>
    Asunto: {{{ $subject }}}<br><br>
    Mensaje: {{{ $message }}}<br>
</p>