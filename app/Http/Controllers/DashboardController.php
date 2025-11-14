<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kantin;
use App\Models\Pesanan;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $totalUsers = User::count();
        $totalKantins = Kantin::count();
        $totalPesanans = Pesanan::count();

        return view('dashboard-all', compact('users', 'totalUsers', 'totalKantins', 'totalPesanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }
}
