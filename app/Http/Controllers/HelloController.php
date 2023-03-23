<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class HelloController extends Controller
{
    public function index()
    {
        $data = ['one', 'two', 'three', 'four', 'five'];
        return view('hello.index', ['data' => $data]);
    }

    public function post(Request $request)
    {
        return view('hello.index', ['msg' => $request->msg]);
    }

    // public function __invoke()
    // {
    //     return <<<EOF
    //         <!DOCTYPE html>
    //         <html lang="jp">
    //         <head>
    //             <meta charset="UTF-8">
    //             <meta http-equiv="X-UA-Compatible" content="IE=edge">
    //             <meta name="viewport" content="width=device-width, initial-scale=1.0">
    //             <title>Hello</title>
    //             <style>body {font-size:16pt; color:#999; }
    //             h1 { font-size:100pt; text-align:center; color#eee;
    //                magin:-40px 0px -50px 0px; }</style>
    //         </head>
    //         <body>
    //             <h1>Single Action</h1>
    //             <p>This is single action controller! </p>
    //         </body>
    //         </html>
    //     EOF;
    // }
    // public function index(Request $request, Response $response)
    // {
    //     $html = <<<EOF
    //         <!DOCTYPE html>
    //         <html lang="jp">
    //         <head>
    //             <meta charset="UTF-8">
    //             <meta http-equiv="X-UA-Compatible" content="IE=edge">
    //             <meta name="viewport" content="width=device-width, initial-scale=1.0">
    //             <title>Hello/Index</title>
    //             <style>body {font-size:16pt; color:#999; }
    //             h1 { font-size:100pt; text-align:center; color#eee;
    //                magin:-40px 0px -50px 0px; }</style>
    //         </head>
    //         <body>
    //             <h1>Hello</h1>
    //             <h3>Request</h3>
    //             <pre>{{$request}}</pre>
    //             <h3>Response</h3>
    //             <pre>{$response}</pre>
    //         </body>
    //         </html>
    //         EOF;
    //     $response->setContent($html);
    //     return $response;
    // }

    //     public function other()
    //     {
    //         global $head, $style, $body, $end;

    //         $html = $head . tag('little', 'Hello/Other') . $style .
    //             $body
    //             . tag('h1', 'Other') . tag('p', 'this is Other page!')
    //             . '<a href="/hello/other">go to Other page</a>'
    //             . $end;
    //         return $html;
    //     }
}
