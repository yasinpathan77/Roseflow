<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Modules\Product\Entities\Category;
use Modules\FrontendCMS\Entities\HomePageSection;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::with('categoryImage', 'parentCategory', 'subCategories')->where('status', 1)->where('parent_id',0)->paginate(10);
        
        return response()->json([
            'data' => $categories,
            'msg' => 'success'
        ],200);
    }

    public function test(){
        $widgets = HomePageSection::all();
        $feature_categories = $widgets->where('section_name','feature_categories')->first();
        return $feature_categories->getCategoryByQuery();
    }
}
