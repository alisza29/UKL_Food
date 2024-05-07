<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\foodmodel;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{
    public function __construct() //ADMIN
    {
        $this->middleware('auth:api');
    }

    public function getfoodid($id) // get food by id
    {
        $food = foodmodel::where('id_food', $id)->first();
        return Response()->json($food);
    }

    public function addfood(Request $req) //tambah
    {
        $validator = Validator::make($req->all(), [
            'image' => 'required|image',
            'name' => 'required',
            'spicy_level' => 'required|numeric',
            'price' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['error validatornya']->$validator->errors()->toJson());
        }

        //proses foto
        if ($req->hasFile('image')) {
            $file = $req->file('image');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);

            //nyimpen foto
            $save = foodmodel::create([
                'image' => $fileName,
                'name' => $req->get('name'),
                'spicy_level' => $req->get('spicy_level'),
                'price' => $req->get('price'),
            ]);

            return response()->json(['message' => 'Sukses mengunggah food']);
        } else {
            return response()->json(['message' => 'Gagal mengunggah food']);
        }

        //nyimpen data 
        if ('$save') {
            return response()->json(['status' => true, 'message' => 'Sukses menambahkan food']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal menambahkan food']);
        }
    }

    public function updatefood(Request $req, $id) //ubahh
    {
        $validator = Validator::make($req->all(), [
            'image' => 'required',
            'name' => 'required',
            'spicy_level' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        // ini yang agak ngawur gara gara gabisa updatee wkwk
        $fileName = 'fotomenu.jpeg';

        if ($req->hasFile('image')) {
            $file = $req->file('image');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
        }

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toJson()]);

        }

        $ubah = foodmodel::where('id_food', $id)->update([
            'image' => $fileName,
            'name' => $req->get('name'),
            'spicy_level' => $req->get('spicy_level'),
            'price' => $req->get('price'),
        ]);

        if ($ubah) {
            return response()->json(['status' => true, 'message' => 'Sukses mengubah food']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal mengubah food']);
        }
    }

    public function deletefood($id) //hapus
    {
        $hapus = foodmodel::where('id_food', $id)->delete();
        if ($hapus) {
            return response()->json(['status' => true, 'message' => 'Sukses menghapus food']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus food']);
        }
    }
}