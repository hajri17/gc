<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer([
            'user.home',
            'user.categories.*',
            'user.others.*',
            'user.products.*',
            'user.checkout.*',
            /*'user.categories.*',
            'user.categories.*',
            'user.categories.*',
            'user.categories.*',*/
            ], function ($view) {
            $carts = Cart::with(
                    'item.main_image',
                    'item.category',
                )
                ->where('user_id', auth()->id())
                ->get();

            $cartTotal = $carts->sum(function ($s) {
                return $s->qty * $s->item->price;
            });

            return $view->with('carts', $carts)
                ->with('cartTotal', $cartTotal);
        });
    }
}
