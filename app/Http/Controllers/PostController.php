<?php

namespace App\Http\Controllers;

use App\Post;
use App\Team;
use Image;
use Storage;
use Purifier;
use Gate;
use App\User;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function __construct(){


    $this->middleware('auth');

}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {

        function linkifyYouTubeURLs($text) {
        $text = preg_replace('~
            # Match non-linked youtube URL in the wild. (Rev:20130823)
            https?://         # Required scheme. Either http or https.
            (?:[0-9A-Z-]+\.)? # Optional subdomain.
            (?:               # Group host alternatives.
              youtu\.be/      # Either youtu.be,
            | youtube         # or youtube.com or
              (?:-nocookie)?  # youtube-nocookie.com
              \.com           # followed by
              \S*             # Allow anything up to VIDEO_ID,
              [^\w\s-]       # but char before ID is non-ID char.
            )                 # End host alternatives.
            ([\w-]{11})      # $1: VIDEO_ID is exactly 11 chars.
            (?=[^\w-]|$)     # Assert next char is non-ID or EOS.
            (?!               # Assert URL is not pre-linked.
              [?=&+%\w.-]*    # Allow URL (query) remainder.
              (?:             # Group pre-linked alternatives.
                [\'"][^<>]*>  # Either inside a start tag,
              | </a>          # or inside <a> element text contents.
              )               # End recognized pre-linked alts.
            )                 # End negative lookahead assertion.
            [?=&+%\w.-]*        # Consume any URL (query) remainder.
            ~ix', 
            '<p><div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" title="YouTube video player" class="youtube-player" type="text/html" src="https://www.youtube.com/embed/$1" frameborder="10" allowfullscreen></iframe></div></p>',
            $text);
    return $text;
    }
        
        $this->validate($request,[

            'body' => 'required|min:5'

            ]);

        $team = Team::find($id);

        $post = new Post;

        $youtube = linkifyYouTubeURLs($request->body);

        $post->body = Purifier::clean($youtube,'youtube');

        $post->user_id = auth()->id();

        $post->team_id = $team->id;

        if($request->hasFile('FileUpload')){

            $image = $request->file('FileUpload');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/teams/posts/' . $filename);
            Image::make($image)->resize(400, 300)->save($location);

            $post->image = $filename;

        }

        $post->save();

        return back()->withMessage('Your post has been added to the team');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($team_id, $post_id)
    {
        
        $post =  Post::find($post_id);
        $team = Team::find($team_id);
        $user = User::where('id','=',$team->user_id)->first();

        return view('posts.edit',compact('post','team','user'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $team_id, $post_id )
    {
        
    function linkifyYouTubeURLs($text) {
        $text = preg_replace('~
            # Match non-linked youtube URL in the wild. (Rev:20130823)
            https?://         # Required scheme. Either http or https.
            (?:[0-9A-Z-]+\.)? # Optional subdomain.
            (?:               # Group host alternatives.
              youtu\.be/      # Either youtu.be,
            | youtube         # or youtube.com or
              (?:-nocookie)?  # youtube-nocookie.com
              \.com           # followed by
              \S*             # Allow anything up to VIDEO_ID,
              [^\w\s-]       # but char before ID is non-ID char.
            )                 # End host alternatives.
            ([\w-]{11})      # $1: VIDEO_ID is exactly 11 chars.
            (?=[^\w-]|$)     # Assert next char is non-ID or EOS.
            (?!               # Assert URL is not pre-linked.
              [?=&+%\w.-]*    # Allow URL (query) remainder.
              (?:             # Group pre-linked alternatives.
                [\'"][^<>]*>  # Either inside a start tag,
              | </a>          # or inside <a> element text contents.
              )               # End recognized pre-linked alts.
            )                 # End negative lookahead assertion.
            [?=&+%\w.-]*        # Consume any URL (query) remainder.
            ~ix', 
            '<p><div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" title="YouTube video player" class="youtube-player" type="text/html" src="https://www.youtube.com/embed/$1" frameborder="10" allowfullscreen></iframe></div></p>',
            $text);
    return $text;
    }
        
        $this->validate($request,[

            'body' => 'required|min:5'

            ]);

        $post = Post::find($post_id);

        $youtube = linkifyYouTubeURLs($request->body);

        $post->body = Purifier::clean($youtube,'youtube');

        $post->user_id = auth()->id();

        $post->team_id = $team_id;

        if($request->hasFile('FileUpload')){

            $image = $request->file('FileUpload');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/teams/posts/' . $filename);
            Image::make($image)->resize(400, 300)->save($location);

            $post->image = $filename;

        }

        $post->save();

        return redirect()->route('teams.show', $team_id)->withMessage('Your post has been updated');    

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($team_id, $post_id)
    {
       
        $post = Post::find($post_id);

        $post->delete();

        return redirect()->route('teams.show', $team_id)->withMessage('Your post has been deleted'); 

    }
}
