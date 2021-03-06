<?php

namespace App\Http\Controllers\Api\Stock;

use App\Http\Models\Stock\Item;
use App\Http\Models\Stock\PriceMapping;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();

        foreach ($items as $key => $item) {
            # code...
            $item->gsm = Item::getLookup($item->gsm, 'GSM'); //BF,GSM
            $item->bf = Item::getLookup($item->bf, 'BF');
            $item->price_mapping = PriceMapping::where('item_id', $item->id)->get();
        }

        return $items;
    }

    /**
     * Returns deleted Items
     */
    public function deleteGSM(Request $request, $itemId, $gsmCode)
    {
        $priceM = PriceMapping::where(['item_id'=> $itemId, 'gsm' => $gsmCode])->get();

        $item = Item::find($itemId);
        $gsm = $item->gsm;
        $gsmArray = explode(",", $gsm);

        if(in_array($gsmCode, $gsmArray)) {
            $arrayDiff = array_diff($gsmArray, [$gsmCode]);
            $item->gsm = implode($arrayDiff);
            $item->save();
        }

        foreach ($priceM as $key => $value) {
            $value->delete();
        }

        return $priceM;
    }

    /**
     * returns deleted BF
     */
    public function deleteBF(Request $request, $itemId, $bfCode)
    {
        $priceM = PriceMapping::where(['item_id'=> $itemId, 'bf' => $bfCode])->get();
        $item = Item::find($itemId);
        $bf = $item->bf;
        $bfArray = explode(",", $bf);

        if(in_array($bfCode, $bfArray)) {
            $arrayDiff = array_diff($bfArray, [$bfCode]);
            $item->bf = implode($arrayDiff);
            $item->save();
        }

        foreach ($priceM as $key => $value) {
            $value->delete();
        }

        return $priceM;
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
            'item_name' => 'required|max:255',
            'item_code' => 'required|unique:ut_stock_item_m',
            'bf' => 'required',
            'gst' => 'required',
        ]);

        if(!Item::isUnique($request->except('id'))) {
            return response(["message"=> "Duplicate item name, bf, gsm combination."], 422);
        }

        $item = new Item();

        $item->fill($request->except('id')); // <= Error resolved on postgre:  Not null violation: 7 ERROR: null value in column "id" violates not-null constraint 
        $item->user_id = Auth::id();
        $item->save();
        return $item;
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
    public function destroy(Item $item)
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
        return Item::getLOV();
    }
    
    public function getItemCode(Request $request) {
        
        $request->validate([
            'item_name' => 'required',
        ]);
        
        $itemName = $request->item_name;
        $itemName = trim($itemName);

        $names = explode(' ', $itemName);
        $codePrefix = '';
        forEach($names as $name) {
           $codePrefix .= ucfirst($name)[0];
        }

        return Item::getItemCode($codePrefix);
    }
}
