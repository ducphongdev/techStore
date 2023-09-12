@extends('admin.master')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div style="margin-top: 20px;" class="col-sm-6">
                    <h1>Bài viết</h1>
                </div>
                
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">

            <div class="card">
            <div class="card-header">
                    <a href="{{url('admin/blog/create')}}" class="btn btn-success">Thêm bài viết mới mới</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">STT</th>
                                <th>Tên bài viết</th>
                                <th>Tác giả</th>
                                <th style="width: 40px">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($blogs as $tin)
                                <tr>
                                    <td>{{$blogs->firstItem() + $loop -> index }}</td>
                                    <td>{{ $tin->title }}</td>
                                    <td>
                                        @foreach ($user as $u)
                                            @if ($u->id == $tin->author)
                                                {{ $u->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{url('admin/blog/show',['Id'=>$tin->id])}}" ><button type="button" class="btn btn-primary">Xem</button></a>
                                            <a href="{{url('admin/blog/edit',['Id'=>$tin->id])}}" ><button type="button" class="btn btn-primary2">Sửa</button></a>
                                            <a href="{{ url('admin/blog/delete', ['Id' => $tin->id]) }}" ><button type="button" class="btn btn-primary3">Xóa</button></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                        {{ $blogs ->links('pagination::bootstrap-4') }}
                    </ul>
                </div>
            </div>
            @endsection
            
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

