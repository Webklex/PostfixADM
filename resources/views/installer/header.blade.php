<?php
/*
 * File: header.blade.php
 * Category: View
 * Author: MSG
 * Created: 25.03.17 17:25
 * Updated: -
 *
 * Description:
 *  -
 */


?>


<div flex-xs flex-gt-xs="100" layout="row" class="mb-16">
    <div class="text-center" flex>
        <md-button class="md-fab md-primary" @if(!$aStep->has('general')){{'disabled'}}@endif aria-label="Use Android">
            <div class="pfa-color-white">1</div>
        </md-button>
        <span>@t('General settings')</span>
    </div>
    <div class="text-center" flex>
        <md-button class="md-fab md-primary" @if(!$aStep->has('database')){{'disabled'}}@endif aria-label="Use Android">
            <div class="pfa-color-white">2</div>
        </md-button>
        <span>@t('Database mapping')</span>
    </div>
    <div class="text-center" flex>
        <md-button class="md-fab md-primary" @if(!$aStep->has('completed')){{'disabled'}}@endif aria-label="Use Android">
            <div class="pfa-color-white">3</div>
        </md-button>
        <span>@t('Complete')</span>
    </div>
</div>
