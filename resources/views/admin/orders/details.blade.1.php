@extends('layouts.app')
@section('header')
    Orders Details of  {{ @$user->name }}
    <br>
    <small> {{ $id }}</small>
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
                        <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                        <thead>
                        <tr>
                            <th scope="col" width="2%"></th>
                            <th scope="col" width="5%">Item</th>                                                                                              
                            <th scope="col" width="10%">Created</th>
                            <th scope="col" width="10%">Purchased</th>
                            <th scope="col" width="10%">Price</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php
                                $total=0;                              
                            @endphp
                            @foreach($orderdetails as $key =>$item) 
                                <tr>
                                    <td></td>
                                    <td>
                                        <div style="width:50px;height:50px;overflow:hidden;">
                                             <img src="{{ asset('storage/media/'.@$item->image)  }}" height=50px;>
                                         </div>
                                     <br>
                                    <strong>{{ $item->title }}</strong>
                                    </td>                                   
                                    <td>{{ $item->created_at }}</td>                                        
                                    <td>{{ $item->purchased_date }}</td>
                                    <td>{{ $item->item_price }} Rs
                                    @php
                                        $total += $item->item_price;
                                    @endphp
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4"></td>
                                <td><strong>Total : {{ $total }} Rs</strong></td>
                            </tr>
                        </tbody>
                        </table>
                                        
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
