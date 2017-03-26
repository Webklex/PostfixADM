

<div class="md-headline" layout="row">
    <div flex>@t('Mailboxmapping definieren')</div>
    <md-select ng-model="vm.data.mailbox.table" class="mt-0 mb-16" placeholder="@t('Tabelle')" flex>
        <md-option value="null">@t('Neu anlegen')</md-option>
        @foreach($matrix as $table)
            <md-option value="{{$table['table']}}">{{$table['table']}}</md-option>
        @endforeach
    </md-select>
</div>
<div flex="100" layout="row"  ng-show="vm.data.mailbox.table != 'null' && vm.data.mailbox.table != null">
    @include('installer.database-mapping-map', [
        'title'   => _t('Emailaddresse'),
        'matrix'  => $matrix,
        'field'   => 'email',
        'section' => 'mailbox',
    ])
    @include('installer.database-mapping-map', [
        'title'   => _t('Passwort'),
        'matrix'  => $matrix,
        'field'   => 'password',
        'section' => 'mailbox',
    ])
    @include('installer.database-mapping-map', [
        'title'   => _t('Quota KB'),
        'matrix'  => $matrix,
        'field'   => 'quota_kb',
        'section' => 'mailbox',
    ])
    @include('installer.database-mapping-map', [
        'title'   => _t('Aktiv Flag'),
        'matrix'  => $matrix,
        'field'   => 'active',
        'section' => 'mailbox',
    ])
    @include('installer.database-mapping-map', [
        'title'   => _t('Domain'),
        'matrix'  => $matrix,
        'field'   => 'domain',
        'section' => 'mailbox',
    ])
</div>
