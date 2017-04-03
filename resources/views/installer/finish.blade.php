
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
                        <span class="md-headline">@t('File permissions incorrect')</span>
                        <p>
                            @t('Please make sure that the following files can be written by your www-data user: <b>installer.lock</b>')
                            <br />
                            @t('File path'): {{base_path().'/installer.lock'}}
                        </p>
                    </div>
                </md-card-content>
            </md-card>
        </div>


        <div flex="100" class="pt-16" layout="row" layout-align="end center">
            <a class="md-button md-primary md-raised md-primary" href="/installer/finish">@t('Retry')</a>
        </div>
    @else
        <div flex-xs flex-gt-xs="100" layout="row" class="mb-16">
            <md-card md-theme="green" flex>
                <md-card-content layout="row">
                    <div flex="nogrow" class="pr-16">
                        <i class="material-icons md-color-white large" style="color: white;">done_all</i>
                    </div>
                    <div flex>
                        <span class="md-headline">@t('Installation has ben completed')</span>
                        <p>
                            @t('That\'s ben it. PostfixADM is now ready to use. Go ahead and creat your first Mailboxes.')
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
                                <span class="md-headline">@t('Please login')</span>
                                <span class="md-subhead"></span>
                            </md-card-title-text>
                        </md-card-title>
                        <md-card-content flex="100">

                            <md-input-container class="md-block">
                                <label>@t('E-Mail Address')</label>
                                <input id="email" type="email" ng-model="vm.email"
                                       name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <div role="alert"><div>{{ $errors->first('email') }}</div></div>
                                @endif
                            </md-input-container>

                            <md-input-container class="md-block">
                                <label>@t('Password')</label>
                                <input id="password" type="password" ng-model="password" minlength="3" name="password" required>
                            </md-input-container>


                        </md-card-content>
                        <md-card-actions layout="row" layout-align="end center">
                            <md-button type="submit">@t('Login')</md-button>
                        </md-card-actions>
                    </md-card>
                </form>
            </div>
        </div>

    @endif

</md-content>
@endsection
