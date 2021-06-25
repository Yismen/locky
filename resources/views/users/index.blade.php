@extends(config('app.env') == "testing" ? 'locky::app' : 'layouts.app')

@section('content')
    @livewire('locky::user.user-index')
@endsection

