@extends('layouts.app')

@section('header')
    Menu Items
      <div class="float-right action-btns pull-right" >
        <a href="{{ url('/ratings/create')}}" class="btn btn-default" role="button" aria-pressed="true">New item</a>
        @if( sizeof($ratings))
            <a href="javascript:void();" class="btn btn-danger " onclick="deleteRecords('ratings');" role="button" aria-pressed="true">Delete</a>
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

                            <form method="GET" action="" id="adminFormList" name="adminFormList" >
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
                                    <th scope="col" width="10%">Actions</th>
                                    <th scope="col" width="20%">Name</th>
                                    <th scope="col" >Description</th>
                                    <th scope="col" width="10%">Created</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                       @if( sizeof($ratings))
                                        @foreach($ratings as $key =>$item)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="itemlist[]" value="{{$item->id}}">
                                                </td>
                                                <th>
                                                    <a href="{{  url('/ratings/'.$item->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                                     |                                                     
                                                     <a href="{{  url('/ratings/'.$item->id.'/delete') }}" onclick="javascript:return confirm('Are you sure to remove this item?')?true:false;">
                                                     <i class="fa fa-trash"></i></a>
                                                     |                                                     
                                                    <a href="javascript:void(0);" class="UpdateStatus" rel="{{$item->id}}" id="ratings_{{$item->id}}">
                                                        @if($item->state=='1')
                                                            <i class="fa fa-toggle-on"></i>
                                                        @else
                                                            <i class="fa fa-toggle-off"></i>
                                                        @endif
                                                     </a>
                                                </th>
                                                <th>
                                                <a href="{{  url('/ratings/'.$item->id.'/edit' )}}">
                                                {{ucfirst($item->name)}}
                                                </a>
                                                </th>
                                                <td>{{ $item->rated_by }}</td>
                                                <td>
                                                  {{ date('j F Y',strtotime($item->created_at) ) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="5">{{ $ratings->links() }}</td>
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

