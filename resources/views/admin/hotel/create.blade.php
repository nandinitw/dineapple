@extends('layouts.app')
@section('header')
    New Restaurant 
@endsection
@section('content')

    <div class="row">
        <form class="form-horizontal" role="form"  method="POST" action="{{ url('/hotels') }}" enctype="multipart/form-data" >
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
                                        <img src="{{ asset('storage/hotels/'.@$hotel->hotel_image)  }}" width="90">
                                </span>
                                    
                                <input id="featured" type="file" class="upload-featured pd_bt_10" name="featured" />
                                <input id="featured_img" type="hidden" name="image" value="{{isset($hotel->hotel_image)?$hotel->hotel_image:''}}" />
                                
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

