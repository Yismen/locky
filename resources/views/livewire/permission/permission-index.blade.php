<div class="container mx-auto">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="card-title px-5">
                        {{ __('Permissions') }}
                    </h4>
                </div>
                <div class="col-md-8">
                    <div class="d-flex justify-content-end justify-content-lg-end justify-content-sm-start mx-2">
                        {{-- Pagination Amount --}}
                        <div class="mr-2">
                            {{-- <label for=""></label> --}}
                            <select class="form-control" wire:model="amount">
                                @foreach ($this->filterAmounts($permissions->total()) as $interval)
                                    <option value="{{ $interval }}">
                                        @if ($loop->last)
                                            {{ __('All') }}
                                        @else
                                            {{ $interval }}
                                        @endif
                                    </option>                        
                                @endforeach
                            </select>
                        </div>
                        {{-- Search --}}
                        <div class="mr-2" wire:ignore>
                            <div class="input-group">
                                <input type="text"
                                class="form-control" wire:model.debounce.500ms="search" aria-describedby="helpId" placeholder="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-light text-dark border" type="button" wire:click.prevent="$set('search', '')">&times;</button>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            @livewire('locky::permission.permission-form')
                            @livewire('locky::permission.permission-detail')
                        </div>
                    </div>
                </div>
                {{-- col --}}
            </div>
            {{-- .row --}}
        </div>
        {{-- car-body --}}
    </div>
    {{-- card --}}
    <div class="card mt-2">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover m-0">
                    <thead>
                        <tr>
                            <th>
                                <a href="#" wire:click.prevent="sortBy('name')" class="d-flex flex-row justify-content-start">
                                    {{ __('Name') }}  
                                    <span>{!! $this->getIcon('name') !!}</span>
                                </a>
                            </th>
                            <th>
                                {{ __('Roles') }} 
                            </th>
                            <th>
                                {{ __('Users') }} 
                            </th>

                            <th class="col-1">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td>
                                <td>
                                    @foreach ($permission->roles as $role)
                                        <span class="badge bg-success text-light">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($permission->users as $user)
                                        <span class="badge bg-primary text-light">
                                            {{ $user->name }}
                                        </span>
                                    @endforeach
                                </td>

                                <td>
                                    <a href="#" class="btn btn-warning btn-sm" 
                                        wire:click.prevent="edit({{ $permission->id }})"
                                        title="{{ __('Edit') }}"
                                    >
                                        @include('locky::livewire.icons.pencil')                                         
                                    </a>
                                    <a href="#" 
                                        class="btn btn-default btn-sm border" 
                                        wire:click.prevent="detail({{ $permission->id }})"
                                        title="{{ __('Details') }}"
                                    >
                                        @include('locky::livewire.icons.eye')                                         
                                    </a>                                    
                                </td>
                            </tr>
                        @endforeach          
                    </tbody>
                </table>
            </div>
        </div>
        @if ($permissions->hasPages())
            <div class="card-footer">            
                {{ $permissions->links() }}
            </div>
        @endif
    </div>
</div>
