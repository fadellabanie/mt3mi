<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category as CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CategoryResource::collection(Category::active()
            ->with(['products' => function ($query) {
                $query->active()->with([
                    'tags' => function ($query) {
                        $query->active();
                    },
                    'productSizes' => function ($query) {
                        $query->active();
                    },
                    'productModifiers' => function ($query) {
                        $query->with(['modifier' => function ($query) {
                            $query->with(['modifierOptions']);
                        }]);
                    }
                ]);
            }])
            ->get()
        );
    }
}
