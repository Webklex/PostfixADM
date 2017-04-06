/*
 * File: app.js
 * Category: -
 * Author: MSG - Webklex
 * URL: http://webklex.com
 * Created: 11.03.17 01:23
 * Updated: -
 *
 * Description:
 *  -
 */

(function(){
    'use strict';

    angular.module('app', [
        'ngMaterial'
    ]);



    angular.module('app').config(['$interpolateProvider', '$mdThemingProvider', function($interpolateProvider, $mdThemingProvider){
        $interpolateProvider.startSymbol('[[');
        $interpolateProvider.endSymbol(']]');

        $mdThemingProvider.definePalette('padm', $mdThemingProvider.extendPalette('blue', {
            '50':   '#E7F1F5',
            '100':  '#B9D5E1',
            '200':  '#8BB9CD',
            '300':  '#5C9DB9',
            '400':  '#2E81A5',
            '500':  '#006591',
            '600':  '#005377',
            '700':  '#00415D',
            '800':  '#002E42',
            '900':  '#001C28',
            'A100': '#FFFFFF',
            'A200': '#2E81A5',
            'A400': '#006490',
            'A500': '#005377',
            'A700': '#004360',
            //'contrastDefaultColor': 'dark',    // whether, by default, text (contrast)
            //'contrastAccentColor': '#000',    // whether, by default, text (contrast)
            // on this palette should be dark or light

            'contrastDarkColors': ['50', '100', //hues which contrast should be 'dark' by default
                '200', '300', '400', 'A100'],
            'contrastLightColors': ['50', '100', //hues which contrast should be 'dark' by default
                '200', '300', '400', 'A100']
        }));

        $mdThemingProvider.theme('default')
            .primaryPalette('padm')
            .accentPalette('padm')

        $mdThemingProvider.theme('red')
            .primaryPalette('red')

        $mdThemingProvider.theme('red').backgroundPalette('red').dark();
        $mdThemingProvider.theme('green').backgroundPalette('green').dark();
        $mdThemingProvider.theme('blue').backgroundPalette('padm').dark();
        $mdThemingProvider.theme('light-blue').backgroundPalette('light-blue').dark();
    }]);
})();