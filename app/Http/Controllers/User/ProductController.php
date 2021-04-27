<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Item::with('main_image', 'category', 'reviews')->get();

        return view('user.products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Item::with(
                'main_image',
                'category',
                'reviews',
                'images',
            )
            ->find($id);

        return view('user.products.show', compact('product'));
    }

    public function quickView($id)
    {
        $product = Item::with(
                'main_image',
                'category',
                'reviews',
            )
            ->find($id);

        return view('user.products.quick-view', compact('product'));
    }

    public function fullScreen($id)
    {
        $product = Item::with(
                'main_image',
                'category',
                'reviews',
            )
            ->find($id);

        return view('user.products.fullscreen', compact('product'));
    }
}
