@extends('layouts.app')
@section('header')
    Tables
     <div class="float-right action-btns pull-right">
        <a href="{{ url('manage/tables/create')}}" class="btn btn-default" role="button" aria-pressed="true">New Tables</a>
        @if( sizeof($tables))
            <a href="javascript:void(0);" class="btn btn-danger " onclick="deleteRecords('manage/tables');" role="button" aria-pressed="true">Delete</a>
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
                            
                            <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                            <thead>
                                <tr>
                                <th scope="col" width="2%"><input type="checkbox" id="all_chkbox"></th>
                                <th scope="col">Actions</th>
                                <th scope="col">Title</th>
                                <th scope="col">Outlet(Restaurant)</th>
                                <th scope="col">Capacity</th>
                                <th scope="col">Created</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if( sizeof($tables))
                                @foreach($tables as $key =>$item)
                                    <tr>
                                    <th>        
                                        <input type="checkbox" name="tablelist[]" value="{{$item->id}}">
                                    </th>
                                    <th>
                                        <a href="{{ url('manage/tables/'.$item->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                        |                                                     
                                        <a href="{{ url('manage/tables/'.$item->id.'/delete') }}" onclick="javascript:return confirm('Are you sure to remove this item?')?true:false;" ><i class="fa fa-trash"></i></a> 
                                        
                                        <!--<a href="javascript:void(0);" class="UpdateStatus" rel="{{$item->id}}" id="tables_{{$item->id}}">
                                                            @if($item->state=='1')
                                                                <i class="fa fa-toggle-on"></i>
                                                            @else
                                                                <i class="fa fa-toggle-off"></i>
                                                            @endif
                                        </a>-->
                                    </th>
                                    <th>
                                        <a href="{{ url('manage/tables/'.$item->id.'/edit') }}">
                                            {{ucfirst($item->table_name)}}
                                        </a>
                                    </th>
                                        <td>{{$item->outlet->name}} ({{$item->outlet->hotel->name}})</td>
                                        <td> {{$item->no_of_persons}}</td>
                                        <td> {{ date('j F Y',strtotime($item->created_at) ) }} </td>
                                    </tr>
                                @endforeach                            
                                        <tr>
                                            <td colspan="6">{{ $tables->links() }}</td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td colspan="6" align="center">No items found!</td>
                                        </tr>
                                        @endif
                            </tbody>
                            </table>
                            </form>

                     </div>

                  </div>

                  <div class="row">
                        <div class="col-sm-5">

                        </div>
                        <div class="col-sm-7">

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
