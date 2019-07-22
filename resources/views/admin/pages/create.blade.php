@extends('layouts.app')
@section('header')
    Create a page
@endsection
@section('content')

    <div class="row">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/pages') }}" >

        @csrf  
        <div class="col-md-8">
            <div class="box box-primary">            
                <div class="box-body">         
                          
                        <div class="form-group">
                            <div class="col-md-12">
                            <label for="name" >{{ __('Name*') }}</label>
                                <input id="title" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}"   autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">                         
                           <div class="col-md-12">
                                <label for="slug" class="">{{ __('Slug') }}</label>                                   
                                <input id="slug" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="slug" value="{{ old('slug') }}"   autofocus>
                            </div>                                
                        </div>

                        @php 
                        $user = Auth::user();
                        @endphp

                        @if( $user->role == 1)
                        <div class="form-group">                         
                           <div class="col-md-12">
                                <label for="slug" class="">{{ __('Hotel id') }}</label>     
                                <select class="form-control" id="hotel_id" name="hotel_id">
                                    <option value="">Select menu group</option>                                                              
                                    @foreach($hotels as $item)                                   
                                                <option value="{{$item->id}}">{{ucfirst($item->name)}}</option>                                       
                                    @endforeach
                                <select>
                            </div>                                
                        </div>
                        @else
                            <input id="slug" type="hidden"  name="hotel_id" value="{{ $user->hotel_id }}" >
                        @endif


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
                                    <a href="{{URL::asset('pages')}}" >Back to list</a>
                            </div>
                            <div class="col-md-6">                                
                                <button type="submit" class="editor-submit btn btn-primary pad_lr_20 pull-right">
                                 Save
                                </button>
                            </div>
                        </div>
                </div>
            </div>    
        </div>
        <input id="state" type="hidden" name="state" value="1"  >
        </form>            
    </div>
  
@endsection

