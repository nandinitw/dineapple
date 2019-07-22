@extends('layouts.app')

@section('header')
    Create Roles
@endsection

@section('content')
         
        <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">            
                <div class="box-body">
                       
                      <form method="POST" action="{{ url('/roles') }}">
                      
                        @csrf                        
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label text-md-left">{{ __('Title') }}</label>

                            <div class="col-md-6">                                                                          
                                <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ isset($role->title) ? $role->title : old('title') }}"   autofocus>

                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                            
                         <div class="form-group row">
                            <label for="description" class="col-md-3 col-form-label text-md-left">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" value="{{ isset($role->role_description) ? $role->role_description : old('description') }}"   autofocus>

                                @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-3 col-form-label text-md-left">{{ __('Roles') }}</label>
                            <div class="col-md-6 form-check-inline">             
                                <div class="form-check">
                                    <input class="form-check-input" name="permissions[]" type="checkbox" id="inlineCheckbox1" value="role-create">
                                    <label class="form-check-label" for="inlineCheckbox1">Add</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="permissions[]" type="checkbox" id="inlineCheckbox2" value="role-edit">
                                    <label class="form-check-label" for="inlineCheckbox2">Edit</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="permissions[]" type="checkbox"id="inlineCheckbox3"  value="role-update">
                                    <label class="form-check-label" for="inlineCheckbox2">Update</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="permissions[]" type="checkbox" id="inlineCheckbox4" value="role-delete">
                                    <label class="form-check-label" for="inlineCheckbox2">Delete</label>
                                </div>
                            </div>
                        </div>
                             
                        @if( isset($role->id) )
                        <input type="hidden" value="{{$role->id}}" id="role_id_hidden" name="role_id_hidden" >                        
                        <input type="hidden" name="role_id" value="{{ @$role->id }}">                        
                        @endif
                    
                        <input type="hidden" name="is_removable" value="{{ @$role->is_removable }}">
                        <input type="hidden" name="is_admin" value="{{ @$role->is_admin }}">
                        
                 
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                 Save
                                </button>
                            </div>
                        </div>
                    </form>                 
                    
                </div>
            </div>
             
        </div>
        <div class="col-md-4">
            <div class="box box-primary">            
                <div class="box-body">                        
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <a href="{{URL::asset('roles')}}" >Back to list</a>
                                </div>                               
                                
                            </div>
                        </div> 
                       
                </div>
            </div>
    
        </div>
        
    </div>
     
@endsection
