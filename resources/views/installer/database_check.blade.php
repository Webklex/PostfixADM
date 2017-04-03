
@extends('layout.app', [
    'scripts' => [
        '/assets/js/installer.min.js'
    ]
])


@section('content')
<md-content class="md-padding" layout-xs="column" layout="row" layout-align="center start"
            layout-wrap>

    @include('installer.header')

    @if($aError->count() > 0)
        <div flex-xs flex-gt-xs="100" layout="row" class="mb-16">
            <md-card md-theme="red" flex>
                <md-card-content layout="row">
                    <div flex="nogrow" class="pr-16">
                        <i class="material-icons md-color-white large" style="color: white;">warning</i>
                    </div>
                    <div flex>
                        <span class="md-headline">@t('Well.. that\'s not how things work!')</span>
                        <p>
                            @t('Please double check your provided information. It seems something isn\'t right')
                            @t('Die Datenbank gab folgende Fehlermeldungen zurück'):
                            @foreach($aError as $error)
                                <br />
                                {{$error}}
                            @endforeach
                        </p>
                    </div>
                </md-card-content>
            </md-card>
        </div>

        <div flex="100" class="pt-16" layout="row" layout-align="start center">
            <a class="md-button md-primary md-raised md-primary" href="/installer/database">@t('Retry')</a>
        </div>
    @else

        <div flex-xs flex-gt-xs="100" layout="row" class="mb-16">
            <md-card md-theme="green" flex>
                <md-card-content layout="row">
                    <div flex="nogrow" class="pr-16">
                        <i class="material-icons md-color-white large" style="color: white;">done_all</i>
                    </div>
                    <div flex>
                        <span class="md-headline">@t('Database mapping has ben approved')</span>
                        <p>
                            @t('The provided database mapping schema has ben approved and stored.')
                            @t('You can now continue and finish start the database migration process.')
                            @t('Please make sure you have a database backup in case something goes wrong.')
                        </p>
                    </div>
                </md-card-content>
            </md-card>
        </div>

        <div flex="100" class="pt-16" layout="row" layout-align="end center">
            <a class="md-button md-primary md-raised md-primary" href="/installer/service">@t('Finish migration')</a>
        </div>
    @endif

</md-content>
@endsection
