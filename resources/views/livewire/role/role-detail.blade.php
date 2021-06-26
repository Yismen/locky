<div class="inline-flex" wire:ignore.self>
    <!-- Modal -->
    <div class="modal fade" id="detailRoleModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Details For') }} {{ $role->name ?? '' }}</h5>
                    <button type="button" class="close" wire:click.prevent="closeModal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th class="col-4">{{ __('Name') }}</th>
                                <td>{{ $role->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <th class="col-4">{{ __('Permissions') }}</th>
                                <td>
                                    @foreach ($role->permissions as $permission)
                                        <span class="badge badge-success">{{ $permission->name }}</span>
                                    @endforeach    
                                </td>
                            </tr>
                            <tr>
                                <th class="col-4">{{ __('Users') }}</th>
                                <td>
                                    @foreach ($role->users as $user)
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
            window.addEventListener('show-detail-role-modal', event => {
                $('#detailRoleModal').modal('show');
            });
            
            window.addEventListener('close-detail-role-modal', event => {
                $('#detailRoleModal').modal('hide');
            });
        })();
    </script>
@endpush
