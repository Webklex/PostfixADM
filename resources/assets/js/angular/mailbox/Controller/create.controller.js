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

    angular.module('app').controller('mailboxCreate', [mailboxCreate]);

    function mailboxCreate() {
        var vm = this;

        vm.data = {
            email:    '',
            quota_kb:  0,
            password:  ''
        };

        vm.parse = function(json){
            vm.domains = JSON.parse(json);
        }
    }
})();