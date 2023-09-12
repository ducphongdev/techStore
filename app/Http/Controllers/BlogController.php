<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use App\Models\Categories;
use App\Models\PropertiCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = User::all();
        $nguoivietbai = Blog::where('author',Auth::user()->id)->orderBy('id','DESC')->paginate(10);
        $blog = Blog::all();
        $blogs = Blog::orderBy('id','DESC')->paginate(7);
        // $category = Categories::where('chubien',Auth::user()->id)->get();

        return view('admin.pages.blog.index',compact('nguoivietbai','user','blogs'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = User::all();
        $category = Categories::all();
        return view('admin.pages.blog.create',compact('user','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'title' => 'required|unique:blogs|max:255',
            'summary' => 'required',
            'content' => 'required',      
              
            'category' => 'required',      
            'tag' => 'required',      
        ],
        [
            'title.unique' => 'Tên bài viết đã tồn tại',
            'title.required' => 'Chưa nhập tên bài viết',
            'title.max' => 'Tên bài viết quá dài',
            'summary.required' => 'Chưa nhập tóm tắt',
            'content.required' => 'Chưa nhập nội dung',
            'category.required' => 'Chưa chọn danh mục',
            'tag.required' => 'Chưa chọn tag',
           
        ]);

        $blog = new Blog();
        $blog->title = $data['title'];
        $blog->author = $request->author;
        $blog->slug =  $request->slug;
        $blog->tag = $data['tag'];
        $blog->summary = $data['summary'];
        $blog->id_category = $request->category;
        $blog->content = $data['content'];
        $blog->video =  $request->video;
        
        $get_image = $request->file('picture');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/blog',$new_image);
            $blog->picture = $new_image;

            $blog->save();
            if($request->submit == null)
            return redirect()->route('blog.index')->with('success','Thêm bài viết thành công');
            else
            return redirect()->back()->with('success','Thêm thành công');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::all();
        $tin = Blog::find($id);
        return view('admin.pages.blog.show',compact('tin','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blog::find($id);
        $category = Categories::all();
        $properti =PropertiCategory::all();

        return view('admin.pages.blog.edit',compact('blog','category','properti'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        $blog->title = $request->title;
        $blog->author = $request->author;
        $blog->slug =  $request->slug;
        $blog->tag = $request->tag;
        $blog->summary = $request->summary;
        $blog->id_category = $request->category;
        $blog->content = $request->content;
        $blog->video =  $request->video;
        $get_image = $request->file('picture');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/blog',$new_image);
            $blog->picture = $new_image;

            $blog->save();
            
            return redirect()->route('blog.index')->with('success','Cập nhật bài viết thành công');
        }
        $blog->save();
        
        return redirect()->route('blog.index')->with('success','Cập nhật bài viết thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $baiviet = Blog::find($id);
        $baiviet->delete();
        return redirect()->route('blog.index')->with('success','Xóa bài viết thành công');
    }

    public function taobaiviet(Request $request){
        $data = $request->all();
        $blog = new PropertiCategory();
        $blog->title = $data['title'];
        $blog->slug = $data['slug'];
        $blog->id_category = $data['danhmuc'];
        $blog->id_properticategory = $data['thuoctinh'];
        $blog->summary = $data['summary'];
        $blog->tag = $data['tag'];
        $blog->picture = $data['picture'];
        $blog->video = $data['video'];
        $blog->content = $data['content'];
        $blog->author = $data['author'];
        $get_image = $request->file('picture');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/blog',$new_image);
            $blog->picture = $new_image;

            $blog->save();
            if($request->submit == null)
            return redirect()->route('blog.index')->with('success','Thêm bài viết thành công');
            else
            return redirect()->back()->with('success','Thêm thành công');
        }
        $blog->save();

      
        

        $output ='';
        $output.='<div class="alert alert-info alert-dismissible">';
        $output.=' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        $output.='<h5><i class="icon fas fa-info"></i>Thêm thành công</h5>';

        $output.='</div>';

        echo $output;
    }
    

  
}
