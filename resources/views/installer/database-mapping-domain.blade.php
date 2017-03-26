

<div class="md-headline" layout="row">
    <div flex>@t('Domainmapping definieren')</div>
    <md-select ng-model="vm.data.domain.table" class="mt-0 mb-16" placeholder="@t('Tabelle')" flex>
        <md-option value="null">@t('Neu anlegen')</md-option>
        @foreach($matrix as $table)
            <md-option value="{{$table['table']}}">{{$table['table']}}</md-option>
        @endforeach
    </md-select>
</div>
<div flex="100" layout="row"  ng-show="vm.data.domain.table != 'null' && vm.data.domain.table != null">
    @include('installer.database-mapping-map', [
        'title'   => _t('Domainname'),
        'matrix'  => $matrix,
        'field'   => 'name',
        'section' => 'domain',
    ])
    @include('installer.database-mapping-map', [
        'title'   => _t('Aktiv Flag'),
        'matrix'  => $matrix,
        'field'   => 'active',
        'section' => 'domain',
    ])
</div>
