
@extends('layout.app', [
    'scripts' => [
        '/assets/js/installer.min.js'
    ]
])


@section('content')
<md-content class="md-padding" layout-xs="column" layout="row" layout-align="center start"
            layout-wrap ng-controller="installerSetup as vm" ng-init="vm.parse('{{json_encode(array_merge(["quota_token" => str_random(32)], old()))}}')">

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
    @else
        <div flex-xs flex-gt-xs="100" layout="row" class="mb-16">
            <md-card md-theme="green" flex>
                <md-card-content layout="row">
                    <div flex="nogrow" class="pr-16">
                        <i class="material-icons md-color-white large" style="color: white;">done_all</i>
                    </div>
                    <div flex>
                        <span class="md-headline">@t('Migration erfolgreich abgeschlossen')</span>
                        <p>
                            @t('Das wichtigste ist geschafft. Nun fehlen nur noch ein paar Kleinigkeiten und alles is fertig eingerichtet.')
                        </p>
                    </div>
                </md-card-content>
            </md-card>
        </div>
    @endif


    <form method="POST" action="/installer/service" flex="100" layout="row">

        {{ csrf_field() }}

        <div flex-xs flex-gt-xs="50" layout="row">
            <md-card md-theme="default" flex>
                <md-card-content>
                    <span class="md-headline">@t('Superadmin anlegen')</span>

                    <md-list>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('name')){{' has-error'}}@endif">
                            <p>@t('Name')</p>
                            <input type="text" ng-model="vm.data.name" name="name">
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('email')){{' has-error'}}@endif">
                            <p>@t('Emailadresse')</p>
                            <input type="text" ng-model="vm.data.email" name="email">
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('password')){{' has-error'}}@endif">
                            <p>@t('Passwort')</p>
                            <input type="password" ng-model="vm.data.password" name="password">
                        </md-list-item>

                    </md-list>
                </md-card-content>
            </md-card>
        </div>

        <div flex-xs flex-gt-xs="50" layout="row">
            <md-card md-theme="default" flex>
                <md-card-content>
                    <span class="md-headline">@t('Quota service aktivieren')</span>
                    <p>
                        @t('Der Quota service ermöglicht es Ihnen die aktuell Postfachgröße der einzelnen Mailboxen einzusehen, ohne auf deren Konten zu zu greifen.')
                        <br />
                        @t('Hierzu wird allerdings eine gewisse Fachkenntnis im Umgang mit Linuxdistributionen benötigt.')
                        <br />
                        <br />
                        @t('Eine anleitung kann hier gefunden werden'): <a target="_blank" href="https://wwww.github.com/webklex/postfixadm">Github Wiki</a>
                    </p>
                    <md-list>

                        <md-divider></md-divider>

                        <md-list-item class="@if ($errors->has('quota')){{' has-error'}}@endif">
                            <p>@t('Quota aktivieren')</p>
                            <input type="hidden" name="quota" value="[[vm.data.quota]]" />
                            <md-checkbox class="md-secondary" ng-model="vm.data.quota"
                                         ng-true-value="true" ng-false-value="false"></md-checkbox>
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('quota_url')){{' has-error'}}@endif">
                            <p>@t('Socket')</p>
                            <input type="text" ng-model="vm.data.quota_url" name="quota_url">
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('quota_token')){{' has-error'}}@endif">
                            <p>@t('Token')</p>
                            <input type="text" ng-model="vm.data.quota_token" name="quota_token">
                        </md-list-item>

                        <md-divider></md-divider>

                    </md-list>
                </md-card-content>

                <md-card-actions layout="row" layout-align="end center" class="p-16">
                    <button class="md-button md-primary md-raised md-primary"
                            ng-disabled="
                                vm.data.name       == null ||
                                vm.data.email      == null ||
                                vm.data.password   == null ||
                                vm.data.name       == ''   ||
                                vm.data.email      == ''   ||
                                vm.data.password   == ''   ||
                                (
                                    vm.data.password != null ? vm.data.password.length < 6 : false
                                )
                    ">
                        @t('Installation abschließen')
                    </button>
                </md-card-actions>
            </md-card>
        </div>
    </form>

</md-content>
@endsection
