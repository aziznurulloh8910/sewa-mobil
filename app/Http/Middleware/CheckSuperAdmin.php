<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user adalah super admin
        if ($this->isSuperAdmin()) {
            return $next($request);
        }

        // Cek apakah user mengakses halaman CRUD aset
        if ($this->isAsetPage($request)) {
            return $next($request);
        }

        // Redirect ke halaman lain jika bukan super admin dan mengakses halaman selain CRUD aset
        return $this->redirectWithError($request);
    }

    /**
     * Cek apakah user adalah super admin.
     *
     * @return bool
     */
    private function isSuperAdmin(): bool
    {
        return auth()->check() && auth()->user()->role == 1;
    }

    /**
     * Cek apakah user mengakses halaman CRUD aset.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    private function isAsetPage(Request $request): bool
    {
        return $request->is('aset/*');
    }

    /**
     * Redirect ke halaman lain dengan pesan error.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function redirectWithError(Request $request): Response
    {
        $pageNames = [
            'criteria' => 'Data Kriteria',
            'subcriteria' => 'Data Sub Kriteria',
            'evaluation' => 'Data Penilaian',
            'process' => 'Data Perhitungan',
            'ranking' => 'Hasil Perankingan',
            'users' => 'Data Users',
        ];

        $pageName = $pageNames[$request->path()] ?? $request->path();
        return redirect('/home')->with('error', 'You do not have access to the ' . $pageName . ' page.');
    }
}