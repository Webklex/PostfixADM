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
        '/assets/js/domain.min.js'
    ]
])

@section('content')
    <md-content class="md-padding" layout="row" layout-wrap layout-align="center center" flex="100"
                ng-controller="domainCreate as vm">
        <div flex="100" flex-gt-xs="75" flex-gt-md="50" flex-gt-lg="25" layout="row">

            <form role="form" name="authForm" method="POST" action="/domain/create" autocomplete="off" novalidate flex="100">
                {{ csrf_field() }}
                <md-card md-theme="default" flex="100">
                    <md-card-title>
                        <md-card-title-text>
                            <h1 class="display-inline-block vertical-align-middle">
                                <a href="/redirect/back" title="@t('Back')" class="clickable">
                                    <i class="material-icons md-color-default">arrow_back</i>
                                </a>
                                @t('Create new domain')
                            </h1>
                            <span class="md-subhead"></span>
                        </md-card-title-text>
                    </md-card-title>
                    <md-card-content flex="100">

                        <md-input-container class="md-block">
                            <label>Name der Domain</label>
                            <input id="name" type="text" ng-model="name" minlength="5" maxlength="100" name="name" value="{{ old('name') }}" required autofocus>
                            @if ($errors->has('name'))
                                <div role="alert"><div>{{ $errors->first('name') }}</div></div>
                            @endif
                            <div ng-messages="authForm.name.$error" role="alert">
                                <div ng-message-exp="['required', 'minlength', 'maxlength']">
                                    @t('The domain name has to include the .tld and contain more then 5 characters.')
                                </div>
                            </div>
                        </md-input-container>

                    </md-card-content>
                    <md-card-actions layout="row" layout-align="end center">
                        <md-button type="submit" class="md-raised md-primary mai-8">@t('Create domain')</md-button>
                    </md-card-actions>
                </md-card>
            </form>
        </div>
    </md-content>

@endsection

