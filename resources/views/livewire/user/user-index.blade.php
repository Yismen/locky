<div class="container mx-auto">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="card-title px-5">
                        {{ __('Users') }}
                    </h4>
                </div>
                <div class="col-md-8">
                    <div class="d-flex justify-content-end justify-content-lg-end justify-content-sm-start mx-2">
                        {{-- Pagination Amount --}}
                        <div class="mr-2">
                            {{-- <label for=""></label> --}}
                            <select class="form-control" wire:model="amount">
                                @foreach ($this->filterAmounts($users->total()) as $interval)
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
                            @livewire('locky::user.user-form')
                            @livewire('locky::user.user-detail')
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
                                <a href="#" wire:click.prevent="sortBy('email')" class="d-flex flex-row justify-content-start">
                                    {{ __('Email') }}  
                                    <span>{!! $this->getIcon('email') !!}</span>
                                </a>
                            </th>
                            <th>
                                <a href="#" wire:click.prevent="sortBy('inactivated_at')" class="d-flex flex-row justify-content-start">
                                    {{ __('Status') }}  
                                    <span>{!! $this->getIcon('inactivated_at') !!}</span>
                                </a>
                            </th>
                            <th>
                                {{ __('Roles') }} 
                            </th>

                            <th class="col-1">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="text-{{ $user->inactivated_at ? 'danger' : ''}} ">
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->inactivated_at }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <span class="badge bg-success text-light">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </td>

                                <td>
                                    <a href="#" class="btn btn-warning btn-sm" 
                                        wire:click.prevent="edit({{ $user->id }})"
                                        title="{{ __('Edit') }}"
                                    >
                                        @include('locky::livewire.icons.pencil')                                         
                                    </a>
                                    <a href="#" 
                                        class="btn btn-default btn-sm border" 
                                        wire:click.prevent="detail({{ $user->id }})"
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
        @if ($users->hasPages())
            <div class="card-footer">            
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
