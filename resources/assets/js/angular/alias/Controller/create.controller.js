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

    angular.module('app').controller('aliasCreate', [aliasCreate]);

    function aliasCreate() {
        var vm = this;

        vm.data = {
            domain_id:   null,
            source:      '',
            destination: []
        };

        vm.parse = function(json){
            vm.domains = JSON.parse(json);
            vm.addAlias();
        };

        vm.addAlias = function(){
            vm.data.destination.push('');
        };

        vm.removeAlias = function(key){
            vm.data.destination.splice(key, 1);
        }
    }
})();