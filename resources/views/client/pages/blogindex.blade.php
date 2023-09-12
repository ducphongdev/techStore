@extends('client.master')
@section('title','Tin tức')
@section('content')

<div class="container">
    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content d-md-flex justify-content-between align-items-center">
                    <div class="mb-3 mb-md-0">
                        <h2>Tin tức nổi bật</h2>
                        <p>Luôn được cập nhật liên tục</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="product_top_bar">

            <div clas='left_dorp'>
                <div class="row">
                    @foreach($blogs as $value)
                    <div class="col-4">
                        <a>
                            <img src="{{ URL::to('public/uploads/blog/'.$value->picture) }}" style="width:400px; height:300px;border-radius:3%;">
                        </a>
                        <br>
                    </div>
                    <div class="col-8">
                        <h3 style="font-size: 20px;">{{$value->title}}</h3>
                        <p>{{$value->summary}}</p>
                        <a style="color: blue;" href="{{url('blogs/details')}}/{{$value->id}}">Đọc tiếp...</a><br></br>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div style="margin-bottom:40px">
        {{ $blogs ->links('pagination::bootstrap-4') }}
        </div>
        
</div>
</section>
@endsection