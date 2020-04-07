<?php

namespace App\Http\Controllers\Advert;

use App\Entity\Advert\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdvertsController extends Controller
{
    public function show(Category $category)
    {
        return view('advert.category.show', [
            'category' => $category,
        ]);
    }
}
