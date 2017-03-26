
@extends('layout.app', [
    'scripts' => [
        '/assets/js/installer.min.js'
    ]
])


@section('content')
<md-content class="md-padding" layout-xs="column" layout="row" layout-align="center start"
            layout-wrap ng-controller="installerSetup as vm" ng-init="vm.parse('{{json_encode(old())}}')">

    @include('installer.header')

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
    @endif

    @if(old('mysql_error'))
        <div flex-xs flex-gt-xs="100" layout="row" class="mb-16">
            <md-card md-theme="red" flex>
                <md-card-content layout="row">
                    <div flex="nogrow" class="pr-16">
                        <i class="material-icons md-color-white large" style="color: white;">warning</i>
                    </div>
                    <div flex>
                        <span class="md-headline">@t('Verbindungsfehler')</span>
                        <p>
                            @t('Achtung es konnte keine Verbindung zur angegebenen Datenbank hergestellt werden.')
                            @t('Bitte überprüfe deine Angaben noch einmal und versuche es erneut.')
                            <br />
                            @t('Fehlercode'): <b>{{old('mysql_error')}}</b>
                        </p>
                    </div>
                </md-card-content>
            </md-card>
        </div>
    @endif

    <form method="POST" action="/installer/general" flex="100" layout="row">
        {{ csrf_field() }}

        <div flex-xs flex-gt-xs="50" layout="row">
            <md-card md-theme="default" flex>
                <md-card-content>
                    <span class="md-headline">@t('Allgemeine Einstellungen')</span>
                    <md-list>

                        <md-divider></md-divider>

                        <md-list-item class="@if ($errors->has('APP_DEBUG')){{' has-error'}}@endif">
                            <p>@t('Debugmodus aktivieren')</p>
                            <md-checkbox class="md-secondary" name="APP_DEBUG" ng-model="vm.data.APP_DEBUG"
                                         ng-true-value="true" ng-false-value="false" ng-checked=""></md-checkbox>
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('APP_LOG_LEVEL')){{' has-error'}}@endif">
                            <p>@t('Anwendungsloglevel')</p>
                            <md-select placeholder="@t('Bitte wählen')"
                                       name="APP_LOG_LEVEL" ng-model="vm.data.APP_LOG_LEVEL" class="md-no-underline">
                                <md-option value="debug">Debug</md-option>
                                <md-option value="info">Info</md-option>
                                <md-option value="notice">Notice</md-option>
                                <md-option value="warning">Warning</md-option>
                                <md-option value="error">Error</md-option>
                                <md-option value="critical">Critical</md-option>
                                <md-option value="alert">Alert</md-option>
                                <md-option value="emergency">Emergency</md-option>
                            </md-select>
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('APP_URL')){{' has-error'}}@endif">
                            <p>@t('Anwendungsurl')</p>
                            <input type="text" ng-model="vm.data.APP_URL" name="APP_URL">
                        </md-list-item>

                        <md-divider></md-divider>
                    </md-list>
                </md-card-content>
                <md-card-content>
                    <span class="md-headline">@t('Datenbank Einstellungen')</span>
                    <md-list>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('DB_CONNECTION')){{' has-error'}}@endif">
                            <p>@t('Datenbanktreiber')</p>
                            <md-select placeholder="@t('Bitte wählen')"
                                       name="DB_CONNECTION" ng-model="vm.data.DB_CONNECTION" class="md-no-underline">
                                <md-option value="mysql">MySQL</md-option>
                            </md-select>
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if ($errors->has('DB_HOST')){{'md-color-red'}}@endif">
                            <p>@t('Datenbankserver')</p>
                            <input type="text" ng-model="vm.data.DB_HOST" name="DB_HOST">
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('DB_PORT')){{' has-error'}}@endif">
                            <p>@t('Port')</p>
                            <input type="text" ng-model="vm.data.DB_PORT" name="DB_PORT">
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('DB_DATABASE')){{' has-error'}}@endif">
                            <p>@t('Datenbank')</p>
                            <input type="text" ng-model="vm.data.DB_DATABASE" name="DB_DATABASE">
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('DB_USERNAME')){{' has-error'}}@endif">
                            <p>@t('Benutzer')</p>
                            <input type="text" ng-model="vm.data.DB_USERNAME" name="DB_USERNAME">
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('DB_PASSWORD')){{' has-error'}}@endif">
                            <p>@t('Passwort')</p>
                            <input type="text" ng-model="vm.data.DB_PASSWORD" name="DB_PASSWORD">
                        </md-list-item>

                    </md-list>
                </md-card-content>
            </md-card>
        </div>

        <div flex-xs flex-gt-xs="50" layout="row">
            <md-card md-theme="default" flex>
                <md-card-content>

                    <span class="md-headline">@t('Emaileinstellungen')</span>

                    <md-list>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('MAIL_DRIVER')){{' has-error'}}@endif">
                            <p>@t('Emailtreiber')</p>
                            <md-select placeholder="@t('Bitte wählen')"
                                       name="MAIL_DRIVER" ng-model="vm.data.MAIL_DRIVER" class="md-no-underline">
                                <md-option value="smtp">SMTP</md-option>
                            </md-select>
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('MAIL_HOST')){{' has-error'}}@endif">
                            <p>@t('Serveradresse')</p>
                            <input type="text" ng-model="vm.data.MAIL_HOST" name="MAIL_HOST">
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('MAIL_PORT')){{' has-error'}}@endif">
                            <p>@t('Port')</p>
                            <input type="text" ng-model="vm.data.MAIL_PORT" name="MAIL_PORT">
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('MAIL_USERNAME')){{' has-error'}}@endif">
                            <p>@t('Benutzername')</p>
                            <input type="text" ng-model="vm.data.MAIL_USERNAME" name="MAIL_USERNAME">
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('MAIL_PASSWORD')){{' has-error'}}@endif">
                            <p>@t('Passwort')</p>
                            <input type="password" ng-model="vm.data.MAIL_PASSWORD" name="MAIL_PASSWORD">
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('MAIL_ENCRYPTION')){{' has-error'}}@endif">
                            <p>@t('Verschlüsselung')</p>
                            <md-select placeholder="@t('Bitte wählen')"
                                       name="MAIL_ENCRYPTION" ng-model="vm.data.MAIL_ENCRYPTION" class="md-no-underline">
                                <md-option value="false">Keine</md-option>
                                <md-option value="ssl">SSL</md-option>
                                <md-option value="tls">TLS</md-option>
                            </md-select>
                        </md-list-item>

                        <md-divider></md-divider>
                    </md-list>
                </md-card-content>

                <md-card-title>
                    <md-card-title-text>
                    </md-card-title-text>
                </md-card-title>
                <md-card-actions layout="row" layout-align="end center" class="p-16">
                    <button class="md-button md-primary md-raised md-primary" href="">@t('Einstellungen übernehmen')</button>
                </md-card-actions>
            </md-card>
        </div>
    </form>

</md-content>
@endsection
