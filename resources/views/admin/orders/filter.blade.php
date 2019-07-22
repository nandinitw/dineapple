@php
if( isset($_REQUEST['filter_item']) )
$request_item = $_REQUEST['filter_item'];
if( isset($_REQUEST['filter_user']) )
$request_user = $_REQUEST['filter_user'];
@endphp
@extends('layouts.app')
@section('header')
   Order Filter
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
                      
                    <form method="POST" action="{{ url('/orderfilter') }}" id="filter_orderfrm">
                    
                        <div class="col-sm-12"> Filter By
                            <select class="form-control" id="filter_user" name="filter_user">
                                <option value="">Filter by User</option>
                                 @foreach($users as $key => $user)
                                     @if($user->name)
                                     <option value="{{ $user->id }}" {{ (@$request_user == $user->id)? 'selected':'' }}>{{ $user->name }}</option>
                                      @endif  
                                 @endforeach    
                            </select>     
                            <select class="form-control" id="filter_item" name="filter_item">
                                <option value="">Filter by Item</option>
                                @foreach($items as $key => $item)
                                     <option  value="{{ $item->id }}" {{ (@$request_item == $item->id)? 'selected':'' }} >{{ $item->name }}</option>
                                 @endforeach   
                            </select>
                                <hr>
                        </div>
                            
                        <div class="col-sm-12">    
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">                                  
                                        <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                        <thead>
                                        <tr>
                                            <th scope="col" width="2%"></th>
                                            <th scope="col" width="15%">Order Id</th>
                                            <th scope="col" width="15%">User</th>
                                            <th scope="col" width="15%">Item Name</th>
                                            <th scope="col" width="10%">Order Placed</th>   
                                            <th scope="col" width="10%">Purchased date</th>
                                            <th scope="col" width="5%">Unit</th>   
                                            <th scope="col" width="5%">Item Price</th>                    
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if( sizeof($cartItems))
                                            @foreach( $cartItems as $key => $item)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                        <td><a href="{{ url('/order/'.$item->order_id.'/show') }}" > ORDER DETAILS OF {{ $item->order_id }}</a></td>
                                                        <td>{{ $item->user }}</td>
                                                        <td>{{ $item->itemname }}</td>
                                                        <td>{{ $item->created_at }}</td>
                                                        <td>{{ $item->purchased_date }}</td>
                                                        <td>{{ $item->unit }}</td>
                                                        <td>{{ $item->item_price }}</td>    
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="8">
                                                    {{ $cartItems->links() }}
                                                </td>
                                            </tr>
                                          @else
                                              <tr>
                                                <td colspan="8" align="center">
                                                    No Orders has been placed yet!
                                                </td>
                                              </tr>
                                          @endif
                                        </tbody>
                                        </table>
                        </div>
                     </form>   
                          
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
