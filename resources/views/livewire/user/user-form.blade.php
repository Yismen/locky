<div class="inline-flex"  >
    <button type="button" wire:click.prevent="create()"  data-toggle="modal" class="btn btn-primary">
        {{ __('locky::messages.add') }}
    </button>  
    <!-- Create or Update Modal -->    
    <div wire:ignore.self class="modal fade" id="createOrUpdateUserModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title">{{ $is_editing ? __('locky::messages.edit') : __('locky::messages.create') }} {{ __('locky::messages.user') }}</h5>
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div wire:key="inactivateUser">
                    @if ($is_editing && !$user->isActive())
                        <div class="modal-body">                                  
                            <div class="alert alert-danger" role="alert">
                                <strong>{{ __('locky::messages.inactive_user_alert') }}</strong>
                            </div>  
                        </div>
                        <div class="modal-footer bg-light">                     
                            <a href="#" class="btn btn-warning" wire:click.prevent="activateUser({{ $user->id }})">
                                {{  __('locky::messages.activate') }}
                            </a>
                        </div>
                    @else
                        <form 
                            @if ($is_editing)
                                wire:submit.prevent="update" wire:key="update_form"   
                            @else
                                wire:submit.prevent="store" wire:key="store_form"
                            @endif
                        >
                            <div class="modal-body">
                                @include('locky::livewire.user._active-users-form')
                            </div>
                            {{-- /Modal Body --}}
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

                            @if ($is_editing && $user->isActive())
                                <div class="modal-footer bg-light" wire:loading.remove  wire:target="update">                                
                                    <a href="#" class="btn btn-danger" wire:click.prevent="inactivateUser({{ $user->id }})">
                                        {{  __('locky::messages.inactivate') }}
                                    </a>
                                </div>
                            @endif
                        </form>
                    @endif
                </div>
                
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