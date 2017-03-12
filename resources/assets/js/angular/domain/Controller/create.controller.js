/*
 * File: start.controller.js
 * Category: AngularJS Controller
 * Author: MSG
 * Created: 18.02.17 22:44
 * Updated: -
 *
 * Description:
 *  -
 */


/*global angular*/

(function(){
    'use strict';

    angular.module('app').controller('domainCreate', [domainCreate]);

    function domainCreate() {
        var vm = this;

        vm.data = {};

        vm.parse = function(json){
            vm.data = JSON.parse(json);
        }
    }
})();