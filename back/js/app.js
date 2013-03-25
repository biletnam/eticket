bind_mce();
var ticket_id = $("#last_ticket_id").val();
$(document).ready(function(){
    init();
    bind_user();
    bind_category();
    bind_event();
    bind_status_event();
    delete_gallery();
    bind_search_user();
});

function init(){
    $("table .delete-row").click(function(){
        if(!confirm("Are you sure?")) return false;
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
    
    $('.datetimepicker').livequery(function() {
        $(this).datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth:true,
            changeYear:true,
            yearRange: "c-1:c+1"
        });
    });
    $(".fancybox").fancybox();
    $(".tab-content .tab-pane .btn-continue,.tab-content .tab-pane .btn-previous").click(function(){
       
        var ele = $(this);       
        var parent = ele.parents('.tab-pane');
        var tab_content = ele.parents('.tab-content');
        var index = parseInt($('.tab-pane',tab_content).index(parent));
        var navigate = ele.hasClass('btn-continue') ? index+1 : index-1;
        $(".nav.nav-tabs li:eq("+navigate+") > a").trigger('click');
    });
}

function delete_gallery(){
    
    $('.gallery .btn-delete').click(function(e){
              e.preventDefault();
              
                if(!confirm("Are you sure delete this photo?")) return false;
       var ele = $(this);
       var url = ele.attr('href');
       var id = ele.attr('value');
       
       $.post(url,function(){
           $('#gallery_'+id).fadeOut('slow');
       });
       
    });
    
    return false;
}

function bind_status_event(){
    
    $(".approved").click(function(){
        //if(!confirm("Are you sure delete this item?")) return false;
        var ele = $(this);
        $.get(ele.attr('href'),"",function(){
            ele.parents("tr").fadeOut('slow');
        });
        return false;
    });
    
    $(".btn-destroy").click(function(){
        
        if(!confirm("Are you sure Disqualify this event?")) return false;
        
        var ele = $(this);
        var id = ele.attr('value');
        var parent = ele.parents('.frm-approve');
        var note = $('.note',parent).val();
        var event_id = $('.event_id',parent).val();
        var email = $('.user_email',parent).val();
        var data = {
            id:event_id,
            note:note,
            email:email
        };
        
       
        
        $.post(ele.attr('href'),data,function(){
            $('#tr_'+id).fadeOut('slow');
            $.fancybox.close();
        });

        return false;
    });
}

function bind_user(){
    $("#users .ban").live('click',function(){
        if(!confirm("Are you locked this account?")) return false;
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
        if(!confirm("Are you unlocked this account?")) return false;
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
        window.location = baseUrl+"/category/index/type/"+ ele.val();
    });
}

function bind_search_user(){
    $(".user-type").change(function(){
        var ele = $(this);
        window.location = baseUrl+"/user/index/role/"+ ele.val();
    });
}

function bind_event(){
    
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

                lastXhr = $.getJSON(baseUrl+'event/search_location/s/' + str + '/', request, function( data, status, xhr ) {
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
                $("#event_form select[name=country]").val(ui.item.country);
                return false;
            },
            select: function(event, ui) { 
                $("#event_form .loading-location").hide();
                $("#event_form #add_location").val( ui.item.title );
                $("#event_form input[name=address]").val(ui.item.address);
                $("#event_form select[name=country]").val(ui.item.country);
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
    
    
    $("#event_form .ticket-info .setting").live('click',function(){
        
        var ele = $(this);
        var parent = ele.parents('.ticket-info');
        $('.description-ticket',parent).toggle();
        return false;
    });
    
    /*
    $("#event_form .ticket-info .remove-ticket").live('click',function(){
        if(!confirm('Bạn có chắc không?')) return false;
        var ele = $(this);
        var parent = ele.parents('.ticket-info').fadeOut('slow',function(){
            $(this).remove();
            var tickets = $(".table-ticket .ticket-info").length;
            if(tickets == 0)
                $("#event_form .table-ticket").hide();
        });
        
        return false;
    }); */
    
    /*
    $("#event_form .btn-ticket").click(function(){
        var ele = $(this);
        var type = ele.hasClass("free") ? "free" : "paid";
        var new_id = '['+ticket_id+']';
        var ticket_free = $(".ticket-info.clone."+type).clone().removeClass('clone hide')
        .find('.ticket-id').attr('name', 'ticket_id'+new_id).end()
        .find('.ticket-name').attr('name','ticket_name'+new_id).end()
        .find('.ticket-quantity').attr('name', 'ticket_quantity'+new_id).end()
        .find('.ticket-fee').attr('name', 'ticket_fee'+new_id).end()
        .find('.ticket-status').attr('name', 'ticket_status'+new_id).end()
        .find('.ticket-description').attr('name', 'ticket_description'+new_id).end()
        .find('.ticket-hide-description').attr('name', 'ticket_hide_description'+new_id).end()
        .find('.ticket-start-date').attr('name', 'ticket_start_date'+new_id).end()
        .find('.ticket-start-hour').attr('name', 'ticket_start_hour'+new_id).end()
        .find('.ticket-start-minute').attr('name', 'ticket_start_minute'+new_id).end()
        .find('.ticket-end-date').attr('name', 'ticket_end_date'+new_id).end()
        .find('.ticket-end-hour').attr('name', 'ticket_end_hour'+new_id).end()
        .find('.ticket-end-minute').attr('name', 'ticket_end_minute'+new_id).end()
        .find('.ticket-min').attr('name', 'ticket_min'+new_id).end()
        .find('.ticket-max').attr('name', 'ticket_max'+new_id).end()
        .find('.ticket-service-fee').attr('name', 'ticket_service_fee'+new_id).end()                            
        .insertBefore('.table-ticket tfoot');
        $("#event_form .table-ticket").show();
        ticket_id++;
        return false;
    });*/
    
    
    
    $("#event_form .ticket-info .remove-ticket.clone").live('click',function(){
        if(!confirm("Do you want to delete this ticket?")) return false;
        var ele = $(this);
        ele.parents('.table-ticket').fadeOut('slow',function(){
            $(this).remove();            
        });        
        return false;
    });
    
    $("#event_form .ticket-info .remove-ticket:not(.clone)").live('click',function(){
        if(!confirm("Do you want to delete this ticket?")) return false;
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
    
    $("#event_form .btn-ticket").click(function(){
        var ele = $(this);
        var type = ele.hasClass("free") ? "free" : "paid";
        var ticket_free = $(".table-ticket.clone."+type).clone().removeClass('clone hide');
        $("#event_form").append(ticket_free);
        //$("#event_form .table-ticket").show();
        //ticket_id++;
        return false;
    });
    
    
    $("#event_form .ticket-info .quantity").keyup(function(){
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
    
    $("#event_form .ticket-info .ticket-fee").keyup(function(){
        var ele = $(this);
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
                }
                else{
                    display_success(response.message.error[0]);
                    if(response.type == "add"){
                        parent.attr('action',baseUrl+"/event/edit_ticket_type/id/"+response.id);
                        $(".remove-ticket",parent).removeClass('clone').attr('href',baseUrl+"/event/delete_ticket_type/id/"+response.id);
                    }
                    
                }
                $(".loading",parent).hide();
                $(".ticket-info",parent).show();
                
                $(".apply-ticket",parent).removeClass('disabled');
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
    
    $(".ticket-tax",ticket_info).text(number_format(tax)+" VNĐ");
    $(".ticket-total",ticket_info).text(number_format(final_total)+" VNĐ");
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
        editor_selector : "tinymce",
        theme : "advanced",        
        mode : "specific_textareas",
        plugins : "fullpage"
        
    });

}