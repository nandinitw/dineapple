@extends('layouts.app')

@section('header')
    New Menu Item
@endsection

@section('content')


    <div class="row">
        <form class="form-horizontal" role="form"  method="POST" action="{{ url('/menuitems') }}" enctype="multipart/form-data" >
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-body">
                       @csrf


                        <div class="form-group">
                            <div class="col-md-12">

                            <label for="name" >{{ __('Name*') }}</label>
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ isset($menuitem->name) ? $menuitem->name : old('name') }}"   autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                            <label for="name" >{{ __('GroupId*') }}</label>
                                 <select class="form-control" id="group_id" name="group_id">
                                    <option value="">Select menu group</option>

                                    @foreach($menugroups as $item)
                                         @if(!@$menuitem->id)
                                            <option value="{{$item->id}}" {{ ( $item->id == old('group_id'))? 'selected' : '' }}  >{{ucfirst($item->name)}}</option>
                                         @else
                                             <option value="{{$item->id}}" {{ ( $item->id == $menuitem->group_id )? 'selected':'' }}  >{{ucfirst($item->name)}}</option>
                                         @endif
                                    @endforeach
                                </select>

                                @if ($errors->has('group_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('group_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group">
                           <div class="col-md-12">
                                <label for="lastname" class="">{{ __('Description') }}</label>
                                    <textarea name="description" id="description" class="form-control" cols="40" rows="4" placeholder="Enter the description" >{{ isset($menuitem->description) ? $menuitem->description : old('description') }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3">
                            <label for="price" >{{ __('Price*') }}</label>
                                <input id="price" type="text" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" value="{{ isset($menuitem->price) ? $menuitem->price : old('price') }}"   autofocus>

                                @if ($errors->has('price'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3">
                            <label for="price_unit" >{{ __('Unit*') }}</label>
                                <input id="price_unit" type="text" class="form-control{{ $errors->has('price_unit') ? ' is-invalid' : '' }}" name="price_unit" value="{{ isset($menuitem->price_unit) ? $menuitem->price_unit : old('price_unit') }}"   autofocus>

                                @if ($errors->has('price_unit'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price_unit') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3">
                            <label for="min_order" >{{ __('Minimum order') }}</label>
                                <input id="min_order" type="text" class="form-control{{ $errors->has('min_order') ? ' is-invalid' : '' }}" name="min_order" value="{{ isset($menuitem->min_order) ? $menuitem->min_order : old('min_order') }}"   autofocus>

                                @if ($errors->has('min_order'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('min_order') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3">
                                <label for="preparation_time" >{{ __('Preparation time') }}</label>
                                <input id="preparation_time" type="text" class="form-control{{ $errors->has('preparation_time') ? ' is-invalid' : '' }}" name="preparation_time" value="{{ isset($menuitem->preparation_time) ? $menuitem->preparation_time : old('preparation_time') }}"   autofocus>

                                @if ($errors->has('preparation_time'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('preparation_time') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group">
                             <div class="col-md-12">
                            <label for="name" >{{ __('Ingredients') }}</label>

                                <input type="text" class="form-control" id="ingredients" name="ingredients" class="form-control" value="{{ isset($menuitem->ingredients) ? $menuitem->ingredients : old('ingredients') }}" />

                                @if ($errors->has('ingredients'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ingredients') }}</strong>
                                    </span>
                                @endif

                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                            <label for="name" >{{ __('Special notes') }}</label>

                                 <textarea name="special_notes" id="special_notes" class="form-control" cols="40" rows="4" placeholder="Enter the special notes" >{{ isset($menuitem->special_notes) ? $menuitem->special_notes : old('special_notes') }}</textarea>

                                @if ($errors->has('special_notes'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('special_notes') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if( isset($menuitem->id) )
                        <input type="hidden" value="{{$menuitem->id}}" id="id" name="id" >
                        @endif

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body">
                        <div class="form-group">
                            <div class="col-md-6">
                                    <a href="{{URL::asset('menuitems')}}" >Back to list</a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="editor-submit btn btn-primary pad_lr_20 pull-right">
                                {{ (@$menuitem->id)? "Update" : "Save" }}
                                </button>
                            </div>
                        </div>

                            <hr>

                        <div class="form-group">

                            <label for="logo" class="col-md-12">Featured Image*</label>

                            <div class="col-md-12">


                                <span class="result-featured" style="{{ ( !empty($menuitem->image))? 'display:block;':'display:none;'  }}">
                                    <a href="javascript:void(0);" class="remove-featured red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        <img src="{{  url('storage/media/'.@$menuitem->image)}}" width="90">
                                </span>


                                <input   id="featured" type="file" class="upload-featured pd_bt_10" name="featured" />
                                <input id="featured_img" type="hidden" name="image" value="{{isset($menuitem->image)?$menuitem->image:''}}" />

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

        </form>
    </div>

<script>
    //var ingredient_arr = "<?php //echo $ingredients; ?>";

    jQuery(document).ready(function(){
        var ingredient ='';
        if(ingredient_arr)
        ingredient = ingredient_arr.split(',');

        $('#deleteImage').click(function(){
          var handle = confirm("Do you need to update the item image!");
            if(handle){
                $(this).parent().hide();
                $(this).parent().find('#uploadimage').val('');
                $('#main-image').show();
            }
        });

        $('#ingredients').tokenfield({
            autocomplete: {
                source: ingredient,
                delay: 100
            },
            showAutocompleteOnFocus: true
        });

        $('#ingredients').on('tokenfield:createtoken', function (event) {
            var existingTokens = $(this).tokenfield('getTokens');
            $.each(existingTokens, function(index, token) {
                if (token.value === event.attrs.value)
                    event.preventDefault();
            });
        });


    });

</script>

@endsection


