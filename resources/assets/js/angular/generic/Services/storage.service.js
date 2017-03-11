/*
 * File: storageService.js
 * Category: AngularJS Service
 * Author: MSG
 * Created: 16.01.16 01:16
 * Updated: -
 *
 * Description:
 *  -
 */

(function(){
    "use strict";

    angular.module('app').service('storageService', ['localStorageService', storageService]);

    function storageService(localStorageService) {

        /* Get a stored value. If the given one doesn't exist
         * the default value will be returned
         * @param string key
         * @param mixed defaultValue
         * @param boolean notNull
         *
         * @return mixed
         * */
        this.get = function(key, defaultValue, notNull){
            var value = localStorageService.get(key);
            if(angular.isUndefined(value) || (notNull == true && value == null)){
                return defaultValue;
            }
            return value;
        };

        /* Store a value on the client machine
         * @param string key
         * @param mixed value
         *
         * @return self
         * */
        this.set = function(key, value){
            localStorageService.set(key, value);
            return this;
        };

        /* Get a stored object. If the given one doesn't exist
         * the default value will be returned
         * @param string key
         * @param mixed defaultValue
         * @param boolean notNull
         *
         * @return mixed
         * */
        this.getObject = function(key, defaultValue, notNull){
            var json = this.get(key, defaultValue, notNull);
            if(angular.isString(json)){
                return JSON.parse(json);
            }
            return json;
        };

        /* Store an object on the client machine
         * @param string key
         * @param object|array value
         *
         * @return self
         * */
        this.setObject = function(key, value){
            return this.set(key, JSON.stringify(value));
        };

        /* Dumps the class name - generated function
         * @return string
         */
        this._toString = function () {
            return 'storageService';
        };
    }
})();