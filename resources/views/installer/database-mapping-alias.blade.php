

<div class="md-headline" layout="row">
    <div flex>@t('Alias mapping definition')</div>
    <md-select ng-model="vm.data.alias.table" class="mt-0 mb-16" placeholder="@t('Table')" flex>
        <md-option value="null">@t('Create')</md-option>
        @foreach($matrix as $table)
            <md-option value="{{$table['table']}}">{{$table['table']}}</md-option>
        @endforeach
    </md-select>
</div>
<div flex="100" layout="row"  ng-show="vm.data.alias.table != 'null' && vm.data.alias.table != null">
    @include('installer.database-mapping-map', [
        'title'   => _t('Source address'),
        'matrix'  => $matrix,
        'field'   => 'source',
        'section' => 'alias',
    ])
    @include('installer.database-mapping-map', [
        'title'   => _t('Target addresses'),
        'matrix'  => $matrix,
        'field'   => 'destination',
        'section' => 'alias',
    ])
    @include('installer.database-mapping-map', [
        'title'   => _t('Domain'),
        'matrix'  => $matrix,
        'field'   => 'domain',
        'section' => 'alias',
    ])
</div>
