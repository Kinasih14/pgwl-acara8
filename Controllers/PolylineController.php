<?php

namespace App\Http\Controllers;
use App\Models\Polylines;
use Illuminate\Http\Request;

class PolylineController extends Controller
{
    public function __construct(){
        $this->polyline = new Polylines();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $polylines = $this->polyline->polylines();

        foreach ($polylines as $p) {
            $feature[] = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom), //decode dari json ke php
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' =>$p->description,
                    'image' =>$p->image,
                    'created_at' =>$p->created_at,
                    'updated_at' =>$p->updated_at
                ]
                ];
        }

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $feature,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'name' => 'required',
            'geom' => 'required',
            'image' => 'mimes:jpg,jpeg,jpeg,png,tiff, gif |max:1000' // 10MB
        ],
        [
            'name.required' => 'Name is required',
            'geom.required' => 'Location is required',
            'image.mimes' => 'Image must be a file of type: jpg, jpeg, png, tiff, gif',
            'image.max' => 'Image must not exceed 10MB'
        ]);

        // upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_polyline.' . $image->getClientOriginalExtension();
            $image->move('storage/images', $filename);
        } else {
            $filename = null;
        }

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'geom' => $request->geom,
            'image' => $filename
        ];

        //create folder image
        if(!is_dir('storage/images')) {
            mkdir('storage/images', 0777); //077sebagai permisionnya untuk read, write, dan execute
        }


        //create polyline
        if(!$this->polyline->create($data)) {
            return redirect()->back()->with('error', 'Failed to create polyline');
        }

        //redirect to map
        return redirect()->back()->with('success', 'Polyline created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        //get image
        $image = $this-> polyline->find($id)->image;

        //delete polyline
        if(!$this->polyline->destroy($id)) {
            return redirect()->back()->with('error', 'Failed to delete polyline');
        }

        //delete image
        if ($image !=null) {
            unlink('storage/images/'.$image);
        }

        //redirect to map
        return redirect()->back()->with('success', 'Polyline deleted successfully');
    }

    public function table() {

        $polylines = $this->polyline->all();

        $data = [
            'title' => 'Table Polyline',
            'polylines'=> $polylines
        ];

        return view('table-polyline', $data);

    }
}
