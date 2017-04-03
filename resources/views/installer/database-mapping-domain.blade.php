

<div class="md-headline" layout="row">
    <div flex>@t('Domain mapping definition')</div>
    <md-select ng-model="vm.data.domain.table" class="mt-0 mb-16" placeholder="@t('Table')" flex>
        <md-option value="null">@t('Create')</md-option>
        @foreach($matrix as $table)
            <md-option value="{{$table['table']}}">{{$table['table']}}</md-option>
        @endforeach
    </md-select>
</div>
<div flex="100" layout="row"  ng-show="vm.data.domain.table != 'null' && vm.data.domain.table != null">
    @include('installer.database-mapping-map', [
        'title'   => _t('Domain name'),
        'matrix'  => $matrix,
        'field'   => 'name',
        'section' => 'domain',
    ])
    @include('installer.database-mapping-map', [
        'title'   => _t('Active Flag'),
        'matrix'  => $matrix,
        'field'   => 'active',
        'section' => 'domain',
    ])
</div>
