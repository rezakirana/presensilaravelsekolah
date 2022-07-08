<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Kelas;
use App\Model\Jadwal;
use App\Model\Presensi;
use App\Model\PresensiDetail;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Presensi::with(['jadwal'])->orderBy("created_at", 'DESC')->get();
        return response()->json([
            'data' => $data,
            'status' => 200,
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
        $jadwal = Jadwal::where('id', $request->jadwal_id)->first();

        $presensi = new Presensi();
        $presensi->jadwal_id = $request->jadwal_id;

        $presensi->kelas = $jadwal->kelas->nama_kelas;
        $presensi->mapel = $jadwal->mapel->nama_mapel;
        $presensi->guru = $jadwal->guru->nama;

        $presensi->tanggal = \Carbon\Carbon::parse($request->tanggal);
        $presensi->save();

        $kelas = Kelas::where('id', $jadwal->kelas->id)->first();
        if ($kelas) {
            foreach ($kelas->siswas as $key => $siswa) {
                $presensi_detail = new PresensiDetail();
                $presensi_detail->presensi_id = $presensi->id;
                $presensi_detail->siswa_id = $siswa->id;
                $presensi_detail->status = 0;
                $presensi_detail->save();
            }
        }

        return response()->json(['message' => 'success', 'status' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Presensi::with(['jadwal'])->where('id', $id)->first();
        $data_detail = PresensiDetail::with(['siswa'])->where('presensi_id', $id)->get();
        return response()->json([
            'data' => $data,
            'data_detail' => $data_detail,
            'status' => 200,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Presensi $presensi)
    {

        foreach ($presensi->presensi_details as $key => $detail) {
            $detail->status = $request->status[$key];
            $detail->save();
        }

        return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $presensi = Presensi::where('id', $id)->first();
        $presensi->delete();
        return response()->json(['status' => true]);
    }
}
