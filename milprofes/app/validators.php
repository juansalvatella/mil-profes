<?php

/*
* app/validators.php
*/

Validator::extend('alpha_spaces', function($attribute, $value)
{
    return preg_match('/^[\pL\s]+$/u', $value);
});

Validator::extend('numeric_spaces', function($attribute, $value)
{
    return preg_match('/^([0-9_-\s])+$/i', $value);
});