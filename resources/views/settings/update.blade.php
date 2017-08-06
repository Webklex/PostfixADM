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
    <md-content class="md-padding" layout-xs="column" layout="row" layout-align="center start"
                layout-wrap
                ng-controller="installerSetup as vm"
                ng-init="vm.parse('{{json_encode(array_merge(collect($config)->except("encryption")->toArray(), old()))}}')">


        @if($errors->count() > 0)
            <div flex-xs flex-gt-xs="100" layout="row" class="mb-16">
                <md-card md-theme="red" flex>
                    <md-card-content layout="row">
                        <div flex="nogrow" class="pr-16">
                            <i class="material-icons md-color-white large" style="color: white;">warning</i>
                        </div>
                        <div flex>
                            <span class="md-headline">@t('Well.. that\'s not how things work!')</span>
                            <p>
                                @t('Please double check your provided information. It seems something isn\'t right')
                            </p>
                        </div>
                    </md-card-content>
                </md-card>
            </div>
        @elseif(isset($updated))
            <div flex-xs flex-gt-xs="100" layout="row" class="mb-16">
                <md-card md-theme="green" flex>
                    <md-card-content layout="row">
                        <div flex="nogrow" class="pr-16">
                            <i class="material-icons md-color-white large" style="color: white;">done_all</i>
                        </div>
                        <div flex>
                            <span class="md-headline">@t('Settings successfully saved')</span>
                            <p>
                                @t('The provided settings have ben successfully saved and will be applied after the next reload.')
                            </p>
                        </div>
                    </md-card-content>
                </md-card>
            </div>
        @endif

        <form role="form" name="authForm" method="POST" action="/settings" autocomplete="off" novalidate flex="100" layout="row" layout-wrap>
            {{ csrf_field() }}
            <div flex-gt-sm="50" flex="100">
                <md-card md-theme="default" flex>
                    <md-card-title flex="100">
                        <md-card-title-text flex="100" layout="row" layout-align="start start">
                            <span class="md-headline">@t('Activate quota service')</span>
                        </md-card-title-text>
                    </md-card-title>
                    <md-card-content layout-wrap layout="row"  flex="100">
                        <p>
                            @t('The quota service is designed to receive the individual mailbox quota without having the mailbox password.')
                            <br />
                            @t('The setup requires some minor linux know-how.')
                            <br />
                            <br />
                            @t('Follow the link if you need further assistant'): <a target="_blank" href="https://github.com/Webklex/PostfixADM/wiki">Github Wiki</a>
                        </p>
                        <md-list flex="100">

                            <md-divider></md-divider>

                            <md-list-item class="@if ($errors->has('quota')){{' has-error'}}@endif">
                                <p>@t('Activate quota')</p>
                                <input type="hidden" name="quota" value="[[vm.data.quota.enabled]]" />
                                <md-checkbox class="md-secondary" ng-model="vm.data.quota.enabled"
                                             ng-true-value="true" ng-false-value="false"></md-checkbox>
                            </md-list-item>

                            <md-divider></md-divider>

                            <md-list-item class="@if($errors->has('quota_url')){{' has-error'}}@endif">
                                <p>@t('Socket')</p>
                                <input type="text" ng-model="vm.data.quota.url" name="quota_url">
                            </md-list-item>

                            <md-divider></md-divider>

                            <md-list-item class="@if($errors->has('quota_token')){{' has-error'}}@endif">
                                <p>@t('Token')</p>
                                <input type="text" ng-model="vm.data.quota.token" name="quota_token">
                            </md-list-item>

                        </md-list>

                    </md-card-content>
                </md-card>
            </div>
            <div flex-gt-sm="50" flex="100">
                <md-card md-theme="default" flex>
                    <md-card-title flex="100">
                        <md-card-title-text flex="100" layout="row" layout-align="start start">
                            <span class="md-headline">@t('Security options')</span>
                        </md-card-title-text>
                    </md-card-title>
                    <md-card-content layout-wrap layout="row"  flex="100">


                        <md-list flex="100">

                            <md-divider></md-divider>

                            <md-list-item class="@if ($errors->has('generate_new_quota')){{' has-error'}}@endif">
                                <p>@t('Renew service token')</p>
                                <input type="hidden" name="generate_new_quota" value="[[vm.data.quota.generate_new_quota]]" />
                                <md-checkbox class="md-secondary" ng-model="vm.data.quota.generate_new_quota"
                                             ng-true-value="true" ng-false-value="false"></md-checkbox>
                            </md-list-item>

                            <md-divider></md-divider>

                            <md-list-item class="@if ($errors->has('generate_new_ssl')){{' has-error'}}@endif">
                                <p>@t('Renew SSL key pair')</p>
                                <input type="hidden" name="generate_new_ssl" value="[[vm.data.quota.generate_new_ssl]]" />
                                <md-checkbox class="md-secondary" ng-model="vm.data.quota.generate_new_ssl"
                                             ng-true-value="true" ng-false-value="false"></md-checkbox>
                            </md-list-item>

                            <md-divider></md-divider>

                            <md-list-item class="@if($errors->has('encryption')){{' has-error'}}@endif">
                                <p>@t('Password encryption algorithm')</p>
                                <md-select placeholder="@t('Please choose')"
                                           name="encryption" ng-model="vm.data.encryption" class="md-no-underline">
                                    <md-option value="BLF-CRYPT">BLF-CRYPT</md-option>
                                    <md-option value="SHA512-CRYPT">SHA512-CRYPT</md-option>
                                    <md-option value="SHA256-CRYPT">SHA256-CRYPT</md-option>
                                    <md-option value="MD5-CRYPT">MD5-CRYPT</md-option>
                                    <md-option value="LANMAN">LANMAN</md-option>
                                    <md-option value="NTLM">NTLM</md-option>
                                    <md-option value="RPA">RPA</md-option>
                                    <md-option value="CRAM-MD5">CRAM-MD5</md-option>
                                    <md-option value="DIGEST-MD5">DIGEST-MD5</md-option>
                                    <md-option value="SCRAM-SHA-1">SCRAM-SHA-1</md-option>
                                    <md-option value="PLAIN">PLAIN</md-option>
                                    <md-option value="CRYPT">CRYPT</md-option>
                                    <md-option value="PLAIN-MD5">PLAIN-MD5</md-option>
                                    <md-option value="LDAP-MD5">LDAP-MD5</md-option>
                                    <md-option value="SMD5">SMD5</md-option>
                                    <md-option value="SHA">SHA</md-option>
                                    <md-option value="SSHA">SSHA</md-option>
                                    <md-option value="SHA256">SHA256</md-option>
                                    <md-option value="SSHA256">SSHA256</md-option>
                                    <md-option value="SHA512">SHA512</md-option>
                                    <md-option value="SSHA512">SSHA512</md-option>
                            </md-list-item>
                            <md-divider></md-divider>

                        </md-list>

                    </md-card-content>
                    <md-card-title flex="100">
                        <md-card-title-text flex="100" layout="row" layout-align="start start">
                            <span class="md-headline">@t('Version')</span>
                        </md-card-title-text>
                    </md-card-title>
                    <md-card-content layout-wrap layout="row"  flex="100">


                        <md-list flex="100">

                            <md-divider></md-divider>

                            <md-list-item layout="row">
                                <p flex="nogrow">@t('Current version'):</p>
                                <input type="text" value="{{$version}}" disabled flex>
                            </md-list-item>

                            <md-divider></md-divider>

                            {{--
                            <md-list-item layout="row" class="pr-0">
                                <p flex="nogrow">@t('Software update'):</p>
                                <div flex></div>
                                <a href="/update"  class="md-raised md-accent md-button mr-0" flex="nogrow">@t('Check')</a>
                            </md-list-item>

                            <md-divider></md-divider>
                            --}}

                        </md-list>

                    </md-card-content>

                    <md-card-actions layout="row" layout-align="end center" class="pt-16 pb-8 pr-8">
                        <button class="md-button md-primary md-raised md-primary">
                            @t('Einstellungen speichern')
                        </button>
                    </md-card-actions>
                </md-card>
            </div>
        </form>
    </md-content>

@endsection
