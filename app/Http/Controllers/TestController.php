<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Request $request)
    {
        $data = [
            'hotels' => [
                'rooms' => [
                    'type' => 'single',
                    'price' => 100,
                    'currency' => 'AED'
                ]
            ],
            'tickets' => []
        ];

        $reqContent = $request->getContent();
        $reqContent = str_replace('{', '', $reqContent);
        $reqContent = str_replace('}', '', $reqContent);
        $reqContent = str_replace('[', '', $reqContent);
        $reqContent = str_replace(']', '', $reqContent);
        $reqContent = trim(preg_replace('/\t+/', '', $reqContent));
        $reqContent = preg_replace('/\n+/', '', $reqContent);

        $rules = explode(',', $reqContent);

        $traversedArr = null;
        foreach ($rules as $rule) {
            $explodedRule = explode('=', $rule);
            $patternArr = explode('.', $explodedRule[0]);

            $traversedKey = '';
            foreach ($patternArr as $pattern) {
                if ($pattern == '*') {
                } elseif(preg_match('/\d+/', $pattern)) {
                    // Change item
                } else {
                    // Change array
                    $traversedKey = $pattern;
                    if ($traversedArr == null) {
                        $traversedArr = $data[$traversedKey];
                    } else {
                        $traversedArr = $traversedArr[$pattern];
                    }
                    var_dump($traversedArr);
                }
            }
        }

        dd($traversedArr);

//        return response()->json($data);
    }
}
