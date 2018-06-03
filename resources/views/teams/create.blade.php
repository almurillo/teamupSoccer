@extends('layouts.main')


@section ('title','| Create Team')

@section ('content')

  @include ('layouts.errors')
  @include ('layouts.success')

<h1>Create a New Team</h1>

<div class="row">

	<div class="col-md-12">

		<hr />
		<div class="well">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data">

						{{ csrf_field() }}

						<div class="form-group">
							<label for="name">Team Name:</label>
							<input type="text" id="name" name="name" {{-- onBlur="checkGname()" --}} class="form-control" v-model="teamName">

            </div>

						<div class="form-group">
							<span id="gnamestatus"></span>
						</div>

						<div class="form-group">
							<label for="join">How To Join The Team:</label>
							<select name="invite" id="invite" class="form-control">
								{{-- <option value="null" selected>&nbsp</option> --}}
								<option value="1">Ask to join</option>
								<option value="0">Join immediately</option>
							</select>
						</div>

						<div class="form-group">
							<label for="state">State:</label>
							<select id="state" name="state" class="form-control">
								<option></option>
							@foreach ($states as $state)

								<option value="{{ $state->state_code }}">{{ $state->state_code }}</option>

							@endforeach
              <geo-select></geo-select>

							</select>
						</div>

						<div class="form-group">
							<label for="city">City:</label>
						<select class="form-control" name="city" id="city">
							<option></option>
						</select>
						</div>

						<div class="form-group">
							<label for="city">Upload Avatar:</label>
							<input type="file" name="team_avatar" id="team_avatar">
						</div>

						<div class="form-group">
						<button class="btn btn-success btn-block hvr-wobble-vertical" id="newGroupbtn">
							Create Team
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
<script src="https://unpkg.com/vue@2.0.3/dist/vue.js"></script>
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
  Vue.component('geo-select', require('RELATIVE_PATH_TO/vendor/igaster/laravel_cities/src/vue/geo-select.vue'));
  var app = new Vue({
  el: '#app',
  data: {
    teamName: ''
  }
})


</script>

@endsection
