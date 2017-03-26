
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
                        <span class="md-headline">@t('Ups.. so gehts nicht')</span>
                        <p>
                            @t('Bitte überprüfe deine Angaben noch einmal und versuche es erneut.')
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
            <a class="md-button md-primary md-raised md-primary" href="/installer/database">@t('Neu versuchen')</a>
        </div>
    @else

        <div flex-xs flex-gt-xs="100" layout="row" class="mb-16">
            <md-card md-theme="green" flex>
                <md-card-content layout="row">
                    <div flex="nogrow" class="pr-16">
                        <i class="material-icons md-color-white large" style="color: white;">done_all</i>
                    </div>
                    <div flex>
                        <span class="md-headline">@t('Datenbankmapping erfolgreich geprüft')</span>
                        <p>
                            @t('Das von Ihnen angegebene Datenbankmapping wurde erfolgreich geprüft.')
                            @t('Jetzt können Sie die Installation abschließen und mit der Datenmigration beginnen.')
                            @t('Bitte achten Sie darauf ein Datenbackup für den Fall der Fälle bereit zu halten.')
                        </p>
                    </div>
                </md-card-content>
            </md-card>
        </div>

        <div flex="100" class="pt-16" layout="row" layout-align="end center">
            <a class="md-button md-primary md-raised md-primary" href="/installer/service">@t('Migration abschließen')</a>
        </div>
    @endif

</md-content>
@endsection
