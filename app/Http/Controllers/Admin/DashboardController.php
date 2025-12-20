<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Instansi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPending = Instansi::where('status', 'pending')->count();
        $totalAktif   = Instansi::where('status', 'active')->count();
        $totalUser    = User::where('role', 'pengelola')->count();

        return view('admin.dashboard', compact('totalPending', 'totalAktif', 'totalUser'));
    }

    public function validasiPage()
    {
        // Menampilkan antrian sekolah yang statusnya pending
        $antrian = Instansi::where('status', 'pending')->with('user')->get();
        return view('admin.validasi', compact('antrian'));
    }

    public function approve($id)
    {
        $instansi = Instansi::findOrFail($id);
        $instansi->update(['status' => 'active']);
        return back()->with('success', 'Instansi disetujui & tayang!');
    }

    public function reject($id)
    {
        $instansi = Instansi::findOrFail($id);
        $instansi->update(['status' => 'rejected']);
        return back()->with('error', 'Instansi ditolak.');
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }
}