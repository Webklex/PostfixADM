<?php
/*
 * File: 404.blade.php
 * Category: View
 * Author: MSG
 * Created: 26.03.17 06:36
 * Updated: -
 *
 * Description:
 *  -
 */


?>

@extends('layout.app')

@section('content')
    <md-content class="md-padding" layout="row" layout-wrap layout-align="center center">

        <md-card md-theme="default" flex="100">
            <md-card-title flex="100">
                <md-card-title-text flex="100" layout="row" layout-align="center center">

                    <div>
                        <h1 class="text-center mt-8">
                            <span class="md-headline" style="font-size: 72px;">@t('ERROR 404')</span>
                        </h1>
                        <span class="mt-16 text-center mb-background-white">
                            @t('..well sorry but this page doesn\'t exists. You might want to go somewhere else.')
                        </span>
                    </div>

                </md-card-title-text>
            </md-card-title>
            <md-card-content layout-wrap layout="row" flex="100" class="text-center mt-32" layout-align="center center">
                <a class="md-button md-primary md-raised md-primary" href="/redirect/back">@t('Back')</a>
            </md-card-content>
        </md-card>


    </md-content>

@endsection
