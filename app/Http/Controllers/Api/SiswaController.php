<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Siswa::get();
        return response()->json(['data' => $data]);
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

            $siswa = new Siswa();
            $siswa->nis = $request->nis;
            $siswa->nama = $request->nama;
            $siswa->gender = $request->gender;
            $siswa->tahun_masuk = \Carbon\Carbon::parse($request->tahun_masuk);
            $siswa->tempat_lahir = $request->tempat_lahir;
            $siswa->tgl_lahir = \Carbon\Carbon::parse($request->tgl_lahir);
            $siswa->nama_ortu = $request->nama_ortu;
            $siswa->alamat = $request->alamat;
            $siswa->email = $request->email;
            $siswa->phone_number = $request->phone_number;
            $siswa->kelas_id = $request->kelas_id;

            $siswa->save();
            return response()->json(['message' => 'success', 'status' => true]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'failed', 'status' => false]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show(Siswa $siswa)
    {
        return response()->json(['message' => 'success', 'status' => true, 'data' => $siswa]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Siswa $siswa)
    {
        $siswa->nis = $request->nis;
        $siswa->nama = $request->nama;
        $siswa->gender = $request->gender;
        $siswa->tahun_masuk = \Carbon\Carbon::parse($request->tahun_masuk);
        $siswa->tempat_lahir = $request->tempat_lahir;
        $siswa->tgl_lahir = \Carbon\Carbon::parse($request->tgl_lahir);
        $siswa->nama_ortu = $request->nama_ortu;
        $siswa->alamat = $request->alamat;
        $siswa->email = $request->email;
        $siswa->phone_number = $request->phone_number;
        $siswa->kelas_id = $request->kelas_id;

        $siswa->save();
        return response()->json(['message' => 'success', 'status' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return response()->json(['message' => 'success', 'status' => true]);
    }
}
