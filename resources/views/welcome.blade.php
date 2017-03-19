
@extends('layout.app')

@section('content')
<md-content class="md-padding" layout-xs="column" layout="row" layout-wrap>

    <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="25" flex-gt-lg="25" layout="row">
        <md-card md-theme="default">
            <md-card-title>
                <md-card-title-text>
                    <span class="md-headline">@t('Mailboxen verwalten')</span>
                    <span class="md-subhead">
                        @t('Sehe alle deine verfügbaren Mailboxen ein, verwalte sie, füge neue hinzu, ändere oder lösche sie.')
                    </span>
                </md-card-title-text>
            </md-card-title>
            <md-card-actions layout="row" layout-align="end center">
                <a class="md-button" href="/mailbox">@t('Alle einsehen')</a>
                <a class="md-button" href="/mailbox/create">@t('Neue anlegen')</a>
            </md-card-actions>
        </md-card>
    </div>

    <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="25" flex-gt-lg="25" layout="row">
        <md-card md-theme="default">
            <md-card-title>
                <md-card-title-text>
                    <span class="md-headline">@t('Aliase verwalten')</span>
                    <span class="md-subhead">
                        @t('Sehe alle deine verfügbaren Mailboxen aliase ein, verwalte sie, füge neue hinzu, ändere oder lösche sie.')
                    </span>
                </md-card-title-text>
            </md-card-title>
            <md-card-actions layout="row" layout-align="end center">
                <a class="md-button" href="/alias">@t('Alle einsehen')</a>
                <a class="md-button" href="/alias/create">@t('Neue anlegen')</a>
            </md-card-actions>
        </md-card>
    </div>

    @if(isSuperUser() == true)


        <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="25" flex-gt-lg="25" layout="row">
            <md-card md-theme="default">
                <md-card-title>
                    <md-card-title-text>
                        <span class="md-headline">@t('Domains verwalten')</span>
                        <span class="md-subhead">
                        @t('Sehe alle deine verfügbaren Domains ein, verwalte sie, füge neue hinzu, ändere oder lösche sie.')
                    </span>
                    </md-card-title-text>
                </md-card-title>
                <md-card-actions layout="row" layout-align="end center">
                    <a class="md-button" href="/domain">@t('Alle einsehen')</a>
                    <a class="md-button" href="/domain/create">@t('Neue anlegen')</a>
                </md-card-actions>
            </md-card>
        </div>

        <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="25" flex-gt-lg="25" layout="row">
            <md-card md-theme="default" flex>
                <md-card-title>
                    <md-card-title-text>
                        <span class="md-headline">@t('Benutzer verwalten')</span>
                        <span class="md-subhead">
                            @t('Sehe alle Benutzer ein, verwalte sie, füge neue hinzu, ändere oder lösche sie.')
                        </span>
                    </md-card-title-text>
                </md-card-title>
                <md-card-actions layout="row" layout-align="end center">
                    <a class="md-button" href="/user">@t('Alle einsehen')</a>
                    <a class="md-button" href="/user/create">@t('Neue anlegen')</a>
                </md-card-actions>
            </md-card>
        </div>
    @endif
</md-content>
@endsection
