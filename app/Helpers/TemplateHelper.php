<?php

/*
* File: TemplateHelper.php
* Category: -
* Author: MSG
* Created: 11.03.17 13:14
* Updated: -
*
* Description:
*  -
*/


if (!function_exists('getCurrent')) {

    /**
     * say hello
     *
     * @param string $name
     * @return string
     */
    function getCurrent($mModel, $key) {
        return old($key) ? old($key) : $mModel->$key;
    }
}

if (!function_exists('realUser')) {

    /**
     * say hello
     *
     * @param string $name
     * @return string
     */
    function realUser() {
        return \App\Models\User::findOrFail(auth()->user()->id);
    }
}