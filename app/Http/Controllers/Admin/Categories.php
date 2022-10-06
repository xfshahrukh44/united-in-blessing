<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use DB;

class Categories extends Controller
{
    public function __construct()
    {
        //
    }

    final public function index()
    {

        try {
            if (request()->ajax()) {
                return datatables()->of(Category::with('sub_category')->get())
                    ->addColumn('parent_id', function ($data) {
                        return $data->sub_category->name ?? 'NULL';
                    })
                    ->addColumn('action', function ($data) {
                        return '<a title="View" href="category-view/' . $data->id . '" class="btn btn-dark btn-sm"><i class="fas fa-eye"></i></a>&nbsp;<a title="edit" href="category-edit/' . $data->id . '" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>&nbsp;<button title="Delete" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    })->rawColumns(['parent_id', 'action'])->make(true);
            }
        } catch (\Exception $ex) {
            return redirect('/')->with('error', $ex->getMessage());
        }
        return view('admin.category.list');
    }

    public function addCategory(Request $request)
    {
        if ($request->method() == 'POST') {
            $this->validate($request, array(
                'name' => 'required|unique:categories'
            ));
            //image uploading
            if ($request->file('file')) {
                $image = time() . '.' . $request->file('file')->extension();
//                $request->file('file')->storeAs('upload/category', $image);
                $request->file('file')->move(public_path().'/uploads/category/',$image);
                $imageName = $image;
            }


            $slugStr = Str::of($request->input('name'))->slug('-');
            $category = Category::create([
                'name' => $request->input('name'),
                'parent_id' => $request->input('main-category'),
                'category_slug' => $this->createSlug($slugStr),
                'description' => $request->input('description'),
                'meta_tag_title' => $request->input('meta-title'),
                'meta_tag_description' => $request->input('meta-description'),
                'meta_tag_keywords' => $request->input('meta-keywords'),
                'category_image' => isset($imageName) ? $imageName : null,
            ]);
            if ($category) {
                return redirect()->back()->with(['success' => 'Category Added Successfully']);
            }
        }
        $mainCategories = Category::where('status', 1)->where('parent_id', 0)->get();
        return view('admin.category.add-category', compact('mainCategories'));
    }

    private function createSlug($str)
    {
        $checkSlug = Category::where('category_slug', $str)->exists();
        if ($checkSlug) {
            $number = 1;
            while ($number) {
                $newSlug = $str . "-" . $number++;
                $checkSlug = Category::where('category_slug', $newSlug)->exists();
                if (!$checkSlug) {
                    $slug = $newSlug;
                    break;
                }
            }

        } else {
            $slug = $str;
        }
        return $slug;
    }
    final public function edit(Request $request, $id){
        if ($request->method() == 'POST') {
            $this->validate($request, array(
                'name' => ['required', Rule::unique('categories')->ignore($id)]
            ));

            if ($request->has('main-category') && $request->get('main-category') != 0){
                $main_category = $request->input('main-category');
                $mainCategory = Category::find($main_category);
                if($mainCategory->name == $request->input('name')){
                    return redirect()->back()->with(['err'=> "Parent and Child Category can't be same"])->withInput();
                }
            }
            $category = Category::find($id);

            //image uploading
            if ($request->file('file')) {
                $image = time() . '.' . $request->file('file')->extension();
            //    $request->file('file')->storeAs('upload/category', $image);
                $request->file('file')->move(public_path().'/uploads/category/',$image);
                $imageName = $image;
                $category->category_image = $imageName;
            }

            $category->name = $request->input('name');
            $category->parent_id = $request->input('main-category');
            $category->description = $request->input('description');
            $category->meta_tag_title = $request->input('meta-title');
            $category->meta_tag_description = $request->input('meta-description');
            $category->meta_tag_keywords = $request->input('meta-keywords');

            if ($category->save()) {
                return redirect()->back()->with(['success' => 'Category Edit Successfully']);
            }
        }else {
            $content=Category::findOrFail($id);
            $mainCategories = Category::where('status', 1)->where('parent_id', 0)->get();
            return view('admin.category.add-category', compact('mainCategories','content'));
        }
    }
    final public function destroy(int $id)
    {
        $productCheck = Product::where('category_id',$id)->count();
        if($productCheck > 0){
            echo 0;
        }
        $content=Category::find($id);
        if($content->parent_id==0){
            $count=Category::where('parent_id',$id)->count();
            if($count==0){
                $content->delete();
                echo 1;
            }else{

                echo 0;
            }
        }
        else{
            $content->delete();//
            echo 1;

        }
    }
    final public function show(int $id){

        $content= Category::with('sub_category')->find($id);
        return view('admin.category.view',compact('content'));
    }
}
