<div>
    @if($statu == 1)
    <div class="card-body">
        @include('include.alert-result')
        @if($updateLines)
        <form wire:submit.prevent="updateTask">
        @else
        <form wire:submit.prevent="storeTask({{ $Line->id }})">
        @endif
            <div class="card card-body">
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="companies_id">{{ __('general_content.task_type_trans_key') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tags"></i></span>
                            </div>
                            <select class="form-control" wire:click.prevent="ChangeTaskType()" wire:model.live="TaskType" name="TaskType" id="TaskType">
                                <option value="">{{ __('general_content.select_task_type_trans_key') }}</option>
                                <option value="TechCut">{{__('general_content.technical_cut_trans_key') }}</option>
                                <option value="BOM">{{__('general_content.bom_trans_key') }}</option>
                            </select>
                        </div>
                        @error('document_type') <span class="text-danger">{{ $message }}<br/></span>@enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label for="ordre">{{ __('general_content.sort_trans_key') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-sort-numeric-down"></i></span>
                            </div>
                            <input type="number" class="form-control @error('ordre') is-invalid @enderror" name="ordre" id="ordre" placeholder="{{ __('general_content.sort_trans_key') }}" min="0" wire:model.live="ordre">
                            
                            <input type="hidden" name="{{ $idType }}" value="{{ $Line->id   }}">
                        </div>
                        @error('ordre') <span class="text-danger">{{ $message }}<br/></span>@enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label for="methods_services_id">{{ __('general_content.service_trans_key') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-list"></i></span>
                            </div>
                            <select class="form-control @error('methods_services_id') is-invalid @enderror" wire:click.prevent="ChangeCodelabel()" name="methods_services_id" id="methods_services_id" wire:change="changeInputValues" wire:model.live="methods_services_id" required>
                            <option>{{ __('general_content.select_service_trans_key') }}</option>
                                @foreach ($ServicesSelect as $item)
                                <option value="{{ $item->id }}-{{ $item->type }}" data-txt="{{ $item->label }}">{{ $item->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('methods_services_id') <span class="text-danger">{{ $message }}<br/></span>@enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label for="label">{{__('general_content.label_trans_key') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tags"></i></span>
                            </div>
                            <input type="text" class="form-control @error('label') is-invalid @enderror"  name="label"  id="LABEL_TechnicalCut" placeholder="{{__('general_content.label_trans_key') }}" wire:model.live="label">
                        </div>
                        @error('label') <span class="text-danger">{{ $message }}<br/></span>@enderror
                    </div>
                    <div class="form-group col-md-2">
                        @if($TaskType == 'BOM') 
                        <label for="component_id">{{__('general_content.component_trans_key') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                            </div>
                            <select class="form-control @error('component_id') is-invalid @enderror" name="component_id" id="component_id"  wire:change="componentCost" wire:model.live="component_id" >
                                <option>{{ __('general_content.select_component_trans_key') }}</option>
                                @foreach ($ProductSelect as $item)
                                <option value="{{ $item->id }}" class="{{ $item->methods_services_id }}">{{ $item->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('component_id') <span class="text-danger">{{ $message }}<br/></span>@enderror
                        @endif 
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-2">
                    </div>
                    <div class="form-group col-md-2">
                        @if($TaskType == 'TechCut')
                        <label for="seting_time">{{ __('general_content.setting_time_trans_key') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-stopwatch"> {{__('general_content.hour_trans_key') }}</i></span>
                            </div>
                            <input type="number" class="form-control @error('seting_time') is-invalid @enderror" name="seting_time"  id="seting_time" placeholder="{{ __('general_content.setting_time_trans_key') }}" value="0" step=".001"  min="0" wire:change="changeInputValues"  wire:model.defer="seting_time" >
                        </div>
                        @error('seting_time') <span class="text-danger">{{ $message }}<br/></span>@enderror
                        @else 
                        <label for="qty">{{ __('general_content.qty_trans_key') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-times"></i></span>
                            </div>
                            <input type="number" class="form-control @error('qty') is-invalid @enderror" name="qty"  id="qty" value="{{ $Line->qty  }}" placeholder="{{ __('general_content.qty_trans_key') }}" step=".001"  min="0" wire:model.live="qty">
                        </div>
                        @error('qty') <span class="text-danger">{{ $message }}<br/></span>@enderror
                        @endif
                    </div>
                    <div class="form-group col-md-2">
                        @if($TaskType == 'TechCut')
                        <label for="unit_time">{{ __('general_content.unit_time_trans_key') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-stopwatch"> {{__('general_content.hour_trans_key') }}</i></span>
                            </div>
                            <input type="number" class="form-control @error('unit_time') is-invalid @enderror" name="unit_time"  id="unit_time" placeholder="{{ __('general_content.unit_time_trans_key') }}" value="0" step=".001"  min="0" wire:change="changeInputValues" wire:model.defer="unit_time" >
                        </div>
                        @error('unit_time') <span class="text-danger">{{ $message }}<br/></span>@enderror
                        @endif
                    </div>
                    <div class="form-group col-md-2">
                        <label for="unit_cost">{{ __('general_content.cost_trans_key') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ $Factory->curency }}</span>
                            </div>
                            <input type="number" class="form-control @error('unit_cost') is-invalid @enderror" name="unit_cost"  id="unit_cost" placeholder="{{ __('general_content.cost_trans_key') }}" value="0" step=".001" min="0" wire:model.defer="unit_cost">
                        </div> 
                        <p>({{ $seting_time  }} h /{{ $Line->qty  }} + {{ $unit_time }} h) x {{ $methods_services_hourly_rate }} {{ $Factory->curency }} / h = {{ ((float)$seting_time / (float)$Line->qty + (float)$unit_time) * (float)$methods_services_hourly_rate }}
                    </div>
                    <div class="form-group col-md-2">
                        <label for="unit_price">{{ __('general_content.price_trans_key') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ $Factory->curency }}</span>
                            </div>
                            <input type="number" class="form-control @error('unit_price') is-invalid @enderror" name="unit_price"  id="unit_price" placeholder="{{ __('general_content.unit_time_trans_key') }}" value="0" step=".001" min="0" wire:model.live="unit_price">
                        </div>
                        <p>{{ $unit_cost  }} {{ $Factory->curency }} x {{ $methods_services_margin }} %  = {{ round( (float)$unit_cost*(1+((float)$methods_services_margin/100)),2) }}</p>
                        @error('unit_price') <span class="text-danger">{{ $message }}<br/></span>@enderror
                    </div>
                    <div class="form-group col-md-2">
                        @if($TaskType == 'BOM' or $TaskType == 'TechCut')
                            @if($updateLines)
                            <x-adminlte-button class="btn-flat" type="submit" label="{{ __('general_content.update_trans_key') }}" theme="info" icon="fas fa-lg fa-save"/>
                            @else
                            <x-adminlte-button class="btn-flat" type="submit" label="Add Task" theme="success" icon="fas fa-lg fa-save"/>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
    @endif

    @if($Line->id ?? null)
    <div class="card-body">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{__('general_content.technical_cut_trans_key') }}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('general_content.collapse_trans_key') }}">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="{{ __('general_content.remove_trans_key') }}">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{__('general_content.id_trans_key') }} </th>
                            <th>{{ __('general_content.order_trans_key') }}</th>
                            <th>{{__('general_content.label_trans_key') }}</th>
                            <th>{{ __('general_content.service_trans_key') }}</th>
                            <th>{{ __('general_content.setting_time_trans_key') }}</th>
                            <th>{{ __('general_content.unit_time_trans_key') }}</th>
                            <th>{{ __('general_content.total_time_trans_key') }}</th>
                            <th>{{ __('general_content.progress_trans_key') }}</th>
                            <th>{{ __('general_content.cost_trans_key') }}</th>
                            <th>{{ __('general_content.margin_trans_key') }}</th>
                            <th>{{ __('general_content.price_trans_key') }}</th>
                            <th>{{__('general_content.status_trans_key') }}</th>
                            <th>{{__('general_content.action_trans_key') }}</th>
                            <th>{{__('general_content.end_date_trans_key') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($Line->TechnicalCut as $TechLine)
                        <tr>
                            <td><a href="{{ route('production.task.statu.id', ['id' => $TechLine->id]) }}" class="btn btn-sm btn-success">{{__('general_content.view_trans_key') }} </a> #{{ $TechLine->id }}</a></td>
                            <td>{{ $TechLine->ordre }}</td>
                            <td>{{ $TechLine->label }}</td>
                            <td @if($TechLine->methods_services_id ) style="background-color: {{ $TechLine->service['color'] }};" @endif >
                                @if($TechLine->methods_services_id )
                                    @if( $TechLine->service['picture'])
                                        <p data-toggle="tooltip" data-html="true" title="<img alt='Service' class='profile-user-img img-fluid img-circle' src='{{ asset('/images/methods/'. $TechLine->service['picture']) }}'>">
                                            <span>{{ $TechLine->service['label'] }}</span>
                                        </p>
                                    @else
                                        {{ $TechLine->service['label'] }}
                                    @endif
                                @endif
                            </td>
                            <td>{{ $TechLine->seting_time }} h</td>
                            <td>{{ $TechLine->unit_time }} h</td>
                            <td>{{ $TechLine->TotalTime() }} h</td>
                            <td><x-adminlte-progress theme="teal" value="{{ $TechLine->progress() }}" with-label animated/></td>
                            <td>{{ $TechLine->unit_cost }} {{ $Factory->curency }}</td>
                            <td>{{ $TechLine->Margin() }} %</td>
                            <td>{{ $TechLine->unit_price }} {{ $Factory->curency }}</td>
                            <td>
                            @if($TechLine->order_lines_id)
                                {{ $TechLine->status['title'] }}
                            @else
                                {{__('general_content.not_this_page_trans_key') }}
                            @endif
                            </td>
                            <td class=" py-0 align-middle">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <div class="dropdown-menu">
                                        <a href="#" class="dropdown-item " wire:click="duplicateLine({{$TechLine->id}})" ><span class="text-info"><i class="fa fa-light fa-fw  fa-copy"></i> {{ __('general_content.copie_line_trans_key') }}</span></a>
                                        <a href="#" class="dropdown-item" wire:click="editTaskLine({{$TechLine->id}})"><span class="text-primary"><i class="fa fa-lg fa-fw  fa-edit"></i> {{ __('general_content.edit_line_trans_key') }}</span></a>
                                        <a href="#" class="dropdown-item" wire:click="destroyTaskLine({{$TechLine->id}})" ><span class="text-danger"><i class="fa fa-lg fa-fw fa-trash"></i> {{ __('general_content.delete_line_trans_key') }}</span></a>
                                    </div>
                                </div>
                            </td>
                            @if($TechLine->type != 1 & $TechLine->type != 7)
                            <td class="bg-info color-palette">{{ $TechLine->service['label'] }}</td>
                            @elseif($todayDate->format("Y-m-d") > $TechLine->getFormattedEndDateAttribute() )
                            <td class="bg-danger color-palette">{{ $TechLine->getFormattedEndDateAttribute() }}</td>
                            @elseif($todayDate->format("Y-m-d") == $TechLine->getFormattedEndDateAttribute() )
                            <td class="bg-orange color-palette">{{ $TechLine->getFormattedEndDateAttribute() }}</td> 
                            @else
                            <td class="bg-primary color-palette">{{ $TechLine->getFormattedEndDateAttribute() }}</td>
                            @endif 
                        </tr>
                        @empty
                        <x-EmptyDataLine col="14" text="{{ __('general_content.no_data_trans_key') }}"  />
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>{{ __('general_content.total_trans_key') }} :</th>
                            <th></th>
                            <th></th>
                            <th>{{ $Line->getTechnicalCutTotalSettingTimeAttribute() }} h</th>
                            <th>{{ $Line->getTechnicalCutTotalUnitTimeAttribute() }} h</th>
                            <th></th>
                            <th></th>
                            <th>{{ $Line->getTechnicalCutTotalUnitCostAttribute() }}  {{ $Factory->curency }}</th>
                            <th>{{ $Line->getTechnicalCutTMarginAttribute() }} %</th>
                            <th>{{ $Line->getTechnicalCutTotalUnitPricettribute() }}  {{ $Factory->curency }}</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
            
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{__('general_content.bill_of_materials_trans_key') }}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('general_content.collapse_trans_key') }}">
                    <i class="fas fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="{{ __('general_content.remove_trans_key') }}">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>{{__('general_content.id_trans_key') }} </th>
                        <th>{{ __('general_content.order_trans_key') }}</th>
                        <th>{{__('general_content.label_trans_key') }}</th>
                        <th>{{ __('general_content.service_trans_key') }}</th>
                        <th>{{__('general_content.component_trans_key') }}</th>
                        <th>{{ __('general_content.qty_trans_key') }}</th>
                        <th>{{ __('general_content.cost_trans_key') }}</th>
                        <th>{{ __('general_content.margin_trans_key') }}</th>
                        <th>{{ __('general_content.price_trans_key') }}</th>
                        <th>{{__('general_content.status_trans_key') }}</th>
                        <th>{{__('general_content.action_trans_key') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($Line->BOM as $BOMline)
                        <tr>
                            <td>#{{ $BOMline->id }}</td>
                            <td>{{ $BOMline->ordre }}</td>
                            <td>{{ $BOMline->label }}</td>
                            <td @if($BOMline->methods_services_id ) style="background-color: {{ $BOMline->service['color'] }};" @endif >
                                @if($BOMline->methods_services_id )
                                    @if( $BOMline->service['picture'])
                                        <p data-toggle="tooltip" data-html="true" title="<img alt='Service' class='profile-user-img img-fluid img-circle' src='{{ asset('/images/methods/'. $BOMline->service['picture']) }}'>">
                                            <span>{{ $BOMline->service['label'] }}</span>
                                        </p>
                                    @else
                                        {{ $BOMline->service['label'] }}
                                    @endif
                                @endif
                            </td>
                            <td>{{ $BOMline->Component['code'] }}</td>
                            <td>{{ $BOMline->qty }}</td>
                            <td>{{ $BOMline->unit_cost }} {{ $Factory->curency }}</td>
                            <td>{{ $BOMline->Margin() }} %</td>
                            <td>{{ $BOMline->unit_price }} {{ $Factory->curency }}</td>
                            <td>
                                @if($BOMline->order_lines_id)
                                {{ $BOMline->status['title'] }}
                                @else
                                {{__('general_content.not_this_page_trans_key') }}
                                @endif
                            </td>
                            <td class=" py-0 align-middle">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <div class="dropdown-menu">
                                        <a href="#" class="dropdown-item " wire:click="duplicateLine({{$BOMline->id}})" ><span class="text-info"><i class="fa fa-light fa-fw  fa-copy"></i> {{ __('general_content.copie_line_trans_key') }}</span></a>
                                        <a href="#" class="dropdown-item" wire:click="editTaskLine({{$BOMline->id}})"><span class="text-primary"><i class="fa fa-lg fa-fw  fa-edit"></i> {{ __('general_content.edit_line_trans_key') }}</span></a>
                                        <a href="#" class="dropdown-item" wire:click="destroyTaskLine({{$BOMline->id}})" ><span class="text-danger"><i class="fa fa-lg fa-fw fa-trash"></i> {{ __('general_content.delete_line_trans_key') }}</span></a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <x-EmptyDataLine col="11" text="{{ __('general_content.no_data_trans_key') }}"  />
                        @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th>{{ __('general_content.total_trans_key') }} :</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>{{ $Line->getBOMTotalUnitCostAttribute() }}  {{ $Factory->curency }}</th>
                        <th>{{ $Line->getBOMTMarginAttribute() }} %</th>
                        <th>{{ $Line->getBOMTotalUnitPricettribute() }}  {{ $Factory->curency }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    @endif

    @if($statu == 1)
    <div class="card-body">
        @if($updateLines)
        <form wire:submit.prevent="updateSubAssembly">
        @else
        <form wire:submit.prevent="storeSubAssembly({{ $Line->id }})">
        @endif
            <div class="card card-body">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="subAssemblyOrdre">{{ __('general_content.sort_trans_key') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-sort-numeric-down"></i></span>
                            </div>
                            <input type="number" class="form-control @error('subAssemblyOrdre') is-invalid @enderror" name="subAssemblyOrdre" id="subAssemblyOrdre" placeholder="{{ __('general_content.sort_trans_key') }}" min="0" wire:model.live="subAssemblyOrdre">
                            
                        </div>
                        @error('subAssemblyOrdre') <span class="text-danger">{{ $message }}<br/></span>@enderror
                        <input type="hidden" name="{{ $idType }}" value="{{ $Line->id   }}">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="subAssemblyComponentId">{{__('general_content.component_trans_key') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                            </div>
                            <select class="form-control @error('subAssemblyComponentId') is-invalid @enderror" name="subAssemblyComponentId" id="subAssemblyComponentId"  wire:click.prevent="ChangeSubAssemblyCodelabel()" wire:model.live="subAssemblyComponentId" >
                                <option>{{ __('general_content.select_component_trans_key') }}</option>
                                @foreach ($ComponentSelect as $item)
                                <option value="{{ $item->id }}" class="{{ $item->methods_services_id }}">{{ $item->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('subAssemblyComponentId') <span class="text-danger">{{ $message }}<br/></span>@enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label for="subAssemblylabel">{{__('general_content.label_trans_key') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tags"></i></span>
                            </div>
                            <input type="text" class="form-control @error('subAssemblylabel') is-invalid @enderror"  name="subAssemblylabel"  id="subAssemblylabel" placeholder="{{__('general_content.label_trans_key') }}" wire:model.live="subAssemblylabel" disabled>
                        </div>
                        @error('subAssemblylabel') <span class="text-danger">{{ $message }}<br/></span>@enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label for="subAssemblyQty">{{ __('general_content.qty_trans_key') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-times"></i></span>
                            </div>
                            <input type="number" class="form-control @error('subAssemblyQty') is-invalid @enderror" name="subAssemblyQty"  id="subAssemblyQty" value="1" placeholder="{{ __('general_content.qty_trans_key') }}" step="1"  min="0" wire:model.live="subAssemblyQty">
                        </div>
                        @error('subAssemblyQty') <span class="text-danger">{{ $message }}<br/></span>@enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label for="subAssemblyUnit_price">{{ __('general_content.price_trans_key') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ $Factory->curency }}</span>
                            </div>
                            <input type="number" class="form-control @error('subAssemblyUnit_price') is-invalid @enderror" name="subAssemblyUnit_price"  id="subAssemblyUnit_price" placeholder="{{ __('general_content.price_trans_key') }}" value="0" step=".001" min="0" wire:model.live="subAssemblyUnit_price">
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        @if($updateLines)
                        <x-adminlte-button class="btn-flat" type="submit" label="{{ __('general_content.update_trans_key') }}" theme="info" icon="fas fa-lg fa-save"/>
                        @else
                        <x-adminlte-button class="btn-flat" type="submit" label="{{ __('general_content.add_sub_assembly_trans_key') }}" theme="success" icon="fas fa-lg fa-save"/>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
    @endif

    @if($Line->id ?? null)
    <div class="card-body">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">{{ __('general_content.sub_assembly_trans_key') }}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('general_content.collapse_trans_key') }}">
                    <i class="fas fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="{{ __('general_content.remove_trans_key') }}">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>{{__('general_content.id_trans_key') }} </th>
                        <th>{{ __('general_content.order_trans_key') }}</th>
                        <th>{{__('general_content.id_trans_key') }}</th>
                        <th>{{__('general_content.label_trans_key') }}</th>
                        <th>{{ __('general_content.qty_trans_key') }}</th>
                        <th>{{ __('general_content.cost_trans_key') }}</th>
                        <th>{{ __('general_content.price_trans_key') }} </th>
                        <th>{{__('general_content.action_trans_key') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse ($Line->SubAssembly as $SubAssemblyLine)
                        <tr>
                            <td>#{{ $SubAssemblyLine->id }}</td>
                            <td>{{ $SubAssemblyLine->ordre }}</td>
                            <td>{{ $SubAssemblyLine->Child['code'] }}</td>
                            <td>{{ $SubAssemblyLine->Child['label'] }}</td>
                            <td>{{ $SubAssemblyLine->qty }}</td>
                            <td>{{ $SubAssemblyLine->Child['selling_price'] }}  {{ $Factory->curency }}</td>
                            <td>{{ $SubAssemblyLine->unit_price }}  {{ $Factory->curency }}</td>
                            <td class=" py-0 align-middle">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <div class="dropdown-menu">
                                        <a href="#" class="dropdown-item " wire:click="duplicateSubAssemblyLine({{$SubAssemblyLine->id}})" ><span class="text-info"><i class="fa fa-light fa-fw  fa-copy"></i> {{ __('general_content.copie_line_trans_key') }}</span></a>
                                        <a href="#" class="dropdown-item" wire:click="editSubAssemblyLine({{$SubAssemblyLine->id}})"><span class="text-primary"><i class="fa fa-lg fa-fw  fa-edit"></i> {{ __('general_content.edit_line_trans_key') }}</span></a>
                                        <a href="#" class="dropdown-item" wire:click="destroySubAssemblyLine({{$SubAssemblyLine->id}})" ><span class="text-danger"><i class="fa fa-lg fa-fw fa-trash"></i> {{ __('general_content.delete_line_trans_key') }}</span></a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <x-EmptyDataLine col="6" text="{{ __('general_content.no_data_trans_key') }}"  />
                        @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    @endif
</div>
