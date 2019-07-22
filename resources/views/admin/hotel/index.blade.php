@extends('layouts.app')

@section('header')
    Restaurants Management
      <div class="float-right action-btns pull-right" >
        <a href="{{ url('/hotels/create')}}" class="btn btn-default" role="button" aria-pressed="true">New Restaurant</a>
        @if( sizeof($hotels))
            <a href="javascript:void(0);" class="btn btn-danger " onclick="deleteRecords('hotels');"   role="button" aria-pressed="true">Delete</a>
        @endif
      </div>

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
                            <form method="GET" id="adminFormList" name="adminFormList" action="">

                                    <div class="row">
                                      <div class="col-sm-6">
                                      </div>                                    
                                      <div class="col-sm-6">
                                      @include('common.search')
                                      </div>                                     
                                    </div>
                                    <hr>

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                    <tr>
                                    <th scope="col" width="2%"><input type="checkbox" id="all_chkbox"></th>
                                    <th scope="col" width="5%">Actions</th>
                                    <th scope="col" width="20%">Name</th>                            
                                    <th scope="col" width="10%">Created</th>
                                    <!--<th scope="col">Status</th>  -->
                                    </tr>
                                    </thead>
                                    <tbody>
                                       @if( sizeof($hotels))
                                        @foreach($hotels as $key =>$item)
                                            <tr>
                                            <td>
                                                <input type="checkbox" name="grouplist[]" value="{{$item->id}}">
                                            </th>
                                            <td align="center">                                        
                                                <a href="{{ url('/hotels/'.$item->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                                |
                                                <a href="{{ url('/hotels/'.$item->id.'/delete') }}"><i class="fa fa-trash"></i></a>                                                    
                                                | 
                                                <a href="javascript:void(0);" class="UpdateStatus" rel="{{$item->id}}" id="hotels_{{$item->id}}">                                                   
                                                    @if($item->state=='1')
                                                        <i class="fa fa-toggle-on"></i>
                                                    @else
                                                        <i class="fa fa-toggle-off"></i>
                                                    @endif
                                                 </a>
                                                    
                                            </th>
                                            <td>
                                                <a href="{{  url('/hotels/'.$item->id.'/edit') }}">
                                                {{ucfirst($item->name)}}
                                                </a>
                                            </td>                                          
                                            <td>{{ date('j F Y',strtotime($item->created_at) ) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="5">{{ $hotels->links() }}</td>
                                        </tr>
                                        @else
                                        <tr>
                                              <td colspan="5" align="center">No items found!</td>
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

