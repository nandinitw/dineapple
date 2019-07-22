@extends('layouts.app')

@section('content')
     @if (Auth::user())   
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$ordersCount}}</h3>

              <p>New Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="{{ url('/orders') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$itemsCount}}</h3>

              <p>Menu Items</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ url('/menuitems') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$usersCount}}</h3>

              <p>Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ url('/users') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <!-- ./col -->
        @if(Auth::user()->role == 1)
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$hotelsCount}}</h3>

              <p>Hotels</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('/hotels') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$outletsCount}}</h3>

              <p>Outlets</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('/outlets') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        @endif
        <!-- ./col -->
      </div>
   
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
       
          <!-- /.nav-tabs-custom -->

          <!-- Chat box -->
         
          <!-- /.box (chat box) -->

          <!-- TO DO List -->
          @if(Auth::user()->role == 1)
            <div class="box box-primary">
              <div class="box-header">
                <i class="ion ion-clipboard"></i>
                <h3 class="box-title">Restaurants</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <ul class="todo-list">
                  @foreach($hotels as $key => $hotel)

                    <li>
                      <span class="text">{{++$key}}</span>
                      <span class="text">{{$hotel->name}}</span>
                      <div class="tools">
                        <a href="{{ url('/hotels/'.$hotel->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                      </div>
                    </li> 
                  @endforeach               
                </ul>
              </div>
              <!-- /.box-body -->
              <div class="box-footer clearfix no-border">
                <a type="button" href="{{ url('/hotels') }}" class="btn btn-default pull-right"></i> View Restaurants</a>
              </div>
            </div>
          @endif
          
          <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>
              <h3 class="box-title">Recent Orders</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="todo-list">
                
                @foreach($orders as $key => $order)    
                  <li>
                    <?php
                      $class = "";
                      switch($order->status){
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
                    <span class="text">{{++$key}}</span>
                    <span class="text">{{$order->id}}</span>
                    <span class="text btn {{$class}} btn-xs">{{$order->status}}</span>
                    <div class="tools">
                      <a href="{{ url('/orders/'.$order->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                    </div>
                  </li> 
                @endforeach               
              </ul>
              </div>
              <div class="box-footer clearfix no-border">
                <a type="button" href="{{ url('/orders') }}" class="btn btn-default pull-right"></i> View Orders</a>
              </div>
            </div>
         
            <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>
              <h3 class="box-title">Recent Products</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="todo-list">
                @foreach($menuItems as $key => $menuItem)    
                  <li>
                    <span class="text">{{++$key}}</span>
                    <span class="text">{{$menuItem->name}}</span>   
                    <span class="text">({{$menuItem->group->name}})</span>          
                    <div class="tools">
                      <a href="{{ url('/menuitems/'.$menuItem->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                    </div>
                  </li> 
                @endforeach               
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix no-border">
              <a type="button" href="{{ url('/menuitems') }}" class="btn btn-default pull-right"></i> View Menu items</a>
            </div>
          </div>
          <!-- /.box -->

          

         


        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-6 connectedSortable">

          <div class="box box-primary">
              <div class="box-header">
                <i class="ion ion-clipboard"></i>
                <h3 class="box-title">Outlets</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <ul class="todo-list">
                  
                  @foreach($outlets as $key => $outlet)
                  
                    <li>
                      <span class="text">{{++$key}}</span>
                      <span class="text">{{$outlet->name}}</span>
                      @if(isset($outlet->hotel->name))
                      <span class="text">({{$outlet->hotel->name}})</span>
                      @endif
                      <div class="tools">
                        <a href="{{ url('/outlets/'.$outlet->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                      </div>
                    </li> 
                  @endforeach               
                </ul>
              </div>
              <!-- /.box-body -->
              <div class="box-footer clearfix no-border">
                <a type="button" href="{{ url('/outlets') }}" class="btn btn-default pull-right"></i> View Outlets</a>
              </div>
            </div>


          <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>
              <h3 class="box-title">Users</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="todo-list">
                
                @foreach($users as $key => $user)    
                  <li>
                    <span class="text">{{++$key}}</span>
                    <span class="text">{{$user->email}}</span>
                    <div class="tools">
                      <a href="{{ url('/users/'.$user->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                    </div>
                  </li> 
                @endforeach               
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix no-border">
              <a type="button" href="{{ url('/users') }}" class="btn btn-default pull-right"></i> View Users</a>
            </div>
          </div>
          <!-- /.box -->

          <!-- Map box -->
         
          <!-- /.box -->

          <!-- /.box -->

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    @endif
@endsection
