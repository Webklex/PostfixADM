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
        '/assets/js/alias.min.js'
    ]
])

@section('content')
    <md-content class="md-padding" layout-xs="column" layout="row" layout-wrap layout-align="center center"
                ng-controller="aliasUpdate as vm" ng-init="vm.parse('{{$mAlias->toJson()}}' , '{{$aDomain->toJson()}}')">
        <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="25" flex-gt-lg="10" layout="row">

            <a href="/alias" title="Zurück">
                <i class="material-icons md-color-default">arrow_back</i>
            </a>

            <form role="form" name="authForm" method="POST" action="/alias/update/{{$mAlias->id}}" autocomplete="off">
                {{ csrf_field() }}
                <input type="checkbox" name="active"
                       ng-value="vm.data.active"
                       ng-checked="vm.data.active"
                       ng-click="vm.data.active = !vm.data.active" class="display-none"/>

                <md-card md-theme="default">
                    <md-card-title>
                        <md-card-title-text>
                            <span class="md-headline">Alias aktualisieren</span>
                            <span class="md-subhead"></span>
                        </md-card-title-text>
                    </md-card-title>
                    <md-card-content layout-wrap layout="row">

                        <md-input-container flex="50">
                            <label>Quelladresse</label>
                            <input id="source" type="text" minlength="5" ng-model="vm.data.source"
                                   maxlength="100" name="source" value="{{ getCurrent($mAlias, 'source') }}" required autofocus autocomplete="off">
                            @if ($errors->has('source'))
                                <div role="alert"><div>{{ $errors->first('emasourceil') }}</div></div>
                            @endif
                            <div ng-messages="authForm.source.$error" role="alert">
                                <div ng-message-exp="['required', 'minlength', 'maxlength']">
                                    Your name must be between 5 and 100 characters long and look like an e-mail address.
                                </div>
                            </div>
                        </md-input-container>


                        <md-input-container flex="50">
                            <label>Domain</label>
                            <md-select name="domain_id" ng-model="vm.data.domain_id" required>
                                <md-option ng-repeat="domain in vm.domains track by $index" ng-value="domain.id">[[domain.name]]</md-option>
                            </md-select>
                            @if ($errors->has('domain_id'))
                                <div role="alert"><div>{{ $errors->first('domain_id') }}</div></div>
                            @endif
                        </md-input-container>

                        <md-input-container flex="100" ng-repeat="destination in vm.data.destination track by $index">
                            <label>Zieladressen</label>
                            <input id="destination_[[$index]]" type="text" ng-model="destination"
                                   name="destination[]" value="" required autocomplete="off">
                            <md-icon class="material-icons md-color-default" style="display:inline-block;" ng-click="vm.removeAlias($index)">delete</md-icon>
                        </md-input-container>

                        <div flex="100">
                            <md-icon class="material-icons md-color-default" style="float: right; border: 1px solid #929292;" ng-click="vm.addAlias()">add</md-icon>
                        </div>

                        @if ($errors->has('destination'))
                            <div role="alert" flex><div>{{ $errors->first('destination') }}</div></div>
                        @endif

                    </md-card-content>
                    <md-card-actions layout="row" layout-align="end center">
                        <md-button type="submit">Alias aktualisieren</md-button>
                    </md-card-actions>
                </md-card>
            </form>
        </div>
    </md-content>

@endsection


