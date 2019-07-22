@extends('layouts.app')

@section('header')
    Resturants offers
      <div class="float-right action-btns pull-right" >
        <a href="{{ url('/offers/create')}}" class="btn btn-default" role="button" aria-pressed="true">New offers</a>
        @if( sizeof($offers))
            <a href="javascript:void(0);" class="btn btn-danger " onclick="deleteRecords('offers');"   role="button" aria-pressed="true">Delete</a>
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
                                    <th scope="col" width="10%">Name</th>                            
                                    <th scope="col" width="20%">Description</th> 
                                    <th scope="col" width="5%">Offer Percentage</th> 
                                    <th scope="col" width="5%">Limit</th> 
                                    <th scope="col" width="10%">Created</th>
                                    <!--<th scope="col">Status</th>  -->
                                    </tr>
                                    </thead>
                                    <tbody>
                                       @if( sizeof($offers))
                                        @foreach($offers as $key =>$item)
                                            <tr>
                                            <td>
                                                <input type="checkbox" name="grouplist[]" value="{{$item->id}}">
                                            </th>
                                            <td align="center">                                        
                                                <a href="{{ url('/offers/'.$item->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                                |
                                                <a href="{{ url('/offers/'.$item->id.'/delete') }}"  onclick="javascript:return confirm('Are you sure to remove this item?')?true:false;"><i class="fa fa-trash"></i></a>                                                    
                                                |
                                                <a href="javascript:void(0);" class="UpdateStatus" rel="{{$item->id}}" id="offers_{{$item->id}}">                                                
                                                    @if($item->state==1)
                                                        <i class="fa fa-toggle-on"></i>
                                                    @else
                                                        <i class="fa fa-toggle-off"></i>
                                                    @endif
                                                 </a>                                                    
                                            </th>
                                            <td>
                                                <a href="{{  url('/offers/'.$item->id.'/edit') }}">
                                                {{ucfirst($item->offer_name)}}
                                                </a>
                                            </td>  
                                            <td>                                                
                                                {{ucfirst($item->description)}}                                                
                                            </td>      
                                            <td>
                                                {{ ucfirst($item->discount )}}%                                             
                                            </td> 
                                            <td>
                                                {{ ucfirst($item->limit )}}
                                            </td>                                    
                                            <td>{{ date('j F Y',strtotime($item->created_at) ) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="7">{{ $offers->links() }}</td>
                                        </tr>
                                        @else
                                        <tr>
                                              <td colspan="7" align="center">No items found!</td>
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

