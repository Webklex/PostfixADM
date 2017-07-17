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
                        @t('Index of all existing mailboxes')
                    </h1>
                </md-card-title-text>
            </md-card-title>
            <md-card-content layout-wrap layout="row"  flex="100">

                @if($aMailbox->count() == 0)
                    <h1 class="md-headline text-center mt-8" flex="100">
                        @t('You might want to create a mailbox first..')
                    </h1>
                @else

                    <md-list ng-cloak  flex="100">
                        <md-list-item layout="row" flex="100">
                            <div flex><i>@t('E-mail address')</i></div>
                            @if(config('postfixadm.quota.enabled') == true)
                                <div flex-xs="25" flex><i>@t('Mailbox size (MB)')</i></div>
                            @endif
                            <md-menu class="md-secondary" flex>
                                <md-button class="md-icon-button"></md-button>
                                <md-menu-content width="3">
                                </md-menu-content>
                            </md-menu>
                        </md-list-item>

                        @foreach( $aMailbox as $mMailbox)
                            <md-divider></md-divider>
                            <md-list-item layout="row" flex="100">
                                <div flex>{{$mMailbox->email}}</div>
                                @if(config('postfixadm.quota.enabled') == true)
                                    <div flex-xs="25" flex>
                                        @if($mMailbox->quota > 0 && $mMailbox->quota_kb > 0)

                                            <span class="hide-sm hide-xs show-gt-sm">
                                                {{$mMailbox->quota}}MB / {{$mMailbox->quota_kb}}MB
                                            </span>
                                            <?php
                                            $percent = ($mMailbox->quota / $mMailbox->quota_kb) * 100;
                                            ?>
                                            @if($percent >= 75)
                                                <md-progress-linear class="md-warn" value="{{$percent}}"></md-progress-linear>
                                            @elseif($percent > 50)
                                                <md-progress-linear class="md-primary" value="{{$percent}}"></md-progress-linear>
                                            @else
                                                <md-progress-linear class="md-accent" value="{{$percent}}"></md-progress-linear>
                                            @endif
                                        @else
                                            <span class="hide-sm hide-xs show-gt-sm">
                                                {{$mMailbox->quota}}MB / {{$mMailbox->quota_kb}}MB
                                            </span>
                                            <md-progress-linear class="md-accent"></md-progress-linear>
                                        @endif
                                    </div>
                                @endif


                                <md-menu class="md-secondary" flex>
                                    <md-button class="md-icon-button">
                                        <i class="material-icons md-color-default">toc</i>
                                    </md-button>
                                    <md-menu-content width="3">
                                        <md-menu-item>
                                            <a class="md-button" href="/mailbox/update/{{$mMailbox->id}}">@t('Edit')</a>
                                        </md-menu-item>
                                        <md-menu-item>
                                            <a class="md-button" href="/mailbox/delete/{{$mMailbox->id}}">@t('Delete')</a>
                                        </md-menu-item>
                                    </md-menu-content>
                                </md-menu>
                            </md-list-item>
                        @endforeach
                        <md-divider></md-divider>

                    </md-list>

                    {{ $aMailbox->links() }}
                @endif

            </md-card-content>
        </md-card>

        <div layout="row" flex="100" layout-align="end center" md-theme="green">
            <a href="/mailbox/create" md-theme="green" class="md-button md-fab md-green" aria-label="@t('Create new')">
                <i class="material-icons md-white">add</i>
            </a>
        </div>
    </md-content>

@endsection
