<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

final readonly class Categories
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver

        if(Cache::has("categories")){
            Log::info("categories cache");
            return Cache::get("categories");
        }else{
            $categories = Category::all();
            Cache::put("categories", $categories);
            return $categories;
        }

        // return Category::all();
    }
}
