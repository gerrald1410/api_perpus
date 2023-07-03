<?php

namespace App\Http\Controllers;

use App\Models\Perpus;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Exception;


class PerpusController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perpus = Perpus::all();

        if ($perpus) {
            return ApiFormatter::createApi(200, 'success', $perpus);
        }else{
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function generateToken()
    {
        return csrf_token();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'nis' => 'required|numeric',
                'nama' => 'required|min:3',
                'rombel' => 'required',
                'rayon' => 'required',
                'judul_buku' => 'required',
                'tanggal' => 'required',
            ]);
            
            $perpus = Perpus::create([
                'nis' => $request->nis,
                'nama' => $request->nama,
                'rombel' => $request->rombel,
                'rayon' => $request->rayon,
                'judul_buku' => $request->judul_buku,
                'tanggal' => \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d'),
            ]);
          
            $hasilTambahData = Perpus::where('id', $perpus->id)->first();
            if ($hasilTambahData) {
                return ApiFormatter::createAPI(200, 'success', $perpus);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {

            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function createToken()
    {
        return response()->json(csrf_token());
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $perpus = Perpus::find($id);
            if ($perpus) {
                return ApiFormatter::createAPI(200, 'success', $perpus);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Perpus $perpus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nis' => 'required|numeric',
                'nama' => 'required|min:3',
                'rombel' => 'required',
                'rayon' => 'required',
                'judul_buku' => 'required',
                'tanggal' => 'required',
            ]);

            $perpus = Perpus::find($id);
            $perpus->update([
                'nis' => $request->nis,
                'nama' => $request->nama,
                'rombel' => $request->rombel,
                'rayon' => $request->rayon,
                'judul_buku' => $request->judul_buku,
                'tanggal' => \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d'),
            ]);

            $dataTerbaru = Perpus::where('id', $perpus->id)->first();
            if ($dataTerbaru) {
                return ApiFormatter::createAPI(200, 'success', $dataTerbaru);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage()); 
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $perpus = Perpus::find($id);
            $cekBerhasil = $perpus->delete();
            if ($cekBerhasil) {
                return ApiFormatter::createAPI(200, 'success', 'Data terhapus!');
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function trash()
    {
        try {
            $perpus = Perpus::onlyTrashed()->get();
            if ($perpus) {
                return ApiFormatter::createAPI(200, 'success', $perpus);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $perpus = Perpus::onlyTrashed()->where('id', $id);
            $perpus->restore();
            $dataKembali =  Perpus::where('id', $id)->first();
            if ($dataKembali) {
                return ApiFormatter::createAPI(200, 'success', $dataKembali);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function permanenDelete($id)
    {
        try {
            $sampah = Perpus::onlyTrashed()->where('id', $id);
            $cekBerhasil = $sampah->forceDelete();
            if ($cekBerhasil) {
                return ApiFormatter::createApi(200, 'success', 'permanen');
            }else{
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }
}
