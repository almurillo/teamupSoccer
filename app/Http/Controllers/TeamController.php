<?php

namespace App\Http\Controllers;

use App\Team;
use App\Post;
use App\User;
use App\Member;
use App\Game;
use App\Player;
use Illuminate\Http\Request;
use DB;
use Image;
use Storage;
use Gate;
use Auth;
use Carbon\Carbon;
use Intervention\Image\ImageManager;

class TeamController extends Controller
{

    public function __construct(){


    $this->middleware('auth');

}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $states = DB::table('states')->get();

        return view('teams.create',compact('states'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate(request(), [

            'name' => 'required|min:2|unique:teams,name',

            'invite' => 'required',

            'state' => 'required|min:2',

            'city' => 'required|min:2',

            'team_avatar' => 'sometimes|image'

            ]);

        $team = new Team;

        $team->name = $request->name;

        $team->invrule = $request->invite;

        $team->state_code = $request->state;

        $team->city = $request->city;

        $team->user_id = auth()->id();

        if($request->hasFile('team_avatar')){

            $image = $request->file('team_avatar');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/teams/' . $filename);
            Image::make($image)->resize(400, 400)->orientate()->save($location);

            $team->logo = $filename;

        } else {

            $team->logo = 'gLogo.png';

        }


        $team->save();

        $member = new Member;

        $member->team_id = $team->id;
        $member->user_id = auth()->id();
        $member->approved = '1';
        $member->admin = '1';

        $member->save();

        return redirect()->route('teams.show', $team->id)->withMessage('Your new team has been created. let\'s play soccer');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team, Game $game)
    {

        $member = Member::where(['user_id' => auth()->id(), 'team_id' => $team->id])
        ->first();
        if($member == null){
          $member = [];
        }
        $user = User::where('id','=',$team->user_id)->first();

        $approves = Member::join('users','users.id', '=', 'members.user_id')
        ->where(['members.approved'=>'0', 'members.team_id' => $team->id])
        ->select('members.*','users.name')
        ->get();

        $games = Game::where('games.team_id',$team->id)
        ->whereDate('games.game_time','>=', Carbon::today()->toDateString())
        ->orderBy('games.game_time', 'ASC')
        ->get();

        $players = Player::where(['team_id'=>$team->id])
        ->get();

        // dd($games);

        return view('teams.show', compact('team','user','member','approves','games','players'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
    $user = Auth::user();
    // if (Gate::allows('update-team', $team)){
    if ($user->can('view', $team)){
        $states = DB::table('states')->get();

        return view('teams.edit', compact('team','states'));

    }else{

        return back();

      }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

      $team = Team::find($id);
        // dd($team->id);
      if ($user->can('update', $team)){
        $this->validate(request(), [

            'name' => "required|min:2|unique:teams,name,$id",

            'invite' => 'required',

            'state' => 'required|min:2',

            'city' => 'required|min:2',

            'team_avatar' => 'sometimes|image'

            ]);

        // $team = Team::find($id);

        $team->name = $request->name;

        $team->invrule = $request->invite;

        $team->state_code = $request->state;

        $team->city = $request->city;

        if($request->hasFile('team_avatar')){

            $image = $request->file('team_avatar');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/teams/' . $filename);
            Image::make($image)->resize(400, 400)->orientate()->save($location);

            $oldimage = $team->logo;

            $team->logo = $filename;

            storage::delete($oldimage);

        }

        $team->save();

        return redirect()->route('teams.show', $team->id)->withMessage('Your team information has been updated!');
      }
      return ("You are not allowed to change anything on the team!");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
      $user = Auth::user();
      if ($user->can('delete', $team)){
        Storage::delete($team->logo);

        // $team->users()->detach();

        $team->delete();
        // Member::where('team_id', $team)->delete();

        return redirect('/')->withErrors('Your team has been deleted!');
      }
        return back()->withErrors("You cannot delete this team!");
    }
}
