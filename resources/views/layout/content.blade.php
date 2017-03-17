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

<section class="pa-header" layout="column" layout-align="start start" flex >
    <a href="/">
        <h1 class="pa-header-title md-display-4">Postfix <span class="part-two">ADM</span></h1>
    </a>

        <md-menu class="pa-menu-right" md-position-mode="target-right target">
            <md-button aria-label="Open menu with custom trigger" class="md-icon-button" ng-mouseenter="$mdMenu.open()">
                <i class="material-icons md-color-white">toc</i>
            </md-button>
            <md-menu-content width="3" ng-mouseleave="$mdMenu.close()">

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
                    <md-menu-item>
                        <a href="/logout" class="md-button">
                            @t('Abmelden')
                        </a>
                    </md-menu-item>
                @endif
            </md-menu-content>
        </md-menu>

</section>
<md-content class="md-padding" layout-xs="column" layout="column">
    @yield('content')
</md-content>
