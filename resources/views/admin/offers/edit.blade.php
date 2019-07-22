@extends('layouts.app')
@section('header')
    Update an Offer
@endsection
@section('content')

    <div class="row">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/offers/'.$offer->id) }}" >

        @csrf  
        @method('PUT')
        <div class="col-md-8">
            <div class="box box-primary">            
                <div class="box-body">         
                          
                        <div class="form-group">
                            <div class="col-md-12">
                            <label for="name" >{{ __('Name*') }}</label>
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{  $offer->offer_name }}"   autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                            
                        <div class="form-group selctcls">
                            <div class="col-md-12">
                            <label for="item_id" >{{ __('Items*') }}</label>                                
                                <select id="item_id" name="item_id">
                                    <option value="">Select a Item</option>  
test{{ $offer->item_id }}
                                    @foreach($items as $key => $value)                                   
                                        <option value="{{ $value->id }}" {{  ( $offer->item_id == $value->id )? 'selected':'' }} >{{ $value->name }} - {{ $value->price_unit }} {{ $value->price }}</option>   
                                    @endforeach    

                                </select>
                                @if ($errors->has('item_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('item_id') }}</strong>
                                    </span>
                                @endif
                            </div>          
                        </div> 

                        <div class="form-group">                         
                           <div class="col-md-12">
                                <label for="lastname" class="">{{ __('Description') }}</label>                                   
                            <textarea name="description" id="description" class="form-control" cols="40" rows="4" placeholder="Enter the description" >{{ $offer->description }}</textarea>                             
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>                                
                        </div>

                        <div class="form-group">                         
                                <div class="col-md-6">
                                    <label for="discount" class="">{{ __('Discount*') }}</label>                                   
                                    <input id="discount" type="text" class="form-control{{ $errors->has('discount') ? ' is-invalid' : '' }}" name="discount" value="{{ $offer->discount }}"   autofocus>
                                    @if ($errors->has('discount'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('discount') }}</strong>
                                        </span>
                                    @endif
                                </div>   

                                <div class="col-md-6">
                                    <label for="limit" class="">{{ __('Limit') }}</label>                                   
                                    <input id="limit" type="text" class="form-control{{ $errors->has('limit') ? ' is-invalid' : '' }}" name="limit" value="{{ $offer->limit }}"   autofocus>
                                    @if ($errors->has('limit'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('limit') }}</strong>
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
                                    <a href="{{URL::asset('offers')}}" >Back to list</a>
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

        <input type="hidden" id="id" name="id" value="{{ $offer->id }}">
        <input type="hidden" id="state" name="state" value="{{ $offer->state }}">
        </form>            
    </div>
  
@endsection

