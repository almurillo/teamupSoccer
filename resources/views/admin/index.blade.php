@extends('layouts.main')

@section('title', '| DASHBOARD')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @component('components.who')

                    @endcomponent
                </div>
            </div>
        </div>
    </div>

@endsection