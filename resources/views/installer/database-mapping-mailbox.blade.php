

<div class="md-headline" layout="row">
    <div flex>@t('Mailbox mapping definition')</div>
    <md-select ng-model="vm.data.mailbox.table" class="mt-0 mb-16" placeholder="@t('Table')" flex>
        <md-option value="null">@t('Create')</md-option>
        @foreach($matrix as $table)
            <md-option value="{{$table['table']}}">{{$table['table']}}</md-option>
        @endforeach
    </md-select>
</div>
<div flex="100" layout="row"  ng-show="vm.data.mailbox.table != 'null' && vm.data.mailbox.table != null">
    @include('installer.database-mapping-map', [
        'title'   => _t('E-mail address'),
        'matrix'  => $matrix,
        'field'   => 'email',
        'section' => 'mailbox',
    ])
    @include('installer.database-mapping-map', [
        'title'   => _t('Password'),
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
        'title'   => _t('Active Flag'),
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
