<?php
/*
 * File: content.blade.php
 * Category: View
 * Author: MSG
 * Created: 11.03.17 00:49
 * Updated: -
 *
 * Description:
 *  -
 */


?>

<md-content class="pa-header md-padding pb-0 pt-0 md-content-auto-height" layout-xs="column" layout="column">
    <md-content class="md-padding pb-0 md-content-auto-height" layout-xs="column" layout="row">

        <div flex-xs flex-gt-xs="100" layout="row" class="mb-0">
            <md-card md-theme="blue" flex>
                <md-card-content layout="row" ng-controller="navigationController as nav">
                    <div flex="nogrow" class="pr-16" layout-align="center center">
                        <a href="/">
                            <h1 class="pa-header-title md-display-2 m-1 hide-sm hide-xs show-gt-sm">
                                <div class="material-icons" style="color: white;">verified_user</div>
                                Postfix <span class="part-two">ADM</span>
                            </h1>
                            <h1 class="pa-header-title md-display-2 m-1 show-sm show-xs hide-gt-sm mt-8 mb-0">
                                <div class="material-icons" style="color: white;">verified_user</div>
                                <span class="part-two">PFA</span>
                            </h1>
                        </a>
                    </div>
                    <div flex></div>
                    <div flex="nogrow" layout="row" layout-align="center center">

                        <div ng-click="nav.navigation.toggle()" class="pl-16 pr-16 clickable">
                            <i class="material-icons md-color-white">toc</i>
                        </div>
                    </div>
                </md-card-content>
            </md-card>
        </div>
    </md-content>
</md-content>

<md-content class="md-padding pt-0" layout-xs="column" layout="column">
    @yield('content')
</md-content>

<md-sidenav class="md-sidenav-right" md-component-id="main-side-navigation" md-whiteframe="4" style="max-height: 100%;">
    <div ng-controller="navigationController as nav">

        <md-content class="m-0 p-0" style="max-height: 100%;">
            <md-menu-content class="m-0 p-0" style="max-height: 100%;">

                <h3 flex="100">@t('Sprache')</h3>

                @if(app()->getLocale() != 'de')
                    <md-menu-item>
                        <a href="/language/de" class="md-button">
                            Deutsch
                        </a>
                    </md-menu-item>
                @else
                    <md-menu-item>
                        <a href="/language/en" class="md-button">
                            English
                        </a>
                    </md-menu-item>
                @endif


                @if(auth()->check())

                    <h3 flex="100">@t('Mailbox management')</h3>
                    <md-menu-divider></md-menu-divider>
                    <md-menu-item>
                        <a class="md-button" href="/mailbox">@t('View all')</a>
                    </md-menu-item>
                    <md-menu-divider></md-menu-divider>
                    <md-menu-item>
                        <a class="md-button" href="/mailbox/create">@t('Create new')</a>
                    </md-menu-item>

                    <h3 flex="100">@t('Alias management')</h3>
                    <md-menu-divider></md-menu-divider>
                    <md-menu-item>
                        <a class="md-button" href="/alias">@t('View all')</a>
                    </md-menu-item>
                    <md-menu-divider></md-menu-divider>
                    <md-menu-item>
                        <a class="md-button" href="/alias/create">@t('Create new')</a>
                    </md-menu-item>


                    @if(isSuperUser() == true)

                        <h3 flex="100">@t('Domain management')</h3>
                        <md-menu-divider></md-menu-divider>
                        <md-menu-item>
                            <a class="md-button" href="/domain">@t('View all')</a>
                        </md-menu-item>
                        <md-menu-divider></md-menu-divider>
                        <md-menu-item>
                            <a class="md-button" href="/domain/create">@t('Create new')</a>
                        </md-menu-item>

                        <h3 flex="100">@t('User management')</h3>
                        <md-menu-divider></md-menu-divider>
                        <md-menu-item>
                            <a class="md-button" href="/user">@t('View all')</a>
                        </md-menu-item>
                        <md-menu-divider></md-menu-divider>
                        <md-menu-item>
                            <a class="md-button" href="/user/create">@t('Create new')</a>
                        </md-menu-item>
                    @endif


                    <h3 flex="100">@t('System')</h3>
                    <md-menu-divider></md-menu-divider>
                    <md-menu-item>
                        <a href="/account" class="md-button">
                            @t('Account')
                        </a>
                    </md-menu-item>
                    @if(isSuperUser())
                        <md-menu-divider></md-menu-divider>
                        <md-menu-item>
                            <a href="/log" class="md-button">
                                @t('System log')
                            </a>
                        </md-menu-item>
                        <md-menu-divider></md-menu-divider>
                        <md-menu-item>
                            <a href="/settings" class="md-button">
                                @t('Settings')
                            </a>
                        </md-menu-item>
                        {{--
                        <md-menu-divider></md-menu-divider>
                        <md-menu-item>
                            <a href="/update" class="md-button">
                                @t('Update')
                            </a>
                        </md-menu-item>
                        --}}
                    @endif
                    <hr />
                    <md-menu-item>
                        <a href="/logout" class="md-button color-red">
                            @t('Logout')
                        </a>
                    </md-menu-item>
                @endif
            </md-menu-content>
        </md-content>
    </div>
</md-sidenav>
