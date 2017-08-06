
@extends('layout.app')

@section('content')
<md-content class="md-padding" layout-xs="column" layout="row" layout-wrap>

    <div flex="100" layout="row">
        <md-card md-theme="default" flex="100">
            <md-card-content flex="100" layout="row" layout-wrap>
                <div flex="100">
                    <h1>@t('System update')</h1>
                    <p>
                        @t('This updating tool is designed to make the system update as easy as possible.')
                        <br />
                        @t('Just in case something goes wrong during the update, you should always backup your files and database first.')
                    </p>
                </div>
                <div flex="100" flex-gt-xs="50">
                    @t('You are currently running on version'):
                    <span class="pfa-label @if($currentVersion != $nextVersion){{'pfa-label-info'}}@else{{'pfa-label-success'}}@endif">{{$currentVersion}}</span>
                </div>
                @if($currentVersion != $nextVersion && $nextVersion != null)
                    <div flex="100" flex-gt-xs="50" @if($currentVersion == $nextVersion){{'md-hidden'}}@endif>
                        @t('A new version is available'):
                        <span class="pfa-label pfa-label-success">{{$nextVersion}}</span>
                        <br />
                        <br />
                        <span class="md-headline">@t('Changelog'):</span>
                        <md-list flex="100">

                            @foreach($changelog as $log)
                                <md-divider></md-divider>
                                <md-list-item layout="row" class="pl-0 pr-0">
                                    <p flex="nogrow" class="pr-8">#<b>{{$log->num}}</b></p>
                                    <p flex>{{$log->description}}</p>
                                    <span flex="nogrow" class="pfa-label pfa-label-{{$log->type}}">{{$log->type}}</span>
                                </md-list-item>
                            @endforeach

                            <md-divider></md-divider>

                        </md-list>
                    </div>
                @endif
            </md-card-content>
            <md-card-actions layout="row" layout-align="end center">
                @if($currentVersion != $nextVersion && $nextVersion != null)
                    <a class="md-button md-primary md-raised mai-8" href="/update/start/{{$nextVersion}}">@t('Download files and start the update')</a>
                @endif
            </md-card-actions>
        </md-card>
    </div>
</md-content>
@endsection
