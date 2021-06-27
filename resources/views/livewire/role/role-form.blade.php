<div class="inline-flex"  >
    <button type="button" wire:click.prevent="create()"  data-toggle="modal" class="btn btn-primary">
        {{ __('locky::messages.add') }}
    </button>  
    <!-- Create or Update Modal -->    
    <div wire:ignore.self class="modal fade" id="createOrUpdateRoleModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title">{{ $is_editing ? __('locky::messages.edit') : __('locky::messages.create') }} {{ __('locky::messages.role') }}</h5>
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    @if ($is_editing)
                        <form wire:submit.prevent="update">                        
                    @else
                        <form wire:submit.prevent="store">
                    @endif
                
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">                            
                                <div class="form-group">
                                    <label for="name">{{ __('locky::messages.name') }}</label>
                                    <input type="text"
                                    class="form-control @error('fields.name') is-invalid @enderror" wire:model.debounce.350ms="fields.name" id="name" aria-describedby="name" placeholder="">
                                    @error('fields.name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>                          
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if ($is_editing)
                            @include('locky::livewire.role._additional-fields')
                        @endif
                        {{-- /Modal Body --}}
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-dark" data-dismiss="modal">{{ __('Close') }}</button> --}}
                        @if ($is_editing)                        
                            <button type="submit" class="btn btn-success">
                                {{  __('locky::messages.update') }}
                            </button>
                        @else                      
                            <button type="submit" class="btn btn-primary">
                                {{  __('locky::messages.create') }}
                            </button>                       
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->    
    <div wire:ignore.self class="modal fade" id="deleteRoleModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">{{ __('Delete') }} Role</h5>
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-danger">
                    {{ _('You are about to delete this record from the database, which CAN NOT be reverterd. Are you sure you want proceed?') }} {{ $fields['name'] ?? '' }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-danger" wire:click.prevent="completeDelete()">{{ __('Delete') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function() {
        document.addEventListener('show-role-modal-form', () => {
            $('#createOrUpdateRoleModal').modal('show');
        });
        
        document.addEventListener('close-role-modal-form', () => {
            $('#createOrUpdateRoleModal').modal('hide');
        });

        document.addEventListener('show-delete-role-modal', () => {
            $('#deleteRoleModal').modal('show');
        });
        
        document.addEventListener('close-delete-role-modal', () => {
            $('#deleteRoleModal').modal('hide');
        });
    })()
</script>
@endpush