<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Team;

class MembersController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
       
       $user_id = auth()->id();
       $count = Member::where(['team_id' => $id, 'user_id' => $user_id])->count();

       if($count > 0){

        return back()->withMessage('You are already a member of this team');

       }

        $member = new Member;

        $member->team_id = $id;
        $member->user_id = auth()->id();


        $app = Team::where('id',$id)->first();
        if($app->invrule == 1 ){

            $app = '0';

        }else{

            $app = '1';

        }

        $member->approved = $app;

        $member->save();

        if($app == 1){

            return back()->withMessage('You\'re now part of the team. Have fun!');

        }else{

            return back()->withMessage('You request is pending approval; please allow sometime to be approved');

        }

        
    }

    public function update($team, $member)

    {
        

        $member = Member::find($member);

        $member->approved = '1';

        $member->save();


        return back()->withMessage('Player has been approved!');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $team, $member)
    {
        $member = Member::where('id', $member)->first();

        if($member->admin == '1'){

            return back()->withErrors('You are the admin for this Team you cannot leave the team!');

        }else{

        $member->delete();

        return back()->withErrors('Player has left this team');

        }
        
    }
}
