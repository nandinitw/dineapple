@extends('layouts.app')
@section('header')
    Waiter's Feedback
@endsection
@section('content')

    <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-body">
              <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                 
                  <div class="row">
                      <div class="col-sm-6">
                            
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="row">
                                        <div class="col-sm-6">
                                        </div>
                                        
                                        <div class="col-sm-6">

                                          <!--include('common.search')-->
                                        </div>
                                      
                                    </div>
                                    <hr>

                                    <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                    <tr>
                      
                                    <th scope="col" colspan="2">Customers</th>                                    
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if( sizeof($users) )
                                              @foreach($users as $key =>$item)                                                
                                                    <tr>
                                                      <td>
                                                      <a href="{{  url('/users/'.$item->id.'/edit') }}">
                                                        {{$item->email}}
                                                      </a>
                                                      </td>
                                                      <td>
                                                      <a href="{{  url('/viewfeedbackofcustomer/'.$item->id) }}">
                                                      <span class="sp-box">VIEW FEEDBACK</span>
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
