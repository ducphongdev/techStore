@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="card-title">Doanh Thu</p>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body dashboard-tabs p-0">
                    <ul class="nav nav-tabs px-4" role="tablist">
                        <li class="nav-item">
                        <a class="nav-link @php if( $type == 'all'){ echo 'active';}; @endphp " role="tab" aria-controls="overview" href="{{route('revenue')}}">Tổng quan</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link @php if( $type == 'month'){ echo 'active';}; @endphp "  href="{{route('revenueByMonth')}}">Tháng này</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link @php if( $type == 'week'){ echo 'active';}; @endphp  " role="tab" aria-controls="overview" aria-selected="true" href="{{route('revenueByWeek')}}">Tuần này</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link @php if( $type == 'day'){ echo 'active';}; @endphp " role="tab" aria-controls="overview" aria-selected="true" href="{{route('revenueByDay')}}">Hôm nay</a>
                        </li>
                    </ul>
                    <div class="tab-content py-0 px-0">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                        <div class="d-flex flex-wrap justify-content-xl-between">
                            <div class="d-none d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                            <i class="mdi mdi-calendar-heart icon-lg mr-3 text-primary"></i>
                            <div class="d-flex flex-column justify-content-around">
                                <small class="mb-1 text-muted">Tính đến</small>
                                <div class="dropdown">
                                <a class="btn btn-secondary dropdown-toggle p-0 bg-transparent border-0 text-dark shadow-none font-weight-medium" href="#" role="button" aria-expanded="false">
                                    <h5 class="mb-0 d-inline-block">{{$date}}</h5>
                                </a>
                                </div>
                            </div>
                            </div>
                            <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                            <i class="mdi mdi-currency-usd mr-3 icon-lg text-danger"></i>
                            <div class="d-flex flex-column justify-content-around">
                                <small class="mb-1 text-muted">Doanh thu</small>
                                <h5 class="mr-2 mb-0">{{number_format($revenue->sum('total'), 0, '.', '.')}} VNĐ</h5>
                            </div>
                            </div>
                            <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                            <i class="mdi mdi-eye mr-3 icon-lg text-success"></i>
                            <div class="d-flex flex-column justify-content-around">
                                <small class="mb-1 text-muted">Lượt xem sản phẩm</small>
                                <h5 class="mr-2 mb-0">{{$totalView}}</h5>
                            </div>
                            </div>
                            <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                            <i class="mdi mdi-cellphone mr-3 icon-lg text-warning"></i>
                            <div class="d-flex flex-column justify-content-around">
                                <small class="mb-1 text-muted">Sản phẩm đã bán</small>
                                <h5 class="mr-2 mb-0">{{$totalPro}}</h5>
                            </div>
                            </div>
                            <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                            <i class="mdi mdi-cart mr-3 icon-lg text-danger"></i>
                            <div class="d-flex flex-column justify-content-around">
                                <small class="mb-1 text-muted">Tổng số đơn hàng</small>
                                <h5 class="mr-2 mb-0">{{$revenue->count()}}</h5>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <p class="card-title">Sản phẩm bán chạy nhất</p>
                    <div class="table-responsive pt-3">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th>
                                Top
                            </th>
                            <th>
                                Sản phẩm
                            </th>
                            <th>
                                Số lượng
                            </th>
                            <th>
                                Doanh thu
                            </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($higest_resolved as $key => $item)
                            <tr>
                            <td>
                                {{$key +1}}
                            </td>
                            <td>
                                {{$item->product_name}}
                            </td>
                            <td>
                                {{$item->number_total}}
                            </td>
                            <td>
                                {{number_format($item->number_total*$item->price, 0, '.', '.')}} VNĐ
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Sản phẩm bán chậm nhất</p>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            Top
                          </th>
                          <th>
                            Sản phẩm
                          </th>
                          <th>
                            Số lượng
                          </th>
                          <th>
                            Doanh thu
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($lowest_resolved as $key => $item)
                        <tr>
                          <td>
                            {{$key +1}}
                          </td>
                          <td>
                            {{$item->product_name}}
                          </td>
                          <td>
                            {{$item->number_total}}
                          </td>
                          <td>
                            {{number_format($item->number_total*$item->price, 0, '.', '.')}} VNĐ
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
               </div>
            </div>

            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Sản phẩm chưa bán được</p>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            #
                          </th>
                          <th>
                            Sản phẩm
                          </th>
                          <th>
                            Số lượng
                          </th>
                          <th>
                            Giá
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($no_resolved as $key => $item)
                        <tr>
                          <td>
                            {{$key +1}}
                          </td>
                          <td>
                            {{$item->name}}
                          </td>
                          <td>
                            {{$item->quantity}}
                          </td>
                          <td>
                            {{number_format($item->price, 0, '.', '.')}} VNĐ
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
               </div>
            </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function(){
      $('.order-status').change(function (e) { 
        e.preventDefault();
         status=$(this).find(':selected').val();
         order_id=$(this).attr('data-order_id')
         $.ajax({
          url: '{{route('orderUpdate')}}',
            method: 'post',
            data:{
              _token: "{{ csrf_token() }}",
              order_id:order_id,
              status: status
            },
            success:function(data){
              window.location.reload();
            }
         })
      });
     })
  </script>
  @endsection