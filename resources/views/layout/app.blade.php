<?php
/*
 * File: layout.blade.php
 * Category: View
 * Author: MSG
 * Created: 11.03.17 00:51
 * Updated: -
 *
 * Description:
 *  -
 */


?>
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

    @include('layout.header')

    <body ng-app="app" ng-cloak>
        <div class="wrapper">
            @include('layout.content')
        </div>
        @include('layout.footer')
    </body>
</html>
