@extends('layouts.main')


@section ('title','| Edit Your Team')

@section ('content')

  @include ('layouts.errors')
  @include ('layouts.success')

<h1>Update Your Team Information</h1>

<div class="row">
	
	<div class="col-md-12">
		
		<hr />
		<div class="well">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<form action="{{ route('teams.update', $team->id) }}" method="POST" enctype="multipart/form-data">

						{{ csrf_field() }}

						{{ method_field('PUT') }}

						<div class="form-group">
							<label for="name">Team Name:</label>
							<input type="text" id="name" name="name" {{-- onBlur="checkGname()" --}} class="form-control" value="{{ $team->name }}">
						</div>

						<div class="form-group">
							<span id="gnamestatus"></span>
						</div>

						<div class="form-group">
							<label for="join">How To Join The Team:</label>
							<select name="invite" id="invite" class="form-control">
									
								@if ($team->invrule =='1') 
									<option value="1">Ask to join</option>
								@else
									<option value="0">Join immediately</option>
								@endif

								@if ($team->invrule ==='1') 
									<option value="0">Join immediately</option>
								@else
									<option value="1">Ask to join</option>
								@endif

							</select>
						</div>

						<div class="form-group">
							<label for="state">State:</label>
							<select id="state" name="state" class="form-control">
								<option value="{{ $team->state_code }}">{{ $team->state_code }}</option>
							@foreach ($states as $state)

								<option value="{{ $state->state_code }}">{{ $state->state_code }}</option>

							@endforeach
							</select>
						</div>

						<div class="form-group">
							<label for="city">City:</label>
						<select class="form-control" name="city" id="city">
							<option value="{{ $team->city }}">{{ $team->city }}</option>
						</select>
						</div>

						<div class="form-group">
							<label for="city">Upload Avatar:</label>
							<input type="file" name="team_avatar" id="team_avatar">
						</div>

						<div class="form-group">
						<button class="btn btn-success btn-block hvr-wobble-vertical" id="newGroupbtn">
							Update Team
						</button>
						</div>

						<div class="form-group">
						<span id="status"></span>
						</div>

						</form>
					</div>
				</div>
			</div>

	</div>

</div>
<script>

    $('#state').on('change',function(){
    var state_code = $(this).val();    
    if(state_code){
        $.ajax({
           type:"GET",
           url:"{{url('api/get-city-list')}}?state_code="+state_code,
           success:function(res){               
            if(res){
                $("#city").empty();
                $.each(res,function(key,value){
                	value = JSON.stringify(value);
                	value = value.slice(9);
                	value = value.slice(0,-2);
                    $("#city").append('<option value="'+value+'">'+value+'</option>');
                });
           
            }else{
               $("#city").empty();
            }
           }
        });
    }else{
        $("#city").empty();
 	}

  });

</script>

@endsection