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

@extends('layout.app')

@section('content')
    <md-content class="md-padding" layout="row" layout-wrap layout-align="start start">

        <md-card md-theme="default" flex="100">
            <md-card-title flex="100">
                <md-card-title-text flex="100" layout="row" layout-align="start start">

                    <h1 class="md-title display-inline-block vertical-align-middle clickable" flex="nogrow">
                        <a href="/redirect/back" title="@t('Back')" class="clickable">
                            <i class="material-icons md-color-default">arrow_back</i>
                        </a>
                    </h1>

                    <h1 class="md-title display-inline-block vertical-align-middle">
                        @t('PostfixADM system log')
                    </h1>
                </md-card-title-text>
            </md-card-title>
            <md-card-content layout-wrap layout="row"  flex="100">

                @if($aLog->count() == 0)
                    <h1 class="md-headline text-center mt-8" flex="100">
                        @t('You might want to do something first')
                    </h1>
                @else

                    <md-list ng-cloak  flex="100">

                        @foreach( $aLog as $mLog)
                            <md-divider></md-divider>
                            <md-list-item layout="row">
                                <div flex>{{$mLog->message}}</div>
                                <div hide show-gt-xs flex="nogrow">{{$mLog->user->name}}</div>
                                <div hide show-gt-xs class="pl-8" flex="nogrow">{{$mLog->created_at}}</div>
                            </md-list-item>
                        @endforeach

                    </md-list>

                    {{ $aLog->links() }}
                @endif

            </md-card-content>
        </md-card>
    </md-content>

@endsection
