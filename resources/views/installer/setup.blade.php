
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
                            <span class="md-headline">@t('Datei besitzt keine Schreibrechte')</span>
                            <p>
                                @t('Bitte überprüfe Sie die Berechtigungen der <b>.env</b>, der <b>config/postfixadm.php</b> und der <b>installer.lock</b> Datei im root Verzeichnis der postfixADM-Installation.')
                                @if($is_writable == false)
                                    <br />
                                    @t('Dateipfad'): {{base_path().'/.env'}}
                                @endif
                                @if($lock_writable == false)
                                    <br />
                                    @t('Dateipfad'): {{base_path().'/installer.lock'}}
                                @endif
                                @if($is_writable_conf == false)
                                    <br />
                                    @t('Dateipfad'): {{base_path().'/config/postfixadm.php'}}
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
                            <span class="md-headline">@t('OpenSSL Fehler')</span>
                            <p>
                                @t('Leider scheint ihr System kein OpenSSL zu unterstützen. Dies ist aber dringend notwendig, um einen sicheren Betrieb zu gewähren.')
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
                            <span class="md-headline">@t('DoveADM Fehler')</span>
                            <p>
                                @t('Leider scheint ihr System kein DoveADM zu unterstützen. Dies ist aber dringend notwendig, um einen sicheren Betrieb zu gewähren.')
                                <br />
                                @t('Eventuell fehlendes Paket: <b>doveadm</b> / <b>dovecot-core</b> / <b>dovecot-common</b>')
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
                        <span class="md-headline">@t('Alle soweit bereit')</span>
                        <p>
                            @t('Der Installation steht nun nichts mehr im Wege. Klicken Sie auf "Installation beginnen", um zu starten.')
                        </p>
                    </div>
                </md-card-content>
            </md-card>
        </div>
    @endif

    <div flex-xs flex-gt-xs="100" layout="row">
        <md-card md-theme="default" flex>
            <md-card-content>
                <span class="md-headline">@t('PostfixADM Installationsprozess starten')</span>
                <p>
                    @t('In den nächsten drei Schritten werden sie Stück für Stück durch die einzelnen Installationsprozesse geführt.')
                    <br />
                    @t('Die Basisinstallation dauert im Durchschnitt nur wenige Minuten. Er sollte in jedem Fall vollendet werden.')
                    <br />
                    @t('Sollte dies aus irgendwelchen Gründen nicht möglich sein, sollte diese Seite unter keinen Umständen öffentlich erreichbar sein.')
                    <br />
                    <br />
                    @t('Für Tipps zur Installation oder allgemein bekannten Problemen gehen Sie bitte auf eine der folgenden Seiten:')
                    <br />
                    <a target="_blank" href="https://wwww.github.com/webklex/postfixadm">Github Wiki</a>
                    <br />
                    <a target="_blank" href="https://wwww.postfixadm.com">postfixADM helpdesk</a>
                </p>
            </md-card-content>

            <md-card-title>
                <md-card-title-text>
                </md-card-title-text>
            </md-card-title>
            <md-card-actions layout="row" layout-align="end center" class="p-16">
                @if(isset($is_writable))
                    @if($is_writable == false || $lock_writable == false || $is_writable_conf == false || $openssl == false)
                        <a class="md-button md-primary md-raised" href="#" disabled>@t('Installation beginnen')</a>
                    @else
                        <a class="md-button md-primary md-raised md-primary" href="/installer/general">@t('Installation beginnen')</a>
                    @endif
                @endif
            </md-card-actions>
        </md-card>
    </div>

</md-content>
@endsection
