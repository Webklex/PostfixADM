@extends('layout.app')

@section('content')
    <md-content class="md-padding" layout-xs="column" layout="row" layout-wrap layout-align="center center">
        <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="25" flex-gt-lg="10" layout="row">
            <form role="form" name="authForm" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <md-card md-theme="default">
                    <md-card-title>
                        <md-card-title-text>
                            <span class="md-headline">Bitte anmelden</span>
                            <span class="md-subhead"></span>
                        </md-card-title-text>
                    </md-card-title>
                    <md-card-content>

                            <md-input-container class="md-block">
                                <label>E-Mail Address</label>
                                <input id="email" type="email" ng-model="email" minlength="5" maxlength="100" ng-pattern="/^.+@.+\..+$/" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <div role="alert"><div>{{ $errors->first('email') }}</div></div>
                                @endif
                                <div ng-messages="authForm.email.$error" role="alert">
                                    <div ng-message-exp="['required', 'minlength', 'maxlength', 'pattern']">
                                        Your email must be between 5 and 100 characters long and look like an e-mail address.
                                    </div>
                                </div>
                            </md-input-container>

                            <md-input-container class="md-block">
                                <label>Password</label>
                                <input id="password" type="password" ng-model="password" minlength="3" name="password" required>
                                @if ($errors->has('password'))
                                    <div role="alert"><div>{{ $errors->first('password') }}</div></div>
                                @endif
                                <div ng-messages="authForm.password.$error" role="alert">
                                    <div ng-message-exp="['required', 'minlength']">
                                        Your password must be at least 3 characters long.
                                    </div>
                                </div>
                            </md-input-container>


                    </md-card-content>
                    <md-card-actions layout="row" layout-align="end center">
                        <md-button type="submit">Anmelden</md-button>
                    </md-card-actions>
                </md-card>
            </form>
        </div>
    </md-content>

@endsection
