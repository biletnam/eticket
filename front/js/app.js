bind_mce();
var ticket_id = $("#last_ticket_id").val();
$(document).ready(function(){
    init();
    bind_user();
    bind_category();
    bind_event();
});

function init(){
    $('.alert .close').click(function(){
        $('.alert').fadeOut('slow');
    });
    $(".fancybox").fancybox();
    
    $('.btn-invite').fancybox({
        
    });
    
    $("table .delete-row").click(function(){
        if(!confirm("Are you sure delete this item?")) return false;
        var ele = $(this);
        $.get(ele.attr('href'),"",function(){
            ele.parents("tr").fadeOut('slow');
        });
        return false;
    });
    
    $('.datetimepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth:true,
        changeYear:true,
        yearRange: "c-1:c+1"
    });

}

function bind_user(){
    $("#users .ban").live('click',function(){
        if(!confirm("Bạn có chắc banned người dùng này không?")) return false;
        var ele = $(this);
        var parent = ele.parents('tr');
       
        $.get(ele.attr('href'),"",function(data){
            if(data.success)
            {
                $(".label-banned",parent).show();
                ele.addClass('hide');
                $(".unban",parent).removeClass('hide');
            }
        },'json');
        return false;
    });
    
    $("#users .unban").live('click',function(){
        if(!confirm("Bạn có chắc unban người dùng này không?")) return false;
        var ele = $(this);
        var parent = ele.parents('tr');
       
        $.get(ele.attr('href'),"",function(data){
            if(data.success)
            {
                $(".label-banned",parent).hide();
                ele.addClass('hide');
                $(".ban",parent).removeClass('hide');
            }
        },'json');
        return false;
    });
}

function bind_category(){
    $(".category-type").change(function(){
        var ele = $(this);
        window.location = baseUrl+"category/index/type/"+ ele.val();
    });
}

function display_error(msg){
    $(".alert-success").hide();
    $(".alert-error .msg").html(msg);
    $(".alert-error").fadeIn('slow');
}

function display_success(msg){
    $(".alert-error").hide();
    $(".alert-success .msg").html(msg);
    $(".alert-success").fadeIn('slow');
}

function number_format (number, decimals, dec_point, thousands_sep) {
    // *     example 1: number_format(1234.56);
    // *     returns 1: '1,235'
    // *     example 2: number_format(1234.56, 2, ',', ' ');
    // *     returns 2: '1 234,56'
    // *     example 3: number_format(1234.5678, 2, '.', '');
    // *     returns 3: '1234.57'
    // *     example 4: number_format(67, 2, ',', '.');
    // *     returns 4: '67,00'
    // *     example 5: number_format(1000);
    // *     returns 5: '1,000'
    // *     example 6: number_format(67.311, 2);
    // *     returns 6: '67.31'
    // *     example 7: number_format(1000.55, 1);
    // *     returns 7: '1,000.6'
    // *     example 8: number_format(67000, 5, ',', '.');
    // *     returns 8: '67.000,00000'
    // *     example 9: number_format(0.9, 0);
    // *     returns 9: '1'
    // *    example 10: number_format('1.20', 2);
    // *    returns 10: '1.20'
    // *    example 11: number_format('1.20', 4);
    // *    returns 11: '1.2000'
    // *    example 12: number_format('1.2000', 3);
    // *    returns 12: '1.200'
    // *    example 13: number_format('1 000,50', 2, '.', ' ');
    // *    returns 13: '100 050.00'
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
        var k = Math.pow(10, prec);
        return '' + Math.round(n * k) / k;
    };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function bind_mce(){
    tinyMCE.init({
        // General options
        mode : "specific_textareas",
        editor_selector : "tinymce",
        theme : "advanced",
        plugins : "autolink,lists,pagebreak,style,table,advimage,advlink,inlinepopups,media,paste,nonbreaking,xhtmlxtras,template,wordcount",
        entity_encoding : "raw",
        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,media,advhr,image,media_uploader",
        theme_advanced_buttons2 : "pastetext,pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,code",
        theme_advanced_buttons3 : "",
        theme_advanced_buttons4 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
                
        // Example content CSS (should be your site CSS)
        content_css : "css/content.css",
                
        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "lists/template_list.js",
        external_link_list_url : "lists/link_list.js",
        external_image_list_url : "lists/image_list.js",
        media_external_list_url : "lists/media_list.js",
        extended_valid_elements : "script[language|type|src]",        
 
        // Replace values for the template plugin
        template_replace_values : {
            username : "Some User",
            staffid : "991234"
        },
                
        setup : function(ed) {
            ed.addButton('media_uploader', {
                title : 'Media Uploader',
                image : baseUrl + 'img/media-button.png',
                onclick : function() {
                    $.fancybox({
                        href : baseUrl + 'ajax/media_uploader',
                        type : 'ajax'
                    })
                }
            });
        }
    });
    
   
}


