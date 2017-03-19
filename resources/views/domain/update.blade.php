<?php
/*
 * File: update.blade.php
 * Category: View
 * Author: MSG
 * Created: 11.03.17 14:09
 * Updated: -
 *
 * Description:
 *  -
 */


?>
@extends('layout.app', [
    'scripts' => [
        '/assets/js/domain.min.js'
    ]
])

@section('content')
    <md-content class="md-padding" layout-xs="column" layout="row" layout-wrap layout-align="center center"
                ng-controller="domainUpdate as vm" ng-init="vm.parse('{{$mDomain->toJson()}}')">
        <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="25" flex-gt-lg="10" layout="row">

            <form role="form" name="authForm" method="POST" action="/domain/update/{{$mDomain->id}}" autocomplete="off" novalidate>
                {{ csrf_field() }}
                <input type="checkbox" name="active"
                       ng-value="vm.data.active"
                       ng-checked="vm.data.active"
                       ng-click="vm.data.active = !vm.data.active" class="display-none"/>

                <md-card md-theme="default">
                    <md-card-title>
                        <md-card-title-text>
                            <span class="md-headline display-inline-block vertical-align-middle">
                                <a href="/domain" title="@t('Zurück')" class="clickable">
                                    <i class="material-icons md-color-default">arrow_back</i>
                                </a>
                                @t('Domain aktualisieren')
                            </span>
                            <span class="md-subhead"></span>
                        </md-card-title-text>
                    </md-card-title>
                    <md-card-content>

                        <md-input-container class="md-block">
                            <label>@t('Name der Domain')</label>
                            <input id="name" type="text" minlength="5" ng-model="vm.data.name"
                                   maxlength="100" name="name" value="{{ getCurrent($mDomain, 'name') }}" required autofocus>
                            @if ($errors->has('name'))
                                <div role="alert"><div>{{ $errors->first('name') }}</div></div>
                            @endif
                            <div ng-messages="authForm.name.$error" role="alert">
                                <div ng-message-exp="['required', 'minlength', 'maxlength']">
                                    @t('Der Name der Domain inklusive TLD muss mindestens 5 Zeichen lang sein.')
                                </div>
                            </div>
                        </md-input-container>

                        <md-input-container class="md-block">
                            <md-checkbox ng-checked="vm.data.active" ng-click="vm.data.active = !vm.data.active">
                                @t('Domain ist aktiv und kann verwendet werden')
                            </md-checkbox>
                            @if ($errors->has('active'))
                                <div role="alert"><div>{{ $errors->first('active') }}</div></div>
                            @endif
                        </md-input-container>

                    </md-card-content>
                    <md-card-actions layout="row" layout-align="end center">
                        <md-button type="submit">@t('Domain aktualisieren')</md-button>
                    </md-card-actions>
                </md-card>
            </form>
        </div>
    </md-content>

@endsection


