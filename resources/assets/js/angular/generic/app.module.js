/*
 * File: app.module.js.js
 * Category: AngularJS Module
 * Author: MSG
 * Created: 18.02.17 21:55
 * Updated: -
 *
 * Description:
 *  -
 */


(function(){
    'use strict';

    angular.module('app').config(['$interpolateProvider', function($interpolateProvider){
        $interpolateProvider.startSymbol('[[');
        $interpolateProvider.endSymbol(']]');
    }]);
})();