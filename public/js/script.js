$(document).ready(function(){

    	$('.action_group_check').change(function(){
			var current_id = $(this).attr('id');
			chk_value =  current_id.split('_');	checkbox_val = chk_value[1];
			if(this.checked) {
				$("input[type=checkbox][value='"+checkbox_val+"']").attr("checked",true);
			}else{
				$("input[type=checkbox][value='"+checkbox_val+"']").attr("checked",false);
			}
		});

		$('#all_chkbox').change(function(){
			if(this.checked){
				$(this).closest('form').find("input[type=checkbox]").attr("checked",true);
			}else{
				$(this).closest('form').find("input[type=checkbox]").attr("checked",false);
			}
		});



    $('.UpdateStatus').click(function(){
        var update_id = $(this).attr('rel');        
        var controller = $(this).attr('id');  controller = controller.split("_");             
        var toggle_class = $(this).find('i').attr('class');
        var status = (toggle_class == 'fa fa-toggle-off')? '1':'0';

        $.ajax({
            type: "post",
            url: controller[0]+"/status",
            data: {'id':update_id,'status':status},
        })
        .done(function(response){
                if(response == 'success'){
                    update_class = (status=='1')? 'fa fa-toggle-on':'fa fa-toggle-off';
                    $('#'+controller[0]+'_'+update_id).find('i').attr('class',update_class);
                }
        });
    });

    //ajax image upload
     $('.upload-featured').change(function(e) {

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var file_data = $(this).prop("files")[0];   // Getting the properties of file from file field
        var form_data = new FormData();                  // Creating object of FormData class
        form_data.append("file", file_data);
        form_data.append("folder", 'posts');
        form_data.append("type", 'featured');
        form_data.append("_token", CSRF_TOKEN);

            $.ajax({
                    url: APP_URL+'/ajaximage/upload',
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         // Setting the data attribute of ajax with file_data
                    type: 'post',
           }).done(function( result ){
           $('.invalid-feedback').remove();
                    if(result.status == 'success') {
                           // $('#featured').hide();
                            $('#featured_img').val(result.file_name);
                            var html = '<img src="'+result.file_url+'" width="90"><a href="javascript:void(0);" title="Delete feature image" class="remove-featured red"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                            $('.result-featured').html(html).show();
                            $(".loadings").fadeOut('slow');
                    }
                    else{
                            $(".loadings").fadeOut('slow');
                            $(".error").html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>'+result.message+'</div>');
                    }
            });
            //.error(function(){
            //        alert("Internal server error occured. May be the uploaded image size is too large. Please try with another image!!" );
            //        $(".loadings").fadeOut('slow');
            //});

        });

        $(".result-featured").on("click", "a.remove-featured", function(){
           $('.result-featured').hide();
            $('#featured, #featured_img').val('');
           $('#featured').show();
        });

        //add to cart button
        jQuery('.addtocart').click(function(){
            $('.empty_cart').remove();

             $(this).attr("disabled", true);
            var item_name = jQuery(this).parent().find('.itemname').text();
            var item_id = jQuery(this).parent().find('.item_id').val();


            if( jQuery('#cart_list').length  > 0)
              jQuery('.checkout_btn').show();
            else
                jQuery('.checkout_btn').hide();


            $.ajax({
                url: APP_URL+'/addtocart',
                method:'POST',
                data:{'item':item_id,'action':'insert'}
             })
            .done(function(response){
                if(response.success){
                    jQuery("ul#cart_list").prepend('<li>'+item_name+'<input type="hidden" class="item_id" name=items[] value='+item_id+' ><input type="hidden" class="cart_id" name="cart[]" value='+response.last_insert_id+'><a class="removeitem" href="javascript:void(0);">x</a></li> ');

                    $('.cart-counter').text( jQuery("ul#cart_list li").length).show();
                }
                console.log(response);
             });
        });

        jQuery('body').on('click', '.removeitem', function(){

             var confirm_delete = confirm("Do you need to remove the item from the cart!");

             if( confirm_delete ){
                jQuery(this).parent().remove();
                var cart_id = jQuery(this).parent().find('.cart_id').val();
                var item_id = jQuery(this).parent().find('.item_id').val();

                if( jQuery('#cart_list li').length  > 0)
                    jQuery('.checkout_btn').show();
                else
                    jQuery('.checkout_btn').hide();

                 jQuery.ajax({
                    url: APP_URL+'/addtocart',
                    method:'POST',
                    data:{'item':cart_id,'action':'delete'}
                 })
                .done(function(response){
                    if(response.success){
                        $('#item_block_'+item_id).find('button.addtocart').attr("disabled", false);
                        $('.cart-counter').text( jQuery("ul#cart_list li").length).show();
                    }
                    console.log(response);
                 });
             }
         });

          jQuery('.removeitem_cart').click(function(){
                var confirm_delete = confirm("Do you need to remove the item from the cart!");

                if( confirm_delete ){
                   jQuery(this).parent().parent().remove();
                   var item_id = jQuery(this).parent().find('.cart_id').val();
                   if( jQuery('#cart_list li').length  > 0)
                       jQuery('.checkout_btn').show();
                   else
                       jQuery('.checkout_btn').hide();

                    jQuery.ajax({
                       url: APP_URL+'/addtocart',
                       method:'POST',
                       data:{'item':item_id,'action':'delete'}
                    })
                   .done(function(response){
                       if(response.success){
                            var rowCount = $('#cart_item_list tbody tr').length;
                            if( rowCount == 0 )
                             jQuery('.checkout-btn').remove();
                       }
                       console.log(response);
                    });
                }
          });

          jQuery('#filter_user, #filter_item').change(function(){
             jQuery('#filter_orderfrm').submit();
          });

        $("#select_hotel").select2({
            placeholder: "Select a Hotel",
            allowClear: true
        });
        $("#select_outlet").select2({
            placeholder: "Select an Outlet",
            allowClear: true
        });
        $("#item_id").select2({
            placeholder: "Select an Item",
            allowClear: true
        });
        

        $("#select_hotel").on('change', function() {
            var hotel_id = jQuery(this).val();
            jQuery.ajax({
                url: APP_URL+'/getoutlets',
                method:'POST',
                data:{'item':hotel_id}
             })
            .done(function(response){
                var opts = $.parseJSON(response);
                $('#select_outlet').empty();
                if(opts.length){
                    $.each(opts, function(i, d) {
                        $('#select_outlet').append('<option value="' + d.id + '">' + d.name + '</option>');
                    });
                    $('#select_outlet').val(opts[0].id).trigger('change');
                }else{
                    $('#select_outlet').append('<option value="">Select an Outlet</option>').trigger('change');
                }
             });
        });

        $('#reset_form').click(function(){
            $('.search-txt, #filter_role').val('');
           jQuery('#adminFormList').submit();
        });

});

function deleteRecords(controller){    
	var $checkboxes = jQuery('#adminFormList input[type="checkbox"]');
    checkedItems = $checkboxes.filter(':checked').length;     
	if(checkedItems > 0){
		var status = confirm("Do you need to delete an item !");
		if (status == true) {            
            jQuery("#adminFormList").attr('action',APP_URL+'/'+controller+'/delete');
            jQuery("#adminFormList").attr('method','post');
            jQuery("#adminFormList").submit();
		} else {
			return false;
		}
	}else{
		alert("Please select an item to be deleted!");
	}
}

