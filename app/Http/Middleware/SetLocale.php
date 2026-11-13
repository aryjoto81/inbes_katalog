<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // Mengecek apakah di session ada pilihan bahasa ('id' atau 'en'),
        // jika tidak ada maka default-nya adalah 'id' (Bahasa Indonesia).
       if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } else {
            App::setLocale('id'); // Default Bahasa Indonesia
        }

        return $next($request);
    }
}
