@extends('layout.app')

@section('content')
    <md-content class="md-padding" layout="row" layout-wrap layout-align="center center">
        <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="25" flex-gt-lg="10" layout="row">
            <form role="form" name="authForm" autocomplete="off" novalidate method="POST" action="/2fa/validate" flex>
                {{ csrf_field() }}
                <md-card md-theme="default">
                    <md-card-title>
                        <md-card-title-text>
                            <span class="md-headline">@t('Google 2FA authentication')</span>
                            <span class="md-subhead"></span>
                        </md-card-title-text>
                    </md-card-title>
                    <md-card-content>

                            <md-input-container class="md-block">
                                <label>@t('One-Time Password')</label>
                                <input id="number" type="number" ng-model="vm.totp"
                                       name="totp" required autofocus>
                                @if ($errors->has('totp'))
                                    <div role="alert"><div>{{ $errors->first('totp') }}</div></div>
                                @endif
                            </md-input-container>

                    </md-card-content>
                    <md-card-actions layout="row" layout-align="end center">
                        <md-button type="submit">@t('Login')</md-button>
                    </md-card-actions>
                </md-card>
            </form>
        </div>
    </md-content>

@endsection
