@extends('layouts.app')
@section('header')
    New Menu Item
@endsection

@section('content')
    <div class="row">
        <form class="form-horizontal" id="adminFormList" role="form"  method="POST" action="{{ url('/assignratings') }}" >
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-body">
                       @csrf
                       <div class="form-group">
                            <div class="col-md-12">

                            <label for="name" >{{ __('Hotel') }}</label>
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" disabled="true" name="name" value="{{ $outlet->hotel->name   }}"   autofocus>


                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">

                            <label for="name" >{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" disabled="true" name="name" value="{{ $outlet->name   }}"   autofocus>


                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-9" style="height:400px; overflow-y: auto;">
                            <label for="name" >{{ __('Assign Ratings') }}</label>                            
                                <?php foreach($ratings as $key => $item ){ ?>                                
                                    <div class="checkbox">
                                        <label>
                                        <input type="checkbox" value="{{ $item->id }}" name="rating_id[]" {{  ( sizeof($assigned) && in_array($item->id,$assigned) )? "checked":"" }}  >
                                            {{ $item->name }}
                                        </label>
                                    </div>                                    
                                <?php } ?>
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
                                    <a href="{{URL::asset('assignratings')}}" >Back to list</a>
                            </div>
                            <div class="col-md-6">
                                <a href="javascript:void(0);" class="editor-submit btn btn-primary pad_lr_20 pull-right" onclick="AssignRecords();" role="button" aria-pressed="true">Assign</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="outlet_id" name="outlet_id" value="{{ $outlet->id }}">
        </form>
    </div>

<script>
    function AssignRecords(){            
        var $checkboxes = jQuery('#adminFormList input[type="checkbox"]');
        checkedItems = $checkboxes.filter(':checked').length;     
        if(checkedItems == 0){
            alert("Please select ratings to be assigned");           
        }else{
            document.getElementById("adminFormList").submit(); 
        } 
    }
</script>
@endsection


