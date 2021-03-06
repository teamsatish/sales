<?php

namespace App\Http\Controllers\Api\Stock;

use App\Http\Models\Stock\Tumbrow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TumbrowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Tumbrow::getLOV();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $request->validate([
            'translation_type' => 'required|max:255',
            'code' => 'required|max:50',
            'meaning' => 'required',
            'order' => 'required',
        ]);

        $lookup = new AureoleLookup();

        $lookup->fill($request->except('id')); // <=Error resolved on postgre:  Not null violation: 7 ERROR: null value in column "id" violates not-null constraint 
        $lookup->save();
        return $lookup;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GlobalValue  $globalValue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AureoleLookup $aureoleLookup)
    {
        $aureoleLookup->fill($request->all());
        $aureoleLookup->save();
        return $aureoleLookup;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GlobalValue  $globalValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(AureoleLookup $aureoleLookup)
    {
        //
        $aureoleLookup->delete();
        // return Response::
        return response()->json(['response' => 'Deleted Successfully']);
    }

    
    /**
     * Get List of values for form
     */
    public function getLOV() {
        return Tumbrow::getLOV();
    }
}