function bind_event(){
    $(".create-magu .make_event_live").click(function(){
        $("#event_form").trigger('submit'); 
        return false;
    });
    
    var cache = {},lastXhr;
    $('#event_form #add_location').keyup(function() {
        var str = $.trim($(this).val());
        if(str.length == 0)
            return false;
        $("#event_form .loading-location").show();
        $("#event_form #add_location").autocomplete({
            source: function( request, response ) {
                $("#event_form .loading-location").hide();
                var term = request.term;    
                if ( term in cache ) {
                    response( cache[ term ] );
                    return;
                }

                lastXhr = $.getJSON(baseUrl+'/event/search_location/s/' + str + '/', request, function( data, status, xhr ) {
                    cache[ term ] = data;
                    if ( xhr === lastXhr ) {
                        response( data );
                    }
                });
            },
            delay: 400,
            focus: function(event, ui) {
                $("#event_form .loading-location").hide();
                $("#event_form #add_location").val( ui.item.title );
                $("#event_form input[name=address]").val(ui.item.address);
                $("#event_form select[name=city]").val(ui.item.city);
                return false;
            },
            select: function(event, ui) { 
                $("#event_form .loading-location").hide();
                $("#event_form #add_location").val( ui.item.title );
                $("#event_form input[name=address]").val(ui.item.address);
                $("#event_form select[name=city]").val(ui.item.city);
                $("#event_form input[name=location_id]").val(ui.item.value);
                return false;
            },
            change: function(event, ui) { 
                if (ui.item == null) {
                    $("#event_form input[name=location_id]").val('');
                }
                $("#event_form .loading-location").hide();
            },
            open: function(event,ui){
                $("#event_form .loading-location").hide();
            },
            close: function(event,ui){
                $("#event_form .loading-location").hide();
            }
        });        
    });
    
    $("#event_form .remove-event-thumb").click(function(){
        if(!confirm('Do you want to delete this logo?')) return false;        
        
        var ele = $(this);
        var parent = ele.parents('#event_form');
        $(".image-default.thumbnail",parent).remove();        
        ele.remove();
        $(".waiting",parent).show();
        $.get(ele.attr('href'),"",function(response){           
            if(response.success){
                $(".image-default.waiting",parent).remove();
                $(".image-default.default").removeClass('hide');
            }           
        },'json');
        return false;
    });
    
    $("#event_form .ticket-info .setting").live('click',function(){
        
        var ele = $(this);
        var parent = ele.parents('.ticket-info');
        $('.description-ticket',parent).toggle();
        return false;
    });
    
    $("#event_form .ticket-info .remove-ticket.clone").live('click',function(){
        if(!confirm('Do you want to delete this ticket type?')) return false;
        var ele = $(this);
        ele.parents('.table-ticket').fadeOut('slow',function(){
            $(this).remove();            
        });        
        return false;
    });
    
    $("#event_form .ticket-info .remove-ticket:not(.clone)").live('click',function(){
        if(!confirm('Do you want to delete this ticket type?')) return false;
        var ele = $(this);
        var parent = ele.parents('.table-ticket');
        $(".ticket-info",parent).hide();
        $(".loading",parent).show();
        $.get(ele.attr('href'),"",function(response){
            if(response.message.success){
                ele.parents('.table-ticket').fadeOut('slow',function(){
                    $(this).remove();            
                });     
                display_success(response.message.error[0]);
            }else{
                var msg = "";
                $.each(response.message.error,function(k,v){
                    msg+= v+"<br/>"; 
                });
                display_error(msg);
            }
            $(".loading",parent).hide();
            $(".ticket-info",parent).show();
            
        },'json');
           
        return false;
    });
    
    $(".btn-ticket").click(function(){
        var ele = $(this);
        var type = ele.hasClass("free") ? "free" : "paid";
        var ticket_free = $(".table-ticket.clone."+type).clone().removeClass('clone hide');
        $("#event_form").append(ticket_free);
        //$("#event_form .table-ticket").show();
        //ticket_id++;
        return false;
    });
    
    $("#event_form .ticket-info .quantity").live('keyup',function(){
        var ele = $(this);
        var quantity = 0;
        var ticket_quantities = $("#event_form .ticket-info .quantity");
        $.each(ticket_quantities,function(k,v){
            var val = $(v).val();
            val = val == "" ? 0 : val;
            val = parseInt(val);
            quantity+= val;           
        });
        $("#event_form .total-ticket").val(quantity);
        count_total(ele.parents('.ticket-info'));
    });
    
    $("#event_form .ticket-info .ticket-fee").live('keyup',function(){
        var ele = $(this);
        count_total(ele.parents('.ticket-info'));
    });
    
    $("#event_form .ticket-info .ticket-service-fee").live('change',function(){
        var ele = $(this);
        var parent = ele.parents('.ticket-info');
        $(".ticket-total",parent).hide();
        count_total(parent);
        $(".ticket-total",parent).fadeIn('slow');
    });
    
    $("#event_form .apply-ticket").live('click',function(){
        
        var ele = $(this);
        var parent = ele.parents(".table-ticket");
        var td = ele.parent();
        if(ele.hasClass('disabled')) return false;      
        
        if(parent.hasClass('processing')) return false;
        
        if(!confirm("Are you sure?")) return false;
        
        $(".apply-ticket",parent).addClass('disabled');
        
        parent.ajaxSubmit({
            beforeSubmit:function(){
                $(".ticket-info",parent).hide();
                $(".loading",parent).show();
                parent.addClass('processing');  
            },
            success: function(response){                
                if(!response.message.success){
                    var msg = "";
                    $.each(response.message.error,function(k,v){
                        msg+= v+"<br/>"; 
                    });
                    display_error(msg);
                    $(".apply-ticket",parent).removeClass('disabled');
                }
                else{
                    display_success(response.message.error[0]);
                    if(response.type == "add"){                        
                        parent.attr('action',baseUrl+"/event/edit_ticket_type/id/"+response.id);
                        $(".remove-ticket",parent).removeClass('clone').attr('href',baseUrl+"/event/delete_ticket_type/id/"+response.id);
                    }
                    $(".apply-ticket.edit1",parent).removeClass('disabled btn-info').html('Edit <i class="icon icon-edit"></i>');
                    $(".apply-ticket.edit2",parent).removeClass('disabled btn-info').addClass('btn').html('Edit');
                }
                $(".loading",parent).hide();
                $(".ticket-info",parent).show();
                
                
                parent.removeClass('processing');
            },
            dataType:'json'
        });        
        return false;
    });
    
    $("#event_form .table-ticket").live('submit',function(){
        var ele = $(this);
        $(".apply-ticket",ele).eq(0).trigger('click');
        return false;
    });
}


function count_total(ticket_info){
    
    var type = $(".ticket-id",ticket_info).val();
    if(type == "free")
        return false;
    
    var quantity = parseInt($(".ticket-quantity",ticket_info).val());
    var fee = parseFloat($(".ticket-fee",ticket_info).val());    
    if(isNaN(quantity) || isNaN(fee))
        return false;
    
    var service_fee = $(".ticket-service-fee:checked",ticket_info).val();
    var tmp_total = quantity*fee;
    var tax = tmp_total * ticketTax;
    var final_total = service_fee == 1 ? tmp_total + tax : tmp_total;
    
    $(".ticket-tax",ticket_info).text(number_format(tax)+" USD");
    $(".ticket-total",ticket_info).text(number_format(final_total)+" USD");
}