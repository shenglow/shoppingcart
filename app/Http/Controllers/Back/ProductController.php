<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSpecification;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @param  string  $c_name
     * @param  string  $c_subname
     * @return \Illuminate\Http\Response
     */
    public function index($c_name = '', $c_subname = '')
    {
        $categories = Category::all();
        $arr_categories = array();

        foreach($categories as $category) {
            $arr_categories[$category->name][] = array(
                'cid' => $category->cid,
                'subname' => $category->subname
            );
        }

        $arr_where = array();
        if (!empty($c_name)) $arr_where[] = array('name', '=', $c_name);
        if (!empty($c_subname)) $arr_where[] = array('subname', '=', $c_subname);

        $products = Category::with('products')->where($arr_where)->get();

        return view('back.product', [
            'user' => $this->user,
            'categories' => $arr_categories,
            'products' => $products,
            'c_name' => $c_name,
            'c_subname' => $c_subname
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $arr_categories = array();
        foreach($categories as $category) {
            $arr_categories[$category->name][] = array(
                'cid' => $category->cid,
                'subname' => $category->subname,
            );
        }

        return view('back.product-create', ['user' => $this->user, 'categories' => $arr_categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'price' => 'required|integer',
            'c_name' => 'required',
            'c_subname' => 'required|integer',
            'description' => 'required',
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $messages = [
            'name.required' => '名稱 為必填欄位',
            'price.required' => '價格 為必填欄位',
            'price.integer' => '價格 必須為整數',
            'c_name.required' => '類別 為必選欄位',
            'c_subname.required' => '子類別 為必選欄位',
            'c_subname.integer' => '子類別 內容有誤',
            'description.required' => '簡述 為必填欄位',
            'image.required' => '照片 最少須一張',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            $str_content = '';
            foreach ($validator->errors()->all() as $message) {
                $str_content .= (empty($str_content)) ? $message : ' , '.$message;
            }

            $msg = array('content' => '新增失敗: '.$str_content, 'type' => 'alert-danger');

            Session::flash('msg', $msg);
            return redirect()->route('admin.product.create')->withInput();
        }

        $product = new Product; 

        // create folder if no exixts
        $img_path = 'uploads/product/'.(string) Str::uuid();
        if (!file_exists($img_path)) {
            mkdir($img_path, 0755, true);
        }

        $img_name = '';
        if ($request->hasFile('image')) {
            $path = public_path().'/'.$img_path.'/';
            foreach ($request->file('image') as $key => $image) {
                $fileName = time().'_'.$image->getClientOriginalName();
                $img_name .= $fileName.',';
                $image->move($path, $fileName);
            }
        }

        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->cid = $request->input('c_subname');
        $product->description = $request->input('description');
        $product->detail = $request->input('detail');
        $product->path = $img_path;
        $product->image = $img_name;

        $product->save();

        
        foreach ($request->input('specification') as $key => $value) {
            $specification = '';
            $quantity = 0;
            if (!empty($value)) {
                $specification = $value;
                if (isset($request->input('quantity')[$key])) {
                    $quantity = $request->input('quantity')[$key];
                }
            }

            $productSpecification = new ProductSpecification;
            $productSpecification->pid = $product->pid;
            $productSpecification->specification = $specification;
            $productSpecification->quantity = $quantity;

            $productSpecification->save();
        }
        
        $msg = array('content' => '新增成功', 'type' => 'alert-success');

        Session::flash('msg', $msg);
        return redirect()->route('admin.product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $product = Product::with('category')->find($product->pid);

        $categories = Category::all();
        $arr_categories = array();
        foreach($categories as $category) {
            if ($category->cid == $product->cid) {
                $c_name = $category->name;
                $c_subname = $category->subname;
            }
            $arr_categories[$category->name][] = array(
                'cid' => $category->cid,
                'subname' => $category->subname,
            );
        }

        $specification = Product::find($product->pid)->specification;

        return view('back.product-edit', [
            'user' => $this->user,
            'product' => $product,
            'categories' => $arr_categories,
            'c_name' => $c_name,
            'c_subname' => $c_subname,
            'specification' => $specification,
            'images' => explode(',', $product->image)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'name' => 'required',
            'price' => 'required|integer',
            'c_name' => 'required',
            'c_subname' => 'required|integer',
            'description' => 'required',
            // 'image' => 'required',
            // 'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $messages = [
            'name.required' => '名稱 為必填欄位',
            'price.required' => '價格 為必填欄位',
            'price.integer' => '價格 必須為整數',
            'c_name.required' => '類別 為必選欄位',
            'c_subname.required' => '子類別 為必選欄位',
            'c_subname.integer' => '子類別 內容有誤',
            'description.required' => '簡述 為必填欄位',
            // 'image.required' => '照片 最少須一張',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            $str_content = '';
            foreach ($validator->errors()->all() as $message) {
                $str_content .= (empty($str_content)) ? $message : ' , '.$message;
            }

            $msg = array('content' => '新增失敗: '.$str_content, 'type' => 'alert-danger');

            Session::flash('msg', $msg);
            return redirect()->route('admin.product.edit', $product->pid)->withInput();
        }

        $product = Product::find($product->pid);

        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->cid = $request->input('c_subname');
        $product->description = $request->input('description');
        $product->detail = $request->input('detail');

        $product->save();

        foreach ($request->input('specification') as $key => $value) {
            $specification = '';
            $quantity = 0;
            if (!empty($value)) {
                $specification = $value;
                if (isset($request->input('quantity')[$key])) {
                    $quantity = $request->input('quantity')[$key];
                }
            }
            
            $productSpecification = productSpecification::where('psid', $key)->where('pid', $product->pid)->first();
            if ($productSpecification === null) {
                $productSpecification = new ProductSpecification;
            }
            
            $productSpecification->pid = $product->pid;
            $productSpecification->specification = $specification;
            $productSpecification->quantity = $quantity;

            $productSpecification->save();
        }
        
        $msg = array('content' => '新增成功', 'type' => 'alert-success');

        Session::flash('msg', $msg);
        return redirect()->route('admin.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    /**
     * Change product status.
     *
     * @param  int  $pid
     * @param  bool $status
     * @return \Illuminate\Http\Response
     */
    public function changeStatus($pid, $status)
    {
        $product = Product::find($pid);
        if ($product !== null) {
            $product->is_enable = $status;
            $product->save();
        }

        return redirect()->back();
    }
}
