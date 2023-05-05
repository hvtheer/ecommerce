<?php

namespace App\Http\Controllers\Admin;

use App\Models\Test;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TestFormRequest;

class TestController extends Controller
{
    public function index()
    {
        return view('admin.test.index');
    }

    public function create()
    {
        return view('admin.test.create');
    }

    public function store(TestFormRequest $request)
    {
        $validatedData = $request->validated();

        $test = new Test();
        $test->name = $validatedData['name'];
        $test->slug = Str::slug($validatedData['slug']);
        $test->description = $validatedData['description'];

        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;

            $file->move('uploads/test/',$filename);
            $test->image = $filename;
        }

        // $test->meta_title = $validatedData['meta_title'];
        // $test->meta_keyword = $validatedData['meta_keyword'];
        // $test->meta_description = $validatedData['meta_description'];

        $test->status = $request->status == true ? '1':'0';
        $test->save();

        return redirect('admin/test')->with('message','Ok roi do');
    }
}
