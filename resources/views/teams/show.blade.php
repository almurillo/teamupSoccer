@extends('layouts.main')

@section('title', "| $team->name")

@section('content')

@include ('layouts.errors')
@include ('layouts.success')

<div class="row">

<div class="col-sm-3">

	<img class="img-circle" src="../images/teams/{{ $team->logo }}" width="150" height="150">

</div>

<div class="col-sm-6">

		<h1>{{ $team->name }} <br>
		<small>{{ $team->city }} , {{ $team->state_code }}</small><br>
		<h5>Created by {{ $user->name }}</h5></h1>

	@if($member == null)

		<form action="{{ route('members.store', $team->id) }}" method="POST">

		{{ csrf_field() }}

		<button type="submit" class="btn btn-info btn-sm">Join Team</button>

		</form>

	@elseif($member->admin == 1)

	 <span class="label label-primary">Your are the team captain</span>

	@elseif($member->approved == 1)

		<form action="{{ route('members.destroy', [$team->id, $member->id]) }}" method="POST">

		{{ csrf_field() }}
		{{ method_field('DELETE') }}

		<button type="submit" class="btn btn-danger btn-sm">Leave Team</button>

		</form>

@endif
</div>

@if(@$member->admin == 1)

<div class="col-md-3">

	<a class="btn btn-success btn-block" href="{{ route('teams.edit', $team->id) }}"><i class="fa fa-edit fa-lg"></i> Edit Team</a><br>


<form action="{{ route('teams.destroy', $team->id) }}" method="POST">

	{{ csrf_field() }}
	{{ method_field('DELETE') }}

	<button type="submit" class="btn btn-danger btn-block"><i class="fa fa-trash fa-lg"></i> Delete Team</button>

</form>

<a class="btn btn-primary btn-block" href="{{ route('games.create', $team->id) }}"><i class="fa fa-plus fa-lg"></i> Add Games</a><br>

</div>

@endif

</div>

@if(count($games))

<div class="row">

<h2>Upcoming Games</h2>
 @foreach($games as $game)
	<div class="col-md-12">

			<div class="card">

				<table class="table">

					{{-- <tr>

						<td>Place</td>
						<td>Field</td>
						<td>Date and Time</td>
						<td>players</td>
						<td></td>
						<td></td>
						<td></td>

					</tr> --}}


					<tr>

						<td>place: <small>{{ $game->place }}</small></td>
						<td>field: {{ $game->field }}</td>
						<td>Date/Time: <small>{{ date('m/d/Y h:i A', strtotime($game->game_time)) }}</small></td>
						<td><a href="{{ route('players.show',$game->id) }}" class="btn btn-xs btn-success"><i class="fa fa-user"></i> Players</a></td>
						<td>
							{{-- @if($count == 0) --}}
									<form action="{{ route('player.store', [$game->team_id, $game->id]) }}" method="POST">
										{{ csrf_field() }}
										<button class="btn btn-xs btn-default btn-block" type="submit" name="addPlayer" title="Join"><i class="fa fa-soccer-ball-o"></i> Join</button>
									</form>
							{{-- @else
								<form action="{{ route('player.destroy', [$game->team_id, $game->id, $game->user_id]) }}" method="POST">
									{{ csrf_field() }}
									<button class="btn btn-xs btn-danger btn-block" type="submit" name="deletePlayer" title="Quit"><i class="fa fa-soccer-ball-o"></i> Quit</button>
								</form>
							@endif --}}

								@if(@$member->admin == 1)

								<td>

									<a href="{{ route('games.edit',[$game->team_id, $game->id]) }}" class="btn btn-xs btn-primary btn-block"><i class="fa fa-edit"></i> Edit</a>
								</td>


								<td>

									<a href="{{ route('games.destroy',[$game->team_id, $game->id]) }}" class="btn btn-xs btn-danger btn-block"><i class="fa fa-trash"></i> Delete</a>

								</td>

								@endif


						</td>

					</tr>

				</table>

			{{-- <div>
				@foreach($players as $player)
					{{ $player->name }}
				@endforeach
			</div> --}}

			</div>

	</div>
		@endforeach
