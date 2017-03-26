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
                            <span class="md-headline">@t('Ups.. so gehts nicht')</span>
                            <p>
                                @t('Bitte überprüfe deine Angaben noch einmal und versuche es erneut.')
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
                            <span class="md-headline">@t('Einstellungen erfolgreich gespeichert')</span>
                            <p>
                                @t('Die angegebenen Eisntellungen wurden gespeichert und werden nach dem nächsten Neuladen angewendet.')
                            </p>
                        </div>
                    </md-card-content>
                </md-card>
            </div>
        @endif

        <form role="form" name="authForm" method="POST" action="/settings" autocomplete="off" novalidate flex="100" layout="row">
            {{ csrf_field() }}
            <div flex-gt-sm="50" flex="100">
                <md-card md-theme="default" flex>
                    <md-card-title flex="100">
                        <md-card-title-text flex="100" layout="row" layout-align="start start">
                            <span class="md-headline">@t('Quota service aktivieren')</span>
                        </md-card-title-text>
                    </md-card-title>
                    <md-card-content layout-wrap layout="row"  flex="100">
                        <p>
                            @t('Der Quota service ermöglicht es Ihnen die aktuell Postfachgröße der einzelnen Mailboxen einzusehen, ohne auf deren Konten zu zu greifen.')
                            <br />
                            @t('Hierzu wird allerdings eine gewisse Fachkenntnis im Umgang mit Linuxdistributionen benötigt.')
                            <br />
                            <br />
                            @t('Eine anleitung kann hier gefunden werden'): <a target="_blank" href="https://wwww.github.com/webklex/postfixadm">Github Wiki</a>
                        </p>
                        <md-list flex="100">

                            <md-divider></md-divider>

                            <md-list-item class="@if ($errors->has('quota')){{' has-error'}}@endif">
                                <p>@t('Quota aktivieren')</p>
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
                            <span class="md-headline">@t('Sicherheisteinstellungen')</span>
                        </md-card-title-text>
                    </md-card-title>
                    <md-card-content layout-wrap layout="row"  flex="100">


                        <md-list flex="100">

                            <md-divider></md-divider>

                            <md-list-item class="@if ($errors->has('generate_new_quota')){{' has-error'}}@endif">
                                <p>@t('Token neu generieren')</p>
                                <input type="hidden" name="generate_new_quota" value="[[vm.data.quota.generate_new_quota]]" />
                                <md-checkbox class="md-secondary" ng-model="vm.data.quota.generate_new_quota"
                                             ng-true-value="true" ng-false-value="false"></md-checkbox>
                            </md-list-item>

                            <md-divider></md-divider>

                            <md-list-item class="@if ($errors->has('generate_new_ssl')){{' has-error'}}@endif">
                                <p>@t('SSL keys neu generieren')</p>
                                <input type="hidden" name="generate_new_ssl" value="[[vm.data.quota.generate_new_ssl]]" />
                                <md-checkbox class="md-secondary" ng-model="vm.data.quota.generate_new_ssl"
                                             ng-true-value="true" ng-false-value="false"></md-checkbox>
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
                                <p flex="nogrow">@t('Aktuelle Version'):</p>
                                <input type="text" value="{{$version}}" disabled flex>
                            </md-list-item>

                            <md-divider></md-divider>


                            <md-list-item layout="row" class="pr-0">
                                <p flex="nogrow">@t('Software Update'):</p>
                                <div flex></div>
                                <a href="/upgrade" class="md-button md-button-link mr-0" flex="nogrow">@t('Prüfen')</a>
                            </md-list-item>

                            <md-divider></md-divider>

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
