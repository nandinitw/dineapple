@extends('layouts.app')
@section('header')
    New Outlet 
@endsection
@section('content')

    <div class="row">
        <form class="form-horizontal" role="form"  method="POST" action="{{ url('/outlets') }}" enctype="multipart/form-data" >
        <div class="col-md-8">
            <div class="box box-primary">            
                <div class="box-body">
                       
                        @csrf                        
                        <div class="form-group">
                            <div class="col-md-12">
                            <label for="name" >{{ __('Name*') }}</label>
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}"   autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                            
                        <div class="form-group selctcls">
                            <div class="col-md-12">
                            <label for="hotel_id" >{{ __('Hotel*') }}</label>                                
                                <select id="select_hotel" name="hotel_id">
                                    <option value="">Select a Hotel</option>                                       
                                    @foreach($hotels as $item)                                        
                                         @if(!@$menugroup->hotel_id)    
                                            <option value="{{$item->id}}" {{ ( $item->id == old('hotel'))? 'selected' : '' }}  >{{ucfirst($item->name)}}</option>
                                         @else
                                             <option value="{{$item->id}}" {{ ( $item->id == $menugroup->hotel_id )? 'selected':'' }}  >{{ucfirst($item->name)}}</option>
                                         @endif                                         
                                    @endforeach        
                                </select>
                                @if ($errors->has('hotel'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('hotel') }}</strong>
                                    </span>
                                @endif
                            </div>          
                        </div> 

                         <div class="form-group">                         
                           <div class="col-md-12">
                                <label for="lastname" class="">{{ __('Description') }}</label>                                   
                            <textarea name="description" id="description" class="form-control" cols="40" rows="4" placeholder="Enter the description" >{{ old('description') }}</textarea>                             
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>                                
                        </div>

                     
                </div>
            </div>             
        </div>

        <div class="col-md-4">
            <div class="box box-primary">            
                <div class="box-body">                        
                        <div class="form-group">
                            <div class="col-md-6">
                                    <a href="{{URL::asset('hotels')}}" >Back to list</a>
                            </div>
                            <div class="col-md-6">                                
                                <button type="submit" class="editor-submit btn btn-primary pad_lr_20 pull-right">
                                 Save
                                </button>
                            </div>
                        </div>
                            <hr>
                        <div class="form-group">
                            <label for="logo" class="col-md-12">Featured Image*</label>
                            <div class="col-md-12">
                                                        
                                <span class="result-featured" style="{{ ( !empty($hotel->hotel_image))? 'display:block;':'display:none;'  }}">
                                    <a href="javascript:void(0);" class="remove-featured red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </span>
                                    
                                <input id="featured" type="file" class="upload-featured pd_bt_10" name="image" />
                                <input id="featured_img" type="hidden" name="image" value=" " />
                                
                                @if ($errors->has('featured'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Featured image required!</strong>
                                    </span>
                                @endif
    
                                <span class="result-logo"> </span>

                            </div>
                                
                        </div>
                            
                        @if ($errors->has('image'))
                             <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('image') }}</strong>
                             </span>
                        @endif                
                </div>
            </div>    
        </div>
            
        @if(@$hotel->id )
        <input type="hidden" value="{{ $hotel->id }}" id="id" name="id" >
        @endif
        </form>            
    </div>
        
<script>
    jQuery(document).ready(function(){
    
        $('#deleteImage').click(function(){
          var handle = confirm("Update the group image!");
            if(handle){
                $(this).parent().hide();
                $(this).parent().find('#uploadimage').val('');
                $(this).parent().find('#bgimage').remove();
                $('#main-image').show();
            }
        });
        
        
    });
</script>
    
@endsection

