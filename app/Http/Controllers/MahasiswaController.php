<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentProfile;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentProfile::query();
        if ($request->has('search') && $request->search != '') {
            $query -> whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->has('role_1') && $request->role_1!='' && $request->role_1 != 'Semua Peran')
            {
                $query->where('role_1', $request->role_1);
            }
            $data_mahasiswa = $query->get();
            $mahasiswa_terbaru = StudentProfile::with('user')->orderBy('id', 'desc')->take(5)->get();
            $total_mahasiswa = $data_mahasiswa->count();
            $total_skor = $data_mahasiswa->sum('skill_score');
            $skor_tertinggi = $data_mahasiswa->max('skill_score');
            $skor_terendah = $data_mahasiswa->min('skill_score');
            $rata_rata_skor = $data_mahasiswa->avg('skill_score');
            $daftar_peran = ['PM', 'UI/UX', 'Frontend', 'Backend'];

            return view('mahasiswa.index', compact(
                'data_mahasiswa', 
                'mahasiswa_terbaru', 
                'total_mahasiswa', 
                'total_skor', 
                'skor_tertinggi', 
                'skor_terendah', 
                'rata_rata_skor', 
                'daftar_peran'
            ));           
    }
}