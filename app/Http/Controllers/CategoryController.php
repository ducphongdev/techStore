<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\CateItems;
use App\Models\Products;
use DB;

class CategoryController extends Controller
{
    public function __construct()
    {
        $allCate=Categories::all();
        view()->share('allCate', $allCate);

    }
    public function index()
    {
        return view('admin.pages.categories.index');
    }
    public function create(Request $request)
    {
        if($request->has('file_upload')){
            $file=$request->file_upload;
            $file_name= date('YmdHi').$file->getClientoriginalName();
            $file->move(public_path('images/products'),$file_name);
        }
        $request->merge(['image'=>$file_name]);
        $cate= new Categories();
        $cate->name=$request->name;
        $cate->image=$request->image;
        $cate->save();

        toastr()->success('Thành công', 'Thêm danh mục thành công');
        return redirect('admin/categories/index');

    }
    public function loadEdit($id)
    {
        $cate=Categories::find($id);
        return view('admin.pages.categories.edit',['cate'=>$cate]);
    }
    public function edit(Request $request)
    {
        if($request->file_upload==''){
            $image=$request->input('image1');
        }
        else if($request->has('file_upload')){
            $file=$request->file_upload;
            $file_name= $file->getClientoriginalName();
            $file->move(public_path('images/products'),$file_name);
            $image=$file_name;
        }
            $cate=Categories::find($request->id);
            $cate->name=$request->name;
            $cate->image=$image;
            $cate->save();

            toastr()->success('Thành công', 'Cập nhật danh mục thành công');
            return redirect('admin/categories/index');
    }
    public function delete($id)
    {
        $cate=Categories::find($id);
        $cate->delete();

        toastr()->error('Thành công', 'Xóa danh mục thành công');
        return redirect('admin/categories/index');
    }
}
