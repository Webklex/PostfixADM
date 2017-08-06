
@extends('layout.app', [
    'scripts' => [
        '/assets/js/installer.min.js'
    ]
])


@section('content')
<md-content class="md-padding" layout-xs="column" layout="row" layout-align="center start"
            layout-wrap ng-controller="installerSetup as vm" ng-init="vm.parse('{{json_encode(old())}}')">

    @include('installer.header')

    @if($is_writable == false || $lock_writable == false || $is_writable_conf == false || $openssl == false || $doveadm == false)

        @if($is_writable == false || $lock_writable == false || $is_writable_conf == false)
            <div flex-xs flex-gt-xs="100" layout="row" class="mb-16">
                <md-card md-theme="red" flex>
                    <md-card-content layout="row">
                        <div flex="nogrow" class="pr-16">
                            <i class="material-icons md-color-white large" style="color: white;">warning</i>
                        </div>
                        <div flex>
                            <span class="md-headline">@t('File permissions incorrect')</span>
                            <p>
                                @t('Please make sure that the following files can be written by your www-data user: <b>.env</b>, <b>config/postfixadm.php</b> and <b>installer.lock</b>')
                                @if($is_writable == false)
                                    <br />
                                    @t('File path'): {{base_path().'/.env'}}
                                @endif
                                @if($lock_writable == false)
                                    <br />
                                    @t('File path'): {{base_path().'/installer.lock'}}
                                @endif
                                @if($is_writable_conf == false)
                                    <br />
                                    @t('File path'): {{base_path().'/config/postfixadm.php'}}
                                @endif
                            </p>
                        </div>
                    </md-card-content>
                </md-card>
            </div>
        @endif
        @if($openssl == false)
            <div flex-xs flex-gt-xs="100" layout="row" class="mb-16">
                <md-card md-theme="red" flex>
                    <md-card-content layout="row">
                        <div flex="nogrow" class="pr-16">
                            <i class="material-icons md-color-white large" style="color: white;">warning</i>
                        </div>
                        <div flex>
                            <span class="md-headline">@t('OpenSSL error')</span>
                            <p>
                                @t('It seems like your current system isn\'t supporting OpenSSL. Please make sure you have it up and running before you continue.')
                            </p>
                        </div>
                    </md-card-content>
                </md-card>
            </div>
        @endif
        @if($doveadm == false)
            <div flex-xs flex-gt-xs="100" layout="row" class="mb-16">
                <md-card md-theme="red" flex>
                    <md-card-content layout="row">
                        <div flex="nogrow" class="pr-16">
                            <i class="material-icons md-color-white large" style="color: white;">warning</i>
                        </div>
                        <div flex>
                            <span class="md-headline">@t('DoveADM error')</span>
                            <p>
                                @t('It seems like your current system isn\'t supporting doveadm. Please make sure you have it up and running before you continue.')
                                <br />
                                @t('Maybe you are missing one of the following packages: <b>doveadm</b> / <b>dovecot-core</b> / <b>dovecot-common</b>')
                            </p>
                        </div>
                    </md-card-content>
                </md-card>
            </div>
        @endif
    @else
        <div flex-xs flex-gt-xs="100" layout="row" class="mb-16">
            <md-card md-theme="green" flex>
                <md-card-content layout="row">
                    <div flex="nogrow" class="pr-16">
                        <i class="material-icons md-color-white large" style="color: white;">done_all</i>
                    </div>
                    <div flex>
                        <span class="md-headline">@t('Everything is ready. Lets get started!')</span>
                        <p>
                            @t('Everything has ben setup and prepared for you. You can now start the installation process')
                        </p>
                    </div>
                </md-card-content>
            </md-card>
        </div>
    @endif

    <div flex-xs flex-gt-xs="100" layout="row">
        <md-card md-theme="default" flex>
            <md-card-content>
                <span class="md-headline">@t('Start the PostfixADM installation process')</span>
                <p>
                    @t('This process will guide you through the next three installation steps.')
                    <br />
                    @t('A basic installation just takes a few minutes. It should be completed what so ever.')
                    <br />
                    @t('If you can\'t complete the setup for what ever reason, please make sure noone can reach your web root.')
                    <br />
                    <br />
                    @t('Joust in case you need any help or tips, take a look at the official documentations:')
                    <br />
                    <a target="_blank" href="https://github.com/Webklex/PostfixADM/wiki">Github Wiki</a>
                    <br />
                    <a target="_blank" href="https://wwww.postfixadm.com">postfixADM Helpdesk</a>
                </p>
            </md-card-content>

            <md-card-title>
                <md-card-title-text>
                </md-card-title-text>
            </md-card-title>
            <md-card-actions layout="row" layout-align="end center" class="p-16">
                @if(isset($is_writable))
                    @if($is_writable == false || $lock_writable == false || $is_writable_conf == false || $openssl == false)
                        <a class="md-button md-primary md-raised" href="#" disabled>@t('Start installation')</a>
                    @else
                        <a class="md-button md-primary md-raised md-primary" href="/installer/general">@t('Start installation')</a>
                    @endif
                @endif
            </md-card-actions>
        </md-card>
    </div>

</md-content>
@endsection
