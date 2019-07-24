<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Carousel;
use Illuminate\Support\Facades\Validator;

class CarouselController extends Controller
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
        $carousels = Carousel::all();
        
        return view('back.carousel', ['user' => $this->user, 'carousels' => $carousels]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.carousel-create', ['user' => $this->user]);
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
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $messages = [
            'image.required' => '請上傳照片',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            $str_content = '';
            foreach ($validator->errors()->all() as $message) {
                $str_content .= (empty($str_content)) ? $message : ' , '.$message;
            }

            $msg = array('content' => '新增失敗: '.$str_content, 'type' => 'alert-danger');

            $request->session()->flash('msg', $msg);
            return redirect()->route('admin.carousel.create')->withInput();
        }

        $carousel = new Carousel; 

        // create folder if no exixts
        $img_path = 'uploads/carousel';
        if (!file_exists($img_path)) {
            mkdir($img_path, 0755, true);
        }

        if ($request->hasFile('image')) {
            $path = public_path().'/'.$img_path.'/';
            $image = $request->file('image');
            $fileName = time().'_'.$image->getClientOriginalName();
            $image->move($path, $fileName);
        }

        $carousel->image = $img_path.'/'.$fileName;
        $carousel->href = $request->input('href');
        $carousel->status = ($request->input('status')) ? true : false;
        $carousel->save();

        
        $msg = array('content' => '新增成功', 'type' => 'alert-success');

        $request->session()->flash('msg', $msg);
        return redirect()->route('admin.carousel.index');
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
     * @param  int  $carousel_id
     * @return \Illuminate\Http\Response
     */
    public function edit($carousel_id)
    {
        $carousel = Carousel::find($carousel_id);

        return view('back.carousel-edit', ['user' => $this->user, 'carousel' => $carousel]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $carousel_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $carousel_id)
    {
        $rules = [
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $messages = [
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            $str_content = '';
            foreach ($validator->errors()->all() as $message) {
                $str_content .= (empty($str_content)) ? $message : ' , '.$message;
            }

            $msg = array('content' => '修改失敗: '.$str_content, 'type' => 'alert-danger');

            $request->session()->flash('msg', $msg);
            return redirect()->route('admin.carousel.edit', $carousel_id)->withInput();
        }

        $carousel = Carousel::find($carousel_id); 

        // create folder if no exixts
        $img_path = 'uploads/carousel';
        if (!file_exists($img_path)) {
            mkdir($img_path, 0755, true);
        }

        if ($request->hasFile('image')) {
            $path = public_path().'/'.$img_path.'/';
            $image = $request->file('image');
            $fileName = time().'_'.$image->getClientOriginalName();
            $image->move($path, $fileName);

            unlink(public_path().'/'.$carousel->image);

            $carousel->image = $img_path.'/'.$fileName;
        }

        $carousel->href = $request->input('href');
        $carousel->status = ($request->input('status')) ? true : false;
        $carousel->save();

        $msg = array('content' => '修改成功', 'type' => 'alert-success');

        $request->session()->flash('msg', $msg);
        return redirect()->route('admin.carousel.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $carousel_id)
    {
        $carousel = Carousel::find($carousel_id);

        unlink(public_path().'/'.$carousel->image);

        $carousel->delete();

        $msg = array('content' => '刪除成功', 'type' => 'alert-success');

        $request->session()->flash('msg', $msg);

        return redirect()->route('admin.carousel.index');
    }
}
