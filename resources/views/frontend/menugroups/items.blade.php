@extends('layouts.app')
@section('header')
   Items
@endsection
@section('content')
    <div class="row">

    </div>

    <div class="row">

        <div class="col-md-12">
        <div class="box box-primary">
        <div class="box-body">
        <div class="col-md-12">
        <h4><a href="{{URL::asset('menulist')}}" class="back-menu" >Back to menu</a></h4>
        </div>
        <hr>
              <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                  <div class="row">
                   @if( sizeof($menuitems))
                   <form>
                     @csrf()
                        @foreach($menuitems as $key =>$item)
                            <div class="col-md-3 mt-2" style="overflow:hidden;" id="item_block_{{ $item->id }}" >
                                <img src="{{ asset('storage/media/'.@$item->image)  }}" height=200px;>
                                <div class="itemname mt-2"><strong> {{ucfirst($item->name)}}</strong>
                                    <strong><div style="float:right;">{{ucfirst($item->price)}} {{ucfirst($item->price_unit)}}</div></strong>
                                </div>
                                <div>
                                    <p>
                                         @php
                                         if( strlen($item->description) > 300)
                                         $item->description = substr($item->description,0,200).'...'
                                         @endphp
                                         {{ $item->description }}
                                    </p>
                                </div>
                                <input type="hidden" name="menu_group" value="{{ $item->group_id }}">
                                <input type="hidden" name="item_id" class="item_id" value="{{ $item->id }}">
                                @php
                                    $status =  ( in_array($item->id,$purchase_list ) )? 'disabled' : '';
                                @endphp
                                
                                <button type="button" class="btn btn-primary addtocart" {{$status}} >Add to Cart</button>
                            </div>
                        @endforeach
                      </form>
                    @else
                     <div class="alert" role="alert">
                       <h4>Empty Items!, Click back to add more items</h4>
                     </div>
                    @endif
                    </div>
                    {{ $menuitems->links() }}
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
