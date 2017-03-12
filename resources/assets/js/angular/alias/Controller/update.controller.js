/*
 * File: alias.controller.js
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

    angular.module('app').controller('aliasUpdate', [aliasUpdate]);

    function aliasUpdate() {
        var vm = this;

        vm.data = {};

        vm.parse = function(data, domains){
            vm.data             = JSON.parse(atob(data));
            vm.data.destination = vm.data.destination.split(',');
            vm.domains          = JSON.parse(domains);
        };

        vm.addAlias = function(){
            vm.data.destination.push('');
        };

        vm.removeAlias = function(key){
            vm.data.destination.splice(key, 1);
        }
    }
})();