@extends('layouts.app')
@section('header')
    Attributes
     <div class="float-right action-btns pull-right">
        <a href="{{ url('attributes/create')}}" class="btn btn-default" role="button" aria-pressed="true">New</a>
        @if( sizeof($attributes))
            <a href="javascript:void(0);" class="btn btn-danger " onclick="deleteRecords('attributes');" role="button" aria-pressed="true">Delete</a>
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
                         
                            <form method="GET" action="" id="adminFormList" >
                            {{ csrf_field() }}
                            <div class="row">
                                      <div class="col-sm-6">
                                      </div>
                        
                                      <div class="col-sm-6">
                                      @include('common.search')
                                      </div>

                                    </div>
                                    <hr>
                             
                            <table class="table table-bordered table-striped dataTable">
                            <thead>
                                <tr>
                                <th scope="col" width="2%"><input type="checkbox" id="all_chkbox"></th>
                                <th scope="col">Actions</th>
                                <th scope="col">Title</th>
                                <th scope="col">Section</th>
                                <th scope="col">Type</th>
                                <th scope="col">Created</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if( sizeof($attributes))
                            @foreach($attributes as $key =>$item)
                                <tr>
                                <th>        
                                      <input type="checkbox" name="attributelist[]" value="{{$item->id}}">
                                </th>
                                <th>
                                    <a href="{{ url('attributes/'.$item->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                    |                                                     
                                    <a href="{{ url('attributes/'.$item->id.'/delete') }}" onclick="javascript:return confirm('Are you sure to remove this item?')?true:false;" ><i class="fa fa-trash"></i></a> 
                                    
                                    <!--<a href="javascript:void(0);" class="UpdateStatus" rel="{{$item->id}}" id="tables_{{$item->id}}">
                                                        @if($item->state=='1')
                                                            <i class="fa fa-toggle-on"></i>
                                                        @else
                                                            <i class="fa fa-toggle-off"></i>
                                                        @endif
                                    </a>-->
                                </th>
                                <th>
                                    <a href="{{ url('attributes/'.$item->id.'/edit') }}">
                                        {{ucfirst($item->name)}}
                                    </a>
                                </th>
                                    <td> {{ucfirst($item->section->name) }} </td>
                                    <td> {{ucfirst($item->type) }} </td>
                                    <td> {{ date('j F Y',strtotime($item->created_at) ) }} </td>
                                </tr>
                            @endforeach
                            <tr>
                                            <td colspan="5">{{ $attributes->links() }}</td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td colspan="5" align="center">No items found!</td>
                                        </tr>
                                        @endif
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
