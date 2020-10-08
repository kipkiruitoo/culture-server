<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArt;
use App\Http\Resources\Art as ArtResource;
use App\Http\Resources\SingleArt;
use Illuminate\Http\Request;
use App\Models\Art;

class ArtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $art = Art::jsonPaginate();

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


        $art = new Art($request->validated());

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
}
