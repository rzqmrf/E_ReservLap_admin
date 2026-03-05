<?php

namespace App\Http\Controllers;
use App\Models\about;
use Illuminate\Http\Request;

class AboutControllers extends Controller
{
    /** Display a listing of the resource. */
    public function index()
    {
        $abouts = about::all();
        return view('about.index', compact('abouts'));
    }

    /** Show the form for creating a new resource. */
    public function create()
    {
        return view('about.create');
    }

    /** Store a newly created resource in storage. */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        about::create($data);

        return redirect()->route('about.index');
    }

    /** Display the specified resource. */
    public function show(about $about)
    {
        return view('about.show', compact('about'));
    }

    /** Show the form for editing the specified resource. */
    public function edit(about $about)
    {
        return view('about.edit', compact('about'));
    }

    /** Update the specified resource in storage. */
    public function update(Request $request, about $about)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $about->update($data);

        return redirect()->route('about.show', $about);
    }

    /** Remove the specified resource from storage. */
    public function destroy(about $about)
    {
        $about->delete();
        return redirect()->route('about.index');
    }
}
