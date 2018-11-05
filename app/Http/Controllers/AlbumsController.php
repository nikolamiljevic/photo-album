<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Album;

class AlbumsController extends Controller
{
    public function index(){
        $albums = Album::with('Photos')->get();
        return view('albums.index')->with('albums',$albums);
    }   

    public function create(){
        return view('albums.create');
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'cover_image'=>'image|max:1999'
        ]);

        //ime fajla se ekstenzijom jpg
      $filenameWithExt =  $request->file('cover_image')->getClientOriginalName();
        //samo ime fajla bez ekstenzije
      $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

      //dobavljanje ekstenzije
         $extension = $request->file('cover_image')->getClientOriginalExtension();
      //sad pravimo novo ime fajla gde ubacujemo ime fajla + vreme + tacka + ekstenzija
        $filenameToStore = $filename.'_'.time().'.'.$extension;
      //upload slike
        $path = $request->file('cover_image')->storeAs('public/album_covers', $filenameToStore);
      //pravljenje albuma
      $album = new Album;
      $album->name = $request->input('name');
      $album->description = $request->input('description');
      $album->cover_image = $filenameToStore;
      $album->save();
      return redirect('/albums')->with('success','Album created');
    }

    public function show($id){
        $album = Album::with('Photos')->find($id);
        return view('albums.show')->with('album',$album);
    }
}

