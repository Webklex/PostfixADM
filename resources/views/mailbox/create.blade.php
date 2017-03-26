<?php
/*
 * File: create.blade.php
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
        '/assets/js/mailbox.min.js'
    ]
])

@section('content')
    <md-content class="md-padding" layout="row" layout-wrap layout-align="center center"
                ng-controller="mailboxCreate as vm" ng-init="vm.parse('{{$aDomain->toJson()}}')">
        <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="25" flex-gt-lg="10" layout="row">

            <form role="form" name="authForm" method="POST" action="/mailbox/create" novalidate autocomplete="off">
                {{ csrf_field() }}
                <input type="checkbox" name="active"
                       ng-value="vm.data.active"
                       ng-checked="vm.data.active"
                       ng-click="vm.data.active = !vm.data.active" class="display-none"/>

                <md-card md-theme="default">
                    <md-card-title>
                        <md-card-title-text>
                            <span class="md-headline display-inline-block vertical-align-middle">
                                <a href="/mailbox" title="@t('Zurück')" class="clickable">
                                    <i class="material-icons md-color-default">arrow_back</i>
                                </a>
                                @t('Mailbox erstellen')
                            </span>
                            <span class="md-subhead"></span>
                        </md-card-title-text>
                    </md-card-title>
                    <md-card-content layout-wrap layout="row">

                        <md-input-container flex="50">
                            <label>@t('Accountname')</label>
                            <input id="name" type="text" minlength="2" ng-model="vm.data.email"
                                   maxlength="100" name="email" value="{{ old('email') }}" required autofocus autocomplete="off">
                            @if ($errors->has('email'))
                                <div role="alert"><div>{{ $errors->first('email') }}</div></div>
                            @endif
                            <div ng-messages="authForm.email.$error" role="alert">
                                <div ng-message-exp="['required', 'minlength', 'maxlength']">
                                    @t('Der Name muss mindestens 2, aber nicht länger als 100 Zeichen sein')
                                </div>
                            </div>
                        </md-input-container>

                        <md-input-container flex="50">
                            <label>@t('Domain')</label>
                            <md-select name="domain_id" ng-model="vm.data.domain_id" required>
                                <md-option ng-repeat="domain in vm.domains track by $index" ng-value="domain.id">[[domain.name]]</md-option>
                            </md-select>
                            @if ($errors->has('domain_id'))
                                <div role="alert"><div>{{ $errors->first('domain_id') }}</div></div>
                            @endif
                        </md-input-container>

                        <md-input-container flex>
                            <label>@t('Passwort')</label>
                            <input id="password" type="password" minlength="5" ng-model="vm.data.password"
                                   minlength="100" name="password" value="" autocomplete="off">
                            @if ($errors->has('password'))
                                <div role="alert"><div>{{ $errors->first('password') }}</div></div>
                            @endif
                            <div ng-messages="authForm.name.$error" role="alert">
                                <div ng-message-exp="['required', 'minlength', 'maxlength']">
                                    @t('Das Passwort muss mindestens 5, aber nicht länger als 100 Zeichen sein')
                                </div>
                            </div>
                        </md-input-container>

                        <md-input-container flex>
                            <label>@t('Postfachgröße in MB')</label>
                            <input id="quota_kb" type="text" ng-model="vm.data.quota_kb"
                                   name="quota_kb" value="{{ old('quota_kb') }}" required autocomplete="off">
                            @if ($errors->has('quota_kb'))
                                <div role="alert"><div>{{ $errors->first('quota_kb') }}</div></div>
                            @endif
                        </md-input-container>

                    </md-card-content>
                    <md-card-actions layout="row" layout-align="end center">
                        <md-button type="submit">@t('Mailbox erstellen')</md-button>
                    </md-card-actions>
                </md-card>
            </form>
        </div>
    </md-content>

@endsection