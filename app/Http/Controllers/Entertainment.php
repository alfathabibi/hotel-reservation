<?php

namespace App\Http\Controllers;

use App\Models\Entertainment as ModelsEntertainment;
use App\Models\EntertainmentPhoto as ModelEntertainmentPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Entertainment extends Controller
{
    public function index()
    {
        return view('pages/entertainment/index', [
            'title' => 'Entertainment',
            'active' => 'entertainment'
        ]);
    }

    public function CreateEntertainment(Request $request)
    {
        $validasi = Validator::make(
            $request->all(),
            [
                'nama' => 'required',
                'harga' => 'required',
                'kategori' => 'required',
                'peruntukan' => 'required',
                'deskripsi' => 'required',
            ]
        );
        if ($validasi->fails()) {
            return response()->json([
                'isError' => true,
                'messages' => $validasi->errors()
            ], 403);
        }

        $entertaintment = new ModelsEntertainment;
        $entertaintment->nama = $request->post()['nama'];
        $entertaintment->harga = $request->post()['harga'];
        $entertaintment->kategori = $request->post()['kategori'];
        $entertaintment->peruntukan = $request->post()['peruntukan'];
        $entertaintment->deskripsi = $request->post()['deskripsi'];
        $entertaintment->save();
        $idEntertainment = $entertaintment->id;

        $files = [];
        if ($request->file('fotos')) {
            foreach ($request->file('fotos') as $key => $file) {
                $fileName = time() . rand(1, 99) . '.' . $file->extension();
                $file->move(public_path('uploads/images'), $fileName);
                $files[] = ['name' => $fileName, 'url' => 'uploads/images/' . $fileName];
            }
        }

        foreach ($files as $key => $file) {
            $fotoEntertainment = new ModelEntertainmentPhoto;
            $fotoEntertainment->entertainment_id = $idEntertainment;
            $fotoEntertainment->nama = $file['name'];
            $fotoEntertainment->path = $file['url'];
            $fotoEntertainment->save();
        }

        return response()->json(['isError' => false, 'messages' => 'Successfully adding data', 'data' => $entertaintment], 201);
    }

    public function ReadAllEntertainment()
    {
        return response()->json(['isError' => false, 'messages' => 'Successfully get all data', 'data' => ModelsEntertainment::all()], 200);
    }

    public function DeleteEntertainment(Request $request)
    {
        $entertaintment = ModelsEntertainment::find($request->post()['id']);
        $entertaintment->delete();
        return response()->json(['isError' => false, 'messages' => 'Successfully delete data', 'data' => $entertaintment], 200);
    }
}
