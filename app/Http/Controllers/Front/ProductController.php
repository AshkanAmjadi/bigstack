<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function productShow($product)
    {
        $product = Product::query()->with([
            'gallery' => function ($query) {
                $query->select('id', 'ext', 'galleriable_id', 'galleriable_type', 'alt');
            },
            'product_stocks',
            'product_attr' => function ($query) {
                $query->with([
                    'attr' => function ($query) {
                        $query->select(['id','name','color']);
                    },
                    'value' => function ($query) {
                        $query->select(['id','value','color_id']);
                    },
                ])->where('special', false);
            },
            'comments' => function ($query) {
                $query->withCount([
                    'tacts as up' => function ($query) {
                        $query->where('tact_type', true);
                    },
                    'tacts as down' => function ($query) {
                        $query->where('tact_type', false);
                    }
                ])->with([
                    'user' => function ($query) {
                        $query->select(['id', 'name']);
                    },
                ]);
            },

        ])->where('id', $product)->first();


        $product = $this->prepreProductStock($product);


        return view('front.product.product', compact('product'));
    }

    protected function prepreProductStock($product)
    {
        $product->main_ps = $product->product_stocks->where('main' , '=' , true)->first();


        $product->product_stocks = $product->product_stocks->map(function ($item,$key){

            if (!$item->s_expire or $item->s_expire <= now()->timestamp){
                $item->vip = false;
            }else{
                $item->vip = $item->s_expire - now()->timestamp;
            }

            if ($item->discount_type and $item->discount){
                if ($item->discount_type === 'percent'){
                    $item->last_price = $item->price * (100 - $item->discount)/100;
                }elseif ($item->discount_type === 'amount'){
                    $item->last_price = $item->price - $item->discount;
                }
            }else{
                $item->last_price = $item->price;
            }
            return $item;

        });

        return $product;
    }

}
