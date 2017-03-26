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
        '/assets/js/user.min.js'
    ]
])

@section('content')
    <md-content class="md-padding" layout="row" layout-wrap layout-align="center center"
                ng-controller="userUpdate as vm" ng-init="vm.parse('{{$mUser->toJson()}}', '{{$aDomain->toJson()}}', '{{ csrf_token()}}')">

        <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="25" flex-gt-lg="10" layout="row">

            <form role="form" name="authForm" method="POST" action="/user/update/{{$mUser->id}}" autocomplete="off" novalidate>
                {{ csrf_field() }}
                <input type="checkbox" name="super_user"
                       ng-value="vm.data.super_user"
                       ng-checked="vm.data.super_user"
                       ng-click="vm.data.super_user = !vm.data.super_user" class="display-none"/>

                <md-card md-theme="default">
                    <md-card-title>
                        <md-card-title-text>
                            <span class="md-headline display-inline-block vertical-align-middle">
                                <a href="/user" title="@t('Zurück')" class="clickable">
                                    <i class="material-icons md-color-default">arrow_back</i>
                                </a>
                                @t('Benutzer aktualisieren')
                            </span>
                            <span class="md-subhead"></span>
                        </md-card-title-text>
                    </md-card-title>
                    <md-card-content>

                        <md-input-container class="md-block">
                            <label>@t('Name')</label>
                            <input id="name" type="text" minlength="2" ng-model="vm.data.name"
                                   maxlength="100" name="name" value="{{ getCurrent($mUser, 'name') }}" required autofocus autocomplete="off">
                            @if ($errors->has('name'))
                                <div role="alert"><div>{{ $errors->first('name') }}</div></div>
                            @endif
                            <div ng-messages="authForm.name.$error" role="alert">
                                <div ng-message-exp="['required', 'minlength', 'maxlength']">
                                    @t('Der Name muss mindestens 2, aber nicht länger als 100 Zeichen sein')
                                </div>
                            </div>
                        </md-input-container>
                        <md-input-container class="md-block">
                            <label>@t('Emailadresse')</label>
                            <input id="name" type="text" minlength="5" ng-model="vm.data.email"
                                   maxlength="100" name="email" value="{{ getCurrent($mUser, 'email') }}" required autofocus autocomplete="off">
                            @if ($errors->has('email'))
                                <div role="alert"><div>{{ $errors->first('email') }}</div></div>
                            @endif
                            <div ng-messages="authForm.email.$error" role="alert">
                                <div ng-message-exp="['required', 'minlength', 'maxlength']">
                                    @t('Der Name muss mindestens 2, aber nicht länger als 100 Zeichen sein')
                                </div>
                            </div>
                        </md-input-container>

                        <md-input-container class="md-block">
                            <label>@t('Passwort')</label>
                            <input id="password" type="password" minlength="5" ng-model="vm.data.password"
                                   minlength="100" name="password" value="" autocomplete="off">
                            @if ($errors->has('password'))
                                <div role="alert"><div>{{ $errors->first('password') }}</div></div>
                            @endif
                            <div ng-messages="authForm.name.$error" role="alert">
                                <div ng-message-exp="['minlength', 'maxlength']">
                                    @t('Das Passwort muss mindestens 5, aber nicht länger als 100 Zeichen sein')
                                </div>
                            </div>
                        </md-input-container>

                        <md-input-container class="md-block">
                            <md-checkbox ng-checked="vm.data.super_user" ng-click="vm.data.super_user = !vm.data.super_user">
                                @t('Benutzer ist super Administrator.')
                            </md-checkbox>
                            @if ($errors->has('super_user'))
                                <div role="alert"><div>{{ $errors->first('super_user') }}</div></div>
                            @endif
                        </md-input-container>

                    </md-card-content>
                    <md-card-actions layout="row" layout-align="end center">
                        <md-button type="submit">@t('Benutzer aktualisieren')</md-button>
                    </md-card-actions>
                </md-card>
            </form>
        </div>
        <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="25" flex-gt-lg="10" layout="row">

            <md-card md-theme="default" flex>
                <md-card-title>
                    <md-card-title-text>
                            <span class="md-headline display-inline-block vertical-align-middle">
                                @t('Domain Zugriff beschränken')
                            </span>
                        <span class="md-subhead"></span>
                    </md-card-title-text>
                </md-card-title>
                <md-card-content>

                    <md-list>
                        <md-list-item ng-repeat="domain in vm.domains" ng-click="vm.toggle(domain)">
                            <p>[[domain.name]] </p>
                            <md-checkbox class="md-secondary" ng-model="domain.checked" ng-disabled="true"></md-checkbox>
                        </md-list-item>
                    </md-list>

                </md-card-content>
            </md-card>

        </div>
    </md-content>

@endsection


