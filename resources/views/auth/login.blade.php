@extends('layout.app')

@section('content')
    <md-content class="md-padding" layout="row" layout-wrap layout-align="center center">
        <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="30" flex-gt-lg="30" layout="row">
            <form role="form" name="authForm" autocomplete="off" novalidate method="POST" action="{{ route('login') }}" flex>
                {{ csrf_field() }}
                <md-card md-theme="default">
                    <md-card-title>
                        <md-card-title-text>
                            <span class="md-headline">@t('Please login')</span>
                            <span class="md-subhead"></span>
                        </md-card-title-text>
                    </md-card-title>
                    <md-card-content>

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
    </md-content>

@endsection
