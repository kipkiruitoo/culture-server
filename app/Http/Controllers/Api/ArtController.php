<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArt;
use App\Http\Resources\Art as ArtResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\SingleArt;
use Illuminate\Http\Request;
use App\Models\Art;
use Auth;

class ArtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $art = Art::where('id', '>', 0)->latest()->paginate(10);

        // dd
        // return new SingleArt::collection($art);
        return response()->json(["message" => "Art Saved Successfully", 'success' => true, "data" =>  SingleArt::collection($art)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArt $request)
    {


        $art = new Art();

        // handle file uploads
        $img = $request->file('image');

        $path = $img->store('art', 'public');

        $art->title = $request->title;
        $art->description = $request->description;
        $art->location = $request->location;
        $art->image = $path;
        $art->user_id = $request->user()->id;
        $art->category_id = 1;




        // dd($request->all());
        // dd($art);
        if ($art->save()) {
            // dd(Art::find($art->id)->get());
            return response()->json(["message" => "Art Saved Successfully", 'success' => true, "data" => new SingleArt($art)]);
        } else {
            return response()->json(["message" => "An error occured", 'success' => false]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($art)
    {
        // $art = $art->jsonPaginate();
        if (Art::where('id', $art)->exists()) {
            $art = Art::find($art);
            return response()->json(["message" => "Art Retrieved Successfully", 'success' => true, "data" => new SingleArt($art)]);
        }

        return response()->json(["message" => "No Query Results for art with id " . $art, 'success' => false], 404);
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
    public function destroy($id)
    {
        //
    }


    public function like(Art $art)
    {
        $user = Auth::user();

        $user->like($art);
        return response()->json(["message" => "Art Liked Successfully", 'success' => true, "data" => new SingleArt($art)]);
    }


    public function unlike(Art $art)
    {
        $user = Auth::user();

        $user->unlike($art);


        return response()->json(["message" => "Art UnLiked Successfully", 'success' => true, "data" => new SingleArt($art)]);
    }

    public function favourite(Art $art)
    {
        $user = Auth::user();
        $user->favorite($art);

        return response()->json(["message" => "Art Favourited Successfully", 'success' => true, "data" => new SingleArt($art)]);
    }

    public function unfavourite(Art $art)
    {
        $user = Auth::user();
        $user->unfavorite($art);

        return response()->json(["message" => "Art UnFavourited Successfully", 'success' => true, "data" => new SingleArt($art)]);
    }

    public function favouriteItems()
    {
        $user = Auth::user();

        $art = $user->getFavoriteItems(Art::class);

        dd($art);

        return response()->json(["message" => "Favourited Items retrieved Successfully", 'success' => true, "data" =>  SingleArt::collection($art)]);
    }

    public function comment(Request $request)
    {
        $comment = $request->comment;
        $art = Art::find($request->art);
        $user = $request->user();

        $user->comment($art, $comment);

        return
            response()->json(["message" => "Comment  Saved Successfully", 'success' => true, "data" => new SingleArt($art)]);
    }

    public function comments(Art $art)
    {
        $comments = $art->comments;
        return
            response()->json(["message" => "Comment  Saved Successfully", 'success' => true, "data" =>  CommentResource::collection($comments)]);
    }
}
