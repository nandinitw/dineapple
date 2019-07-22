@extends('layouts.app')

@section('header')
    Assign Attributes to Outlet
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
                                        @if(Auth::user()->role == 1)
                                          <select id="hotel_id" name="hotel_id"  class="form-control search-txt" style="float:right" >   
                                                <option value="">Select Hotel</option>
                                                @foreach($hotels as $hotel)
                                                    <option value="{{$hotel->id}}" {{ (app('request')->input('hotel_id') == $hotel->id)? 'selected':'' }} >{{$hotel->name}}</option>
                                                @endforeach
                                          </select>
                                         @endif
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
                                    <th scope="col" width="2%">No</th>
                               
                                    <th scope="col" width="20%">Name</th>
                                 
                                    <th scope="col" width="10%">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                       @if( sizeof($outlets))
                                        @foreach($outlets as $key =>$item)
                                            <tr>
                                                <td>
                                                 {{ $key+1 }}
                                                </td>
                                                <td>
                                                <a href="{{  url('/assignattributes/'.$item->id.'/edit' )}}">
                                                {{ucfirst($item->name)}}
                                                </a>
                                                </td>                                               
                                                <td>
                                                  <a href="{{  url('/assignattributes/'.$item->id.'/edit' )}}">
                                                  <span class="sp-box">ASSIGN</span>
                                                  </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="5">{{ $outlets->links() }}</td>
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

