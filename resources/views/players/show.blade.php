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
        <div class="caption">Game Player - {{ $player->name }}
      {{-- @if(@Auth::id() === $player->user_id)
      <form action="{{ route('player.destroy', [$player->team_id, $player->game_id, $player->user_id]) }}" method="POST">
        {{ csrf_field() }}
        <button class="btn btn-xs btn-danger btn-block" type="submit" name="deletePlayer" title="Quit"><i class="fa fa-soccer-ball-o"></i> Quit</button>
      </form>
      @endif --}}
      </div>
    </div>
  </div>
@endforeach
</div>

@endsection

<script src="/js/post.js" type="text/javascript"></script>
