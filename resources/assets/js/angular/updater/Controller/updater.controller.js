/*
 * File: updater.controller.js
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

    angular.module('app').controller('updaterController', ['$http', updaterController]);

    function updaterController($http) {
        var vm = this;

        vm.data = {};

        vm.started = false;
        vm.completed = false;

        vm.step = {
            connect: false,
            download: false,
            extract: false,
            applied: false,
            migration: false,
            completed: false,
        };

        vm.api = '/api/update/step';

        vm.error = [];
        vm.warning = [];

        vm.parse = function(json){
            var data = JSON.parse(json);
            angular.forEach(data, function(value, name){
                if(value != null){
                    vm.data[name] = value;
                }
            });
        };

        vm.startUpdate = function(){
            var options = {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': vm.data.token
                }
            };
            vm.started = true;
            vm.completed = false;

            vm.callStep('connect', options, function(){

                vm.callStep('download', options, function(){

                    vm.callStep('extract', options, function(){

                        vm.callStep('applied', options, function(){

                            vm.callStep('migration', options, function(){

                                vm.callStep('completed', options, function(){
                                    vm.completed = true;
                                });

                            });

                        });

                    });
                });
            });
        };

        vm.callStep = function(step, options, callback){
            options.url = vm.api+'/'+step+'/'+vm.data.version;

            $http(options).then(function(response){
                var data = response.data;

                vm.error = data.error;
                vm.warning = data.warning;
                vm.step[step] = data.status;

                if(data.error.length == 0 && data.status == true){
                    callback();
                }else{
                    vm.started = false;
                }
            }, function(response){
                var data = response.data;

                vm.step[step] = false;
                vm.started = false;
                vm.error = data.error;
                vm.warning = data.warning;
            });
        }
    }
})();