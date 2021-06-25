<div class="inline-flex"  >
    <button type="button" wire:click.prevent="create()"  data-toggle="modal" class="btn btn-primary">
        {{ __('Add') }}
    </button>  
    <!-- Create or Update Modal -->    
    <div wire:ignore.self class="modal fade" id="createOrUpdateUserModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title">{{ $is_editing ? __('Edit') : __('Create') }} User</h5>
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
                        @if ($is_editing && $user->inactivated_at)                            
                            <label for="inactivated_at">{{ __('Inactivation Date') }}</label>
                            <input type="date"
                            class="form-control @error('fields.inactivated_at') is-invalid @enderror" wire:model.debounce.350ms="fields.inactivated_at" id="inactivated_at" aria-describedby="inactivated_at" placeholder="">
                            @error('fields.inactivated_at')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>                          
                            @enderror
                            <p class="form-text text-muted">
                                {{ __('Remove date to re-activate') }}
                            </p>
                        @else
                            @include('locky::livewire.user._active-users-form')
                        @endif
                        {{-- /Modal Body --}}
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-dark" data-dismiss="modal">{{ __('Close') }}</button> --}}
                        @if ($is_editing)                        
                            <button type="submit" class="btn btn-success">
                                {{  __('Update') }}
                            </button>
                        @else                      
                            <button type="submit" class="btn btn-primary">
                                {{  __('Create') }}
                            </button>                       
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->    
    <div wire:ignore.self class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">{{ __('Delete') }} User</h5>
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
        document.addEventListener('show-user-modal-form', () => {
            $('#createOrUpdateUserModal').modal('show');
        });
        
        document.addEventListener('close-user-modal-form', () => {
            $('#createOrUpdateUserModal').modal('hide');
        });

        document.addEventListener('show-delete-user-modal', () => {
            $('#deleteUserModal').modal('show');
        });
        
        document.addEventListener('close-delete-user-modal', () => {
            $('#deleteUserModal').modal('hide');
        });
    })()
</script>
@endpush