<?php //print_r($attributes);?>
@foreach($attributes as $index => $attribute)
                       
                        <div class="form-group">
                            <div class="col-md-12">
                            <br>    
                            <label for="name" >{{ $attribute->name }}</label>
                            <br>
                            @if($attribute->type == "radio")
                                <?php $radio_options = explode(',',$attribute->values) ; //dd($options);?>
                                @if($radio_options)
                                    @foreach($radio_options as $key => $value)
                                        <?php $checked_radio = ($key == 0) ? 'checked=true' : ''?>
                                        <input type="radio" name="variants[{{$attribute->slug}}]" value="{{$value}}" {{$checked_radio}} > {{$value}}<br>
                                    @endforeach
                                @endif
                            @elseif($attribute->type == "text")
                                <input  type="{{ $attribute->type }}" class="form-control" name="variants[{{$attribute->slug}}]" value="" />  
                            @elseif($attribute->type == "textarea")
                                <input  type="{{ $attribute->type }}" class="form-control" name="variants[{{$attribute->slug}}]" value="" /> 
                            @elseif($attribute->type == "dropdown")
                                <select  class="form-control" name="variants[{{$attribute->slug}}]"> 
                                    <?php $select_options = explode(',',$attribute->values) ; //dd($options);?>
                                    @if($select_options)
                                        @foreach($select_options as $key => $value)
                                            <option  value="{{$value}}" > {{$value}}</option>
                                        @endforeach
                                    @endif
                                </select>    
                            @endif
                            </div>
                        </div>
 @endforeach
 <div class="form-group">
                                <div class="col-md-6">
                                <br>
                                <label for="name" >{{ __('Price*') }}</label>
                                    <input id="name" type="text" class="form-control" name="variants[price]" value=""   autofocus>
                                </div>
                        </div>