/*
 * File: setup.controller.js
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

    angular.module('app').controller('installerSetup', [installerSetup]);

    function installerSetup() {
        var vm = this;

        vm.data = {
            APP_DEBUG:      true,
            APP_LOG_LEVEL:  'debug',
            APP_URL:        '',

            DB_CONNECTION:  'mysql',
            DB_HOST:        'localhost',
            DB_PORT:        3306,
            DB_DATABASE:    '',
            DB_USERNAME:    '',
            DB_PASSWORD:    '',

            MAIL_DRIVER:    'smtp',
            MAIL_HOST:      '',
            MAIL_PORT:      '25',
            MAIL_USERNAME:  '',
            MAIL_FROM_NAME: '',
            MAIL_FROM_ADDRESS: '',
            MAIL_PASSWORD:  '',
            MAIL_ENCRYPTION: 'tls',

            encryption: 'SHA512-CRYPT',

            mailbox: {
                table: null,
                email:      {join: {status: false, domain_table: null, join_key: null, join_value: null}},
                password:   {join: {status: false, domain_table: null, join_key: null, join_value: null}},
                quota_kb:   {join: {status: false, domain_table: null, join_key: null, join_value: null}},
                active:     {join: {status: false, domain_table: null, join_key: null, join_value: null}},
                domain:     {join: {status: false, domain_table: null, join_key: null, join_value: null}}
            },
            alias: {
                table: null,
                source:      {join: {status: false, domain_table: null, join_key: null, join_value: null}},
                destination: {join: {status: false, domain_table: null, join_key: null, join_value: null}},
                domain:      {join: {status: false, domain_table: null, join_key: null, join_value: null}}
            },
            domain: {
                table: null,
                name:   {join: {status: false, domain_table: null, join_key: null, join_value: null}},
                active: {join: {status: false, domain_table: null, join_key: null, join_value: null}}
            }
        };

        vm.parse = function(json){
            var data = JSON.parse(json);
            angular.forEach(data, function(value, name){
                if(value != null){
                    vm.data[name] = value;
                }
            });
        };

        vm.getTable = function(model){
            if(model != null){
                return model.replace(/\$.*/, '');
            }
            return false;
        };

        vm.generateDomainMap = function(){
            vm.json_map = JSON.stringify({
                mailbox: vm.data.mailbox,
                alias: vm.data.alias,
                domain: vm.data.domain
            });
        };
    }
})();