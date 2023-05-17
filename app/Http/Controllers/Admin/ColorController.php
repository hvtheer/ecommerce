<?php

namespace App\Http\Controllers\Admin;

use App\Models\Color;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ColorFormRequest;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return view('admin.color.index', compact('colors'));
    }

    public function create()
    {
        return view('admin.color.create');
    }

    public function store(ColorFormRequest $request)
    {
        $validatedData = $request->validated();

        $color = new Color;
        $color->name = $validatedData['name'];
        $color->code = $validatedData['code'];
        $color->status = $request->status == true ? '1':'0';
        $color->save();

        return redirect('admin/color')->with('message','Color added successfully');
    }

    public function edit(int $color_id)
    {
        $color = Color::findOrFail($color_id);

        return view('admin.color.edit', compact('color'));
    }

    public function update(ColorFormRequest $request, $color_id)
    {
        $validatedData = $request->validated();

        $color = Color::findOrFail($color_id);

        $color->name = $validatedData['name'];
        $color->code = $validatedData['code'];
        $color->status = $request->status == true ? '1':'0';
        $color->update();

        return redirect('admin/color')->with('message','Color updated successfully');
    }

    public function destroy($color_id)
    {
        $color= Color::findOrFail($color_id);
        $color->delete();
        return redirect()->back()->with('message','Color deleted successfully');
    }
}
