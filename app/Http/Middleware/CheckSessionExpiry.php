<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionExpiry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('expires_at') && now()->greaterThan(session('expires_at'))) {
            // Hapus sesi jika sudah kedaluwarsa
            session()->flush();
            Alert::error('Silahkan Login Kembali');
            return redirect()->route('login');
        }
        return $next($request);
    }
}
