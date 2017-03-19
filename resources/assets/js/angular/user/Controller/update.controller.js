/*
 * File: mailbox.controller.js
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

    angular.module('app').controller('userUpdate', ['$http', mailboxUpdate]);

    function mailboxUpdate($http) {
        var vm = this;

        vm.data = {};
        vm.domains = [];
        vm.token = '';

        vm.parse = function(json, domains, token){
            vm.data = JSON.parse(json);
            vm.domains = JSON.parse(domains);
            vm.token = token;

            for(var i = 0; i < vm.data.domains.length; i++){
                for(var k = 0; k < vm.domains.length; k++){

                    if(vm.domains[k].checked != true){
                        vm.domains[k].checked = vm.domains[k].id == vm.data.domains[i].id;
                    }
                }
            }
        };

        vm.toggle = function(domain){
            $http({
                method: 'GET',
                url: '/user/toggle/' + vm.data.id + '/' + domain.id,
                headers: {
                    'X-CSRF-TOKEN': vm.token
                },
                data: { test: 'test' }
            }).then(function(){
                domain.checked = !domain.checked;
            }, function(){});
        };
    }
})();