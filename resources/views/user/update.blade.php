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
    <md-content class="md-padding" layout="row" layout-wrap layout-align="center center" flex="100"
                ng-controller="userUpdate as vm" ng-init="vm.parse('{{$mUser->toJson()}}', '{{$aDomain->toJson()}}', '{{ csrf_token()}}')">

        <div flex="100" flex-gt-xs="75" flex-gt-md="50" flex-gt-lg="25" layout="row">

            <form role="form" name="authForm" method="POST" action="/user/update/{{$mUser->id}}" autocomplete="off" novalidate flex="100">
                {{ csrf_field() }}
                <input type="checkbox" name="super_user"
                       ng-value="vm.data.super_user"
                       ng-checked="vm.data.super_user"
                       ng-click="vm.data.super_user = !vm.data.super_user" class="display-none"/>

                <md-card md-theme="default">
                    <md-card-title>
                        <md-card-title-text>
                            <h1 class="display-inline-block vertical-align-middle">
                                <a href="/redirect/back" title="@t('Back')" class="clickable">
                                    <i class="material-icons md-color-default">arrow_back</i>
                                </a>
                                @t('Update user')
                            </h1>
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
                                    @t('The provided name has to be at least 2 characters long.')
                                </div>
                            </div>
                        </md-input-container>
                        <md-input-container class="md-block">
                            <label>@t('E-Mail address')</label>
                            <input id="name" type="text" minlength="5" ng-model="vm.data.email"
                                   maxlength="100" name="email" value="{{ getCurrent($mUser, 'email') }}" required autofocus autocomplete="off">
                            @if ($errors->has('email'))
                                <div role="alert"><div>{{ $errors->first('email') }}</div></div>
                            @endif
                            <div ng-messages="authForm.email.$error" role="alert">
                                <div ng-message-exp="['required', 'minlength', 'maxlength']">
                                    @t('The provided E-Mail address has to be a valid email address')
                                </div>
                            </div>
                        </md-input-container>

                        <md-input-container class="md-block">
                            <label>@t('Password')</label>
                            <input id="password" type="password" minlength="5" ng-model="vm.data.password"
                                   minlength="100" name="password" value="" autocomplete="off">
                            @if ($errors->has('password'))
                                <div role="alert"><div>{{ $errors->first('password') }}</div></div>
                            @endif
                            <div ng-messages="authForm.name.$error" role="alert">
                                <div ng-message-exp="['minlength', 'maxlength']">
                                    @t('The provides password has to be at least 5 characters long.')
                                </div>
                            </div>
                        </md-input-container>

                        <md-input-container class="md-block">
                            <md-checkbox ng-checked="vm.data.super_user" ng-click="vm.data.super_user = !vm.data.super_user">
                                @t('User is a super admin and has almighty power')
                            </md-checkbox>
                            @if ($errors->has('super_user'))
                                <div role="alert"><div>{{ $errors->first('super_user') }}</div></div>
                            @endif
                        </md-input-container>

                    </md-card-content>
                    <md-card-actions layout="row" layout-align="end center">
                        <md-button type="submit" class="md-raised md-primary mai-8">@t('Update user')</md-button>
                    </md-card-actions>
                </md-card>
            </form>
        </div>
        <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="25" flex-gt-lg="10" layout="row">

            <md-card md-theme="default" flex>
                <md-card-title>
                    <md-card-title-text>
                            <span class="md-headline display-inline-block vertical-align-middle">
                                @t('Restrict domain access')
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


