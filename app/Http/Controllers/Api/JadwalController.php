<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jadwal = Jadwal::with(['kelas','guru','mapel'])->get();
        
        
        // $jadwal = Jadwal::join('kelas','kelas.id','=', 'jadwal.kelas_id')
        //                 ->join('mapel','mapel.id','=','jadwal.mapel_id')
        //                 ->select([
        //                     'jadwal.id',
        //                     'jadwal.hari',
        //                     'guru.nama',
        //                     'mapel.nama_mapel',
        //                     'kelas.nama_kelas'
        //                 ])->get();


        return response()->json([
            'data'    => $jadwal,
            'status'    => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // \Log::debug($request->all());
        $jadwal = new Jadwal();
        $jadwal->kelas_id = $request->kelas_id;
        $jadwal->mapel_id = $request->mapel_id;
        $jadwal->guru_id = $request->guru_id;
        $jadwal->hari = $request->hari;
        $jadwal->jam_pelajaran = $request->jam_pelajaran;
       
        $jadwal->save();
        return response()->json(['message' => 'success', 'status' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jadwal = Jadwal::with(['kelas','guru','mapel'])->where('id', $id)->first();
        return response()->json(['message' => 'success', 'status' => true, 'data' => $jadwal]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jadwal $jadwal)
    {

        $jadwal->kelas_id = $request->kelas_id;
        $jadwal->mapel_id = $request->mapel_id;
        $jadwal->guru_id = $request->guru_id;
        $jadwal->hari = $request->hari;
        $jadwal->jam_pelajaran = $request->jam_pelajaran;
       
        $jadwal->save();
        return response()->json(['message' => 'success', 'status' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return response()->json(['message' => 'success', 'status' => true]);
    }
}
