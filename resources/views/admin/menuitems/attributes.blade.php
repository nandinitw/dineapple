<?php //print_r($attributes);?>
<div class="form-group">
@php 
$counter = 0; 
if( sizeof($varients) )
$varients = array_column($varients,'attributes');
@endphp

@foreach($attributes as $index => $attribute)
   
            <div class="col-md-6">                
                <label for="name" >{{ $attribute->name }}</label>
                <br>
                @if($attribute->type == "radio")                
                <?php $radio_options = explode(',',$attribute->values) ; //dd($options);?>

                <?php   
                //please pass the array index instead of counter in $varients[$counter]                           
                if( !empty($varients[$counter]) ){
                    $varients = json_decode($varients[$counter],TRUE );                   
                }
                //Set value for input fields            
                if( isset( $varients[$attribute->slug] )) 
                $attribute_set_value = $varients[$attribute->slug];    
                ?> 

                @if($radio_options)

                    @foreach($radio_options as $key => $value)  
                        <?php
                            $setselected = ( !empty( $varients[$attribute->slug] ) && $varients[$attribute->slug] == $value )? 'checked="checked"':'';      
                        ?>       
                        <?php $checked_radio = ($key == 0) ? 'checked=true' : ''?>
                        <input required type="radio" name="variants[0][{{$attribute->slug}}]" value="{{$value}}" {{ $setselected }} > {{$value}}<br>

                    @endforeach

                @endif

                @elseif($attribute->type == "text")
                    
                    <input required type="{{ $attribute->type }}" class="form-control" name="variants[ {{ $counter }} ][{{$attribute->slug}}]" value="{{ $attribute_set_value }}" />  

                @elseif($attribute->type == "dropdown")

                    <select  class="form-control" name="variants[{{$attribute->slug}}]"> 

                        <?php $select_options = explode(',',$attribute->values) ; //dd($options);?>
                        @if($select_options)
                            @foreach($select_options as $key => $value)
                                <option  value="{{$value}}" > {{$value}}</option>
                            @endforeach
                        @endif

                    </select> 

                @elseif($attribute->type == "checkbox")
                <?php $check_options = explode(',',$attribute->values) ; //dd($options);?>

                    @if($check_options)

                        @foreach($check_options as $key => $value)  

                            <?php   
                            //please pass the array index instead of counter in $varients[$counter]                           
                            if( !empty($varients[$counter]) ){
                            $varients = json_decode($varients[$counter],TRUE );
                            }
                            $setselected = ( !empty( $varients[$attribute->slug] ) && $varients[$attribute->slug] == $value )? 'checked="checked"':'';                        
                            ?>      
                            <?php $checked_radio = ($key == 0) ? 'checked=true' : ''?>
                            <input type="checkbox" name="variants[0][{{$attribute->slug}}]" value="{{$value}}" {{ $setselected }} > {{$value}}<br>

                        @endforeach
       

                    @endif
                @endif    
            </div>    
@endforeach                
            <div class="col-md-4">
                <label for="name" >{{ __('Price*') }}</label>
                <?php
                $price="";
                if( isset($varients['price']) && ( !empty( $varients['price']) ) )
                $price = $varients['price'];
                ?>
                    <input required id="name" type="text" class="form-control" name="variants[{{$counter}}][price]" autofocus value="{{ $price }}">
                </div>
    </div>

@php 
$counter++; 
@endphp
