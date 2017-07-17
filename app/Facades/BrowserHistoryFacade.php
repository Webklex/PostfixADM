<?php
/*
* File: BrowserHistoryFacade.php
* Category: Facade
* Author: MSG
* Created: 17.07.17 19:46
* Updated: -
*
* Description:
*  -
*/


namespace App\Facades;

use \Illuminate\Support\Facades\Facade;

class BrowserHistoryFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'BrowserHistory';
    }
}