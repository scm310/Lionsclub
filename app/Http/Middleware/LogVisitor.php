<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use App\Models\Visitor;

class LogVisitor
{
   
public function handle(Request $request, Closure $next)
{
    $ip = $request->ip();
    $fullUrl = $request->fullUrl();

    // ✅ Exclude admin pages
    if (str_contains($fullUrl, '/admin')) {
        return $next($request);
    }

    $location = Location::get($ip);

    Visitor::create([
            'ip_address' => $ip,
            'country' => $location ? $location->countryName : null,
            'region'  => $location ? $location->regionName  : null,
            'city'    => $location ? $location->cityName    : null,
            'url'     => $request->fullUrl(),
        ]);


    return $next($request);
}

}
