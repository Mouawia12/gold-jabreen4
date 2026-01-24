<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Category2;
use App\Models\Pricing;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Category::all();
        $pricings = Pricing::all(); 
        return view('admin.Category.index' , compact('categories'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request -> id == 0){
            if($request -> image_url){
                $imageName = time().'.'.$request->image_url->extension();
                $request->image_url->move(('images/Category'), $imageName);
            } else {
                $imageName = '' ;
            }

            $validated = $request->validate([
                'name_ar' => 'required|unique:categories',
                'name_en' => 'required|unique:categories',
            ]);
            try {
                Category::create([
                    'name_ar' => $request -> name_ar,
                    'name_en' => $request -> name_en,
                    'description' => $request -> description ?? '' ,
                    'image_url' => $imageName,
                    'parent_id' => 0,
                    'user_id' => Auth::user() -> id
                ]);

                Category2::create([
                    'name_ar' => $request -> name_ar,
                    'name_en' => $request -> name_en,
                    'description' => $request -> description ?? '' ,
                    'image_url' => $imageName,
                    'parent_id' => 0,
                    'user_id' => Auth::user() -> id
                ]);
 
                return redirect()->route('categories')->with('success' , __('main.created'));
            } catch(QueryException $ex){

                return redirect()->route('categories')->with('error' ,  $ex->getMessage());
            }
        } else {
            return  $this -> update($request);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if($category){
            echo json_encode($category);
            exit;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $category = Category::find($request -> id);
        $category2 = Category2::find($request -> id);
        if($category){
            if($request -> image_url){
                $imageName = time().'.'.$request->image_url->extension();
                $request->image_url->move(('images/Category'), $imageName);
            } else {
                $imageName = $category ->  image_url;
            }
            $validated = $request->validate([
                'name_ar' => ['required' , Rule::unique('categories')->ignore($request -> id)],
                'name_en' => ['required' , Rule::unique('categories')->ignore($request -> id)],
            ]);

            try {
                $category -> update([
                    'name_ar' => $request -> name_ar,
                    'name_en' => $request -> name_en,
                    'description' => $request -> description ?? '' ,
                    'image_url' => $imageName,
                    'parent_id' => 0,
                    'user_id' => Auth::user() -> id
                ]);

                $category2 -> update([
                    'name_ar' => $request -> name_ar,
                    'name_en' => $request -> name_en,
                    'description' => $request -> description ?? '' ,
                    'image_url' => $imageName,
                    'parent_id' => 0,
                    'user_id' => Auth::user() -> id
                ]);
                return redirect()->route('categories')->with('success' , __('main.updated'));
            } catch (QueryException $ex){
                return redirect()->route('categories')->with('error' ,  $ex->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if($category){
            $category -> delete();
            return redirect()->route('categories')->with('success' , __('main.deleted'));
        }
    }
}
