@extends('admin.master')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div style="margin-top: 20px;" class="col-sm-6">
                <h1>Chi tiết viết</h1>
            </div>

        </div>
    </div>
</section>
<div class="container-fluid">
    <span id="success">
    </span>
    @if ($errors->any())
    <div class="alert alert-warning alert-dismissible">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Chi tiết viết</h3>
        </div>
        <div class="card-body">
            <img src="{{ URL::to('public/uploads/blog/'.$tin->picture) }}" width=1000px height=600px  alt="">
            <h4 style="margin-top:30px;">{{ $tin->title }}</h4>
            <span>@foreach($user as $u)
                @if($tin->tacgia == $u->id)
                Tác giả: {{ $u->name }}
                @endif
                @endforeach</span>
            <br>
            <div>
                <p>{!! $tin->content !!}</p>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('blog.index') }}" type="submit" name="submit" class="btn btn-warning">Quay lại</a>
    </div>
</div>




@endsection