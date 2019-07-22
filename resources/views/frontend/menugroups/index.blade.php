@extends('layouts.app')
@section('header')
    Our Menus
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">            
            <div class="box-body">
              <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap cvrimgs">              
                  <div class="row">
                   @if( sizeof($menugroups))
                       
                        @foreach($menugroups as $key =>$item)
                            <div class="col-md-3 mt-2" style="overflow:hidden;">
                                <a href="{{ url('/menu/'.$item->id.'/list') }}" title="{{ucfirst($item->name)}}" >
                                        <img src="{{ asset('storage/media/'.@$item->image)  }}" height=200px;>                                                     
                                        <div class="itemname"><strong> {{ucfirst($item->name)}}</strong></div>
                                </a>      
                            </div>
                        @endforeach                       
                    @else
                     <div class="alert alert-light" role="alert">
                        <h4>Create a new menu group!</h4>
                     </div>
                    @endif                    
                     </div>
                        
                     {{ $menugroups->links() }}
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
