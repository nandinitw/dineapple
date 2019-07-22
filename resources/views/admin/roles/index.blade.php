@extends('layouts.app')

@section('header')
    Roles
     <div class="float-right action-btns pull-right">
        <a href="{{ url('/roles/create')}}" class="btn btn-default" role="button" aria-pressed="true">New</a>
        @if( sizeof($roles))
            <a href="javascript:void(0);" class="btn btn-danger " onclick="deleteRecords('roles');" role="button" aria-pressed="true">Delete</a>
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
                       
                            <form method="POST" action="{{url('/roles/delete')}}" id="adminFormList" >
                            @csrf
                            <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                            <thead>
                                <tr>
                                <th scope="col"><input type="checkbox" name="chkbox_0" id="all_chkbox"></th>
                                <th scope="col">Actions</th>
                                <th scope="col">Title</th>
                                <th scope="col">Permissions</th>
                                <th scope="col">Created</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if( sizeof($roles))
                            @foreach($roles as $key =>$item)
                                <tr>
                                <th>
                                  @if($item->is_removable == 'n' )
                                      <input disabled type="checkbox" name="rolelist[]" value="{{$item->id}}">
                                  @else
                                      <input type="checkbox" name="rolelist[]" value="{{$item->id}}">
                                  @endif
                                </th>
                                <th>
                                    <a href="{{ url('/roles/'.$item->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                    |                                                     
                                    <a href="{{ url('/roles/'.$item->id.'/delete') }}" onclick="javascript:return confirm('Are you sure to remove this item?')?true:false;" ><i class="fa fa-trash"></i></a> 
                                    |
                                    <a href="javascript:void(0);" class="UpdateStatus" rel="{{$item->id}}" id="roles_{{$item->id}}">
                                    @if($item->state=='1')
                                        <i class="fa fa-toggle-on"></i>
                                    @else
                                        <i class="fa fa-toggle-off"></i>
                                    @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ url('/roles/'.$item->id.'/edit') }}">
                                    {{ucfirst($item->title)}}
                                    </a>
                                </th>
                                    <td>
                                        @php
                                            $permission_tag = array('role-create'=>'create', 'role-edit'=>'edit','role-update'=>'update','role-delete'=>'delete' );
                                            if($item->permissions)
                                            $permissions = json_decode($item->permissions);
                                        @endphp
                                        @if(is_array($permissions))
                                            @foreach($permissions as $permission)
                                            <span class="sp-box">{{ strtoupper($permission_tag[$permission]) }}</span> 
                                            @endforeach
                                        @endif

                                    </td>
                                    <td> {{ date('j F Y',strtotime($item->created_at) ) }} </td>
                                </tr>
                            @endforeach
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
