@extends('layouts.app')

@section('content')
        <div class="container">
        <div class="row">
                <div class="col-md-12">
                <h1>User Access Control</h1>
                    
                @if (session('success'))
                <div class="alert alert-success">
                {{ session('success') }}
                </div>
                @endif
                    
                    <form method="POST" action={{ url('/assignmodules') }}>
                    @csrf
                    <div class="col-md-12"> 
                        <div class="float-right action-btn" >
                                       {{-- @if( sizeof($userlist)  ) --}}
                                            <button type="submit" class="btn btn-success">Save</button>
                                        {{--endif--}}
                                </div>
                    </div>
                    <div class="col-md-8">
                    
                               @php $base_url = url()->current(); @endphp
                                @if($userlist)
                                   @php $q = app('request')->input('q') @endphp
                                   
                                    <div class="form-group">
                                        <select class="form-control" id="user_list" name="user_list" onchange="fetchModules(this,'{{ $base_url }}');" >                                   
                                            <option value="">Select user</option>
                                            @foreach($userlist as $user)
                                                	@php $select = ($q == $user->id )? "selected" :''; @endphp
                                                <option {{$select}} value="{{ $user->id }} ">{{ $user->email }} </option>
                                            @endforeach
                                            
                                        </select>
                                    </div>
                                 @endif
                                 
                                @if($modulelist && $q)
                                <strong>Select modules</strong>
                                
                                @foreach($modulelist as $module)
                                    @php $selected = ( in_array($module->id, $user_modules) )? "checked":"";   @endphp                                    
                                    <div class="custom-control custom-checkbox">
                                    <input {{$selected}}  type="checkbox" class="custom-control-input" id="customModules{{ @$module->id }}" name="custom_modules[]" value="{{ @$module->id }}">
                                    <label class="custom-control-label" for="customModules<?php echo @$module->id; ?>">{{ ucfirst(@$module->title) }}</label>
                                    </div>                                    
                                @endforeach
                                
                              @endif
                    
                    </div>
                    </form>
                        
                </div>
            </div>
        </div>
@endsection

<script>
	function fetchModules(item, url){
		var user = item.value;
		 if( url && user){
			var redirect = url+'?q='+user;
		 }else{
			var redirect = url
		 }
		 window.location.replace(redirect);
	}
</script>
