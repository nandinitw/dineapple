@extends('layouts.app')

@section('content')<section class="invoice">
 
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Order ID : {{$order->id}}  <br>   
            
            <small class="pull-right"></small>
           
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
          Transaction ID : <b>{{$order->transaction_id}}</b><br>       
          Placed On : <b>{{ date('j F Y',strtotime($order->updated_at) ) }}</b><br>       
          Status : <a class= "btn-xs {{$class}}">{{$order->status}}</a><br>         
        </div>
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong>{{$order->table->outlet->name}}</strong><br>
            C / o {{$order->table->outlet->hotel->name}}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong>{{$order->user->name}}</strong><br>
            {{$order->user->email}}<br>
            {{$order->user->phone}}<br>
          </address>
        </div>
        <!-- /.col -->
       
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>S No</th>
              <th>Item</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $total=0;  
                    $i = 1;                            
                @endphp
                    <?php  $i = 1;?>
                    @foreach($order->items as $key => $order_item)
                      <?php 
                       
                        $subtotal = $order_item->price* $order_item->quantity
                      ?>
                      <tr>
                          <td>{{$i}}</td>
                          <td>
                              
                              <div style="width:50px;height:50px;overflow:hidden;">
                                    <img src="{{asset('storage/app/public/media')}}/{{$order_item->item->image}}" height=100px;>
                              </div>
                              <strong>{{$order_item->item->name}}</strong>
                              
                          </td>                                   
                          <td>AED {{number_format($order_item->price,2)}}</td>                                        
                          <td>{{$order_item->quantity}}</td>
                          <td> AED {{number_format($subtotal,2)}}</td>
                      </tr>
                      <?php $i++;?>
                      @php
                          $total += $subtotal
                      @endphp
                    @endforeach
                <tr>
                    <td colspan="4"></td>
                    <td>Total : <strong>AED {{number_format($total,2)}}</strong></td>
                </tr>
            </tbody>
            
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
      <div class="col-xs-12 table-responsive">
        <form class="form-horizontal" method="POST" action="{{ url('/orders/updatestatus') }}" >
          @csrf
          <input type="hidden" name="order_id" value="{{$order->id}}"/>
          <div class="form-group">
            <div class="col-md-4">
              <label for="name" >{{ __('Update Status*') }}</label>
              <select class="form-control" id="status" name="status">
                  @foreach($availableStatus as $key => $value)
                    <option value="{{$value}}" {{ ( $order->status == $value)? 'selected' : '' }}>{{$value}}</option>
                  @endforeach           
              </select>
              <br>
              <button type="submit" class="editor-submit btn btn-primary pad_lr_20">
                  Update
              </button>
              <a type="button" href="{{ url('/orders/trash')}}/{{$order->id}}" class="editor-submit btn btn-danger pad_lr_20" onclick=" return confirm('Do you wish to delete this item?')">
                  Delete Order
              </a>
              <a type="button" href="javascript:history.back()" class="editor-submit btn  pad_lr_20" style="float:right">
                  Back to List 
              </a>
            </div>          
          </div>
         </form>
        </div> 
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
     
    </section>   

@endsection

