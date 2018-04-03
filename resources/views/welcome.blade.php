@extends ('layouts.main')

@include ('layouts.errors')

@section('title','| HOME')

@section ('content')

    <div class="content">
            
            <div class="row">
                
                <div class="col-md-8 col-sm-offset-2">

                    <div class="panel">
                        
                        @component('components.who')

                        @endcomponent

                    </div>

                </div>

            </div>

    </div>

@endsection
