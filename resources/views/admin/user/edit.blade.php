@extends('layouts.app')
@section('header')
    Edit Users
@endsection
@section('content')

    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">            
                <div class="box-body">
                       
                      <form class="form-horizontal" role="form"  method="POST" action="{{ url('/users') }}">

                        @csrf                        
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">                                                                          
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ isset($user->name) ? $user->name : old('name') }}"   autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                            
                         <div class="form-group row" style="display:none;">
                            <label for="lastname" class="col-md-4 col-form-label text-md-right">{{ __('Lastname') }}</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" value="{{ isset($user->lastname) ? $user->lastname : old('lastname') }}"   autofocus>

                                @if ($errors->has('lastname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                            
                            

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ isset($user->email) ? $user->email : old('email') }}"  >

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('Mobile') }}</label>

                            <div class="col-md-6">
                                <input id="mobile" type="text" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" value="{{ isset($user->mobile) ? $user->mobile : old('mobile') }}"   autofocus>

                                @if ($errors->has('mobile'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        @if(Auth::user()->role ==1)
                            <div class="form-group row">
                                <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('Hotel*') }}</label>
    
                                <div class="col-md-6">
                                    <select id="select_hotel" name="hotel">
                                        <option value="">Select a Hotel</option>                                       
                                        @foreach($hotels as $item)                                        
                                                @if(!@$user->hotel_id)    
                                                    <option value="{{$item->id}}" {{ ( $item->id == old('hotel'))? 'selected' : '' }}  >{{ucfirst($item->name)}}</option>
                                                @else
                                                    <option value="{{$item->id}}" {{ ( $item->id == $user->hotel_id  )? 'selected':'' }}  >{{ucfirst($item->name)}}</option>
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

                            <div class="form-group row">
                                <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('Outlet') }}</label>

                                <div class="col-md-6">
                                    <select id="select_outlet" name="outlet">
                                        @if(!@$user->id) 
                                        <option value="">Select an Outlet</option>
                                        @else    
                                            @foreach($outlets as $item)                                        
                                                    @if(!@$user->outlet_id)    
                                                    <option value="{{$item->id}}" {{ ( $item->id == old('outlet'))? 'selected' : '' }}  >{{ucfirst($item->name)}}</option>
                                                    @else
                                                        <option value="{{$item->id}}" {{ ( $item->id == $user->outlet_id )? 'selected':'' }}  >{{ucfirst($item->name)}}</option>
                                                    @endif                                         
                                            @endforeach
                                        @endif    
                                    </select>
                                    @if ($errors->has('outlet'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('outlet') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="form-group row">
                                <div class="col-md-4"><label for="hotel" >{{ __('Hotel*') }}</label></div>
                                <div class="col-md-6">
                                    
                                    <input name="hotel" value="{{Auth::user()->outlet->hotel->id}}" type = "hidden"/>
                                    <input  value="{{Auth::user()->outlet->hotel->name}}" type = "text" disabled  class="form-control"/>
                                </div>
                            </div>  
                            <div class="form-group row"> 
                            <div class="col-md-4"><label for="outlet" >{{ __('Outlet*') }}</label></div>
                                <div class="col-md-6">    
                                    <input name="outlet" value="{{Auth::user()->outlet->id}}" type = "hidden"/>
                                    <input  value="{{Auth::user()->outlet->name}}" type = "text" disabled class="form-control"/>
                                </div>  
                                
                            </div> 
                        @endif
                        

                        @if(@$user->role !=1)                               
                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

                            <div class="col-md-6">
                                 
                                    <select id="role" type="text" class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" >
                                    @foreach ($roles as $id => $role)                                        
                                        {{ $selected = (@$user->role == $role->id) ? 'selected' : '' }}
                                        
                                         <option value="{{$role->id}}" {{$selected}} >{{ ucfirst($role->title) }}</option>
                                    @endforeach
                                    </select>
                                    @if ($errors->has('role'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('role') }}</strong>
                                        </span>
                                    @endif
    
                            </div>
                        </div>
                        @else
                            <input type="hidden" id="role" name="role" value="{{ @$user->role }}"> 
                        @endif   
                            
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>
                        @if( isset($user->id) )
                        <input type="hidden" value="{{ $user->id }}" id="user_id_hidden" name="user_id_hidden" >
                        @endif
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                 {{ (@$user->id)? "Update" : "Register" }}
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
                                    <a href="{{URL::asset('users')}}" >Back to list</a>
                                </div>
                               
                                
                            </div>
                        </div> 
                       
                </div>
            </div>
    
        </div>
        
    </div>
@endsection
