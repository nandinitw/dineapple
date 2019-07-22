@extends('layouts.app')

@section('header')
    Users
      <div class="float-right action-btns pull-right" >
        <a href="{{ url('/users/create')}}" class="btn btn-default" role="button" aria-pressed="true">New</a>
        @if( sizeof($users))
            <a href="javascript:void(0);" class="btn btn-danger" onclick="deleteRecords('users');" role="button" aria-pressed="true">Delete</a>
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
                            <form method="get" id="adminFormList" name="adminFormList" action="">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="row">
                                        <div class="col-sm-6">
                                        </div>
                                        
                                        <div class="col-sm-6">
                                        <select class="form-control" name="filter_role" id="filter_role">
                                              <option value="">Select a role</option>
                                              @if($roles)
                                                  @foreach ($roles as $key => $item)
                                                    <option value="{{ $item->id }}"  {{ ($item->id == $role_filter)? 'selected':''  }} > {{ $item->title }}</option>
                                                  @endforeach
                                              @endif
                                            </select>

                                          @include('common.search')
                                        </div>
                                      
                                    </div>
                                    <hr>

                                    <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                    <tr>
                                    <th scope="col"><input type="checkbox" id="all_chkbox"></th>
                                    <th scope="col">Actions</th>                                    
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Created</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if( sizeof($users) )
                                              @foreach($users as $key =>$item)                                                
                                                    <tr>
                                                      <th>
                                                      <input {{ ($item->roleId==1)?'disabled':'' }} type="checkbox"   name="userlist[]" value="{{$item->id}}">
                                                      </th>
                                                      <th>
                                                        <a href="{{ url('/users/'.$item->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                                        |                 
                                                        <a href="{{ url('/users/'.$item->id.'/delete') }}" onclick="javascript:return confirm('Are you sure to remove this item?')true:false; " ><i class="fa fa-trash"></i></a> 
                                                      </th>                                                  
                                                      <td>
                                                      <a href="{{  url('/users/'.$item->id.'/edit') }}">
                                                      {{$item->email}}
                                                      </a>
                                                      </td>
                                                      <td> {{$item->role}}</td>
                                                      <td>
                                                        {{ date('j F Y',strtotime($item->created_at) ) }}
                                                      </td>
                                                    </tr>
                                              @endforeach
                                              <tr>
                                                  <td colspan="5" align="center">
                                                          {{ $users->links() }}
                                                  </td>
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
