@extends('admin.master')
@section('content')

<div class="content-wrapper">
    <div class="row">
      <div class="col-md-7 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">THỐNG KÊ DANH MỤC {{$cateItems[0]->Categories->name}}</h4>
              <b>Tổng số lượng sản phẩm: {{$totalProduct}} </b>
              <div class="table-responsive pt-3">
                <table id="recent-purchases-listing" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>
                        #
                      </th>
                      <th>
                        Tên Danh Mục
                      </th>
                      <th>
                        Số lượng Sản Phẩm
                      </th>
                      {{-- <th>
                        Tổng tiền
                      </th> --}}
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($cateItems as $key => $cate)
                    <tr>
                      <td>
                        {{$key+1}}
                      </td>
                      <td>
                        <a href="{{route('inventoryByPro',$cate->id)}}">{{$cate->name}}</a>
                      </td>
                      <td>
                        {{$cate->Products->sum('quantity')}}
                        <br>
                      </td>  
                      {{-- <td>
                        {{number_format($cate->Products->sum('price'), 0, '.', '.')}} VNĐ
                      </td> --}}
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
      </div>
      <div class="col-md-5 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="card-title">BIỂU ĐỒ</p>
            <div id="chart_div"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">SẢN PHẨM CÓ SỐ LƯỢNG NHIỀU NHẤT</h4>
              <div class="table-responsive pt-3">
                <table id="recent-purchases-listing" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>
                        #
                      </th>
                      <th>
                        Tên Sản Phẩm
                      </th>
                      <th>
                        Số lượng Sản Phẩm
                      </th>
                      <th>
                        Tổng tiền
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($topQuantityPro as $key => $pro)
                    <tr>
                      <td>
                        {{$key+1}}
                      </td>
                      <td>
                        <a href="{{route('loadEditPro',$pro->id)}}">{{$pro->name}}</a>
                      </td>
                      <td>
                        {{$pro->quantity}}
                        <br>
                      </td>  
                      <td>
                        {{number_format($pro->price, 0, '.', '.')}} VNĐ
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
              <h4 class="card-title">SẢN PHẨM CÓ SỐ LƯỢNG ÍT NHẤT</h4>
              <div class="table-responsive pt-3">
                <table id="recent-purchases-listing" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>
                        #
                      </th>
                      <th>
                        Tên Sản Phẩm
                      </th>
                      <th>
                        Số lượng Sản Phẩm
                      </th>
                      <th>
                        Tổng tiền
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($botQuantityPro as $key => $pro)
                    <tr>
                      <td>
                        {{$key+1}}
                      </td>
                      <td>
                        <a href="{{route('loadEditPro',$pro->id)}}">{{$pro->name}}</a>
                      </td>
                      <td>
                        {{$pro->quantity}}
                        <br>
                      </td>  
                      <td>
                        {{number_format($pro->price, 0, '.', '.')}} VNĐ
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

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

  google.charts.load('current', {'packages':['corechart']});

  google.charts.setOnLoadCallback(drawChart);
  google.charts.setOnLoadCallback(revenue);
  function drawChart() {

    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Slices');
    data.addRows([
      @php
          foreach($cateItems as $cate) {
              echo "['".$cate->name."', ".$cate->Products->sum('quantity')."],";
          }
      @endphp
    ]);

    // Set chart options
    var options = {'title':'Biểu đồ tỉ lệ sản phẩm trong danh mục',
                    'width': 450,
                    'height':300};

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
</script>
@endsection