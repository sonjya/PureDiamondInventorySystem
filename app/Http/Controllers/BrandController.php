<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class BrandController extends Controller
{
    public function index(Request $request) {
        return Inertia::render('Brands/Index',[
            'brands' => Brand::where('BrandName','LIKE','%'.$request->search.'%')->get(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'BrandName' => 'required',
            'IsActive' => 'required',
        ]);

        $searchBrand = Brand::where('BrandName',$request->BrandName)->count();

        if($searchBrand == 0) {
            $newBrand = new Brand();
            $newBrand->BrandName = $request->BrandName;
            $newBrand->IsActive = $request->IsActive;
            $newBrand->save();
        } else {
            throw ValidationException::withMessages([ 
                'BrandName' => 'Brand name already exists in the database.',
            ]);
        }
    }
    public function update(Request $request, $id) {
        $request->validate([
            'BrandID' => 'required',
            'BrandName' => 'required',
            'IsActive' => 'required',
        ]);

        $searchBrand = Brand::where('BrandID','!=',$id)->where('BrandName',$request->BrandName)->count();

        if($searchBrand == 0) {
            $brand = Brand::find($id);
            $brand->BrandName = $request->BrandName;
            $brand->IsActive = $request->IsActive;
            $brand->save();
        } else {
            throw ValidationException::withMessages([ 
                'BrandName' => 'Brand name already exists in the database.',
            ]);
        }
    }

    public function destroy($id) {
        try {
            $brand = Brand::find($id);
            $brand->delete();
        } catch (Exception $e) {
            throw ValidationException::withMessages([ 
                'BrandName' => 'Brand cannot be deleted. This item is referred to by another object.',
            ]);
        }
    }
}