</div>

@endif

<div class="row">

@if(count($approves) != 0 && @$member->admin == 1)

<div class="column-md-12 text-center">
	<h3>Players Pending Approval</h3>
</div>
<table class="table">
	<tbody>
		<tr>
		@foreach($approves as $approve)
		<td>
			<div class="row animated slideInLeft">
				<div class="col-md-4">
					<a class="text-left" href="#"><h4>{{ $approve->name }}</h4></a>
				</div>
					<div class="row">
						<div class="col-sm-2 formPadding">
							<form action="{{ route('members.update', [$approve->team_id, $approve->id]) }}" method="POST">

									{{ csrf_field() }}
									{{ method_field('PUT') }}

									<button type="submit" class="btn btn-info btn-sm" title="Approve Player"><i class="fa fa-check fa-lg"></i> </button>
								</form>
							</div>
							<div class="col-sm-2 formPadding">
						<form action="{{ route('members.destroy', [$approve->team_id, $approve->id]) }}" method="POST">

						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						<button type="submit" class="btn btn-danger btn-sm" title="Reject Player"><i class="fa fa-close fa-lg"></i></button>
						</form>
					</div>
				</div>
			</div>
		</td>
		@endforeach
		</tr>
	</body>
</table>
@endif

<hr>

<div class="row">

	<div class="col-md-12">

@if($member != null && $member->approved == 1)


		<form enctype="multipart/form-data" method="POST" action="{{ route('posts.store', $team->id) }}">

			{{ csrf_field() }}

			<div class="form-group">

			<textarea onfocus="showBtnDiv()" name="body" id="body" placeholder="Leave a message for your team!" class="form-control"></textarea>

			</div>

			<div id="btns_SP" style="overflow-x:hidden;" class="hiddenStuff">

				<div class="col-md-6">

					<div class="form-group">

						<button class="btn btn-primary btn-block hvr-wobble-vertical">Add Post</button>

					</div>

				</div>

				<div class="col-md-6">

					<div class="form-group">

						<button id="triggerBtn_SP" class="btn btn-success btn-block hvr-wobble-vertical" onclick="triggerUpload(event, 'fu_SP')">Upload Image</button>
						<input type="file" style="display: none; overflow-x:hidden;" name="FileUpload" id="fu_SP" onchange="doUpload('fu_SP')"/>

					</div>

				</div>

			</div>

		</form>

@else

<div class="text-center alert alert-info">You need to be part of the team or approved to see and add comments</div>

@endif

	</div>

</div>

<div class="row">

	<div class="col-md-12">

	@if($member != null && $member->approved == 1)

		<div id="statusarea" style="overflow-x: hidden;">

				@foreach ($team->posts as $post)

			<div id="status" class="status_boxes animated bounceInLeft" style="overflow-x:hidden;">

					<div>
						<div class="col-md-9">
							<img src="/images/users/{{ $post->user->avatar }}" class="img-circle" width="60" height="60" border="0">

							<b>Sent by <a href="#">{{ $post->user->name }}</a>&nbsp;{{ $post->created_at->diffForHumans() }}</b>
						</div>
						<div class="col-md-1">

							<a href="{{ route('posts.edit',[$post->team_id, $post->id]) }}" class="btn btn-primary btn-sm">Edit</a>

						</div>

						<div class="col-md-1">

							<form action="{{ route('posts.destroy', [$team->id, $post->id]) }}" method="POST">

								{{ csrf_field() }}
								{{ method_field('DELETE') }}

								<button type="submit" class="btn btn-danger btn-sm">Delete</button>

							</form>

						</div>
					<div class="row">
						<div class="col-md-12">

							<p>
								{!! $post->body !!}
								@if($post->image)

									<br /><img src="/images/teams/posts/{{ $post->image }}" width="100%"></p>

								@endif
							</p>
						</div>
					</div>

				</div>

			</div>

				@endforeach

		</div>

	@endif

	</div>

</div>


@endsection

<script src="/js/post.js" type="text/javascript"></script>
