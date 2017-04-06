<?php
/*
 * File: index.blade.php
 * Category: View
 * Author: MSG
 * Created: 11.03.17 14:08
 * Updated: -
 *
 * Description:
 *  -
 */


?>

@extends('layout.app', [
    'scripts' => [
        '/assets/js/updater.min.js'
    ]
])

@section('content')
    <md-content ng-controller="updaterController as vm" ng-init="vm.parse('{{json_encode(["version" => $next, "token" => csrf_token()])}}')" class="md-padding" layout-xs="column" layout="row" layout-wrap>

        <div flex-xs flex-gt-xs="100" layout="row" class="mb-16" ng-show="vm.error.length > 0">
            <md-card md-theme="red" flex>
                <md-card-content layout="row">
                    <div flex="nogrow" class="pr-16">
                        <i class="material-icons md-color-white large" style="color: white;">warning</i>
                    </div>
                    <div flex>
                        <span class="md-headline">@t('File permissions incorrect')</span>
                        <p>
                            @t('Please make sure that the following files can be written by your www-data user:')

                            <span ng-repeat="error in vm.error"><br />@t('File path'): [[error]]</span>
                        </p>
                    </div>
                </md-card-content>
            </md-card>
        </div>
        <div flex-xs flex-gt-xs="100" layout="row" class="mb-16" ng-show="vm.warning.length > 0">
            <md-card md-theme="red" flex>
                <md-card-content layout="row">
                    <div flex="nogrow" class="pr-16">
                        <i class="material-icons md-color-white large" style="color: white;">warning</i>
                    </div>
                    <div flex>
                        <span class="md-headline">@t('Well.. that\'s not how things work!')</span>
                        <p>
                            @t('Please double check your provided information. It seems something isn\'t right')
                            <br />
                            <span ng-repeat="warning in vm.warning">[[warning]]<br /></span>
                        </p>
                    </div>
                </md-card-content>
            </md-card>
        </div>
        <div flex-xs flex-gt-xs="100" layout="row" class="mb-16" ng-show="vm.completed == true">
            <md-card md-theme="green" flex>
                <md-card-content layout="row">
                    <div flex="nogrow" class="pr-16">
                        <i class="material-icons md-color-white large" style="color: white;">done_all</i>
                    </div>
                    <div flex>
                        <span class="md-headline">@t('Update completed!')</span>
                        <p>
                            @t('The new update has ben applied. The new version is now fully implemented.')
                        </p>
                    </div>
                </md-card-content>
            </md-card>
        </div>

        <div flex="100" layout="row">
            <md-card md-theme="default" flex="100">
                <md-card-content flex="100" layout="row" layout-wrap>
                    <div flex="100">
                        <h1>@t('Start system update')</h1>
                        <p>
                            @t('Alright, lets get the update started. In order to prevent server timeouts, the update process is split into several smaller parts.')
                            <br />
                            @t('Those parts are listed below. Please don\'t interrupt the update process.')
                            <br />
                            @t('An interrupted update process may crash the installation and result in data loss - so just don\'t do it!')
                        </p>
                    </div>
                    <div flex="100" flex-gt-xs="50" class="pt-16">
                        @t('You are currently running on version'):
                        <span class="pfa-label @if($currentVersion != $next){{'pfa-label-info'}}@else{{'pfa-label-success'}}@endif">{{$currentVersion}}</span>
                    </div>
                    <div flex="100" flex-gt-xs="50" class="pt-16" @if($currentVersion == $next){{'md-hidden'}}@endif>
                        @t('New postfixADM version'):
                        <span class="pfa-label pfa-label-success">{{$next}}</span>
                    </div>
                    <div flex="50" flex-xs="100" flex-sm="100" class="pt-16">
                        <span class="md-headline">@t('Current update status'):</span>
                        <br />
                        <md-list flex="100">

                            <md-divider></md-divider>
                            <md-list-item layout="row" class="pl-0 pr-0">
                                <p flex="nogrow" class="pr-8">
                                    <i ng-class="{'md-color-success':vm.step.connect == true}" class="material-icons">done_all</i>
                                </p>
                                <p flex>@t('Update server available and required patch files located')</p>
                            </md-list-item>

                            <md-divider></md-divider>
                            <md-list-item layout="row" class="pl-0 pr-0">
                                <p flex="nogrow" class="pr-8">
                                    <i ng-class="{'md-color-success':vm.step.download == true}" class="material-icons">done_all</i>
                                </p>
                                <p flex>@t('Patch files downloaded')</p>
                            </md-list-item>
                            <md-divider></md-divider>
                            <md-list-item layout="row" class="pl-0 pr-0">
                                <p flex="nogrow" class="pr-8">
                                    <i ng-class="{'md-color-success':vm.step.extract == true}" class="material-icons">done_all</i>
                                </p>
                                <p flex>@t('Patch files extracted')</p>
                            </md-list-item>
                            <md-divider></md-divider>
                            <md-list-item layout="row" class="pl-0 pr-0">
                                <p flex="nogrow" class="pr-8">
                                    <i ng-class="{'md-color-success':vm.step.applied == true}" class="material-icons">done_all</i>
                                </p>
                                <p flex>@t('Patch files applied')</p>
                            </md-list-item>
                            <md-divider></md-divider>
                            <md-list-item layout="row" class="pl-0 pr-0">
                                <p flex="nogrow" class="pr-8">
                                    <i ng-class="{'md-color-success':vm.step.migration == true}" class="material-icons">done_all</i>
                                </p>
                                <p flex>@t('Migration executed')</p>
                            </md-list-item>
                            <md-divider></md-divider>
                            <md-list-item layout="row" class="pl-0 pr-0">
                                <p flex="nogrow" class="pr-8">
                                    <i ng-class="{'md-color-success':vm.step.completed == true}" class="material-icons">done_all</i>
                                </p>
                                <p flex>@t('Update completed')</p>
                            </md-list-item>

                        </md-list>
                    </div>
                    <div flex="50" flex-xs="100" flex-sm="100" layout="row" layout-align="center center">
                        <div class="text-center" flex>
                            <md-button ng-disabled="vm.started" ng-click="vm.startUpdate()"  class="md-button md-primary md-raised m-8">@t('Start the update process')</md-button>
                        </div>
                    </div>
                </md-card-content>
            </md-card>
        </div>
    </md-content>
@endsection
