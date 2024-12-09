<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Exception;
use Illuminate\Support\Facades\Http;

final readonly class Product
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
        try {
            
            // Tham số query (nếu cần)
            $params = ['user' => 1];
            // Gọi API
            $response = Http::get('https://dummyjson.com/products', $params);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['products'])) {
                    $products = array_map(fn($product) => [
                        'id' => $product['id'],
                        'title' => $product['title'],
                        'price' => $product['price'],
                        'description' => $product['description'],
                    ], $data['products']);
                    return $products;
                } else {
                    return [];
                }
            } else {
                return [];
            }
        } catch (Exception $e) {
            return [];
        }
    }
}
