@extends('layouts.main')

@section('title', "| $team->name")

@section('content')

@include ('layouts.errors')
@include ('layouts.success')

<div class="row">
	
<div class="col-sm-3">
	
	<img class="img-circle" src="/images/teams/{{ $team->logo }}" width="150" height="150">

</div>

<div class="col-sm-6">
	
		<h1>{{ $team->name }} <br>
		<small>{{ $team->city }} , {{ $team->state_code }}</small><br>
		<h5>Created by {{ $user->name }}</h5></h1>

</div>


</div>
<hr>

<div class="row">
	
	<div class="col-md-12">
		
		<form enctype="multipart/form-data" method="POST" action="{{ route('posts.update', [$team->id, $post->id]) }}">

			{{ csrf_field() }}

			{{ method_field('PUT')}}
			
			<div class="form-group">

			<textarea onfocus="showBtnDiv()" name="body" id="body" class="form-control">{{ clean($post->body) }}</textarea>

			</div>

			<div id="btns_SP" style="overflow-x:hidden;" >

				<div class="col-md-6">

					<div class="form-group">
						
						<button class="btn btn-success btn-block hvr-wobble-vertical">Edit Post</button>

					</div>

				</div>

				<div class="col-md-6">

					<div class="form-group">
						
						<button id="triggerBtn_SP" class="btn btn-default btn-block hvr-wobble-vertical" onclick="triggerUpload(event, 'fu_SP')">Upload Image</button>
						<input type="file" style="display: none; overflow-x:hidden;" name="FileUpload" id="fu_SP" onchange="doUpload('fu_SP')"/>

					</div>

				</div>

			</div>

		</form>

	</div>

</div>

@endsection

<script src="/js/post.js" type="text/javascript"></script>