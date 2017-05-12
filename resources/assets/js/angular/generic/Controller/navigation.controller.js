/*
 * File: navigation.controller.js
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

    angular.module('app').controller('navigationController', ['$mdSidenav', navigationController]);

    function navigationController($mdSidenav) {
        var vm = this;


        vm.navigation = {
            id: 'main-side-navigation',

            toggle: function(){
                $mdSidenav(vm.navigation.id).toggle();
            }
        }
    }
})();