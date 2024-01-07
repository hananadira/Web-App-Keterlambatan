<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('administrator.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrator.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|min:3',
    //         'email' => 'required',
    //         'password' => 'required',
    //     ]);

    //     User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'role' => $request->role,
    //         'password' => Hash::make(substr($request->email, 0, 3). substr($request->name, 0, 3))
    //     ]);

    //     return redirect()->route('user.index')->with('success', 'Berhasil menambahkan data pengguna!');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email', // Memastikan email unik
            'password' => 'required|min:8',
            'role' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make(substr($request->email, 0, 3). substr($request->name, 0, 3))
        ]);

        return redirect()->route('user.index')->with('success', 'Berhasil menambahkan data pengguna!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::find($id);
        return view('administrator.user.edit', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|min:3|unique:users,email,' . $id, // Memastikan email unik, kecuali untuk user saat ini
            'role' => 'required',
            'password' => 'nullable|min:8',
        ]);
    
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];
    
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
    
        User::where('id', $id)->update($userData);
    
        return redirect()->route('user.index')->with('success', 'Berhasil mengubah data!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $users = User::find($id);

        if (!$users) {
            return redirect()->back()->with('gagal', 'Data tidak ditemukan!');
        }

        // Ganti dengan relasi yang sesuai, contohnya 'siswa'
        $siswaUsingUser = $users->rayon()->exists(); 

        if ($siswaUsingUser) {
            return redirect()->back()->with('gagal', 'user masih digunakan oleh data keterlambatan!');
        }

        $users->delete();

        return redirect()->route('user.index')->with('deleted', 'Berhasil menghapus data!');
    }


    public function loginAuth(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('home');
            } elseif ($user->role === 'ps') {
                return redirect()->route('dashboardps');
            }
        }
    
        return redirect()->back()->with('failed', 'Proses login gagal, silahkan coba kembali dengan data yang benar!');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login')->with('logout', 'Anda telah logout!');
    }

    // public function home() {
    //     $homes = User::all();

    // }
}
