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
    <md-content class="md-padding" layout-xs="column" layout="row" layout-wrap layout-align="center center">
        <div flex>

            <h1 class="md-title display-inline-block vertical-align-middle clickable">
                <a href="/" title="@t('Zurück')">
                    <i class="material-icons md-color-default">arrow_back</i>
                </a>
            </h1>

            <h1 class="md-title display-inline-block vertical-align-middle">
                @t('Übersicht aller verfügbaren Aliase')
            </h1>

            <md-list ng-cloak>
                <md-divider></md-divider>

                @foreach( $aAlias as $mAlias)
                    <md-list-item>
                        <p>{{$mAlias->source}}</p>

                        <md-menu class="md-secondary">
                            <md-button class="md-icon-button">
                                <i class="material-icons md-color-default">toc</i>
                            </md-button>
                            <md-menu-content width="3">
                                <md-menu-item>
                                    <a class="md-button" href="/alias/update/{{$mAlias->id}}">@t('Bearbeiten')</a>
                                </md-menu-item>
                                <md-menu-item>
                                    <a class="md-button" href="/alias/delete/{{$mAlias->id}}">@t('Löschen')</a>
                                </md-menu-item>
                            </md-menu-content>
                        </md-menu>
                    </md-list-item>
                    <md-divider></md-divider>
                @endforeach

            </md-list>

            {{ $aAlias->links() }}
        </div>
    </md-content>

@endsection
