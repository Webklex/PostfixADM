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
        '/assets/js/mailbox.min.js'
    ]
])

@section('content')
    <md-content class="md-padding" layout-xs="column" layout="row" layout-wrap layout-align="center center"
                ng-controller="mailboxUpdate as vm" ng-init="vm.parse('{{$mMailbox->toJson()}}')">
        <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="25" flex-gt-lg="10" layout="row">

            <a href="/mailbox" title="Zurück">
                <i class="material-icons md-color-default">arrow_back</i>
            </a>

            <form role="form" name="authForm" method="POST" action="/mailbox/update/{{$mMailbox->id}}" autocomplete="off">
                {{ csrf_field() }}
                <input type="checkbox" name="active"
                       ng-value="vm.data.active"
                       ng-checked="vm.data.active"
                       ng-click="vm.data.active = !vm.data.active" class="display-none"/>

                <md-card md-theme="default">
                    <md-card-title>
                        <md-card-title-text>
                            <span class="md-headline">Mailbox aktualisieren</span>
                            <span class="md-subhead"></span>
                        </md-card-title-text>
                    </md-card-title>
                    <md-card-content>

                        <md-input-container class="md-block">
                            <label>Emailadresse</label>
                            <input id="name" type="text" minlength="5" ng-model="vm.data.email"
                                   maxlength="100" name="email" value="{{ getCurrent($mMailbox, 'email') }}" required autofocus autocomplete="off">
                            @if ($errors->has('email'))
                                <div role="alert"><div>{{ $errors->first('email') }}</div></div>
                            @endif
                            <div ng-messages="authForm.email.$error" role="alert">
                                <div ng-message-exp="['required', 'minlength', 'maxlength']">
                                    Your name must be between 5 and 100 characters long and look like an e-mail address.
                                </div>
                            </div>
                        </md-input-container>

                        <md-input-container class="md-block">
                            <label>Postfachgröße in MB</label>
                            <input id="quota_kb" type="text" ng-model="vm.data.quota_kb"
                                   name="quota_kb" value="{{ getCurrent($mMailbox, 'quota_kb') }}" required autocomplete="off">
                            @if ($errors->has('quota_kb'))
                                <div role="alert"><div>{{ $errors->first('quota_kb') }}</div></div>
                            @endif
                        </md-input-container>

                        <md-input-container class="md-block">
                            <label>Passwort</label>
                            <input id="password" type="password" minlength="5" ng-model="vm.data.password"
                                   minlength="100" name="password" value="" autocomplete="off">
                            @if ($errors->has('password'))
                                <div role="alert"><div>{{ $errors->first('password') }}</div></div>
                            @endif
                            <div ng-messages="authForm.name.$error" role="alert">
                                <div ng-message-exp="['minlength', 'maxlength']">
                                    Your password must be at least 5 characters long.
                                </div>
                            </div>
                        </md-input-container>

                        <md-input-container class="md-block">
                            <md-checkbox ng-checked="vm.data.active" ng-click="vm.data.active = !vm.data.active">
                                Mailbox ist aktiv und kann verwendet werden
                            </md-checkbox>
                            @if ($errors->has('active'))
                                <div role="alert"><div>{{ $errors->first('active') }}</div></div>
                            @endif
                        </md-input-container>

                    </md-card-content>
                    <md-card-actions layout="row" layout-align="end center">
                        <md-button type="submit">Mailbox aktualisieren</md-button>
                    </md-card-actions>
                </md-card>
            </form>
        </div>
    </md-content>

@endsection


