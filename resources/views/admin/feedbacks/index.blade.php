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

                                          @include('common.search')
                                        </div>
                                      
                                    </div>
                                    <hr>

                                    <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                    <tr>
                      
                                    <th scope="col">Email</th>                                    
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if( sizeof($users) )
                                              @foreach($users as $key =>$item)                                                
                                                    <tr>
                                                      <td>
                                                      <a href="{{  url('/viewfeedback/'.$item->id) }}">
                                                        {{$item->email}}
                                                      </a>
                                                      </td>
                                                    </tr>
                                              @endforeach
                                              <tr>
                                                  <td colspan="5" align="center">
                                                          
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
