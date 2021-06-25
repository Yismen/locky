@extends(config('app.env') == "testing" ? 'locky::app' : 'layouts.app')

@section('content')
    @livewire('locky::permission.permission-index')
@endsection

