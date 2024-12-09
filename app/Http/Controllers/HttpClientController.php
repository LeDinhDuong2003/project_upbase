<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Cache\RedisStore;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\ToArray;

class HttpClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function rest()
    {
        try {
            // Tham số query (nếu cần)
            $params = 'phone';  // Nếu có tham số, thêm vào mảng này

            // Gọi API
            $response = Http::get('https://dummyjson.com/products/search', $params);
            // $x = Http::get();
            // dd($response);
            return response()->json(data:$response->json());

            // Kiểm tra nếu yêu cầu thành công
        } catch (Exception $e) {
            // Bắt lỗi nếu có vấn đề trong quá trình gọi API hoặc xử lý
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function graph()
    {
        //
        $query = '
            query Capsules {
                capsules {
                    id  
                    landings
                    original_launch
                    reuse_count
                    status
                    type
                }
            }
        ';
        try {
            $response = Http::post('https://spacex-production.up.railway.app/', [
                'query' => $query
            ]);
            return response()->json(data: $response->json());
        } catch (HttpResponseException $e) {
            return response()->json(data: $e->getResponse())->setStatusCode(500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
