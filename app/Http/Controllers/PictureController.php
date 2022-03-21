<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Models\Picture;
use InterventionImage;
//Storegeの読み込み
use Illuminate\Support\Facades\Storage;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('picture.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('picture.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        $validator = Validator::make($request->all(), [
            'title' => 'required | max:191',
            'picture' => 'required|file|image',
        ]);

        // バリデーション:エラー
        if ($validator->fails()) {
            return redirect()
                ->route('picture.create')
                ->withInput()
                ->withErrors($validator);
        }

        $upload_image = $request->file('picture');
        $path = $upload_image->store('uploads', "public");

        if($path){
            //DBに保存
            $result = Picture::create([
                "title" => $request->title,
                "pictureUrl" => $path
            ]);
        }

        $resize = "storage/" . $path;
        // dd($resize);
        InterventionImage::make($resize)->resize(100, null, function ($constraint) {$constraint->aspectRatio();})->save();

        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
