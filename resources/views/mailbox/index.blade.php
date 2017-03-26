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
                        <a href="/" title="@t('Zurück')">
                            <i class="material-icons md-color-default">arrow_back</i>
                        </a>
                    </h1>

                    <h1 class="md-title display-inline-block vertical-align-middle">
                        @t('Übersicht aller verfügbaren Mailboxen')
                    </h1>
                </md-card-title-text>
            </md-card-title>
            <md-card-content layout-wrap layout="row"  flex="100">

                @if($aMailbox->count() == 0)
                    <br />
                    <br />
                    <br />
                    <br />
                    <h1 class="md-headline text-center">
                        @t('Es wurden noch keine Mailboxen angelegt')
                    </h1>
                @else

                    <md-list ng-cloak  flex="100">

                        @foreach( $aMailbox as $mMailbox)
                                <md-divider></md-divider>
                            <md-list-item>
                                <p>{{$mMailbox->email}}</p>

                                <md-menu class="md-secondary">
                                    <md-button class="md-icon-button">
                                        <i class="material-icons md-color-default">toc</i>
                                    </md-button>
                                    <md-menu-content width="3">
                                        <md-menu-item>
                                            <a class="md-button" href="/mailbox/update/{{$mMailbox->id}}">@t('Bearbeiten')</a>
                                        </md-menu-item>
                                        <md-menu-item>
                                            <a class="md-button" href="/mailbox/delete/{{$mMailbox->id}}">@t('Löschen')</a>
                                        </md-menu-item>
                                    </md-menu-content>
                                </md-menu>
                            </md-list-item>
                        @endforeach

                    </md-list>

                    {{ $aMailbox->links() }}
                @endif

            </md-card-content>
        </md-card>

        <div layout="row" flex="100" layout-align="end center" md-theme="green">
            <a href="/mailbox/create" md-theme="green" class="md-button md-fab md-green" aria-label="@t('Neue anlegen')">
                <i class="material-icons md-white">add</i>
            </a>
        </div>
    </md-content>

@endsection
