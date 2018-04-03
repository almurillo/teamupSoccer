@extends ('layouts.main')

@section ('title', 'Create New Game')

@section ('content')


	@include ('layouts.errors')
	@include ('layouts.success')

<div class="well">
	<h3>
		New Game Set Up
	</h3>
 <form class="form" name="gameForm" action="{{ route('games.update', [$eGame->team_id, $eGame->id]) }}" method="POST">

 	{{  csrf_field() }}
 	{{ method_field('PUT') }}

 	<div class="form-group">
		<label for="place">Field Name:</label>
		<input type="text" id="place" name="place" class="form-control" value="{{ $eGame->place }}">
	</div>
	
	<div class="row">
		
		<div class="col-md-4">

			<div class="form-group">
			<label for="place">Field#:</label>
				<select class="form-control" name="field" id="field">

				<option value="{{ $eGame->field }}">{{ $eGame->field }}</option>
    			 <?php for($i=1;$i<=10;$i++){
			     echo "<option>" . $i . "</option>";
			     	}
			     ?>
			     </select>
							

			</div>

		</div>

		<div class="col-md-8">
			<label for="place">Date/Time:</label>
			<div class='input-group' id='calendar1'>
  			<input type="text" name="time" class="form-control" value="{{ date('m/d/Y h:i:A', strtotime($eGame->game_time)) }}"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
			</div>	

		</div>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">

			<div class="form-group">
				<button class="btn btn-success btn-block hvr-wobble-vertical" id="editGame">
					 Update
				</button>
			</div>

		</div>
	</div>

</div>

	</form>
	</div>
        <script type="text/javascript">
          $(function () {
              var date = new Date();
              date.setDate(date.getDate());

            $('#calendar1').datetimepicker({
                minDate: 'now',
                showTodayButton: true,
                showClear: true,
                minDate: date
            });
        });
        </script>




@endsection
