<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Player;
use App\Member;

use Carbon\Carbon;

class PlayerController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($team_id, $game_id)
    {

       $user_id = auth()->id();
       $count = Player::where(['team_id' => $team_id, 'user_id' => $user_id, 'game_id' => $game_id])->count();

       $member = Member::where(['team_id' => $team_id, 'user_id' => $user_id])->first();
       $memberCount = Member::where(['team_id' => $team_id, 'user_id' => $user_id])->count();

       if($count > 0){

        return back()->withErrors('You are already going to this team\'s game');

      } else if (@$member->approved == 0 || $memberCount == 0){

        return back()->withErrors('You need to be part of the Team or approve to join the game.');

       } else {

       $player = new Player;
       $player->team_id = $team_id;
       $player->game_id = $game_id;
       $player->user_id = $user_id;

       $player->save();

       return back()->withMessage('You have been added it to the game!');

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($game_id)
    {
      $players = Player::join('users','players.user_id','=','users.id')
      ->join('games','players.game_id','=','games.id')
      ->whereDate('games.game_time','>=', Carbon::today()->toDateString())
      ->where('games.id','=',$game_id)
      ->get();

      // dd($players);

     return view('players.show', compact('players'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($team_id,$game_id,$user_id)
    {
      Player::where(['team_id'=>$team_id,'game_id'=>$game_id,'user_id'=>$user_id])->detach();
    }
}
