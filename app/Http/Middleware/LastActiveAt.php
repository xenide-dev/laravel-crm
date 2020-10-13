<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LastActiveAt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            $expiresAt = Carbon::now()->addMinutes(1);
            Cache::put("user-is-online-" . Auth::user()->id, true,$expiresAt);
            DB::table("users")
                ->where("id", Auth::user()->id)
                ->update(["last_online_at" => now()]);
        }

        return $next($request);
    }
}
