@extends('layouts.app')
@section('header')
    Edit Rating
@endsection

@section('content')


    <div class="row">
        <form class="form-horizontal" role="form"  method="POST" action="{{ url('/ratings/update') }}" enctype="multipart/form-data" >
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-body">
                       @csrf
                       <div class="form-group">
                            <div class="col-md-12">

                            <label for="name" >{{ __('Name*') }}</label>
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ isset($ratings->name) ? $ratings->name : old('name') }}"   autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                            <label for="name" >{{ __('Rated by*') }}</label>
                                <select class="form-control" id="rated_by" name="rated_by">
                                    <option >Select Rated By</option>
                                    <option value="customer" {{ ($ratings->rated_by == 'customer')? 'selected':'' }} >Customer</option>
                                    <option value="waiter" {{ ($ratings->rated_by == 'waiter')? 'selected':'' }} >Waiter</option>                                    
                                </select>   
                                @if ($errors->has('rated_by'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('rated_by') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">

                            <label for="name" >{{ __('Rating Type*') }}</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="" >Select Type</option>
                                    <option value="star" {{ ($ratings->type == 'star')? 'selected':''}} > Star</option>
                                    <option value="text" {{ ($ratings->type == 'text')? 'selected':''}} > Text</option>   
                                    <option value="checkbox" {{ ($ratings->type == 'checkbox')? 'selected':''}} > Checkbox</option>
                                    <option value="radio" {{ ($ratings->type == 'radio')? 'selected':''}} > Radio</option>   
                                    <option value="dropdown" {{ ($ratings->type == 'dropdown')? 'selected':''}} > Dropdown</option>                                    
                                </select>   
                                @if ($errors->has('type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif

                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                            <label for="name" >{{ __('Options*') }}</label>
                                    <textarea class="form-control" id="options" name="options">{{ $ratings->options }}</textarea>                            
                            </div>
                        </div>

                        @if( isset($ratings->id) )                        
                        <input type="hidden" value="{{$ratings->id}}" id="id" name="id" >
                        @endif

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body">
                        <div class="form-group">
                            <div class="col-md-6">
                                    <a href="{{URL::asset('ratings')}}" >Back to list</a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="editor-submit btn btn-primary pad_lr_20 pull-right">
                                    Update
                                </button>
                            </div>
                        </div>
            </div>
        </div>

        </form>
    </div>

<script>

   // var ingredient_arr = "<?php //echo $ingredients; ?>";

    jQuery(document).ready(function(){
        // var ingredient ='';
        // if(ingredient_arr)
        // ingredient = ingredient_arr.split(',');

        $('#deleteImage').click(function(){
          var handle = confirm("Do you need to update the item image!");
            if(handle){
                $(this).parent().hide();
                $(this).parent().find('#uploadimage').val('');
                $('#main-image').show();
            }
        });

        // $('#ingredients').tokenfield({
        //     autocomplete: {
        //         source: ingredient,
        //         delay: 100
        //     },
        //     showAutocompleteOnFocus: true
        // });

        // $('#ingredients').on('tokenfield:createtoken', function (event) {
        //     var existingTokens = $(this).tokenfield('getTokens');
        //     $.each(existingTokens, function(index, token) {
        //         if (token.value === event.attrs.value)
        //             event.preventDefault();
        //     });
        // });


    });

</script>

@endsection


