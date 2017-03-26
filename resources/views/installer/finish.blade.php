
@extends('layout.app', [
    'scripts' => [
        '/assets/js/installer.min.js'
    ]
])


@section('content')
<md-content class="md-padding" layout="row" layout-align="center start"
            layout-wrap ng-controller="installerSetup as vm" ng-init="vm.parse('{{json_encode(old())}}')">

    @include('installer.header')

    @if($lock_failed == true)
        <div flex-xs flex-gt-xs="100" layout="row" class="mb-16">
            <md-card md-theme="red" flex>
                <md-card-content layout="row">
                    <div flex="nogrow" class="pr-16">
                        <i class="material-icons md-color-white large" style="color: white;">warning</i>
                    </div>
                    <div flex>
                        <span class="md-headline">@t('Datei besitzt keine Schreibrechte')</span>
                        <p>
                            @t('Bitte löschen Sie umgehen die Lock Datei <b>installer.lock</b> im root Verzeichnis der postfixADM-Installation.')
                            @t('Andernfalls können Sie sich nicht anmelden und keine Accounts verwalten.')
                            <br />
                            @t('Dateipfad'): {{base_path().'/installer.lock'}}
                        </p>
                    </div>
                </md-card-content>
            </md-card>
        </div>


        <div flex="100" class="pt-16" layout="row" layout-align="end center">
            <a class="md-button md-primary md-raised md-primary" href="/installer/finish">@t('Erneut versuchen')</a>
        </div>
    @else
        <div flex-xs flex-gt-xs="100" layout="row" class="mb-16">
            <md-card md-theme="green" flex>
                <md-card-content layout="row">
                    <div flex="nogrow" class="pr-16">
                        <i class="material-icons md-color-white large" style="color: white;">done_all</i>
                    </div>
                    <div flex>
                        <span class="md-headline">@t('Installation erfolgreich abgeschlossen')</span>
                        <p>
                            @t('Jetzt ist alles fertig eingerichtet. Nun können Sie sich anmelden und ihre ersten Adressen / Domains oder ALiase anlegen.')
                        </p>
                    </div>
                </md-card-content>
            </md-card>
        </div>

        <div layout="row" layout-align="center center" flex="100">
            <div flex="100" flex-xs="100" flex-gt-xs="75" flex-gt-sm="75" flex-md="50" flex-gt-md="50" flex-lg="35" flex-gt-lg="25" layout="row">

                <form role="form" name="authForm" autocomplete="off" novalidate method="POST" action="{{ route('login') }}" flex="100">
                    {{ csrf_field() }}
                    <md-card md-theme="default" flex="100">
                        <md-card-title>
                            <md-card-title-text>
                                <span class="md-headline">@t('Bitte anmelden')</span>
                                <span class="md-subhead"></span>
                            </md-card-title-text>
                        </md-card-title>
                        <md-card-content flex="100">

                            <md-input-container class="md-block">
                                <label>E-Mail Address</label>
                                <input id="email" type="email" ng-model="vm.email"
                                       name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <div role="alert"><div>{{ $errors->first('email') }}</div></div>
                                @endif
                            </md-input-container>

                            <md-input-container class="md-block">
                                <label>@t('Passwort')</label>
                                <input id="password" type="password" ng-model="password" minlength="3" name="password" required>
                            </md-input-container>


                        </md-card-content>
                        <md-card-actions layout="row" layout-align="end center">
                            <md-button type="submit">@t('Anmelden')</md-button>
                        </md-card-actions>
                    </md-card>
                </form>
            </div>
        </div>

    @endif

</md-content>
@endsection
