<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // Menetapkan nilai default untuk variabel $guards
        $guards = empty($guards) ? [null] : $guards;

        // Melakukan pengecekan untuk setiap guard
        foreach ($guards as $guard) {
            // Jika pengguna sudah terotentikasi dalam guard yang diberikan, maka akan dialihkan ke rute HOME
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        // Jika tidak ada pengguna yang terotentikasi, lanjutkan ke permintaan berikutnya
        return $next($request);
    }
}
