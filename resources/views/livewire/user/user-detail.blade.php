<div class="inline-flex" wire:ignore.self>
    <!-- Modal -->
    <div class="modal fade" id="detailUserModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('locky::messages.details') }} {{ __('locky::messages.for') }} {{ $user->name ?? '' }}</h5>
                    <button type="button" class="close" wire:click.prevent="closeModal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <table class="table">
                        <tbody class="text-{{ $user->inactivated_at ? 'danger' : '' }}">
                            <tr>
                                <th class="col-4">{{ __('locky::messages.name') }}</th>
                                <td>{{ $user->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <th class="col-4">{{ __('Email') }}</th>
                                <td>{{ $user->email ?? '' }}</td>
                            </tr>
                            <tr>
                                <th class="col-4">{{ __('locky::messages.created_at') }}</th>
                                <td>{{ $user->created_at ?? '' }} / {{ optional($user->created_at)->diffForHumans() ?? '' }}</td>
                            </tr>
                            <tr>
                                <th class="col-4">{{ __('locky::messages.status') }}</th>
                                <td>
                                    @if ($user->inactivated_at)
                                        Inactive / {{ $user->inactivated_at ?? '' }}
                                    @else
                                        Active
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="col-4">{{ __('locky::messages.roles_list') }}</th>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <span class="badge badge-success">{{ $role->name }}</span>
                                    @endforeach    
                                </td>
                            </tr>
                            <tr>
                                <th class="col-4">{{ __('locky::messages.permissions_list') }}</th>
                                <td>
                                    @foreach ($user->permissions as $permission)
                                        <span class="badge badge-primary">{{ $permission->name }}</span>
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
            window.addEventListener('show-detail-user-modal', event => {
                $('#detailUserModal').modal('show');
            });
            
            window.addEventListener('close-detail-user-modal', event => {
                $('#detailUserModal').modal('hide');
            });
        })();
    </script>
@endpush
