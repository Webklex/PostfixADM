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
        '/assets/js/installer.min.js'
    ]
])

@section('content')
    <md-content class="md-padding" layout-xs="column" layout="row" layout-wrap>

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
                                    <i class="material-icons md-color-success">done_all</i>
                                </p>
                                <p flex>Update server available and required patch files located</p>
                            </md-list-item>

                            <md-divider></md-divider>
                            <md-list-item layout="row" class="pl-0 pr-0">
                                <p flex="nogrow" class="pr-8">
                                    <i class="material-icons">done_all</i>
                                </p>
                                <p flex>Patch files downloaded</p>
                            </md-list-item>
                            <md-divider></md-divider>
                            <md-list-item layout="row" class="pl-0 pr-0">
                                <p flex="nogrow" class="pr-8">
                                    <i class="material-icons">done_all</i>
                                </p>
                                <p flex>Patch files extracted</p>
                            </md-list-item>
                            <md-divider></md-divider>
                            <md-list-item layout="row" class="pl-0 pr-0">
                                <p flex="nogrow" class="pr-8">
                                    <i class="material-icons">done_all</i>
                                </p>
                                <p flex>Patch files applied</p>
                            </md-list-item>
                            <md-divider></md-divider>
                            <md-list-item layout="row" class="pl-0 pr-0">
                                <p flex="nogrow" class="pr-8">
                                    <i class="material-icons">done_all</i>
                                </p>
                                <p flex>Migration executed</p>
                            </md-list-item>
                            <md-divider></md-divider>
                            <md-list-item layout="row" class="pl-0 pr-0">
                                <p flex="nogrow" class="pr-8">
                                    <i class="material-icons">done_all</i>
                                </p>
                                <p flex>Update completed</p>
                            </md-list-item>

                        </md-list>
                    </div>
                    <div flex="50" flex-xs="100" flex-sm="100" layout="row" layout-align="center center">
                        <div class="text-center" flex>
                            <a class="md-button md-primary md-raised m-8" href="/update/start/{{$next}}">@t('Start the update process')</a>
                        </div>
                    </div>
                </md-card-content>
            </md-card>
        </div>
    </md-content>
@endsection
