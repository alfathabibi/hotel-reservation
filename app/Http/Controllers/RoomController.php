<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomPhotos;
use App\Models\RoomTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    //

    public function index(){
        return view('pages/rooms/rooms',[
            "title" => "Rooms",
            'active' => 'rooms',
            "rooms" => Room::all()
        ]);
    }

    public function create(){
        return view('pages/rooms/createroom',[
            "title" => "Create Room",
            'active' => 'rooms'
        ]);
    }

    public function edit($room_number){
        $room = Room::where('room_number', $room_number)->with('photos')->firstOrFail();
        
        return view('pages/rooms/updateroom',[
            "title" => "Update Room",
            'active' => 'rooms',
            'room' => $room
        ]);
    }

    public function transaction(){

        $transactions = RoomTransaction::with('room')
            ->orderBy('payment_status')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages/rooms/transactionroom',[
            "title" => "Room Transactions",
            'active' => 'rooms',
            "transactions" => $transactions
        ]);
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'room_number' => 'required|unique:rooms|max:4',
            'price' => 'required',
            'type' => 'required',
            'room_area' => 'required|max:2',
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

        $room = Room::create($validatedData)->photos()->createMany([
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

        return redirect('/rooms/create');
    }

    public function delete(Request $request){
        $validatedData = $request->validate([
            'room_number' => 'required'
        ]);

        $room = Room::where('room_number', $validatedData['room_number'])->firstOrFail();
        RoomPhotos::where('room_id', $room->id)->delete();
        $room->delete();
        
        $request->session()->flash('success', 'Delete Room Successfully');
        
        return redirect('/rooms');
    }

    public function update(Request $request, $room_number){

        $validatedData = $request->validate([
            'room_number' => 'required|max:4',
            'price' => 'required',
            'type' => 'required',
            'room_area' => 'required|max:2',
            'floor' => 'required|max:3'
        ]);

        if($request->file('photo1')){
            $photo1 = $request->file('photo1')->store('room-photos');
            RoomPhotos::find($request['idPhoto1'])->update([
                "text" => $photo1
            ]);
        }
        if($request->file('photo2')){
            $photo2 = $request->file('photo2')->store('room-photos');
            RoomPhotos::find($request['idPhoto2'])->update([
                "text" => $photo2
            ]);
        }
        if($request->file('photo2')){
            $photo2 = $request->file('photo2')->store('room-photos');
            RoomPhotos::find($request['idPhoto2'])->update([
                "text" => $photo2
            ]);
        }

        $updatedRoom = Room::where('room_number', $room_number)
            ->update($validatedData);

        $request->session()->flash('success', 'Add Room Successfull!');

        return redirect('/rooms/update/'.$validatedData['room_number']);
    }

    public function createTransaction(Request $request){
        
        $validatedData = Validator::make(
            $request->all(),
            [
                'fromDate' => 'required',
                'toDate' => 'required',
                'customer_id' => 'required',
                'room_id' => 'required',
            ]
        );

        if($validatedData->fails()){
            return response()->json([
                'status' => false,
                'messages' => $validatedData->errors()
            ], 400);
        };

        $room = Room::where('id', $request['room_id'])->firstOrFail();

        if(!$room){
            return response()->json([
                'status' => false,
                'messages' => 'Room tidak ditemukan'
            ], 400);
        }

        $fromDate = strtotime($request['fromDate']);
        $toDate = strtotime($request['toDate']);
        $datediff = round(($toDate - $fromDate) / (60 * 60 * 24));
        
        $request['price'] = $room->price * $datediff;

        $room_transaction = RoomTransaction::create($request->all());

        return response()->json($room_transaction);
    }

    public function getListRooms(Request $request){
        // $data = DB::select('select r.*, rp.text as photos from rooms r
        // left join room_photos rp on r.id = rp.room_id
        // where r.id not in (select room_id from room_transactions where 
        // (fromDate between "2022-06-06" and "2022-06-09") or 
        // (toDate between "2022-06-06" and "2022-06-09") or
        // ("2022-06-06" between fromDate and toDate) or 
        // ("2022-06-09" between fromDate and toDate))
        // group by r.room_number'
        // );

        $validatedData = Validator::make(
            $request->query(),
            [
                'fromDate' => 'required',
                'toDate' => 'required',
            ]
        );

        if($validatedData->fails()){
            return response()->json([
                'status' => false,
                'messages' => $validatedData->errors()
            ], 400);
        };

        $from = $request->query('fromDate');
        $to = $request->query('toDate');

        $data = Room::whereNotIn('id', 
            RoomTransaction::select('room_id')
                ->where('status', '=', 'active')
                ->where(function($query) use($from, $to){
                    $query->orWhere(function($query) use($from, $to){
                        $query->whereBetween('fromDate', [$from, $to]);
                    })
                    ->orWhere(function($query) use($from, $to){
                        $query->whereBetween('toDate', [$from, $to]);
                    })
                    ->orWhere(function($query) use($from, $to){
                        $query->whereRaw($from . ' between fromDate and toDate');
                    })
                    ->orWhere(function($query) use($from, $to){
                        $query->whereRaw($to . ' between fromDate and toDate');
                    });  
                })
        )->with('photos')->get();

        return response()->json($data);
    }

    public function getAllTransaction(Request $request){
        $validateData = Validator::make(
            $request->query(),
            [
                'userId' => 'required',
            ]
        );

        if($validateData->fails()){
            return response()->json([
                'status' => false,
                'messages' => $validateData->errors()
            ], 400);
        };

        $data = RoomTransaction::where('customer_id', '=' ,$request->query('userId'))
        ->orderBy('created_at', 'desc')
        ->with('room')->get();
        return response()->json($data);
    }

    public function updateTransaction(Request $request){

        $validatedData = $request->validate([
            'id'=> 'required'
        ]);

        $data = [
            "status" => $request['status'],
            "payment_status" => $request['payment_status'] === 'true' ? true : false
        ];

        $updatedTr = RoomTransaction::where('id', $validatedData['id'])
            ->update($data);

        $request->session()->flash('success', 'Update Transaction Successfull!');

        return redirect('/rooms/transactions');
    }
}
