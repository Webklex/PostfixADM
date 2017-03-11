/*
 * File: step.service.js
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

    angular.module('app').service('stepService', [stepService]);

    function stepService() {
        var vm = this;

        /**
         * Steps holder
         * @var steps object
         * */
        vm.steps = {
            'temporary_employment': {
                title: 'Befristetes Arbeitsverhältnis?',
                dataKey: 'temporary_employment',
                finished: false
            },
            'temporary_employment_limit': {
                'title': 'Ablauf durch Ende Befristung?',
                dataKey: 'temporary_employment_limit',
                finished: false
            },
            'temporary_employment_result': {
                'title': 'Zusammenfassung: Dein Arbeitsverhältnis war befristet und ist durch Beendigung der Befristung abgelaufen',
                dataKey: 'temporary_employment_result',
                finished: false,
                hidden: true
            },
            'receive_notice_in_writing': {
                'title': 'Kündigung schriftlich erhalten?',
                dataKey: 'receive_notice_in_writing',
                finished: false
            },
            'receive_notice_in_writing_result': {
                'title': 'Zusammenfassung: Du hast keine schriftliche Kündigung erhalten',
                dataKey: 'receive_notice_in_writing_result',
                finished: false,
                hidden: true
            },
            'pregnant': {
                'title': 'Schwanger und Arbeitgeber mitgeteilt?',
                dataKey: 'pregnant',
                finished: false
            },
            'pregnant_result': {
                'title': 'Zusammenfassung: Du bist Schwanger und hast es ddeinem Arbeitgeber mitgeteilt',
                dataKey: 'pregnant_result',
                finished: false,
                hidden: true
            },
            'disabled': {
                'title': 'Hast du eine Schwerbehinderung?',
                dataKey: 'disabled',
                finished: false
            },
            'disabled_result': {
                'title': 'Zusammenfassung: du hast eine Schwerbehinderung',
                dataKey: 'disabled_result',
                finished: false,
                hidden: true
            },
            'employee_over_10': {
                'title': '10 oder mehr Mitarbeiter im Unternehmen?',
                dataKey: 'employee_over_10',
                finished: false
            },
            'works_council_available': {
                'title': 'Betriebsrat vorhanden?',
                dataKey: 'works_council_available',
                finished: false
            },
            'dismissal_date': {
                'title': 'Wann wurde die Kündigung übergeben (persönlich) bzw. wann war diese in der Post?',
                dataKey: 'dismissal_date',
                finished: false
            },
            'dismissal_date_result': {
                'title': 'Vorläufiges Ergebnis: Frist KSCH-Klage',
                dataKey: 'dismissal_date_result',
                finished: false,
                hidden: true
            },
            'dismissed_to': {
                'title': 'Zu wann wurde gekündigt?',
                dataKey: 'dismissed_to',
                finished: false
            },
            'probation': {
                'title': 'Probezeit im Arbeitsvertrag vereinbart?',
                dataKey: 'probation',
                finished: false
            },
            'notice_period': {
                'title': 'Wurde im Arbeitsvertrag eine Kündigungsfrist vereinbart?',
                dataKey: 'notice_period',
                finished: false
            },
            'is_work_council': {
                'title': 'Sind Sie Betriebsratmitglied?',
                dataKey: 'is_work_council',
                finished: false
            },
            'event_of_default': {
                'title': 'Bitte definieren Sie den Kündigungsgrund',
                dataKey: 'event_of_default',
                finished: false
            },
            'contact_lawyer': {
                'title': 'Hilfe vom Anwalt',
                dataKey: 'contact_lawyer',
                finished: false,
                hidden: true
            },
            'initial_consultation': {
                'title': 'Erstberatung',
                dataKey: 'initial_consultation',
                finished: false,
                hidden: true
            },
            'done': {
                'title': 'Abschluss',
                dataKey: 'done',
                finished: false,
                hidden: true
            }
        };

        /**
         * Get a stored value. If the given one doesn't exist
         * the default value will be returned
         * @param step string
         *
         * @return object
         * */
        vm.get = function(step){
            return vm.steps[step]?vm.steps[step]:false;
        };

        /**
         * Get all available steps
         *
         * @return object
         * */
        vm.all = function(){
            return vm.steps;
        };

        /**
         * Dumps the class name - generated function
         * @return string
         */
        vm._toString = function () {
            return 'stepService';
        };
    }
})();