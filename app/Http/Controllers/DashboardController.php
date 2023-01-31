<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index() {
        return Inertia::render('Dashboard/Index', [
            'totalBrands' => Brand::count(),
            'totalItems' => Item::count(),
        ]);
    }
}
