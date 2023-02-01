<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ItemController extends Controller
{
    public function index(Request $request) {
        return Inertia::render('Items/Index',[
            'items' => Item::where('ItemName','LIKE','%'.$request->search.'%')->get(),
            'brands' => Brand::get(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'ItemName' => 'required',
            'ItemPrice' => 'required|numeric',
            'ItemUOM' => 'required',
            'BrandID' => 'required',
            'MinStock' => 'required|numeric',
            'ReorderQty' => 'required|numeric',
            'IsActive' => 'required', 
        ]);

        $searchItem = Item::where('ItemName',$request->ItemName)->count();

        if($searchItem == 0) {
            $newItem = new Item();
            $newItem->ItemName = $request->ItemName;
            $newItem->ItemPrice = $request->ItemPrice;
            $newItem->ItemUOM = $request->ItemUOM;
            $newItem->BrandID = $request->BrandID;
            $newItem->MinStock = $request->MinStock;
            $newItem->ReorderQty = $request->ReorderQty;
            $newItem->IsActive = $request->IsActive;
            $newItem->save();
        } else {
            throw ValidationException::withMessages([ 
                'ItemName' => 'Inventory item already exists in the database.',
            ]);
        }
    }

    public function update(Request $request, $id) {
        $request->validate([
            'ItemID' => 'required',
            'ItemName' => 'required',
            'ItemPrice' => 'required|numeric',
            'ItemUOM' => 'required',
            'BrandID' => 'required',
            'MinStock' => 'required|numeric',
            'ReorderQty' => 'required|numeric',
            'IsActive' => 'required', 
        ]);

        $searchBrand = Item::where('ItemID','!=',$id)->where('ItemName',$request->ItemName)->count();

        if($searchBrand == 0) {
            $item = Item::find($id);
            $item->ItemID = $request->ItemID;
            $item->ItemName = $request->ItemName;
            $item->ItemPrice = $request->ItemPrice;
            $item->ItemUOM = $request->ItemUOM;
            $item->BrandID = $request->BrandID;
            $item->MinStock = $request->MinStock;
            $item->ReorderQty = $request->ReorderQty;
            $item->IsActive = $request->IsActive;
            $item->save();
        } else {
            throw ValidationException::withMessages([ 
                'ItemName' => 'Brand name already exists in the database.',
            ]);
        }
    }

    public function destroy($id) {
        $item = Item::find($id);
        $item->delete();
    }
}
