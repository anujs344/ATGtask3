<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        if($token != 'helloatg')
        {
            $url = $request->url();
            if(Str::endsWith($url, 'status'))
            {
                return response()->json(['task' => $request->input('task_id'),
                                     'status' => '0',
                                    'message' => "Invalid Api Key"
                ]);
            }
            elseif(Str::endsWith($url, 'add'))
            {
                return response()->json(['task' => $request->input('task'),
                                            'status' => '0',
                                        'message' => "Invalid Api Key"
                    ]);
            }
            else
            {
                return $next($request);
            }
        }
        return $next($request);
    }
}
