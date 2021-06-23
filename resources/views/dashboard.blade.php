@extends(config('app.env') == "testing" ? 'locky::app' : 'layouts.app')

@section('content')
    <div class="row justify-content-around">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h4>
                        {{ __('locky::messages.dashboard') }}
                    </h4>
                </div>            
            </div>

            <div class="card mt-2 ">
                <div class="card-body p-0">                            
                    <h4>Work In Progress</h4>
                </div>
            </div>
        </div>
    </div>
@endsection

