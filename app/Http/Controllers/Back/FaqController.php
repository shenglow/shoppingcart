<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Faq;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
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
        $faqs = Faq::all();

        return view('back.faq', ['user' => $this->user, 'faqs' => $faqs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.faq-create', ['user' => $this->user]);
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
            'question' => 'required',
            'answer' => 'required',
        ];

        $messages = [
            'question.required' => '問題為必填欄位',
            'answer.required' => '答案為必填欄位',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            $str_content = '';
            foreach ($validator->errors()->all() as $message) {
                $str_content .= (empty($str_content)) ? $message : ' , '.$message;
            }

            $msg = array('content' => '新增失敗: '.$str_content, 'type' => 'alert-danger');

            $request->session()->flash('msg', $msg);
            return redirect()->route('admin.faq.create')->withInput();
        }

        $faq = new Faq;
        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->status = ($request->input('status')) ? true : false;
        $faq->save();

        $msg = array('content' => '新增成功', 'type' => 'alert-success');

        $request->session()->flash('msg', $msg);
        return redirect()->route('admin.faq.index');
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
     * @param  int  $fid
     * @return \Illuminate\Http\Response
     */
    public function edit($fid)
    {
        $faq = Faq::find($fid);

        return view('back.faq-edit', ['user' => $this->user, 'faq' => $faq]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $fid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $fid)
    {
        $rules = [
            'question' => 'required',
            'answer' => 'required',
        ];

        $messages = [
            'question.required' => '問題為必填欄位',
            'answer.required' => '答案為必填欄位',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            $str_content = '';
            foreach ($validator->errors()->all() as $message) {
                $str_content .= (empty($str_content)) ? $message : ' , '.$message;
            }

            $msg = array('content' => '修改失敗: '.$str_content, 'type' => 'alert-danger');

            $request->session()->flash('msg', $msg);
            return redirect()->route('admin.faq.edit', $fid)->withInput();
        }

        $faq = Faq::find($fid);
        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->status = ($request->input('status')) ? true : false;
        $faq->save();

        $msg = array('content' => '修改成功', 'type' => 'alert-success');

        $request->session()->flash('msg', $msg);
        return redirect()->route('admin.faq.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $fid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $fid)
    {
        $faq = Faq::find($fid);
        $faq->delete();

        $msg = array('content' => '刪除成功', 'type' => 'alert-success');

        $request->session()->flash('msg', $msg);
        return redirect()->route('admin.faq.index');
    }
}
