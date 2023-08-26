<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Collective;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\CollectiveRequest;
use Collator;

class CollectiveController extends Controller
{
    public function __construct()
    {
        return $this->middleware(['auth', 'verified'])->except('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $collectives = Collective::where('user_id', auth()->user()->id)
            ->latest()->paginate(10);
        return array_reverse($collectives);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::all()->toArray();
        return array_reverse($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CollectiveRequest $request)
    {
        //
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $data['slug'] = Str::slug($request->title);
        Collective::create($data);
        return response()->json('Ajout effectue avec succes!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Collective  $collective
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $collective = Collective::find($id) ;
        return response()->json($collective);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Collective  $collective
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $collective = Collective::find($id);
        $categories = Category::all();
        return response()->json(['collective'=>$collective, 'categories' =>$categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Collective  $collective
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $collective = Collective::find($id);
        if ($collective->owner($collective->user_id)) {
            $this->validate($request, [
                'title' => 'required|min:10|unique:collectives,id,' . $collective->id,
                'description' => 'required|min:10',
                'category_id' => 'required|numeric'
            ]);
            $data = $request->except('_token', '_method');
            $data['user_id'] = auth()->user()->id;
            $data['slug'] = Str::slug($request->title);
            $collective->update($data);
            return response()->json('Collective updated successfully');
        }
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Collective  $collective
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $collective =  Collective::find($id) ;
        if ($collective->owner($collective->user_id)) {
            //
            $collective->delete();
         return response()->json('suppression effectue avec succes ') ;
        }
        abort(403);
    }
}
