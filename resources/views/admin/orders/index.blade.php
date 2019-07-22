@extends('layouts.app')

@section('header')
    Orders Management
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-body">
              <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                  <div class="row">
                      <div class="col-sm-9">

                      </div>
                      <div class="col-sm-3">

                      </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-12">
                        <form method="GET" id="adminFormList" name="adminFormList">
   
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="row">
                                      <div class="col-sm-8">
                                      </div>
                                      
                                      <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" name="search_txt" value="{{ app('request')->input('search_txt') }}" placeholder="Keywords" class="form-control search-txt">
                                            <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default filter-btn"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                        <div class="input-group reset">
                                            <a id="reset_form" href="javascript:void(0)">Reset Filters</a>
                                        </div>
                                      </div>
                                    </div>
                                    <br>

                                    <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                    <tr>
                                        <th scope="col" width="5%">Actions</th>
                                        <th scope="col" width="5%">Order Id</th>
                                        <th scope="col" width="5%">Transaction Id</th>
                                        <th scope="col" width="10%">Placed by</th>
                                        <th scope="col" width="5%">Status</th>
                                        <th scope="col" width="10%">Placed On</th>
                                    </tr>
                                    </thead>
                        
                                    <tbody>
                                     @if( sizeof($orders))
                                        @foreach($orders as $key =>$item)
                                                 <?php
                                                      $class = "";
                                                      switch($item->status){
                                                        case "SERVED" : 
                                                              $class = "btn-warning";
                                                              break;
                                                        case "ORDERED" : 
                                                              $class = "btn-primary";
                                                              break;  
                                                        case "COMPLETED" : 
                                                              $class = "btn-success";
                                                              break;            
                                                      }
                                                    ?>
                                            <tr>
                                              <td>
                                                    <a href="{{ url('/orders/'.$item->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                                    |                                                     
                                                    <a href="{{ url('orders/trash/'.$item->id) }}" onclick="javascript:return confirm('Are you sure to remove this item?')?true:false;" ><i class="fa fa-trash"></i></a> 
                                                </td>
                                                <td><b>{{ $item->id }}</b></td>
                                                <td><a href="{{ url('/orders/'.$item->id.'/edit') }}">{{ $item->transaction_id }}</a></td>
                                                <td><a href="{{ url('/users/'.$item->user->id.'/edit') }}">{{$item->user->email}}</a></td>
                                                <td><a class="btn-xs {{$class}}">{{ $item->status }}</a></td>
                                                <td>{{ date('j F Y',strtotime($item->updated_at) ) }}</td>
                                            </tr>
                                        @endforeach          
                                        <tr>
                                            <td colspan="4" align="center">
                                               {{ $orders->links() }}
                                            </td>
                                        </tr>
                                    @else
                                    <tr>
                                        <td colspan="6" align="center">
                                            No Orders has been placed yet!
                                        </td>
                                    </tr>
                                    @endif
                            </tbody>
                            </table>

                          </form>
                     </div>

                  </div>



              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>

@endsection

