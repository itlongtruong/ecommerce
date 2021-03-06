<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Models\Category;

class PageController extends Controller
{
    public function getIndex()
    {
        $product = DB::table('product')->paginate(config('setting.number'));

        return view('public.page.index', ['product' => $product], compact('product'));
    }

    public function getProductsingle(Request $req){
        try {
            $product = Product::where('id', $req->id)->first();
            $product_id = Category::find($product->category_id);
            $product_tt = Product::where('category_id', $product->category_id)->get();
            return view('public.page.product_single', compact('product', 'product_id', 'product_tt'));
        } catch (Exception $e) {
            return Redirect::to('/')->with('msg', ' Sorry something went worng. Please try again.');
        }
    }

    public function getProduct(){
        return view('public.page.product');
    }

    public function getContact()
    {
        return view('public.page.contact');
    }

    public function getRegister()
    {
        return view('public.page.register');
    }

    public function getShopCart()
    {
        return view('public.page.shop-cart');
    }

    public function getMyAccount()
    {
        return view('public.page.myaccount');
    }

    public function getWishlist()
    {
        return view('public.page.wishlist');
    }

    public function getCheckout()
    {
        return view('public.page.checkout');
    }

    public function getAddToCart(Request $req, $id)
    {
        $product = Product::find($id);
        $oldCart = Session('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $id);
        $req->session()->put('cart', $cart);

        return redirect()->back();
    }
}
