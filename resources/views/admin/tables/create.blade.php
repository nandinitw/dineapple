@extends('layouts.app')
@section('header')
    New Table
@endsection
@section('content')

    <div class="row">
        <form class="form-horizontal" role="form"  method="POST" action="{{ url('manage/tables') }}" enctype="multipart/form-data" >
        <div class="col-md-8">
            <div class="box box-primary">            
                <div class="box-body">
                       
                     
                        @csrf
                        
                        <div class="form-group">
                            <div class="col-md-12">
                            <label for="name" >{{ __('Name*') }}</label>
                                <input id="table_name" type="text" class="form-control{{ $errors->has('table_name') ? ' is-invalid' : '' }}" name="table_name" value="{{ isset($table->table_name) ? $table->table_name : old('table_name') }}"   autofocus>

                                @if ($errors->has('table_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('table_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         @if(Auth::user()->role != 2)   
                            <div class="form-group selctcls">
                                <div class="col-md-6">
                                <label for="hotel_id" >{{ __('Hotel*') }}</label>
                                    
                                    <select id="select_hotel" name="hotel">
                                        <option value="">Select a Hotel</option>                                       
                                        @foreach($hotels as $item)                                        
                                                <option value="{{$item->id}}" {{ ( $item->id == old('hotel'))? 'selected' : '' }}  >{{ucfirst($item->name)}}</option>                                      
                                        @endforeach        
                                    </select>
                                    @if ($errors->has('hotel'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('hotel') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            
                                <div class="col-md-6">
                                <label for="outlet_id" >{{ __('Outlet*') }}</label>
                                    <select id="select_outlet" name="outlet">
                                        <option value="">Select an Outlet</option>
                                            @foreach($outlets as $item)                                        
                                                    <option value="{{$item->id}}" {{ ( $item->id == old('outlet'))? 'selected' : '' }}  >{{ucfirst($item->name)}}</option>                                     
                                            @endforeach
                                    </select>

                                    @if ($errors->has('outlet'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('outlet') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div> 
                            @else
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="hotel" >{{ __('Hotel*') }}</label>
                                    <input name="hotel" value="{{Auth::user()->outlet->hotel->id}}" type = "hidden"/>
                                    <input  value="{{Auth::user()->outlet->hotel->name}}" type = "text" disabled  class="form-control"/>
                                </div>
                                <div class="col-md-6">    
                                    <label for="outlet" >{{ __('Outlet*') }}</label>
                                    <input name="outlet" value="{{Auth::user()->outlet->id}}" type = "hidden"/>
                                    <input  value="{{Auth::user()->outlet->name}}" type = "text" disabled class="form-control"/>
                                </div>  
                            </div>      
                        @endif      
                            
                            
                        <div class="form-group">
                            <div class="col-md-6">
                            <label for="name" >{{ __('Capacity*') }}</label>
                                <input id="no_of_persons" type="number" class="form-control{{ $errors->has('no_of_persons') ? ' is-invalid' : '' }}" name="no_of_persons" value="{{ isset($table->no_of_persons) ? $table->no_of_persons : old('table_name') }}"   autofocus>

                                @if ($errors->has('no_of_persons'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('no_of_persons') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="mobile" class="">{{ __('Display Status*') }}</label>
                                <select class="form-control" id="state" name="state">
                                    <option value="0" {{ (@$table->state==0)? 'selected':'' }}>Draft</option>
                                    <option value="1" {{ (@$table->state==1)? 'selected':'' }}>Published</option>
                                    <option value="-2"{{ (@$table->state==-2)? 'selected':'' }}>Trashed</option>
                                </select>
                                    
                                @if ($errors->has('state'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                                @endif
                                
                            </div>
                        </div>

                        <div class="form-group">
                           
                        </div>
                            
                       
                     
                </div>
            </div>             
        </div>
            
        <div class="col-md-4">
            <div class="box box-primary">            
                <div class="box-body">                        
                        <div class="form-group">
                            <div class="col-md-6">
                                    <a href="{{URL::asset('manage/tables')}}" >Back to list</a>
                            </div>
                            <div class="col-md-6">                                
                                <button type="submit" class="editor-submit btn btn-primary pad_lr_20 pull-right">
                                  Save
                                </button>
                            </div>
                        </div>
                            <hr>
                        <!--<div class="form-group">
                            <label for="logo" class="col-md-12">Featured Image*</label>
                            <div class="col-md-12">
                                                        
                                <span class="result-featured" style="{{ ( !empty($menugroup->image))? 'display:block;':'display:none;'  }}">
                                   
                                    <a href="javascript:void(0);" class="remove-featured red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        <img src="{{ asset('storage/app/public/media/'.@$menugroup->image)  }}" width="90">
                                </span>
                                    
                                <input id="featured" type="file" class="upload-featured pd_bt_10" name="featured" />
                                <input id="featured_img" type="hidden" name="image" value="{{isset($menugroup->image)?$menugroup->image:''}}" />
                                
                                @if ($errors->has('featured'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Featured image required!</strong>
                                    </span>
                                @endif
    
                                <span class="result-logo"> </span>

                            </div>
                                
                        </div>-->
                            
                        <!--if ($errors->has('image'))
                             <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('image') }}</strong>
                             </span>
                        endif   -->             
                </div>
            </div>    
        </div>
            
        </form>            
    </div>       
    
@endsection

