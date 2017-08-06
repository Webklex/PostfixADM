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
    <md-content class="md-padding" layout="row" layout-wrap layout-align="center center">

        <div flex="100" flex-gt-xs="75" flex-gt-md="50" flex-gt-lg="25" layout="row">

            <form role="form" name="authForm" method="POST" action="/account" autocomplete="off" novalidate flex="100">
                {{ csrf_field() }}

                <md-card md-theme="default" flex="100">
                    <md-card-title>
                        <md-card-title-text>
                            <h1 class="display-inline-block vertical-align-middle">
                                <a href="/redirect/back" title="@t('Back')" class="clickable">
                                    <i class="material-icons md-color-default">arrow_back</i>
                                </a>
                                @t('Personal security settings')
                            </h1>
                            <span class="md-subhead"></span>
                        </md-card-title-text>
                    </md-card-title>
                    <md-card-content layout="row" layout-wrap>

                        <md-input-container class="md-block" flex-xs="100" flex="50">
                            <label>@t('Password')</label>
                            <input id="password" type="password" minlength="5" ng-model="vm.data.password"
                                   minlength="100" name="password" value="" autocomplete="off">
                            @if ($errors->has('password'))
                                <div role="alert"><div>{{ $errors->first('password') }}</div></div>
                            @endif
                            <div ng-messages="authForm.password.$error" role="alert">
                                <div ng-message-exp="['minlength', 'maxlength']">
                                    @t('The provides password has to be at least 5 characters long.')
                                </div>
                            </div>
                        </md-input-container>

                        <md-input-container class="md-block" flex-xs="100" flex="50">
                            <label>@t('Repeat password')</label>
                            <input id="password_two" type="password" minlength="5" ng-model="vm.data.password_two"
                                   minlength="100" name="password_two" value="" autocomplete="off">
                            @if ($errors->has('password_two'))
                                <div role="alert"><div>{{ $errors->first('password_two') }}</div></div>
                            @endif
                            <div ng-messages="authForm.password_two.$error" role="alert">
                                <div ng-message-exp="['minlength', 'maxlength']">
                                    @t('The provides password has to be at least 5 characters long.')
                                </div>
                            </div>
                        </md-input-container>

                    </md-card-content>
                    <md-card-actions layout="row" layout-align="end center">
                        @if (auth()->user()->google2fa_secret)
                            <a href="/settings/2fa/disable" class="md-button md-primary md-raised" flex="nogrow">@t('Disable 2FA')</a>
                        @else
                            <a href="/settings/2fa/enable" class="md-button md-accent md-raised" flex="nogrow">@t('Enable 2FA')</a>
                        @endif
                        <md-button type="submit" class="md-raised md-primary mai-8">@t('Apply changes')</md-button>
                    </md-card-actions>
                </md-card>
            </form>
        </div>
    </md-content>

@endsection


