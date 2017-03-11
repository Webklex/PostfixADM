
@extends('layout.app')

@section('content')
<md-content class="md-padding" layout-xs="column" layout="row" layout-wrap>

    <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="25" flex-gt-lg="25" layout="row">
        <md-card md-theme="default">
            <md-card-title>
                <md-card-title-text>
                    <span class="md-headline">Mailboxen verwalten</span>
                    <span class="md-subhead">Sehe alle deine verfügbaren Mailboxen ein, verwalte sie, füge neue hinzu, ändere oder lösche sie.</span>
                </md-card-title-text>
            </md-card-title>
            <md-card-actions layout="row" layout-align="end center">
                <a class="md-button" href="/mailbox">Alle einsehen</a>
                <a class="md-button" href="/mailbox/create">Neue anlegen</a>
            </md-card-actions>
        </md-card>
    </div>

    <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="25" flex-gt-lg="25" layout="row">
        <md-card md-theme="default">
            <md-card-title>
                <md-card-title-text>
                    <span class="md-headline">Domains verwalten</span>
                    <span class="md-subhead">Sehe alle deine verfügbaren Domains ein, verwalte sie, füge neue hinzu, ändere oder lösche sie.</span>
                </md-card-title-text>
            </md-card-title>
            <md-card-actions layout="row" layout-align="end center">
                <a class="md-button" href="/domain">Alle einsehen</a>
                <a class="md-button" href="/domain/create">Neue anlegen</a>
            </md-card-actions>
        </md-card>
    </div>

    <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="25" flex-gt-lg="25" layout="row">
        <md-card md-theme="default">
            <md-card-title>
                <md-card-title-text>
                    <span class="md-headline">Aliase verwalten</span>
                    <span class="md-subhead">Sehe alle deine verfügbaren Mailboxen aliase ein, verwalte sie, füge neue hinzu, ändere oder lösche sie.</span>
                </md-card-title-text>
            </md-card-title>
            <md-card-actions layout="row" layout-align="end center">
                <a class="md-button" href="/alias">Alle einsehen</a>
                <a class="md-button" href="/alias/create">Neue anlegen</a>
            </md-card-actions>
        </md-card>
    </div>

    @if(isSuperUser() == true)
        <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="25" flex-gt-lg="25" layout="row">
            <md-card md-theme="default">
                <md-card-title>
                    <md-card-title-text>
                        <span class="md-headline">Benutzer verwalten</span>
                        <span class="md-subhead">Sehe alle Benutzer ein, verwalte sie, füge neue hinzu, ändere oder lösche sie.</span>
                    </md-card-title-text>
                </md-card-title>
                <md-card-actions layout="row" layout-align="end center">
                    <a class="md-button" href="/user">Alle einsehen</a>
                    <a class="md-button" href="/user/create">Neue anlegen</a>
                </md-card-actions>
            </md-card>
        </div>
    @endif
</md-content>
@endsection
