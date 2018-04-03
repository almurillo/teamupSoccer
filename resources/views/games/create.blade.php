@extends ('layouts.main')

@section ('title', 'Create New Game')

@section ('content')


	@include ('layouts.errors')
	@include ('layouts.success')


<div class="well">
	<h3>
		New Game Set Up
	</h3>
 <form class="form" name="gameForm" action="{{ route('games.store', $team->id) }}" method="POST">

 	{{  csrf_field() }}

 	<div class="form-group">
		<label for="place">Field Name:</label>
		<input type="text" id="place" name="place" class="form-control">
	</div>

	<div class="row">

		<div class="col-md-2">

			<div class="form-group">
				<select class="form-control" name="field" id="field">
    			 <?php for($i=1;$i<=10;$i++){
			     echo "<option>" . $i . "</option>";
			     	}
			     ?>
			     </select>


			</div>

		</div>

		<div class="col-md-6">

			<div class='input-group' id='calendar1'>
  			<input type="text" name="time" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
			</div>

		</div>

	<div class="col-md-4">

		<div class="form-group">
			<button class="btn btn-primary btn-block hvr-wobble-vertical" id="newGame">
				Add New Game
			</button>
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
