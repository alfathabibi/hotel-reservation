<?php

namespace App\Http\Controllers;

use App\Models\Ballroom;
use App\Models\BallroomPhotos;
use Illuminate\Http\Request;

class BallroomController extends Controller
{
    //
    public function index(){
        return view('pages/ballrooms/ballrooms',[
            "title" => "Ballrooms",
            'active' => 'ballrooms',
            "ballrooms" => Ballroom::all()
        ]);
    }

    public function create(){
        return view('pages/ballrooms/createballroom',[
            "title" => "Create Ballroom",
            'active' => 'ballrooms'
        ]);
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|unique:ballrooms',
            'price' => 'required',
            'capacity' => 'required',
            'area' => 'required|max:2',
            'facility' => 'required',
            'floor' => 'required|max:3'
        ]);

        $validatedPhotos = $request->validate([
            'photo1' => 'image|file|max:2048',
            'photo2' => 'image|file|max:2048',
            'photo3' => 'image|file|max:2048',
        ]);

        $photo1 = $request->file('photo1')->store('room-photos');
        $photo2 = $request->file('photo2')->store('room-photos');
        $photo3 = $request->file('photo3')->store('room-photos');

        $ballroom = Ballroom::create($validatedData)->photos()->createMany([
            [
                "text" => $photo1
            ],
            [
                "text" => $photo2
            ],
            [
                "text" => $photo3
            ]
        ]);

        $request->session()->flash('success', 'Add Room Successfull!');

        return redirect('/ballrooms/create');
    }

    public function update(Request $request, $name){

        $validatedData = $request->validate([
            'name' => 'required|unique:ballrooms',
            'price' => 'required',
            'capacity' => 'required',
            'area' => 'required|max:2',
            'facility' => 'required',
            'floor' => 'required|max:3'
        ]);

        if($request->file('photo1')){
            $photo1 = $request->file('photo1')->store('ballroom-photos');
            BallroomPhotos::find($request['idPhoto1'])->update([
                "text" => $photo1
            ]);
        }

        $updatedRoom = Ballroom::where('name', $name)
            ->update($validatedData);

        $request->session()->flash('success', 'Add Ballroom Successfull!');

        return redirect('/ballrooms/update/'.$validatedData['name']);
    }

    public function delete(Request $request){
        $validatedData = $request->validate([
            'name' => 'required'
        ]);

        $ballroom = Ballroom::where('name', $validatedData['name'])->firstOrFail();
        BallroomPhotos::where('ballroom_id', $ballroom->id)->delete();
        $ballroom->delete();
        
        $request->session()->flash('success', 'Delete Ballroom Successfully');
        
        return redirect('/ballrooms');
    }
}
