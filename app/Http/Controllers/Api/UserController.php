<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Guru;
use App\Model\Mapel;
use App\Model\Kelas;
use App\Model\Siswa;
use App\Model\Jadwal;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::all();
        return $this->success($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // \Log::debug($request->all());
        // $validator = Validator::make($request->all(), [
        //     'type' => 'required|in:admin,guru',
        //     'username' => 'required|string|unique:users,username',
        //     'password' => 'required|min:6',
        //     'email' => 'required'
        // ]);

        // if ($validator->fails()) {
        //     $msg = $validator->errors();

        //     return $this->failedResponse($msg,422);
        // }

        \Log::debug($request->all());
        // [2022-06-23 14:07:09] local.DEBUG: array (
        //     'type' => 'guru',
        //     'username' => 'seamngatttt',
        //     'password' => 'seamngatttt',
        //   )

        $user = new User();
        $user->type = $request->type;
        $user->name = $request->username;
        $user->email = $request->username.'@gmail.com';
        $user->password = Hash::make($request->password);
        // $user->email= $request->email;

        if ($user->save()) {
            return $this->success($user, 201);
        } else {
            return $this->failedResponse('User gagal ditambahkan!', 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        return response()->json(['message' => 'success', 'status' => true, 'data' => $user]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // $validator = Validator::make($request->all(), [
        //     'type' => 'required|in:admin,guru',
        //     'name' => 'required|string|unique:users,name,' . $user->id,
        //     'password' => 'nullable|min:6',
        // ]);

        // if ($validator->fails()) {
        //     $msg = $validator->errors();

        //     return $this->failedResponse($msg, 422);
        // }

        $user->type = $request->type;
        $user->name = $request->username;
        if ($request->has('password')) {
            $user->password = $request->password ? Hash::make($request->password) : $user->password;
        }

        if ($user->save()) {
            return $this->success($user, 200);
        } else {
            return $this->failedResponse('User gagal diupdate!', 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $deleteData = $user->delete();

        if ($deleteData) {
            return $this->success(null, 200);
        } else {
            return $this->failedResponse('User gagal dihapus!', 500);
        }

    }
    private function success($data, $statusCode, $message = 'success')
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
            'status_code' => $statusCode,
        ], $statusCode);
    }

    private function failedResponse($message, $statusCode)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => null,
            'status_code' => $statusCode,
        ], $statusCode);
    }

    public function cek_token()
    {
        $user = JWTAuth::parseToken()->authenticate();
        return $this->success($user, 200);
    }

    public function get_user_guru()
    {
        // $data = User::where('type', 'guru')->whereNotIn('id', Guru::pluck('user_id'))->get();
        $data = User::where('type', 'guru')->get();

        return $this->success($data, 200);
    }

    public function info()
    {
        $data['mapel'] = Mapel::get()->count();
        $data['guru'] = Guru::get()->count();
        $data['kelas'] = Kelas::get()->count();
        $data['siswa'] = Siswa::get()->count();
        $data['jadwal'] = Jadwal::get()->count();

        return response()->json($data);
    }

}
