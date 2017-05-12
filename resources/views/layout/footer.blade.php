<?php
/*
 * File: footer.blade.php
 * Category: View
 * Author: MSG
 * Created: 11.03.17 00:49
 * Updated: -
 *
 * Description:
 *  -
 */


?>

<section class="pa-footer">
    PostfixADM - Copyright &copy; {{date('Y')}} by <a href="https://www.postfixadm.com" target="_blank">www.postfixadm.com</a>
</section>

<script type="text/javascript" src="/assets/js/vendors.min.js"></script>

<script type="text/javascript" src="/assets/js/app.js"></script>
<script type="text/javascript" src="/assets/js/generic.min.js"></script>


@if(isset($scripts))
    @foreach($scripts as $script)
        <script type="text/javascript" src="{{$script}}"></script>
    @endforeach
@endif