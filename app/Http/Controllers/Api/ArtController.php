<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArt;
use App\Http\Resources\Art as ArtResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\SingleArt;
use App\Http\Resources\SubCategoryResource;
use Illuminate\Http\Request;
use App\Models\Art;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Support\Str;
use Auth;
use Illuminate\Support\Facades\Log;

class ArtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $cat = $request->query('category');
        $subcat
            = $request->query('subcategory');
        if ($cat == 0) {
            $art = Art::where('id', '>', 0)->latest()->paginate(10);
        } else {
            if ($subcat == 0) {
                $art = Art::where('category_id', $cat)->latest()->paginate(10);
            } else {
                $art = Art::where('sub_category_id', $subcat)->latest()->paginate(10);
            }
        }



        // dd
        // return new SingleArt::collection($art);
        return response()->json(["message" => "Art Retrieved Successfully", 'success' => true, "data" =>  SingleArt::collection($art)]);
    }

    public function search(Request $request)
    {
    }

    public function userart($user)
    {
        $art = User::find($user)->art;

        return response()->json(["message" => "Art Retrieved Successfully", 'success' => true, "data" =>  SingleArt::collection($art)]);
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

        Log::info($request);

        // handle file uploads
        $img = $request->file('image');

        $path = $img->storeAs('art',  Str::random(10) . '.' . $img->getClientOriginalExtension(),  'public');

        if ($request->is3d) {
            $art->is3d = 1;
        }

        $art->title = $request->title;
        $art->description = $request->description;
        $art->location = $request->location;
        $art->sub_category_id = $request->subcategory;
        $art->image = $path;
        $art->user_id = $request->user()->id;
        $art->category_id = $request->category;




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

    public function subcategories($category)
    {
        $subs = SubCategory::where('category_id', $category)->get();

        return response()->json(["message" => "Sub Categories Retrieved Successfully", "success" => true, "data" => SubCategoryResource::collection($subs)]);
    }


    public function searchart(Request $request)
    {
        $q = $request->get('q');
        Log::alert($q);

        $art = Art::where('title', 'LIKE', '%' . $q . '%')->orWhere('description', 'LIKE', '%' . $q . '%')->get();

        if (count($art) > 0) {
            return response()->json(["message" => "Search Results for Query etrieved SuccessfullyR", "success" => true, "data" => SingleArt::collection($art)]);
        } else {
            return response()->json(["message" => "No Results for Query", "success" => true, "data" => []]);
        }
    }

    public function searchartist(Request $request)
    {

        $q = $request->get('q');
    }
}
