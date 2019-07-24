<?php
use App\Models\RatingAnswer;
use App\Models\User;
?>

@extends('layouts.app')
@section('header')
    Feedback for {{$user->email}}
@endsection
@section('content')

    <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-body">
              <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                  
                  <div class="row">
                      <div class="col-sm-8">
                                    <div class="panel panel-default">
                                      <div class="panel-heading"><b>Ratings</b></div>
                                        <div class="panel-body">
                                            @if( sizeof($ratings) )
                                                    @foreach($ratings as $key =>$item)    
                                                      @if($item->answer > 0)                                            
                                        
                                                              {{$item->ratings->name}} : 
                                                            
                                                              {{$item->answer}}
                                                              @if($item->ratings->type =="star")
                                                              / {{$item->ratings->limit}}
                                                              @endif 
                                                      <br>      
                                                      @endif 
                                                         
                                                    @endforeach
                
                                            @else
                                                No items found!                       
                                            @endif
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                      <div class="panel-heading"><b>Comments</b></div>
                                        <div class="panel-body">
                                            @if( sizeof($ratings) )
                                                @foreach($ratings as $key =>$item)    
                                                      @if($item->ratings->type == 'text')     
                                                        @if($item->answer)                                       
                                                          {{$item->answer}}
                                                          <br><br>
                                                          <i>Commented on {{ date('j F Y',strtotime($item->updated_at) ) }}</i><br> 
                                                        @else
                                                          Nil
                                                        @endif  
                                                      @endif       
                                                @endforeach
                                              @else
                                                No items found!  
                                              @endif
                                        </div>
                                    </div>
                                    <?php
                                          $ratings = RatingAnswer::getRatingAnswers($id);
                                    ?>
                                    <div class="panel panel-default">
                                      <div class="panel-heading"><b>Waiter's Feedback/Comments</b></div>
                                        <div class="panel-body">
                                            @if( sizeof($ratings) )
                                                @foreach($ratings as $key =>$item)  
                                                      <?php $rated_by = User::find($item->rated_by);
                                                          
                                                      ?>  
                                                      @if($item->ratings->type == 'text')     
                                                        @if($item->answer)   
                                                          <br><br>                                    
                                                          {{$item->answer}}
                                                          <br>
                                                          <i>Commented on {{ date('j F Y',strtotime($item->updated_at) ) }} by <b>{{$rated_by->email}}</b> </i><br> 
                                                          <br>    
                                                        @endif
                                                        @elseif($item->ratings->type =="star")
                                                            <br>
                                                            {{$item->ratings->name}} : {{$item->answer}} / {{$item->ratings->limit}}        
                                                        @endif       
                                                @endforeach
                                              @else
                                                No feedbacks found!  
                                              @endif
                                        </div>
                                    </div>
                                    <br>
                                    <a type="button" href="javascript:history.back()" class="editor-submit btn  pad_lr_20" style="float:right">
                                        Back to List 
                                    </a>

                     </div>

                  </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>

@endsection
