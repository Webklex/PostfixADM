
@extends('layout.app')

@section('content')
<md-content class="md-padding" layout-xs="row" layout="row" layout-align="center center" layout-wrap>

    <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="50" flex-gt-lg="25" layout="column">
        <md-card md-theme="default" flex layout="column" style="min-height: 200px;">
            <md-card-title>
                <md-card-title-text>
                    <span class="md-headline">@t('Mailbox management')</span>
                    <span class="md-subhead">
                        @t('Manage all your available mailboxes. You can edit ord delete existing ones and if you like create some new as well.')
                    </span>
                </md-card-title-text>
            </md-card-title>
            <md-card-actions layout="row" layout-align="end center" class="pb-4 pr-16">
                <a class="md-button" href="/mailbox">@t('View all')</a>
                <a class="md-button" href="/mailbox/create">@t('Create new')</a>
            </md-card-actions>
        </md-card>
    </div>

    <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="50" flex-gt-lg="25" layout="column">
        <md-card md-theme="default" flex layout="column" style="min-height: 200px;">
            <md-card-title>
                <md-card-title-text>
                    <span class="md-headline">@t('Alias management')</span>
                    <span class="md-subhead">
                        @t('Manage all your available alias mailboxes. You can edit ord delete existing ones and if you like create some new as well.')
                    </span>
                </md-card-title-text>
            </md-card-title>
            <md-card-actions layout="row" layout-align="end center" class="pb-4 pr-16">
                <a class="md-button" href="/alias">@t('View all')</a>
                <a class="md-button" href="/alias/create">@t('Create new')</a>
            </md-card-actions>
        </md-card>
    </div>

    @if(isSuperUser() == true)


        <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="50" flex-gt-lg="25" layout="column">
            <md-card md-theme="default" flex layout="column" style="min-height: 200px;">
                <md-card-title>
                    <md-card-title-text>
                        <span class="md-headline">@t('Domain management')</span>
                        <span class="md-subhead">
                        @t('Manage all your available domains. You can edit ord delete existing ones and if you like create some new as well.')
                    </span>
                    </md-card-title-text>
                </md-card-title>
                <md-card-actions layout="row" layout-align="end center" class="pb-4 pr-16">
                    <a class="md-button" href="/domain">@t('View all')</a>
                    <a class="md-button" href="/domain/create">@t('Create new')</a>
                </md-card-actions>
            </md-card>
        </div>

        <div flex-xs flex-gt-xs="50" flex-gt-sm="50" flex-gt-md="50" flex-gt-lg="25" layout="column">
            <md-card md-theme="default" flex layout="column" style="min-height: 200px;">
                <md-card-title>
                    <md-card-title-text>
                        <span class="md-headline">@t('User managament')</span>
                        <span class="md-subhead">
                            @t('This is the place where you can manage all users.')
                        </span>
                    </md-card-title-text>
                </md-card-title>
                <md-card-actions layout="row" layout-align="end center" class="pb-4 pr-16">
                    <a class="md-button" href="/user">@t('View all')</a>
                    <a class="md-button" href="/user/create">@t('Create new')</a>
                </md-card-actions>
            </md-card>
        </div>
    @endif
</md-content>
@endsection
