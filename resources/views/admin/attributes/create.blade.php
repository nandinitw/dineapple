@extends('layouts.app')
@section('header')
    New Attribute
@endsection
@section('content')

    <div class="row">
        <form class="form-horizontal" role="form"  method="POST" action="{{ url('attributes') }}" enctype="multipart/form-data" >
        <div class="col-md-8">
            <div class="box box-primary">            
                <div class="box-body">
                       
                     
                        @csrf
                        
                        <div class="form-group">
                            <div class="col-md-12">
                            <label for="name" >{{ __('Name*') }}</label>
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ isset($table->name) ? $table->name : old('name') }}"   autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <label for="mobile" class="">{{ __('Section*') }}</label>
                                <select class="form-control" id="section_id" name="section_id">
                                    @foreach($sections as $key => $section)
                                        <option value="{{$section->id}}" {{ (@$attribute->section_id==$section)? 'selected':'' }}>{{$section->name}}</option>
                                    @endforeach
                                </select>
                                    
                                @if ($errors->has('section_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('section_id') }}</strong>
                                    </span>
                                @endif
                                
                            </div>    
                        </div>
                            
                        <div class="form-group">
                            
                            <div class="col-md-6">
                                <label for="type" class="field_type">{{ __('Field Type') }}</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="text"     >Text</option>
                                    <option value="textarea" >Text Area</option>
                                    <option value="checkbox" >Checkbox</option>
                                    <option value="radio" >Radio</option>
                                    <option value="multiselect">Multiselect</option>
                                    <option value="number">Number</option>
                                </select>
                                    
                                @if ($errors->has('type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                                
                            </div>
                        </div>
                        <div class="form-group">
                                <div class="col-md-6">
                                    <label for="values" >{{ __('Options*') }}</label>
                                    <textarea  class="form-control" name="values" rows="5" columns="100"></textarea>
                                </div> 
                        </div>             
                        <div class="form-group">
                            
                            <div class="col-md-6">
                                <label for="mobile" class="">{{ __('Display Status*') }}</label>
                                <select class="form-control" id="state" name="state">
                                    <option value="0" {{ (@$attribute->state==0)? 'selected':'' }}>Draft</option>
                                    <option value="1" {{ (@$attribute->state==1)? 'selected':'' }}>Published</option>
                                    <option value="-2"{{ (@$attribute->state==-2)? 'selected':'' }}>Trashed</option>
                                </select>
                                    
                                @if ($errors->has('state'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('state') }}</strong>
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

