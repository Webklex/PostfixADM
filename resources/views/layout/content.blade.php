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
                <md-card-content layout="row">
                    <div flex="nogrow" class="pr-16" layout-align="center center">
                        <a href="/">
                            <h1 class="pa-header-title md-display-2 m-1 hide-sm hide-xs show-gt-sm">
                                <div class="material-icons" style="color: white;">verified_user</div>
                                Postfix <span class="part-two">ADM</span>
                            </h1>
                            <h1 class="pa-header-title md-display-2 m-1 show-sm show-xs hide-gt-sm">
                                <div class="material-icons" style="color: white;">verified_user</div>
                                <span class="part-two">PFA</span>
                            </h1>
                        </a>
                    </div>
                    <div flex></div>
                    <div flex="nogrow" layout="row" layout-align="center center">

                        <md-menu class="pa-menu-right" md-position-mode="target-right target" flex>
                            <md-button aria-label="Open menu with custom trigger" class="md-icon-button" ng-mouseenter="$mdMenu.open()">
                                <i class="material-icons md-color-white">toc</i>
                            </md-button>
                            <md-menu-content width="3" ng-mouseleave="$mdMenu.close()">

                                <md-subheader class="md-no-sticky">@t('Sprache')</md-subheader>

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
                                    <md-menu-divider></md-menu-divider>
                                    <md-subheader class="md-no-sticky">@t('System')</md-subheader>
                                    <md-menu-item>
                                        <a href="/settings" class="md-button">
                                            @t('Settings')
                                        </a>
                                    </md-menu-item>
                                    <md-menu-divider></md-menu-divider>
                                    <md-menu-item>
                                        <a href="/update" class="md-button">
                                            @t('Update')
                                        </a>
                                    </md-menu-item>
                                    <md-menu-divider></md-menu-divider>
                                    <md-menu-item>
                                        <a href="/logout" class="md-button color-red">
                                            @t('Logout')
                                        </a>
                                    </md-menu-item>
                                @endif
                            </md-menu-content>
                        </md-menu>
                    </div>
                </md-card-content>
            </md-card>
        </div>
    </md-content>
</md-content>

<md-content class="md-padding pt-0" layout-xs="column" layout="column">
    @yield('content')
</md-content>
