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
            <md-card md-theme="green" flex>
                <md-card-content layout="row" layout-align="start center">
                    <div flex="nogrow" class="pr-16">
                        <i class="material-icons md-color-white large" style="color: white;">done_all</i>
                    </div>
                    <div flex>
                        <span class="md-headline">@t('Google 2FA authentication enabled')</span>
                    </div>
                </md-card-content>
            </md-card>
        </div>

        <div flex-xs flex-gt-xs="100" layout="row" class="mt-16">
            <md-card md-theme="default" flex>
                <md-card-content layout-wrap layout="row" layout-align="start center" class="text-center" flex="100">
                    <h1 flex="100">@t('Finish the 2FA setup')</h1>
                    <div flex="50">
                        @t('Open up your 2FA mobile app and scan the following QR barcode.')
                        <br />
                        @t('If your 2FA mobile app does not support QR barcodes, enter in the following number'):
                        <br />
                        <p>
                            <code>{{ $secret }}</code>
                        </p>
                    </div>
                    <div flex="50">
                        <img alt="Image of QR barcode" src="{{ $image }}" />
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
