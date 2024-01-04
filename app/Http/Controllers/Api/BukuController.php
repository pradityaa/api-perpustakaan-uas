<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Buku::orderBy('judul','asc')->get();
        return response()->json([
            'status'=> true,
            'message'=> 'Data ditemukan',
            'data'=> $data,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $dataBuku = new Buku;

        $rules = [
            'judul' => 'required',
            'pengarang' => 'required',
            'tanggal_publikasi' => 'required|date',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'messages' => 'gagal memasukkan data',
                'data' => $validator->errors(), 
            ]);
        }

        $dataBuku -> judul = $request -> input('judul');
        $dataBuku -> pengarang = $request -> input('pengarang');
        $dataBuku -> tanggal_publikasi = $request -> input('tanggal_publikasi');

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nama_foto = time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('foto'), $nama_foto);
            $dataBuku->foto = $nama_foto;
        }

        $dataBuku -> save();

        return response()->json([
            'status'=> true,
            'message'=> 'Berhasil memasukkan data',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = Buku::find($id);
        if($data){
            return response()->json([
                'status'=> true,
                'status'=> 'Data ditemukan',
                'status'=> $data,
            ],200);
        }else{
            return response()->json([
                'status'=> false,
                'status'=> 'Data tidak ditemukan',
            ],200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataBuku = Buku::find($id);
    
        if(empty($dataBuku)){
            return response()->json([
                'status'=> false,
                'messages'=> 'data tidak ditemukan',
            ],404);
        }
    
        $rules = [
            'judul' => 'required',
            'pengarang' => 'required',
            'tanggal_publikasi' => 'required|date',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'messages' => 'gagal mengupdate data',
                'data' => $validator->errors(), 
            ]);
        }
    
        $dataBuku->judul = $request->input('judul');
        $dataBuku->pengarang = $request->input('pengarang');
        $dataBuku->tanggal_publikasi = $request->input('tanggal_publikasi');
    
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nama_foto = time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('foto'), $nama_foto);
            $dataBuku->foto = $nama_foto;
        }
    
        $dataBuku->save();
    
        return response()->json([
            'status'=> true,
            'message'=> 'Berhasil mengupdate data',
        ]);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $dataBuku = Buku::find($id);

        if(empty($dataBuku)){
            return response()->json([
                'status'=> false,
                'messages'=> 'data tidak ditemukan',
            ],404);
        }

        $dataBuku -> delete();

        return response()->json([
            'status'=> true,
            'message'=> 'Berhasil menghapus data',
        ]);
    }
}
