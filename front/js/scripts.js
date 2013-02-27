bind_mce();   
$(document).ready(function(){
    // Fix scroll
    var $win = $(window)
    , $nav = $('.submit-bar')
    , navTop = $('.submit-bar').length && $('.submit-bar').offset().top + 40
    , isFixed = 0

    processScroll();

    $win.on('scroll', processScroll);
    function processScroll() {
        var i, scrollTop = $win.scrollTop()
        if (scrollTop >= navTop && !isFixed) {
            isFixed = 1
            $nav.addClass('fixed')
        } else if (scrollTop <= navTop && isFixed) {
            isFixed = 0
            $nav.removeClass('fixed')
        }
    }
    //end Fix scroll
    
    init();    
    jPicker();
    tab_active();
    model_tab();
    bind_event();
    
/*var $content = $(".preview-frame iframe").contents();
     $content.find("body div.navbar").remove();
     $content.find("body div.subnav").remove();
     $content.find("body #footer").remove();*/
});

$(window).load(function() {
    var $content = $(".preview-frame iframe").contents();
    $content.find("body").css('padding-top','0px');
    $content.find("body div.navbar").remove();
    $content.find("body div.subnav").remove();
    $content.find("body #footer").remove();
//$content.find("body .event-body").html('');
//$content.find("body .ticket").html('&nbsp;');
//$content.find("body .ticket-button").remove('');
});

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
        if(!confirm('Bạn có chắc xóa ảnh đại diện của sự kiện này không?')) return false;        
        
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
        if(!confirm('Bạn có chắc không xóa loại vé này không?')) return false;
        var ele = $(this);
        ele.parents('.table-ticket').fadeOut('slow',function(){
            $(this).remove();            
        });        
        return false;
    });
    
    $("#event_form .ticket-info .remove-ticket:not(.clone)").live('click',function(){
        if(!confirm('Bạn có chắc không xóa loại vé này không?')) return false;
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
        
        if(!confirm("Bạn có chắc không?")) return false;
        
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
                
                $(".apply-ticket",parent).removeClass('disabled btn-info').addClass('btn-warning').text('Sửa');
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


function jPicker(){
    $.fn.jPicker.defaults.images.clientPath=baseUrl+'/images/'; 
    $('.Inline').jPicker();
    $(".custom_colors .Ok").live('click',function(){
        var ele = $(this);
        var parent = ele.parents(".modal");
        var id = parent.attr('id');
        id = id.split('-');
        var index = id[1];
        var current_color = $.jPicker.List[index].color.active.val('ahex');
        current_color = current_color.substring(0,6);
        $('.color-id-'+index).css('background','#'+current_color);
        $('.background-id-'+index).css('background','#'+current_color);
        $('.header-background-id-'+index).css('background','#'+current_color);
        $('.preview-background-id-'+index).css('background','#'+current_color);
        $('.preview-color-id-'+index).css('color','#'+current_color);
        $('.border-color-'+index).css('border-color','#'+current_color);

        $(".modal-header .close",parent).trigger('click');
        
        //pick color in Create VSK
        var $content = $(".preview-frame iframe").contents();
        //header text
        $content.find("body .preview-color-id-"+index).css('color','#'+current_color);
        //header background
        $content.find("body .header-background-id-"+index).css('background','#'+current_color);
        //border color
        $content.find("body .border-color-"+index).css('border-color','#'+current_color);
        //background
        $content.find("body .preview-background-id-"+index).css('background','#'+current_color);
        //text color
        $content.find('body .color-id-'+index).css('color','#'+current_color);
        //event title color
        $content.find('body .event-color-id-'+index).css('color','#'+current_color);
        //box background
        $content.find('body .background-id-'+index).css('color','#'+current_color);
        //links color
        $content.find('body .preview-color-id-'+index).css('color','#'+current_color);
    });
    $('.jPicker .Cancel').live('click',function(){
        var parent = $(this).parents('.modal');
        $('.modal-header .close',parent).trigger('click');
    });
}

function bind_mce(){
    
    tinyMCE.init({
        editor_selector : "tinymce",
        theme : "advanced",        
        mode : "specific_textareas",
        plugins : "fullpage"
        
    });

}

function init(){
    /*
    $('a.setting').click(function(){
        var $span = $('span',$(this));
        var hide = $span.hasClass('ico-hide');
        var show = $span.hasClass('ico-show');
        var $body = $(this).parents('tbody');
        console.log($('.description-ticket',$body));
        if(hide){
            $span.removeClass('ico-hide').removeClass('icon-chevron-down').addClass('ico-show').addClass('icon-chevron-up');
            $('.description-ticket',$body).show();
        }else{
            $span.removeClass('ico-show').removeClass('icon-chevron-up').addClass('ico-hide').addClass('icon-chevron-down');
            $('.description-ticket',$body).hide();
        }
    });*/
    
    $('.url_edit').click(function(){
        var $p = $(this).parent(".preview");
        $p.removeClass('show').addClass('hide');
        $('#shortname .edit').removeClass('hide').addClass('show');
        $('#shortname .txt-edit-url').focus();
    });
    
    $('.url_cancel').click(function(){
        var $p = $(this).parents('.edit');
        $p.removeClass('show').addClass('hide');
        $('#shortname .preview').removeClass('hide').addClass('show');
    });
    
    $('ul.list-info li input[type=checkbox]').change(function(){
        var ele = $(this);
        var li = ele.parents('li');
        if($('.block-hide',li).hasClass('hide'))
            $('.block-hide',li).removeClass('hide').addClass('show');
        else
            $('.block-hide',li).removeClass('show').addClass('hide');
    });
    
    $('.facebook input[type=checkbox]').change(function(){
        var ele = $(this);
        var div = ele.parents('label').next();
        if(div.hasClass('hide'))
            div.removeClass('hide').addClass('show');
        else
            div.removeClass('show').addClass('hide');
    });
    
    $('.twitter input[type=checkbox]').change(function(){
        var ele = $(this);
        var div = ele.parents('label').next();
        if(div.hasClass('hide'))
            div.removeClass('hide').addClass('show');
        else
            div.removeClass('show').addClass('hide');
    });
    
    var socials = $('.socials input[type=checkbox]:checked');
    $.each(socials,function(k,v){
        var div = $(v).parents(".socials");
        $('.link',div).removeClass('hide').addClass('show');
    });
    
    
    var checkbox_organizer = $(".list-info input[type=checkbox]:checked");
    $.each(checkbox_organizer,function(k,v){
        var ele = $(v);
        var li = ele.parents('li');
        $(".block-hide",li).removeClass('hide').addClass('show');
    });
    
    
    var radio = $('ul#org_button_select li input[type=radio]:checked');
    var image = radio.next();
    image.addClass('selected');
    
    $('ul#org_button_select li input[type=radio]').change(function(){
        var ele = $(this);
        $('ul#org_button_select li img').removeClass();
        //var li = ele.parents('li');
        var img = ele.next();
        if(!img.hasClass('selected')){
            img.removeClass().addClass('selected');
            return false;
        }
    });
    
    $('.add_calendar').toggle(
        function(){
            var parent = $(this).parents('.event-body');
            $('.other-calendar',parent).slideDown(500);
        }
        ,function(){
            var parent = $(this).parents('.event-body');
            $('.other-calendar',parent).slideUp(500);
        }
        );  

    $('.toggle-preview').click(function(){
        var toggle_preview = $(this);
        var flag = toggle_preview.hasClass("down") ? false : true;

        if(flag){
            $(this).removeClass('up').addClass('down').css('margin-top','0px');
        }else{
            $(this).removeClass('down').addClass('up').css('margin-top','-20px');
        }
        $('.choose-themes').slideToggle("normal");
    });   
  
    $('#attendee').change(function(){
        if($('.attendees #attendee').prop('checked')) {
            $('.display-attendees').trigger('click');
        } else {
        // something else when not
        }
    });
    
    $('#modelAttends').on('hidden', function () {
        $('#attendee').removeAttr('checked');
    });
  
    $('.themes > p > a').click(function(){
        var index = $(this).index();
        $('.themes > p > a').removeClass('current');
        $(this).addClass('current');
        $('.tab-themes ul').hide().eq(index).show();
    });
    
    $(".btn-submit").click(function(){
        var ele= $(this);
        ele.parents('form').trigger('submit');
        return false;
    });
    
    $('.datetimepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth:true,
        changeYear:true,
        yearRange: "c-1:c+1"
    });
}
function tab_active(){
    $('#theme_picker ul.themes li').click(function(){
        $('#theme_picker ul.themes li').removeClass();
        $(this).addClass('active');;
    });
}

function model_tab(){
    $('.header span').click(function(){
        var index = $(this).index();
        $('span',$(this).parent('.header')).removeClass('current');
        $(this).addClass('current');
        $('.content-html div').hide();
        $('.content-html div').eq(index).show();
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