<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Photo;


class PhotosController extends Controller
{
    public function create($album_id){
        return view('photos.create')->with('album_id',$album_id);

    }
    public function store(Request $request){

        $this->validate($request,[
            'title'=>'required',
            'photo'=>'image|max:1999'
        ]);

        //ime fajla se ekstenzijom jpg
      $filenameWithExt =  $request->file('photo')->getClientOriginalName();
        //samo ime fajla bez ekstenzije
      $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

      //dobavljanje ekstenzije
         $extension = $request->file('photo')->getClientOriginalExtension();
      //sad pravimo novo ime fajla gde ubacujemo ime fajla + vreme + tacka + ekstenzija
        $filenameToStore = $filename.'_'.time().'.'.$extension;
      //upload slike
        $path = $request->file('photo')->storeAs('public/photos/'.$request->input('album_id'), $filenameToStore);
      //ubacivanje slike
      $photo = new Photo;
      $photo->album_id = $request->input('album_id');
      $photo->title = $request->input('title');
      $photo->description = $request->input('description');
      $photo->size = $request->file('photo')->getClientSize();
      $photo->photo = $filenameToStore;
      $photo->save();
      return redirect('/albums/'.$request->input('album_id'))->with('success','Photo uploaded');
    }
    
    public function show($id){
        $photo = Photo::find($id);
        return view('photos.show')->with('photo',$photo);
    }

    public function destroy($id){
        $photo = Photo::find($id);
       if(Storage::delete('public/photos/'.$photo->album_id.'/'.$photo->photo)){
        $photo->delete();
        return redirect('/')->with('success','Photo deleted');
       }
    }
}
