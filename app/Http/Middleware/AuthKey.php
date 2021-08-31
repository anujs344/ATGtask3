<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthKey
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
        $token = $request->header('APP_KEY');
        // if($request->input('APP_KEY') != 'helloatg')
        if($token != 'helloatg')
        {
            $url = $request->url();
            if(Str::endsWith($url, 'status'))
            {
                if(Auth::guard('register')->check())
                {
                    return response()->json(['task' => $request->input('task_id'),
                                        'status' => '0',
                                        'message' => "Invalid Api Key"
                    ]);
                }
                return "hello";
            }
            elseif(Str::endsWith($url, 'add'))
            {
                if(Auth::guard('register')->check())
                {
                    return response()->json(['task' => $request->input('task'),
                                                'status' => '0',
                                            'message' => "Invalid Apiii Key"
                        ]);
                }
                return "hello";
            }
            else
            {
                return $next($request);
            }
        }
        if(Auth::guard('register')->check())
         {
            return $next($request);
         }
         else
         {
             return "hello";
         }
    }
}
