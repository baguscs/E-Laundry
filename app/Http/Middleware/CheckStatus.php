<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        
        if (Auth::user()->pegawai->status == 'non-aktif') {
            return redirect('/verification');
        }
        elseif (Auth::user()->pegawai->status == 'suspend') {
            return redirect()->back()->with('pesan', 'Akun anda telah di suspend mohon konfirmasi admin');
        }

        return $next($request);
    }
}
