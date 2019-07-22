@extends('layouts.app')
@section('header')
    My Cart
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
                        <div class="col-md-12">
                            <a href="{{URL::asset('menulist')}}" class="back-menu" >Add more items</a>
                                <hr>
                        </div>
                      <div class="col-sm-12">
                        @if( isset($cartItems) )
                         @if( sizeof($cartItems))
                            <form method="POST" action="{{url('/cart/checkout')}}" id="menuGroupListform" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <table id="cart_item_list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                    <tr>
                                      <th scope="col" width="20%">Item</th>
                                      <th scope="col" width="20%">Action</th>
                                      <th scope="col" width="20%">Price</th>
                                      <th scope="col" >Ingredients</th>
                                      <th scope="col" width="10%">Preparation time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($cartItems as $key => $item)
                                        <tr>
                                          <td>
                                            <div style="width:100px;height100px;overflow:hidden;">
                                              <img src="{{ asset('storage/media/'.@$item->image )  }}" width="80%" >
                                            </div>
                                            <strong>{{ ucfirst($item->name) }}</strong>
                                          </td>
                                          <td>
                                            <input type="hidden" class='item_id' name=items[] value='{{ $item->id }}' >
                                            <input type="hidden" class='cart_id' name=cart[] value='{{ $item->cart_id }}' >
                                            <a class="removeitem_cart" href="javascript:void(0);"><i class="fa fa-trash"></i></a>
                                          </td>
                                          <td>{{ $item->price }}</td>
                                          <td>{{ $item->ingredients }}</td>
                                          <td>{{ $item->preparation_time }}</td>
                                        </tr>
                                      @endforeach



                                    </tbody>
                                    </table>

                                          @if($cartItems)
                                       <div>
                                            <button type="submit" class="editor-submit btn btn-primary pad_lr_20 pull-right checkout-btn">
                                            Proceed to checkout
                                            </button>
                                    </div>
                                      @endif
                            </form>
                            @else
                             <div class="alert alert-light" role="alert">
                                <h4>No items aded to cart!</h4>
                             </div>
                            @endif
                            @endif
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
