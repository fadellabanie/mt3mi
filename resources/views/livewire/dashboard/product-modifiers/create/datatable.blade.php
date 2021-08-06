<div>
    <div class="card card-custom mt-5">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    {{ svg('Layout-left-panel-2') }}
                </span>
                <h3 class="card-label">
                    {{ __('Product Modifiers') }}
                </h3>
            </div>
            <div class="card-toolbar">
                <x-add-new-record-button href="javascript:void(0)" wire:click="create">{{ __('Add new') }}</x-add-new-record-button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_4">
                    <thead>
                        <tr class="text-left">
                            <th class="pl-0" style="min-width: 120px">{{ __('Name') }}</th>
                            <th class="pl-0" style="min-width: 120px">{{ __('Options') }}</th>
                            <th class="pr-0 text-left" style="min-width: 160px">{{ __('Control') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productModifiers->sortBy('uid') as $key => $modifier)
                            <tr>
                                <td class="pl-0">
                                    {{ $modifier['name'] }}
                                </td>
                                <td class="pl-0">
                                    {{ $modifier['minimum_options'] }} - {{ $modifier['maximum_options'] }}
                                </td>
                                <td class="pr-0 text-left">
                                    <x-edit-record-button href="javascript:void(0)" wire:click="selectModifier({{ $modifier['id'] }}, 'update')" />
                                    <x-delete-record-button href="javascript:void(0)" wire:click="selectModifier({{ $modifier['id'] }}, 'delete')"  />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-danger font-size-lg">{{ __('No records found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('livewire.dashboard.product-modifiers.create.create')
    @include('livewire.dashboard.product-modifiers.create.update')
</div>
