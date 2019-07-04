<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return view('back.category', ['user' => $this->user, 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.category-create', ['user' => $this->user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category;

        $rules = [
            'name' => 'required',
            'subname' => 'required',
        ];

        $messages = [
            'name.required' => '類別名稱 為必填欄位',
            'subname.required' => '子類別名稱 為必填欄位',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            $str_content = '';
            foreach ($validator->errors()->all() as $message) {
                $str_content .= (empty($str_content)) ? $message : ' , '.$message;
            }

            $msg = array('content' => '新增失敗: '.$str_content, 'type' => 'alert-danger');

            Session::flash('msg', $msg);
            return redirect()->route('admin.category.create')->withInput();
        }

        $category->name = $request->input('name');
        $category->subname = $request->input('subname');
        $category->show_popular = ($request->input('show_popular')) ? true : false;

        $category->save();

        $msg = array('content' => '新增成功', 'type' => 'alert-success');

        Session::flash('msg', $msg);
        return redirect()->route('admin.category.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $cid
     * @return \Illuminate\Http\Response
     */
    public function edit($cid)
    {
        $category = Category::find($cid);
        return view('back.category-edit', ['user' => $this->user, 'category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $cid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cid)
    {
        $category = Category::find($cid);

        $rules = [
            'name' => 'required',
            'subname' => 'required',
        ];

        $messages = [
            'name.required' => '類別名稱 為必填欄位',
            'subname.required' => '子類別名稱 為必填欄位',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            $str_content = '';
            foreach ($validator->errors()->all() as $message) {
                $str_content .= (empty($str_content)) ? $message : ' , '.$message;
            }

            $msg = array('content' => '修改失敗: '.$str_content, 'type' => 'alert-danger');

            Session::flash('msg', $msg);
            return redirect()->route('admin.category.edit')->withInput();
        }

        $category->name = $request->input('name');
        $category->subname = $request->input('subname');
        $category->show_popular = ($request->input('show_popular')) ? true : false;

        $category->save();

        $msg = array('content' => '修改成功', 'type' => 'alert-success');

        Session::flash('msg', $msg);
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $cid
     * @return \Illuminate\Http\Response
     */
    public function destroy($cid)
    {
        $category = Category::find($cid);
        $category->delete();

        $msg = array('content' => '刪除成功', 'type' => 'alert-success');

        Session::flash('msg', $msg);
        return redirect()->route('admin.category.index');
    }
}
