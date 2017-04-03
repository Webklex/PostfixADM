
<div flex>
    <h3 class="mb-0 mt-0">{{$title}}</h3>

    <div flex="100">
        <span class="md-button md-raised ml-0"
              ng-class="{'md-primary': vm.data.{{$section}}.{{$field}}.join.status == true}"
              ng-click="vm.data.{{$section}}.{{$field}}.join.status = true">@t('Join')</span>
        <span class="md-button md-raised"
              ng-class="{'md-primary': vm.data.{{$section}}.{{$field}}.join.status == false}"
              ng-click="vm.data.{{$section}}.{{$field}}.join.status = false">@t('Direct')</span>
        <div flex="100" ng-show="vm.data.{{$section}}.{{$field}}.join.status == true">
            <h4>@t('Verweis') [[vm.data.{{$section}}.{{$field}}.join.table]]</h4>

            <md-select ng-model="vm.data.{{$section}}.{{$field}}.column" placeholder="@t('Column')" flex="100">
                @foreach($matrix as $table)
                    <div ng-show="vm.data.{{$section}}.table == '{{$table["table"]}}'">
                        <md-option value="null-{{$table["table"]}}">@t('Create')</md-option>
                        @foreach($table['columns'] as $column)
                            <md-option value="{{$table["table"]}}${{$column}}">{{$column}}</md-option>
                        @endforeach
                    </div>
                @endforeach
            </md-select>

            <div flex="100" layout="row" ng-show="vm.data.{{$section}}.{{$field}}.column != null">
                <md-select ng-model="vm.data.{{$section}}.{{$field}}.join_key"
                           class="mt-0 mb-0"
                           ng-change="vm.data.{{$section}}.{{$field}}.join.table = vm.getTable(vm.data.{{$section}}.{{$field}}.join_key)"
                           placeholder="@t('Identifier')" flex>
                    @foreach($matrix as $table)
                        <md-optgroup label="{{$table['table']}}"
                                     ng-hide="vm.data.{{$section}}.table == '{{$table["table"]}}'">
                            @foreach($table['columns'] as $column)
                                <md-option value="{{$table["table"]}}${{$column}}">{{$column}}</md-option>
                            @endforeach
                        </md-optgroup>
                    @endforeach
                </md-select>
                @foreach($matrix as $table)
                    <md-select
                            class="mt-0 mb-0"
                            ng-show="vm.data.{{$section}}.{{$field}}.join.table == '{{$table["table"]}}'"
                            ng-model="vm.data.{{$section}}.{{$field}}.join_value" placeholder="@t('Value')" flex>
                            <md-optgroup label="{{$table['table']}}">
                                @foreach($table['columns'] as $column)
                                    <md-option value="{{$table["table"]}}${{$column}}">{{$column}}</md-option>
                                @endforeach
                            </md-optgroup>
                    </md-select>
                @endforeach
            </div>
        </div>
        <div flex="100" ng-show="vm.data.{{$section}}.{{$field}}.join.status == false">
            <h4>@t('Direkter Zugriff')</h4>
            <md-select ng-model="vm.data.{{$section}}.{{$field}}.column" placeholder="@t('Column')">
                @foreach($matrix as $table)
                    <div ng-show="vm.data.{{$section}}.table == '{{$table["table"]}}'">
                        <md-option value="null-{{$table["table"]}}">@t('Create')</md-option>
                        @foreach($table['columns'] as $column)
                            <md-option value="{{$table["table"]}}${{$column}}">{{$column}}</md-option>
                        @endforeach
                    </div>
                @endforeach
            </md-select>
        </div>
    </div>
</div>