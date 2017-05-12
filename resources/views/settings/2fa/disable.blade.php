<?php
/*
 * File: index.blade.php
 * Category: View
 * Author: MSG
 * Created: 11.03.17 14:08
 * Updated: -
 *
 * Description:
 *  -
 */


?>

@extends('layout.app', [
    'scripts' => [
        '/assets/js/installer.min.js'
    ]
])

@section('content')
    <md-content class="md-padding" layout-xs="column" layout="row" layout-align="center start" layout-wrap>


        <div flex-xs flex-gt-xs="100" layout="row" class="mb-16">
            <md-card md-theme="red" flex>
                <md-card-content layout="row" layout-align="start center">
                    <div flex="nogrow" class="pr-16">
                        <i class="material-icons md-color-white large" style="color: white;">warning</i>
                    </div>
                    <div flex>
                        <span class="md-headline">@t('Google 2FA authentication disabled')</span>
                    </div>
                </md-card-content>
            </md-card>
        </div>

        <div flex-xs flex-gt-xs="100" layout="row" class="mt-16">
            <md-card md-theme="default" flex>
                <md-card-content layout-wrap layout="row" layout-align="start center" class="text-center" flex="100">
                    <h1 flex="100">@t('2FA has been removed')</h1>
                    <div flex="100">
                        @t('The 2FA authentication method has been removed.')
                    </div>
                    <div flex="100">
                        <br />
                        <a class="md-button md-primary md-raised m-8" href="/">@t('Return to the main page')</a>
                    </div>
                </md-card-content>
            </md-card>
        </div>
    </md-content>

@endsection
