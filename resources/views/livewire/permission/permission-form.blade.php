<div class="inline-flex"  >
    <button type="button" wire:click.prevent="create()"  data-toggle="modal" class="btn btn-primary">
        {{ __('Add') }}
    </button>  
    <!-- Create or Update Modal -->    
    <div wire:ignore.self class="modal fade" id="createOrUpdatePermissionModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title">{{ $is_editing ? __('Edit') : __('Create') }} Permission</h5>
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
                                    <label for="name">{{ __('Name') }}</label>
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

                        <div class="row">
                            {{-- Roles --}}
                            <div class="col-md-6">       
                                <h4>{{ __('Roles') }}</h4>                 
                                <div class="row">
                                    @foreach ($roles->split(2) as $chunk)
                                        <div class="col-lg-6">
                                            @foreach ($chunk as $role)
                                                <div class="form-check">
                                                    <label 
                                                        class="form-check-label {{ in_array($role->id, (array) $selected_roles) ? 'font-weight-bold form-check-label text-success' : '' }}" 
                                                    >
                                                        <input type="checkbox" 
                                                            class="form-check-input" 
                                                            wire:model="selected_roles"
                                                            wire:loading.attr="disabled"
                                                            wire:change="updateRole({{ $role->id }})" 
                                                            value="{{ $role->id }}" 
                                                            {{ in_array($role->id, (array) $selected_roles) ? 'checked' : '' }}
                                                        >
                                                        {{ $role->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            {{-- Users --}}
                            <div class="col-md-6">       
                                <h4>{{ __('Users') }}</h4>                 
                                <div class="row">
                                    @foreach ($users->split(2) as $chunk)
                                        <div class="col-lg-6">
                                            @foreach ($chunk as $user)
                                                <div class="form-check">
                                                    <label 
                                                        class="form-check-label {{ $user->hasAnyPermission($permission->name) ? 'font-weight-bold form-check-label text-primary' : '' }}" 
                                                    >
                                                        <input type="checkbox" 
                                                            class="form-check-input" 
                                                            name="selected_users"
                                                            wire:loading.attr="disabled"
                                                            wire:change="updateUser({{ $user->id }})" 
                                                            value="{{ $user->id }}" 
                                                            {{ $user->hasAnyPermission($permission->name) ? 'checked' : '' }}
                                                        >
                                                        {{ $user->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
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
    <div wire:ignore.self class="modal fade" id="deletePermissionModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">{{ __('Delete') }} Permission</h5>
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
        document.addEventListener('show-permission-modal-form', () => {
            $('#createOrUpdatePermissionModal').modal('show');
        });
        
        document.addEventListener('close-permission-modal-form', () => {
            $('#createOrUpdatePermissionModal').modal('hide');
        });

        document.addEventListener('show-delete-permission-modal', () => {
            $('#deletePermissionModal').modal('show');
        });
        
        document.addEventListener('close-delete-permission-modal', () => {
            $('#deletePermissionModal').modal('hide');
        });
    })()
</script>
@endpush