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
    <md-content class="md-padding" layout="row" layout-wrap layout-align="center center" flex="100"
                ng-controller="mailboxUpdate as vm" ng-init="vm.parse('{{json_encode(array_merge($mMailbox->toArray(), ["quota" => $mMailbox->quota]))}}')">

        <div flex="100" flex-gt-xs="75" flex-gt-md="50" flex-gt-lg="25" layout="row">

            <form role="form" name="authForm" method="POST" action="/mailbox/update/{{$mMailbox->id}}" autocomplete="off" novalidate flex="100">
                {{ csrf_field() }}
                <input type="checkbox" name="active"
                       ng-value="vm.data.active"
                       ng-checked="vm.data.active"
                       ng-click="vm.data.active = !vm.data.active" class="display-none"/>

                <md-card md-theme="default">
                    <md-card-title>
                        <md-card-title-text>
                            <h1 class="display-inline-block vertical-align-middle">
                                <a href="/redirect/back" title="@t('Back')" class="clickable">
                                    <i class="material-icons md-color-default">arrow_back</i>
                                </a>
                                <b>{{$mMailbox->email}}</b> @t('update')
                            </h1>
                            <span class="md-subhead"></span>
                        </md-card-title-text>
                    </md-card-title>
                    <md-card-content>

                        @if(config('postfixadm.quota.enabled') == true)
                            <md-input-container class="md-block" layout="row">
                                <label>@t('Mailbox size (MB)')</label>

                                <div flex="100">
                                    @if($mMailbox->quota > 0 && $mMailbox->quota_kb > 0)
                                        <?php
                                        $percent = ($mMailbox->quota / $mMailbox->quota_kb) * 100;
                                        ?>
                                        @if($percent >= 75)
                                            <md-progress-linear class="md-warn" value="{{$percent}}"></md-progress-linear>
                                        @elseif($percent > 50)
                                            <md-progress-linear class="md-primary" value="{{$percent}}"></md-progress-linear>
                                        @else
                                            <md-progress-linear class="md-accent" value="{{$percent}}"></md-progress-linear>
                                        @endif
                                    @else
                                        <md-progress-linear class="md-accent" value="0"></md-progress-linear>
                                    @endif
                                </div>
                                <input id="quota_kb" type="text" ng-model="vm.data.quota_kb"
                                       name="quota_kb" value="{{ getCurrent($mMailbox, 'quota_kb') }}" required autocomplete="off">
                                @if ($errors->has('quota_kb'))
                                    <div role="alert"><div>{{ $errors->first('quota_kb') }}</div></div>
                                @endif
                            </md-input-container>
                        @endif

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
                            <md-checkbox ng-checked="vm.data.active" ng-click="vm.data.active = !vm.data.active">
                                @t('Mailbox is active and can be used')
                            </md-checkbox>
                            @if ($errors->has('active'))
                                <div role="alert"><div>{{ $errors->first('active') }}</div></div>
                            @endif
                        </md-input-container>

                    </md-card-content>
                    <md-card-actions layout="row" layout-align="end center">
                        <md-button type="submit" class="md-raised md-primary mai-8">@t('Update mailbox')</md-button>
                    </md-card-actions>
                </md-card>
            </form>
        </div>
    </md-content>

@endsection


