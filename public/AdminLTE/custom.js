/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* Developer : Asker 
 * website : http://www.askeralik.com 
 * 
 */
(function($) {
	$.fn.customScript = function(options) {
            
        var $options = {  };
        var opts = $.extend({}, $.fn.customScript.defaults, options);
        
        //***********UPLOAD IMAGE *********************//
        
        $('.upload-logo').change(function(e) {  
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var file_data = $(this).prop("files")[0];   // Getting the properties of file from file field
	var form_data = new FormData();                  // Creating object of FormData class
	form_data.append("file", file_data)  ; 
        form_data.append("folder", 'logos') ;
        form_data.append("type", 'logo') ;
        form_data.append("_token", CSRF_TOKEN) ;
        

            $.ajax({
                    url: opts.baseUrl+'admin/ajax/upload',
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         // Setting the data attribute of ajax with file_data
                    type: 'post',
           }).done(function( result ){
                    if(result.status == 'success') {
                            $('#logo_img').val(result.file_name);
                            var html = '<a href="javascript:void(0);" class="remove-logo red"><i class="fa fa-trash" aria-hidden="true"></i></a><a href="'+result.file_url+'" target="_blank"><img src="'+result.file_url+'" width="90"></a>';
                            $('.result-logo').html(html);
                            $(".loadings").fadeOut('slow');
                    }
                    else{
                            $(".loadings").fadeOut('slow');
                            $(".error").html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>'+result.message+'</div>');	
                    }

            }).error(function(){
                    alert("Internal server error occured. May be the uploaded image size is too large. Please try with another image!!" );
                    $(".loadings").fadeOut('slow');
            });
        
        });
	//***********END : UPLOAD LOGO *********************//
        
        //***********UPLOAD document *********************//
        
        $('.upload-document').change(function(e) {  
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var file_data = $(this).prop("files")[0];   // Getting the properties of file from file field
	var form_data = new FormData();                  // Creating object of FormData class
	form_data.append("file", file_data)  ; 
        form_data.append("folder", 'document') ;
        form_data.append("type", 'document') ;
        form_data.append("_token", CSRF_TOKEN) ;
        

            $.ajax({
                    url: opts.baseUrl+'admin/ajax/upload',
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         // Setting the data attribute of ajax with file_data
                    type: 'post',
           }).done(function( result ){ console.log(result);
                    if(result.status == 'success') { 
                            $('#rating_document').val(result.file_name);
                            var html = '<a href="javascript:void(0);" class="remove-document red"><i class="fa fa-trash" aria-hidden="true"></i></a><a href="'+result.file_url+'" target="_blank">'+result.file_name+'</a>';
                            $('.result-document').html(html);
                            $(".loadings").fadeOut('slow');
                    }
                    else{
                            $(".loadings").fadeOut('slow');
                            $(".error").html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>'+result.message+'</div>');	
                    }

            }).error(function(){
                    alert("Internal server error occured. May be the uploaded image size is too large. Please try with another image!!" );
                    $(".loadings").fadeOut('slow');
            });
        
        });
	//***********END : UPLOAD LOGO *********************//
        
        
        //***********UPLOAD FEATURED IMAGE *********************//
        
        $('.upload-featured').change(function(e) {  
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var file_data = $(this).prop("files")[0];   // Getting the properties of file from file field
	var form_data = new FormData();                  // Creating object of FormData class
	form_data.append("file", file_data)  ; 
        form_data.append("folder", 'posts') ;
        form_data.append("type", 'featured') ;
        form_data.append("_token", CSRF_TOKEN) ;
        

            $.ajax({
                    url: opts.baseUrl+'admin/ajax/upload',
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         // Setting the data attribute of ajax with file_data
                    type: 'post',
           }).done(function( result ){
                    if(result.status == 'success') {
                            $('#featured_img').val(result.file_name);
                            var html = '<a href="javascript:void(0);" class="remove-featured red"><i class="fa fa-trash" aria-hidden="true"></i></a><a href="'+result.file_url+'" target="_blank"><img src="'+result.file_url+'" width="90"></a>';
                            $('.result-featured').html(html);
                            $(".loadings").fadeOut('slow');
                    }
                    else{
                            $(".loadings").fadeOut('slow');
                            $(".error").html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>'+result.message+'</div>');	
                    }

            }).error(function(){
                    alert("Internal server error occured. May be the uploaded image size is too large. Please try with another image!!" );
                    $(".loadings").fadeOut('slow');
            });
        
        });
	//***********END : UPLOAD FEATURED IMAGE *********************//
        
        
        
        /*********  Upload School photos**************/
        $('.upload-photo').change(function(e) {  
            var $this = $(this);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var file_data = $(this).prop("files")[0];   // Getting the properties of file from file field
            var form_data = new FormData();                  // Creating object of FormData class
            form_data.append("file", file_data)  ; 
            form_data.append("folder", 'images') ;
            form_data.append("_token", CSRF_TOKEN) ;


            $.ajax({
                    url: opts.baseUrl+'admin/ajax/upload',
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         // Setting the data attribute of ajax with file_data
                    type: 'post',
           }).done(function( result ){

                if(result.status == 'success') {
                    var html = '<li class="upload-thumb"><a href="javascript:void(0);" class="remove-photo red"><i class="fa fa-trash" aria-hidden="true"></i></a><a href="'+result.file_url+'" target="_blank"><img src="'+result.file_url+'" width="90"></a><input type="hidden" name="photos[]" value="'+result.file_name+'" /></li>';
                    $(html).insertBefore('li.upload-addimg');
                    $(".loadings").fadeOut('slow');
                }
                else{
                        $(".loadings").fadeOut('slow');
                        $(".error").html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>'+result.message+'</div>');	
                }

            }).error(function(){
                    alert("Internal server error occured. May be the uploaded image size is too large. Please try with another image!!" );
                    $(".loadings").fadeOut('slow');
            });
        
        });
        //*********** UPLOAD POST PHOTOS *********************//
        
        $('.upload-post-photos').change(function(e) {  
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var file_data = $("#uploadImage").prop("files")[0];   // Getting the properties of file from file field
            var form_data = new FormData();                  // Creating object of FormData class
            form_data.append("file", file_data)  ; 
            form_data.append("folder", 'images') ;
            form_data.append("_token", CSRF_TOKEN) ;


            $.ajax({
                    url: opts.baseUrl+'admin/ajax/upload',
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         // Setting the data attribute of ajax with file_data
                    type: 'post',
           }).done(function( result ){
               //console.log(result);
                    if(result.status == 'success') {
                            var html = '<li class="upload-thumb"><a href="javascript:void(0);" class="remove-upload red"><i class="fa fa-trash" aria-hidden="true"></i></a><a href="'+result.file_url+'" target="_blank"><img src="'+result.file_url+'" width="90"></a><input type="hidden" name="photos[]" value="'+result.file_name+'" /></li>';
                            $(html).insertBefore('li.upload-addimg');
                            $(".loadings").fadeOut('slow');
                    }
                    else{
                            $(".loadings").fadeOut('slow');
                            $(".error").html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>'+result.message+'</div>');	
                    }

            }).error(function(){
                    alert("Internal server error occured. May be the uploaded image size is too large. Please try with another image!!" );
                    $(".loadings").fadeOut('slow');
            });
        
        });
	//***********END : UPLOAD POST PHOTOS *********************//
        
        
        
        //*********** Remove image ***********************//
        $('body').on('click','.remove-logo', function(){ 
            $(this).closest('span.result-logo').html('');
            $('#logo_img').val('');
        });
        $('body').on('click','.remove-featured', function(){ 
            $(this).closest('span.result-featured').html('');
            $('#featured_img').val('');
            
        });
        $('body').on('click','.remove-document', function(){ 
            $(this).closest('span.result-document').html('');
            $('#rating_document').val('');
            
        });
        
        $('body').on("click", "a.remove-photo", function (e) { 
            if(confirm('Are you sure to remove this image?')){
                var image = $(this).closest('li.upload-thumb').find("input[name*='photos[]']").val();
                $('li.upload-addimg').append('<input type="hidden" id="remove_photos" name="remove_photos[]" value="'+image+'" />')

                $(this).closest('li.upload-thumb').css("background-color","#E5E5E5").fadeOut(500, function(){ 
                    $(this).remove();
                });
            }
        });
    
    /*
    $('.switch-editor').click(function(){
        if($(this).prev('textarea').hasClass('txtEditor')){
            $(this).prev('textarea').removeClass('txtEditor').summernote('destroy');
        }
        else{
            $(this).prev('textarea').addClass('txtEditor').summernote({
                    height: 300
            });  
        }
        
    }); */ 
    
    $('.admission-select').click(function(){
        if( $(this)[0].checked == true && $(this).val() == 'Y'){
            $('.admission-date').removeClass('hide');
        }
        else{
            $('.admission-date').addClass('hide');
        }
    });
    
    $('.registration-url-select').click(function(){
        if( $(this)[0].checked == true && $(this).val() == 'Y'){
            $('.registration-url').removeClass('hide');
        }
        else{
            $('.registration-url').addClass('hide');
        }
    });
    $('.week').click(function(){ 
        if( $(this)[0].checked == true ){
            $(this).closest('div.workingtime').find('input[type="text"]').removeAttr('disabled');
        }
        else{
            $(this).closest('div.workingtime').find('input[type="text"]').val('').attr('disabled',true);
        }
    });
    $('.agency').click(function(){ 
        if( $(this)[0].checked == true ){
            $(this).closest('div.school-rating').find('select').removeAttr('disabled');
        }
        else{
            $(this).closest('div.school-rating').find('select').val('').attr('disabled',true);
        }
    });
    //*--------- SEO name of Schools -----------/
        
    $('#edit_slug').click(function(e) {
        $('#seo_url').addClass('hide');
	$('#slug').attr('type','text');
	$(this).addClass('hide');
        $('#save_slug').removeClass('hide');
    });
    
    $('#save_slug').click(function(e) {
        var $this = $(this);
        var id = $this.data('id');
        $('#loader').removeClass('hide');
        $.getJSON(opts.baseUrl+'admin/ajax/school',{id : id, name:$('#slug').val(), action: 'check_name' },function(data){
                $('#loader').addClass('hide');
                $('#slug').val(data.value).attr('type','hidden');
                $('#seo_url').removeClass('hide').html($('#slug').val());
                $('#edit_slug').removeClass('hide');
                $this.addClass('hide');					
        });
    });
    $('#name').keyup(function(e) {
        if($(this).val() != '' ){
         $('#slug_area').removeClass('hide');	
        }
            
        var Text  = $('#name').val();
        var name  =  Text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
        $('#seo_url').html(name);
        $('#slug').val(name);
        return ;
            
    });
    
    //Status change
    
/*----------------------------------------------------------------------------------------------*/        
        //**Plugin initialize ***/
        $.fn.customScript.defaults = {
                baseDir:'',
                baseUrl: '',
                ajaxUrl: ''
        }
    }
    
    
})(jQuery);