<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $categories = Category::all();
        $arr_categories = array();

        foreach($categories as $category) {
            $arr_categories[$category->name]['subcategory'][] = array(
                'cid' => $category->cid,
                'subname' => $category->subname
            );
        }

        return view('front.wishlist', [
            'user' => $user,
            'categories' => $arr_categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // init return value
        $err = 'false';
        $err_msg = '';

        $user = Auth::user();

        $product = Product::find($request->pid);
        if ($product === null) {
            $err = 'true';
            $err_msg = '查無此商品';
        } else {
            $wishlist = Wishlist::firstOrCreate(
                ['id' => $user->id, 'pid' => $request->input('pid')]
            );
        }

        return array('err' => $err, 'err_msg' => $err_msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
