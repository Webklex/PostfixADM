
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
                        <span class="md-headline">@t('Well.. that\'s not how things work!')</span>
                        <p>
                            @t('Please double check your provided information. It seems something isn\'t right')
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
                        <span class="md-headline">@t('Migration has ben successful')</span>
                        <p>
                            @t('The main installation process has ben completed. Lets head over to the next few settings')
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
                    <span class="md-headline">@t('Create a new super admin')</span>

                    <md-list>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('name')){{' has-error'}}@endif">
                            <p>@t('Name')</p>
                            <input type="text" ng-model="vm.data.name" name="name">
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('email')){{' has-error'}}@endif" layout="row">
                            <p flex="nogrow">@t('E-mail address')</p>
                            <input type="text" ng-model="vm.data.email" name="email" flex />
                        </md-list-item>

                        <md-divider></md-divider>

                        <md-list-item class="@if($errors->has('password')){{' has-error'}}@endif">
                            <p>@t('Password')</p>
                            <input type="password" ng-model="vm.data.password" name="password">
                        </md-list-item>

                    </md-list>
                </md-card-content>
            </md-card>
        </div>

        <div flex-xs flex-gt-xs="50" layout="row">
            <md-card md-theme="default" flex>
                <md-card-content>
                    <span class="md-headline">@t('Activate quota service')</span>
                    <p>
                        @t('The quota service is designed to receive the individual mailbox quota without having the mailbox password.')
                        <br />
                        @t('The setup requires some minor linux know-how.')
                        <br />
                        <br />
                        @t('Follow the link if you need further assistant'): <a target="_blank" href="https://wwww.github.com/webklex/postfixadm">Github Wiki</a>
                    </p>
                    <md-list>

                        <md-divider></md-divider>

                        <md-list-item class="@if ($errors->has('quota')){{' has-error'}}@endif">
                            <p>@t('Activate quota')</p>
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
                        @t('Complete installation')
                    </button>
                </md-card-actions>
            </md-card>
        </div>
    </form>

</md-content>
@endsection
