/*
 * File: app.js
 * Category: -
 * Author: MSG - Webklex
 * URL: http://webklex.com
 * Created: 11.03.17 01:23
 * Updated: -
 *
 * Description:
 *  -
 */

(function(){
    'use strict';

    var config = {
        app: {
            name: 'PostfixADM'
        },
        storage: {
            type: 'localStorage' //sessionStorage
        }
    };

    angular.module('app', [
        'ngMaterial'
    ]);
})();