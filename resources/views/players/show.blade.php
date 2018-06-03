@extends('layouts.main')

@section('title', "| Players")

@section('content')

@include ('layouts.errors')
@include ('layouts.success')
<div class="row">
@foreach ($players as $player)
  <div class="col-md-4 animated slideInLeft">
    <div class="thumbnail">
      <img src="../images/users/{{ $player->avatar }}" class="img-circle" alt="{{ $player->name }}">
      <div class="caption">Game Player - {{ $player->name  }}</div>
    </div>
  </div>
@endforeach
</div>

@endsection

<script src="/js/post.js" type="text/javascript"></script>
