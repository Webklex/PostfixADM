<?php

/*
* File: UserHelper.php
* Category: -
* Author: MSG
* Created: 11.03.17 13:14
* Updated: -
*
* Description:
*  -
*/


if (!function_exists('isSuperUser')) {

    /**
     * say hello
     *
     * @param string $name
     * @return string
     */
    function isSuperUser() {
        return auth()->check() ? auth()->user()->super_user : false;
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