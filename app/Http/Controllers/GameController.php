<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Team;
use App\User;
use App\Member;
use Carbon\Carbon;
use Auth;


class GameController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

        $team = Team::where('id',$id)->first();

        return view('games.create', compact('team'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {

        $this->validate($request,[

            'place' => 'required|min:5',
            'field' => 'required|numeric',
            'time'  => 'required|date|after:now'

            ]);

        $time = date("Y-m-d H:i", strtotime($request->time));

        $game = new Game;
        $game->team_id = $id;
        $game->place = $request->place;
        $game->field = $request->field;
        $game->game_time = $time;
        $game->save();

        return redirect()->route('teams.show',$id)->withMessage('New game time has been added it!');


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($team_id, $id)
    {

      $team = Team::where('id',$team_id)->first();

      if(Auth::user()->id == $team->user_id){

        $eGame = Game::where('id', $id)->first();

        return view('games.edit', compact('eGame'));

      } else {

        return back();

      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $team_id, $id)
    {

          $this->validate($request,[

            'place' => 'required|min:5',
            'field' => 'required|numeric',
            'time'  => 'required|date|after:now'

            ]);

          $time = date("Y-m-d H:i", strtotime($request->time));

          $game = Game::find($id);
          $game->place = $request->place;
          $game->field = $request->field;
          $game->game_time = $time;
          $game->save();

          return redirect()->route('teams.show',$team_id)->withMessage('Game has been updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
