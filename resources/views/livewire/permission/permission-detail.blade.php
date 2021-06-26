<div class="inline-flex" wire:ignore.self>
    <!-- Modal -->
    <div class="modal fade" id="detailPermissionModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('locky::messages.details') }} {{ __('locky::messages.for') }} {{ $permission->name ?? '' }}</h5>
                    <button type="button" class="close" wire:click.prevent="closeModal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th class="col-4">{{ __('locky::messages.name') }}</th>
                                <td>{{ $permission->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <th class="col-4">{{ __('locky::messages.roles_list') }}</th>
                                <td>
                                    @foreach ($permission->roles as $role)
                                        <span class="badge badge-success">{{ $role->name }}</span>
                                    @endforeach    
                                </td>
                            </tr>
                            <tr>
                                <th class="col-4">{{ __('locky::messages.users_list') }}</th>
                                <td>
                                    @foreach ($permission->users as $user)
                                        <span class="badge badge-primary">{{ $user->name }}</span>
                                    @endforeach    
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click.prevent="closeModal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>            
        (function() {
            window.addEventListener('show-detail-permission-modal', event => {
                $('#detailPermissionModal').modal('show');
            });
            
            window.addEventListener('close-detail-permission-modal', event => {
                $('#detailPermissionModal').modal('hide');
            });
        })();
    </script>
@endpush
