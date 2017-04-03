
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
                        <span class="md-headline">@t('Well.. that\'s not how things work!')</span>
                        <p>
                            @t('Please double check your provided information. It seems something isn\'t right')
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
                        <span class="md-headline">@t('Connection failed')</span>
                        <p>
                            @t('Warning: The provided database could not be connected.')
                            @t('Please double check your provided information. It seems something isn\'t right')
                            <br />
                            @t('Error code'): <b>{{old('mysql_error')}}</b>
                        </p>
                    </div>
                </md-card-content>
            </md-card>
        </div>
    @endif

    @if(old('mail_error'))
        <div flex-xs flex-gt-xs="100" layout="row" class="mb-16">
            <md-card md-theme="red" flex>
                <md-card-content layout="row">
                    <div flex="nogrow" class="pr-16">
                        <i class="material-icons md-color-white large" style="color: white;">warning</i>
                    </div>
                    <div flex>
                        <span class="md-headline">@t('Connection failed')</span>
                        <p>
                            @t('Warning: The provided mail settings failed.')
                            @t('Please double check your provided information. It seems something isn\'t right')
                            <br />
                            @t('Error'): <b>{{old('mail_error')}}</b>
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
                    <span class="md-headline">@t('General settings')</span>
                    <md-list>

                        <md-divider></md-divider>

                        <md-list-item class="@if ($errors->has('APP_DEBUG')){{' has-error'}}@endif">
                            <p>@t('Activate dubug mode')</p>
                            <md-checkbox class="md-secondary" name="APP_DEBUG" ng-model="vm.data.APP_DEBUG"
                                         ng-true-value="true" ng-false-value="false" ng-checked=""></md-checkbox>
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('APP_LOG_LEVEL')){{' has-error'}}@endif">
                            <p>@t('App log level')</p>
                            <md-select placeholder="@t('Please choose')"
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

                        <md-list-item class="@if($errors->has('APP_URL')){{' has-error'}}@endif" layout="row">
                            <p flex>@t('App url')</p>
                            <input flex type="text" ng-model="vm.data.APP_URL" name="APP_URL">
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
                <md-card-content>
                    <span class="md-headline">@t('Database settings')</span>
                    <md-list>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('DB_CONNECTION')){{' has-error'}}@endif">
                            <p>@t('Database driver')</p>
                            <md-select placeholder="@t('Please choose')"
                                       name="DB_CONNECTION" ng-model="vm.data.DB_CONNECTION" class="md-no-underline">
                                <md-option value="mysql">MySQL</md-option>
                            </md-select>
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if ($errors->has('DB_HOST')){{'md-color-red'}}@endif" layout="row">
                            <p flex>@t('Database host')</p>
                            <input flex type="text" ng-model="vm.data.DB_HOST" name="DB_HOST">
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('DB_PORT')){{' has-error'}}@endif">
                            <p>@t('Port')</p>
                            <input type="text" ng-model="vm.data.DB_PORT" name="DB_PORT">
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('DB_DATABASE')){{' has-error'}}@endif">
                            <p>@t('Database')</p>
                            <input type="text" ng-model="vm.data.DB_DATABASE" name="DB_DATABASE">
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('DB_USERNAME')){{' has-error'}}@endif">
                            <p>@t('User')</p>
                            <input type="text" ng-model="vm.data.DB_USERNAME" name="DB_USERNAME">
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('DB_PASSWORD')){{' has-error'}}@endif">
                            <p>@t('Password')</p>
                            <input type="password" ng-model="vm.data.DB_PASSWORD" name="DB_PASSWORD">
                        </md-list-item>

                    </md-list>
                </md-card-content>
            </md-card>
        </div>

        <div flex-xs flex-gt-xs="50" layout="row">
            <md-card md-theme="default" flex>
                <md-card-content>

                    <span class="md-headline">@t('Email settings')</span>

                    <md-list>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('MAIL_DRIVER')){{' has-error'}}@endif">
                            <p>@t('Email driver')</p>
                            <md-select placeholder="@t('Please choose')"
                                       name="MAIL_DRIVER" ng-model="vm.data.MAIL_DRIVER" class="md-no-underline">
                                <md-option value="smtp">SMTP</md-option>
                            </md-select>
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('MAIL_HOST')){{' has-error'}}@endif">
                            <p>@t('Host')</p>
                            <input type="text" ng-model="vm.data.MAIL_HOST" name="MAIL_HOST">
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('MAIL_PORT')){{' has-error'}}@endif">
                            <p>@t('Port')</p>
                            <input type="text" ng-model="vm.data.MAIL_PORT" name="MAIL_PORT">
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('MAIL_FROM_NAME')){{' has-error'}}@endif" layout="row">
                            <p flex="nogrow">@t('Sender name')</p>
                            <input type="text" ng-model="vm.data.MAIL_FROM_NAME" name="MAIL_FROM_NAME" flex>
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('MAIL_FROM_ADDRESS')){{' has-error'}}@endif" layout="row">
                            <p flex="nogrow">@t('Sender address')</p>
                            <input type="text" ng-model="vm.data.MAIL_FROM_ADDRESS" name="MAIL_FROM_ADDRESS" flex>
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('MAIL_USERNAME')){{' has-error'}}@endif">
                            <p>@t('Username')</p>
                            <input type="text" ng-model="vm.data.MAIL_USERNAME" name="MAIL_USERNAME">
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('MAIL_PASSWORD')){{' has-error'}}@endif">
                            <p>@t('Password')</p>
                            <input type="password" ng-model="vm.data.MAIL_PASSWORD" name="MAIL_PASSWORD">
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('MAIL_ENCRYPTION')){{' has-error'}}@endif">
                            <p>@t('Encryption')</p>
                            <md-select placeholder="@t('Please choose')"
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
                    <button class="md-button md-primary md-raised md-primary" href="">@t('Apply settings')</button>
                </md-card-actions>
            </md-card>
        </div>
    </form>

</md-content>
@endsection
