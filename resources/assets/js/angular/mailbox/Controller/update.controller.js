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

    angular.module('app').controller('mailboxUpdate', [mailboxUpdate]);

    function mailboxUpdate() {
        var vm = this;

        vm.data = {};

        vm.parse = function(json){
            vm.data = JSON.parse(json);
        };

        vm.quota = function(){
            return Math.round((vm.data.quota_kb/vm.data.quota)*100);
        }
    }
})();