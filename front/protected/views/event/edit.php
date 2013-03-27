<?php
$countries = Helper::countries();
$ticket_status = Helper::ticket_status();
?>
<div class="container_12">
    <div class="event-bar clearfix">
        <div class="grid_12">
            <ul class="clearfix">
                <li><a class="<?php if ($type == "general") echo 'active'; ?>" href="<?php echo HelperUrl::baseUrl() ?>event/edit/id/<?php echo $event['id'] ?>/type/general"><i class="icon icon-edit-white"></i>Event Information</a></li>
                <li><a class="<?php if ($type == "ticket") echo 'active'; ?>" href="<?php echo HelperUrl::baseUrl(); ?>event/edit/id/<?php echo $event['id'] ?>/type/ticket"><i class="icon icon-ticket"></i>Ticket</a></li>
                <?php /* <li><a class="" href="<?php echo HelperUrl::baseUrl()?>event/gallery/id/<?php echo $event['id'];?>"><i class="icon icon-ticket"></i>Gallery</a></li> */ ?>
            </ul>
        </div>
    </div>
    <div class="clearfix">
        <div class="grid_12 page-create-ticket">
            <?php if ($type == "general"): ?>
                <form class="form-style form-create-event border form-create-magu" method="post" enctype="multipart/form-data" id="event_form">
                    <input type="hidden" name="location_id" value="<?php if (isset($_POST['location_id'])) echo $_POST['location_id'];else echo $event['location_id']; ?>"/>
                    <div class="row-fluid content">
                        <?php echo Helper::print_error($message); ?>
                        <?php echo Helper::print_success($message); ?>
                        <div class="span10 form-magu">
                            <div class="step"> <div class="number"><span>1</span></div>
                                <h3>Event Information</h3>
                            </div>

                            <div class="controls-group clearfix">
                                <label class="control-label pull-left" for="title">Add Event Title<span class="required">*</span></label>
                                <div class="controls pull-left"><input type="text" class="input-xxlarge span11" name="title" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : htmlspecialchars($event['title']); ?>"></div>
                            </div>
                            <div class="controls-group clearfix">
                                <label class="control-label pull-left" for="location">Location<span class="required">*</span></label>
                                <div class="controls pull-left">
                                    <input type="text" id="add_location" class="input-xxlarge span11" name="location" value="<?php echo isset($_POST['location']) ? htmlspecialchars($_POST['location']) : htmlspecialchars($event['location']); ?>">
                                    <img class="loading-location hide" src="<?php echo Yii::app()->request->baseUrl ?>/img/ajax-big-roller.gif" />
                                </div>
                            </div>
                            <div class="controls-group clearfix">
                                <label class="control-label pull-left" for="address">Address</label>
                                <div class="controls pull-left"><input type="text" class="input-xxlarge span11" name="address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : htmlspecialchars($event['address']); ?>"></div>
                            </div>
                            <div class="controls-group clearfix">
                                <label class="control-label pull-left" for="address">City</label>
                                <div class="controls pull-left"><input type="text" class="input-xxlarge span11" name="city" value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : htmlspecialchars($event['city']); ?>"></div>
                            </div>
                            <div class="controls-group clearfix">
                                <label class="control-label pull-left">Country</label>
                                <div class="controls pull-left">
                                    <?php //print_r($event);die; ?>
                                    <select name="country">
                                        <?php foreach ($countries as $k => $v): ?>
                                            <option <?php if (isset($_POST['country']) && $_POST['country'] == $v['id']) echo 'selected'; else if ($event['country_id'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id']; ?>"><?php echo $v['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="controls-group clearfix">
                                <label class="control-label pull-left">Add When<span class="required">*</span></label>
                                <div class="controls pull-left">

                                    <div class="row-fluid">
                                        <p class="start-date-title">Event starts</p>
                                        <div class="input-append date dp3" data-date-format="mm/dd/yyyy">
                                            <input type="text" class="input-mini ico ico-calendar datetimepicker" name="start_date" value="<?php if (isset($_POST['start_date'])) echo $_POST['start_date']; else echo date('d-m-Y', strtotime($event['start_time'])); ?>">

                                            <select name="start_hour" class="input-mini">
                                                <?php for ($i = 0; $i < 24; $i++): ?>
                                                    <option <?php if (isset($_POST['start_hour']) && $_POST['start_hour'] == $i) echo 'selected'; else if ((int) date('H', strtotime($event['start_time'])) == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                            <select name="start_minute" class="input-mini">
                                                <?php for ($i = 0; $i < 60; $i++): ?>
                                                    <option <?php if (isset($_POST['start_minute']) && $_POST['start_minute'] == $i) echo 'selected'; else if ((int) date('i', strtotime($event['start_time'])) == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                                <?php endfor; ?>
                                            </select>                                                         
                                            <label class="checkbox inline">
                                                <input type="checkbox" name="display_start_time" value="1" <?php if (isset($_POST['display_start_time'])) echo 'checked'; else if ($event['display_start_time']) echo 'checked'; ?>/>
                                                Show
                                            </label>
                                        </div>

                                    </div>
                                    <br/>
                                    <div class="row-fluid">
                                        <p class="end-date-title">Event ends</p>

                                        <div class="input-append date dp3" data-date-format="mm/dd/yyyy">
                                            <input type="text" class="input-mini ico ico-calendar datetimepicker" name="end_date" value="<?php if (isset($_POST['end_date'])) echo $_POST['end_date']; else echo date('d-m-Y', strtotime($event['end_time'])); ?>">

                                            <select name="end_hour" class="input-mini" id="time_hour">
                                                <?php for ($i = 0; $i < 24; $i++): ?>
                                                    <option <?php if (isset($_POST['end_hour']) && $_POST['end_hour'] == $i) echo 'selected'; else if ((int) date('H', strtotime($event['end_time'])) == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                            <select name="end_minute" class="input-mini" id="time_min">
                                                <?php for ($i = 0; $i < 60; $i++): ?>
                                                    <option <?php if (isset($_POST['end_minute']) && $_POST['end_minute'] == $i) echo 'selected'; else if ((int) date('i', strtotime($event['end_time'])) == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                                <?php endfor; ?>
                                            </select>                                                
                                            <label class="checkbox inline">
                                                <input type="checkbox" name="display_end_time" value="1" <?php if (isset($_POST['display_end_time'])) echo 'checked'; else if ($event['display_end_time']) echo 'checked'; ?>/>
                                                Show
                                            </label>
                                            <!--                                                <label class="checkbox inline">
                                                                                                <input type="checkbox" value="1" name="is_repeat" <?php if (isset($_POST['is_repeat'])) echo 'checked';else if ($event['is_repeat']) echo 'checked'; ?>/>
                                                                                                Yes, this event repeats.
                                                                                            </label>-->
                                        </div>

                                    </div>
                                </div>


                            </div>

                            <div class="controls-group clearfix upload">
                                <label class="control-label pull-left" for="title">Upload the logo for your event:</label>
                                <div class="controls pull-left clearfix">
                                    <div class="event-logo pull-left">
                                        <?php if ($event['img'] == ""): ?>
                                            <img class="image-default logo-default" src="<?php echo HelperUrl::baseUrl() ?>img/default_upload_logo.gif" />
                                            <img class="image-default waiting hide" src="<?php echo HelperUrl::baseUrl() ?>img/ajax-big-roller.gif" />
                                        <?php else: ?>
                                            <img class="image-default default logo-default hide" src="<?php echo HelperUrl::baseUrl() ?>img/default_upload_logo.gif" />
                                            <img class="image-default waiting hide" src="<?php echo HelperUrl::baseUrl() ?>img/ajax-big-roller.gif" />
                                            <img class="image-default thumbnail" src="<?php echo HelperApp::get_thumbnail($event['thumbnail'], 'edit'); ?>" />
                                        <?php endif; ?>
                                        <?php if ($event['img'] != ""): ?>
                                            <div class="controls pull-left" style="margin-top: 10px"><a href="<?php echo HelperUrl::baseUrl() ?>event/remove_thumb/id/<?php echo $event['id'] ?>" class="btn-style remove-event-thumb">Remove</a></div>
                                        <?php endif; ?> 
                                        <input type="hidden" name="event_id" value="<?php echo $event['id'] ?>"/>
                                        <input type="hidden" name="file_temp" class="file_temp" value="<?php if (isset($_POST['file_temp'])) echo $_POST['file_temp']; ?>"/>
                                        <input type="hidden" name="name_temp" class="name_temp" value="<?php if (isset($_POST['name_temp'])) echo $_POST['name_temp']; ?>"/>
                                    </div>
                                    <div class="event-logo-upload pull-left">
                                        <p class="help-block">Must be JPG, GIF, or PNG smaller than 2MB.<br/>
                                            We allow only 1920 x 1080 photo. Please upload correct one.
                                        </p>
                                        <div><input class="fileupload customfile-input" class="input-xlarge" name="file" type="file"></div>
                                        <div class="error1"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="controls-group clearfix">
                                <label class="control-label pull-left">Add Event Details  <!--<label class="control-label add-faq"> <a href="">+Add FAQs</a></label>--></label>
                                <div class="controls pull-left text">
                                    <div>
                                        <textarea cols="93" rows="10" name="description" class="tinymce"><?php echo isset($_POST['description']) ? $_POST['description'] : $event['description']; ?></textarea>
                                    </div>          
                                </div>
                            </div>                                        

                            <div class="ticket-ridges"></div>

                            <div class="step"> 
                                <div class="number"><span>2<span></div>
                                            <h3>Option</h3>
                                            </div>

                                            <div class="controls-group clearfix">
                                                <label for="select01" class="control-label pull-left">This event will public and registered.</label>
                                                <div class="controls">
                                                    <select name="published">
                                                        <option <?php if (isset($_POST['published']) && $_POST['published']) echo 'selected';else if ($event['published']) echo 'selected'; ?> value="1">Yes</option>
                                                        <option <?php if (isset($_POST['published']) && !$_POST['published']) echo 'selected';else if (!$event['published']) echo 'selected'; ?> value="0">No</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="controls-group clearfix">
                                                <label class="control-label pull-left">Select categories for your event:</label>
                                                <div class="controls pull-left">
                                                    <select name="primary_cate">

                                                        <option value="0">Primary category</option>                                                    
                                                        <?php foreach ($categories as $k => $v): ?>                
                                                            <option <?php if (isset($_POST['primary_cate']) && $_POST['primary_cate'] == $v['id']) echo 'selected'; else if ($event['categories']['primary']['id'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id'] ?>"><?php echo $v['title']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <select name="second_cate">

                                                        <option value="0">Secondary category</option>                                                    
                                                        <?php foreach ($categories as $k => $v): ?>                
                                                            <option <?php if (isset($_POST['second_cate']) && $_POST['second_cate'] == $v['id']) echo 'selected'; else if (isset($event['categories']['second']) && $event['categories']['second']['id'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id'] ?>"><?php echo $v['title']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="controls-group clearfix">
                                                <label for="optionsCheckbox" class="control-label pull-left">The number of tickets remaining</label>
                                                <div class="controls pull-left">
                                                    <label class="checkbox">
                                                        <input type="checkbox" value="1" name="show_tickets" <?php if (isset($_POST['show_tickets'])) echo 'checked';else if ($event['show_tickets']) echo 'checked'; ?> >
                                                        Show number of tickets remaining on the registration page.
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="controls-group clearfix">
                                                <label class="control-label pull-left">&nbsp;</label>
                                                <div class="controls pull-left clearfix">
                                                    <input type="submit" value="Update" class="btn pull-right">
                                                </div>
                                            </div>


                                            </div>
                                            </div>
                                            </form>
                                        <?php endif; ?>

                                        <?php if ($type == "ticket"): ?>
                                            <div class="form-style border-radius border content">
                                                <div class="alert alert-error hide">
                                                    <button data-dismiss="alert" class="close" type="button">×</button>
                                                    <h4>Error!</h4>
                                                    <div class="msg">

                                                    </div>
                                                </div>

                                                <div class="alert alert-success hide">
                                                    <button data-dismiss="alert" class="close" type="button">×</button>
                                                    <h4>Congratulation!</h4>
                                                    <div class="msg">

                                                    </div>
                                                </div>

                                                <div class="span10 form-magu">

                                                    <div class="step"> <div class="number"><span>3</span></div>
                                                        <h3>Ticket Information</h3>
                                                    </div>
                                                    <div class="add_ticket_container">
                                                        <span class="add_ticket_text">Type of price:</span>
                                                        <?php /* <a class="btn btn-type-price  btn-donate eb_button small default add_ticket_class btn-ticket free">Free</a>
                                                          <a class="btn-style button-medium eb_button small go add_ticket_class btn-ticket paid">Cost</a> */ ?>
                                                        <a class="btn button-medium eb_button small go add_ticket_class btn-ticket paid">Add eTicket</a>

                                                    </div>
                                                    <div id="event_form" class="form-ticket">  
                                                        <?php foreach ($ticket_types as $k => $v): ?>
                                                            <form class="form-horizontal form-create-ticket table-ticket <?php echo $v['type'] ?> <?php if ($v['type'] == 'paid') echo 'custom-table' ?>" method="post" enctype="multipart/form-data" action="<?php echo HelperUrl::baseUrl() ?>event/edit_ticket_type/id/<?php echo $v['id']; ?>">           
                                                                <table class="table table-bordered table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="head-ticket-name">Ticket name</th>
                                                                            <th class="head-ticket-quantity">Quantity</th>
                                                                            <th class="head-ticket-price <?php echo $v['type'] ?>">Price</th>
                                                                            <?php if ($v['type'] == "paid"): ?>
                                                                                <th class="head-ticket-fee">Fee</th>
                                                                                <th>Total</th>
                                                                            <?php endif; ?>
                                                                            <th class="head-ticket-status">Status</th>
                                                                            <th class="head-ticket-action" colspan="3"></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <!-- check if has $_POST['ticket_id'] -->

                                                                    <tbody class="loading hide">
                                                                        <tr>
                                                                            <td colspan="<?php echo $v['type'] == "paid" ? 10 : 8; ?>"><img class="waiting" src="<?php echo HelperUrl::baseUrl() ?>img/ajax-big-roller.gif" /></td>
                                                                        </tr>
                                                                    </tbody>

                                                                    <tbody class="ticket-info <?php echo $v['type']; ?>">
                                                                        <tr>
                                                                    <input type="hidden" name="ticket_id" value="<?php echo $v['id']; ?>" class="ticket-id"/>
                                                                    <td class="ticket_name"><input type="text" name="ticket_name" class="input-mini ticket-name" value="<?php echo htmlspecialchars($v['title']); ?>"></td>
                                                                    <td class="ticket_quantity"><input type="text" placeholder="0" name="ticket_quantity" class="input-mini quantity ticket-quantity" value="<?php echo htmlspecialchars($v['quantity']); ?>"></td>

                                                                    <?php if ($v['type'] == "paid"): ?>
                                                                        <td class="ticket_fee"><input type="text" placeholder="0 TTD" name="ticket_fee" class="input-mini ticket-fee" value="<?php echo htmlspecialchars(number_format($v['price'], 0, '', '')); ?>"></td>
                                                                        <td><span class="price ticket-tax"><?php echo number_format($v['tax']) ?> TTD</span></td>
                                                                        <?php $total = $v['service_fee'] ? $v['price'] * $v['quantity'] + $v['tax'] : $v['price'] * $v['quantity']; ?>
                                                                        <td><span class="price ticket-total"><?php echo number_format($total) ?> TTD</span></td>
                                                                    <?php else: ?>
                                                                        <td class="ticket_fee">Free</td>
                                                                    <?php endif; ?>

                                                                    <td>
                                                                        <select class="ticket-status" name="ticket_status">
                                                                            <?php foreach ($ticket_status as $tkey => $ts): ?>
                                                                                <option <?php if ($v['ticket_status'] == $tkey) echo 'selected'; ?> value="<?php echo $tkey; ?>"><?php echo $ts; ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </td>
                                                                    <td><a href="#" class="setting">Option <i class="icon ico-hide icon-chevron-down"></i></a></td>
                                                                    <td>
                                                                        <a href="#" class="apply-ticket btn-style edit1">Edit <i class="icon icon-edit"></i></a>                        
                                                                    </td>
                                                                    <td>
                                                                        <a href="<?php echo Yii::app()->request->baseUrl ?>/event/delete_ticket_type/id/<?php echo $v['id']; ?>" class="remove-ticket btn-style">Delete<i class="icon icon-delete"></i></a>                        
                                                                    </td>
                                                                    </tr>
                                                                    <tr class="description-ticket hide">
                                                                        <td colspan="9">
                                                                            <div class="controls-group clearfix">
                                                                                <label class="control-label pull-left">
                                                                                    Ticket Description
                                                                                </label>
                                                                                <div class="controls pull-left clearfix">
                                                                                    <textarea name="ticket_description" rows="5" cols="10" class="input-xxlarge ticket-description"><?php echo $v['description']; ?></textarea>
                                                                                    <label>
                                                                                        <input class="ticket-hide-description" type="checkbox" name="ticket_hide_description" <?php if ($v['hide_description']) echo 'checked'; ?>>
                                                                                        Auto Hide Description
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="controls-group clearfix">
                                                                                <label class="control-label pull-left">Time</label>
                                                                                <div class="controls pull-left">

                                                                                    <div class="row-fluid ticket-date">
                                                                                        <p class="start-date-title">Start Sales</p>
                                                                                        <div data-date-format="mm/dd/yyyy" data-date="" class="input-append date dp3">
                                                                                            <input type="text" value="<?php echo htmlspecialchars(date('d-m-Y', strtotime($v['sale_start']))); ?>" name="ticket_start_date" class="input-mini ico ico-calendar datetimepicker ticket-start-date">
                                                                                            <select id="time_hour" class="input-mini ticket-start-hour" name="ticket_start_hour">
                                                                                                <?php for ($i = 0; $i < 24; $i++): ?>
                                                                                                    <option <?php if (date('H', strtotime($v['sale_start'])) == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                                                                                <?php endfor; ?>
                                                                                            </select>
                                                                                            <select id="time_min" class="input-mini ticket-start-minute" name="ticket_start_minute">
                                                                                                <?php for ($i = 0; $i < 60; $i++): ?>
                                                                                                    <option <?php if (date('i', strtotime($v['sale_start'])) == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                                                                                <?php endfor; ?>
                                                                                            </select>
                                                                                            <!-- 
                                                                                            <label class="checkbox inline">
                                                                                                <input type="checkbox" value="show" id="show_time">
                                                                                                Hiện thời gian
                                                                                            </label>
                                                                                            -->
                                                                                        </div>

                                                                                    </div>

                                                                                    <div class="row-fluid ticket-date">
                                                                                        <p class="end-date-title">End Sales</p>

                                                                                        <div data-date-format="mm/dd/yyyy" data-date="" class="input-append date dp3">
                                                                                            <input type="text" value="<?php echo htmlspecialchars(date('d-m-Y', strtotime($v['sale_end']))); ?>" name="ticket_end_date" class="input-mini ico ico-calendar datetimepicker ticket-end-date">

                                                                                            <select id="time_hour" class="input-mini ticket-end-hour" name="ticket_end_hour">
                                                                                                <?php for ($i = 0; $i < 24; $i++): ?>
                                                                                                    <option <?php if (date('H', strtotime($v['sale_end'])) == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                                                                                <?php endfor; ?>
                                                                                            </select>
                                                                                            <select id="time_min" class="input-mini ticket-end-minute" name="ticket_end_minute">
                                                                                                <?php for ($i = 0; $i < 60; $i++): ?>
                                                                                                    <option <?php if (date('i', strtotime($v['sale_end'])) == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                                                                                <?php endfor; ?>
                                                                                            </select>
                                                                                            <!--                                                                   
                                                                                            <label class="checkbox inline">
                                                                                               <input type="checkbox" value="show" id="show_time">
                                                                                               Hiện thời gian
                                                                                            </label>
                                                                                            -->
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="controls-group clearfix">
                                                                                <label class="control-label pull-left" for="address">Tickets per Order:</label>
                                                                                <div class="controls pull-left">
                                                                                    Minimum <input type="text" class="input-mini ticket-min" name="ticket_min" value="<?php echo htmlspecialchars($v['minimum']); ?>">
                                                                                    Maximum <input type="text" class="input-mini ticket-max" name="ticket_max" value="<?php echo htmlspecialchars($v['maximum']); ?>">
                                                                                </div>
                                                                            </div>

                                                                            <?php if ($v['type'] == "paid"): ?>
                                                                                <div class="controls-group clearfix">
                                                                                    <label class="control-label pull-left">Service Fee </label>
                                                                                    <div class="controls pull-left">

                                                                                        <label class="radio">
                                                                                            <input type="radio" name="ticket_service_fee" value="0" class="ticket-service-fee" <?php if (!$v["service_fee"]) echo 'checked'; ?>>
                                                                                            Absorb the fees into the ticket price
                                                                                        </label>
                                                                                        <label class="radio">
                                                                                            <input type="radio" name="ticket_service_fee" value="1" class="ticket-service-fee" <?php if ($v["service_fee"]) echo 'checked'; ?>>
                                                                                            Pass on the fees to the ticket buyer
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                            <div class="controls-group clearfix">
                                                                                <label class="control-label pull-left clearfix">&nbsp;</label>
                                                                                <div class="controls clearfix pull-left">
                                                                                    <div class="btn-apply clearfix">
                                                                                        <a href="#" class="btn btn-warning pull-right apply-ticket edit2">Edit</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <input type="submit" class="hide"/>
                                                            </form>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>

                                                <!-- clone tbody if has ticket -->
                                                <div class="hide">

                                                    <form action="<?php echo HelperUrl::baseUrl() ?>event/add_ticket_type/" enctype="multipart/form-data" method="post" class="form-horizontal table-ticket clone paid hide form-create-ticket">           
                                                        <table class="table table-bordered table-striped ">
                                                            <thead>
                                                                <tr>
                                                                    <th class="head-ticket-name">Ticket name</th>
                                                                    <th class="head-ticket-quantity">Quantity</th>
                                                                    <th class="head-ticket-price">Price</th>
                                                                    <th>Fee</th>
                                                                    <th>Total</th>
                                                                    <th class="head-ticket-status">Status</th>
                                                                    <th colspan="3" class="head-ticket-action"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="loading hide">
                                                                <tr>
                                                                    <td colspan="10"><img src="<?php echo HelperUrl::baseUrl() ?>img/ajax-big-roller.gif" class="waiting"></td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody class="ticket-info">            
                                                                <tr>
                                                            <input type="hidden" value="<?php echo $event['id'] ?>" name="event_id">        
                                                            <input type="hidden" class="ticket-type" value="paid" name="ticket_type">
                                                            <input type="hidden" class="ticket-id" value="" name="ticket_id">
                                                            <td class="ticket_name"><input type="text" class="input-mini ticket-name" name="ticket_name"></td>
                                                            <td class="ticket_quantity"><input type="text" class="input-mini quantity ticket-quantity" name="ticket_quantity" placeholder="0"></td>
                                                            <td class="ticket_fee"><input type="text" class="input-mini ticket-fee" name="ticket_fee" placeholder="0 TTD"></td>
                                                            <td><span class="price ticket-tax">0.00 TTD</span></td>
                                                            <td><span class="price ticket-total">0.00 TTD</span></td>
                                                            <td>
                                                                <select name="ticket_status" class="ticket-status">
                                                                    <?php foreach ($ticket_status as $k => $v): ?>
                                                                        <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </td>
                                                            <td><a class="setting" href="#">Option <i class="icon ico-hide icon-chevron-down"></i></a></td>
                                                            <td>
                                                                <a class="apply-ticket btn-style btn-info edit1" href="#">Add <i class="icon icon-add"></i></a>
                                                                <img style="vertical-align: middle" src="<?php echo HelperUrl::baseUrl() ?>img/ajax-circle-ball.gif" class="waiting hide">
                                                            </td>
                                                            <td>
                                                                <a class="remove-ticket clone btn-style btn-danger" href="#">Delete <i class="icon icon-delete"></i></a>
                                                                <img style="vertical-align: middle" src="<?php echo HelperUrl::baseUrl() ?>img/ajax-circle-ball.gif" class="waiting hide">
                                                            </td>
                                                            </tr>
                                                            <tr class="description-ticket hide">
                                                                <td colspan="9">
                                                                    <div class="controls-group clearfix">
                                                                        <div class="control-label pull-left clearfix">
                                                                            Ticket Description
                                                                        </div>
                                                                        <div class="controls clearfix pull-left">
                                                                            <textarea class="input-xxlarge ticket-description" cols="10" rows="5" name="ticket_description"></textarea>
                                                                            <label>
                                                                                <input type="checkbox" checked="" class="ticket-hide-description" name="ticket_hide_description">
                                                                                Auto hidden description
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="controls-group clearfix">
                                                                        <label class="control-label pull-left clearfix">Time</label>
                                                                        <div class="controls clearfix pull-left">

                                                                            <div class="row-fluid ticket-date">
                                                                                <p class="start-date-title">Start Sales</p>
                                                                                <div class="input-append date dp3" data-date="" data-date-format="mm/dd/yyyy">
                                                                                    <input type="text" value="<?php echo date('d-m-Y'); ?>" class="input-mini ico ico-calendar datetimepicker ticket-start-date " name="ticket_start_date">
                                                                                    <select id="time_hour" class="input-mini ticket-start-hour" name="ticket_start_hour">
                                                                                        <?php for ($i = 0; $i < 24; $i++): ?>
                                                                                            <option <?php if (date("H") == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                                                                        <?php endfor; ?>
                                                                                    </select>
                                                                                    <select id="time_min" class="input-mini ticket-start-minute" name="ticket_start_minute">
                                                                                        <?php for ($i = 0; $i < 60; $i++): ?>
                                                                                            <option <?php if (date("i") == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                                                                        <?php endfor; ?>
                                                                                    </select>
                                                                                </div>

                                                                            </div>

                                                                            <div class="row-fluid ticket-date">
                                                                                <p class="end-date-title">End Sales</p>

                                                                                <div class="input-append date dp3" data-date="" data-date-format="mm/dd/yyyy">
                                                                                    <input type="text" value="<?php echo date('d-m-Y', strtotime("+1 month")); ?>"  class="input-mini ico ico-calendar datetimepicker ticket-end-date " name="ticket_end_date">

                                                                                    <select id="time_hour" class="input-mini ticket-end-hour" name="ticket_end_hour">
                                                                                        <?php for ($i = 0; $i < 24; $i++): ?>
                                                                                            <option <?php if (date("H") == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                                                                        <?php endfor; ?>
                                                                                    </select>
                                                                                    <select id="time_min" class="input-mini ticket-end-minute" name="ticket_end_minute">
                                                                                        <?php for ($i = 0; $i < 60; $i++): ?>
                                                                                            <option <?php if (date("i") == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                                                                        <?php endfor; ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="controls-group clearfix">
                                                                        <label for="address" class="control-label pull-left clearfix">Tickets per Order</label>
                                                                        <div class="controls clearfix pull-left">
                                                                            Minimum <input type="text" value="1" name="ticket_min" class="input-mini ticket-min">
                                                                            Maximum <input type="text" name="ticket_max" class="input-mini ticket-max">
                                                                        </div>
                                                                    </div>

                                                                    <div class="controls-group clearfix">
                                                                        <label class="control-label pull-left clearfix">Service Fee </label>
                                                                        <div class="controls clearfix pull-left">

                                                                            <label class="radio">
                                                                                <input type="radio" class="ticket-service-fee" checked="" value="0" name="ticket_service_fee">
                                                                                Absorb the fees into the ticket price
                                                                            </label>
                                                                            <br/>
                                                                            <label class="radio">
                                                                                <input type="radio" class="ticket-service-fee" value="1" name="ticket_service_fee">
                                                                                Pass on the fees to the ticket buyer
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="controls-group clearfix">
                                                                        <label class="control-label pull-left clearfix">&nbsp;</label>
                                                                        <div class="controls clearfix pull-left">
                                                                            <div class="btn-apply clearfix">
                                                                                <a class="btn-style btn-info pull-right apply-ticket edit2" href="#">Add  <i class="icon icon-add"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            </tbody>       
                                                        </table>
                                                    </form>
                                                    <form action="<?php echo HelperUrl::baseUrl() ?>event/add_ticket_type/" enctype="multipart/form-data" method="post" class="form-horizontal table-ticket clone free hide form-create-ticket">           
                                                        <table class="table table-bordered table-striped ">
                                                            <thead>
                                                                <tr>
                                                                    <th class="head-ticket-name">Ticket name</th>
                                                                    <th class="head-ticket-quantity">Quantity</th>
                                                                    <th class="head-ticket-price free">Price</th>

                                                                    <th class="head-ticket-status">Status</th>
                                                                    <th colspan="3" class="head-ticket-action"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="loading hide">
                                                                <tr>
                                                                    <td colspan="8"><img src="<?php echo HelperUrl::baseUrl() ?>img/ajax-big-roller.gif" class="waiting"></td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody class="ticket-info">
                                                                <tr>
                                                            <input type="hidden" value="<?php echo $event['id'] ?>" name="event_id">        
                                                            <input type="hidden" class="ticket-type" value="free" name="ticket_type">
                                                            <input type="hidden" class="ticket-id" value="" name="ticket_id">
                                                            <td class="ticket_name"><input type="text" class="input-mini ticket-name" name="ticket_name"></td>
                                                            <td class="ticket_quantity"><input type="text" class="input-mini quantity ticket-quantity" name="ticket_quantity" placeholder="0"></td>
                                                            <td class="ticket_fee">Free</td>
                                                            <td>
                                                                <select name="ticket_status" class="ticket-status">
                                                                    <?php foreach ($ticket_status as $k => $v): ?>
                                                                        <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </td>
                                                            <td><a class="setting" href="JavaScript:void(0);">Option <i class="icon-chevron-down icon ico-hide"></i></a></td>
                                                            <td>
                                                                <a class="apply-ticket btn-style btn-info edit1" href="#">Add <i class="icon icon-add"></i></a>
                                                                <img style="vertical-align: middle" src="<?php echo HelperUrl::baseUrl() ?>img/ajax-circle-ball.gif" class="waiting hide">
                                                            </td>
                                                            <td>
                                                                <a class="remove-ticket clone btn-style btn-danger" href="#">Delete <i class="icon icon-delete"></i></a>
                                                                <img style="vertical-align: middle" src="<?php echo HelperUrl::baseUrl() ?>img/ajax-circle-ball.gif" class="waiting hide">
                                                            </td>
                                                            </tr>
                                                            <tr class="description-ticket hide">
                                                                <td colspan="9">
                                                                    <div class="controls-group clearfix">
                                                                        <div class="control-label pull-left clearfix">
                                                                            Ticket Description
                                                                        </div>
                                                                        <div class="controls clearfix pull-left">
                                                                            <textarea class="input-xxlarge ticket-description" cols="10" rows="5" name="ticket_description"></textarea>
                                                                            <label>
                                                                                <input type="checkbox" checked="" name="ticket_hide_description" class="ticket-hide-description">
                                                                                Auto hidden description
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="controls-group clearfix">
                                                                        <label class="control-label pull-left clearfix">Time</label>
                                                                        <div class="controls clearfix pull-left">

                                                                            <div class="row-fluid ticket-date">
                                                                                <p class="start-date-title">Start Sales</p>
                                                                                <div class="input-append date dp3" data-date="" data-date-format="mm/dd/yyyy">
                                                                                    <input type="text" value="<?php echo date('d-m-Y'); ?>" class="input-mini ico ico-calendar datetimepicker ticket-start-date " name="ticket_start_date">
                                                                                    <select id="time_hour" class="input-mini ticket-start-hour" name="ticket_start_hour">
                                                                                        <?php for ($i = 0; $i < 24; $i++): ?>
                                                                                            <option <?php if (date("H") == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                                                                        <?php endfor; ?>
                                                                                    </select>
                                                                                    <select id="time_min" class="input-mini ticket-start-minute" name="ticket_start_minute">
                                                                                        <?php for ($i = 0; $i < 60; $i++): ?>
                                                                                            <option <?php if (date("i") == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                                                                        <?php endfor; ?>
                                                                                    </select>

                                                                                </div>

                                                                            </div>

                                                                            <div class="row-fluid ticket-date">
                                                                                <p class="end-date-title">End Sales</p>


                                                                                <div class="input-append date dp3" data-date="" data-date-format="mm/dd/yyyy">
                                                                                    <input type="text" value="<?php echo date('d-m-Y', strtotime("+1 month")); ?>" class="input-mini ico ico-calendar datetimepicker ticket-end-date" name="ticket_end_date" >

                                                                                    <select id="time_hour" class="input-mini ticket-end-hour" name="ticket_end_hour">
                                                                                        <?php for ($i = 0; $i < 24; $i++): ?>
                                                                                            <option <?php if (date("H") == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                                                                        <?php endfor; ?>
                                                                                    </select>
                                                                                    <select id="time_min" class="input-mini ticket-end-minute" name="ticket_end_minute">
                                                                                        <?php for ($i = 0; $i < 60; $i++): ?>
                                                                                            <option <?php if (date("i") == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                                                                        <?php endfor; ?>
                                                                                    </select>

                                                                                </div>

                                                                            </div>
                                                                        </div>


                                                                    </div>

                                                                    <div class="controls-group clearfix">
                                                                        <label for="address" class="control-label pull-left clearfix">Tickets per Order</label>
                                                                        <div class="controls clearfix pull-left">
                                                                            Minimum <input type="text" value="1" name="ticket_min" class="input-mini ticket-min">
                                                                            Maximum <input type="text" name="ticket_max" class="input-mini ticket-max">
                                                                        </div>
                                                                    </div>
                                                                    <div class="controls-group clearfix">
                                                                        <label for="address" class="control-label pull-left clearfix">&nbsp;</label>
                                                                        <div class="controls clearfix pull-left">
                                                                            <div class="btn-apply clearfix">
                                                                                <a class="btn-style btn-info pull-right apply-ticket edit2" href="#">Add <i class="icon icon-add"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                            </tbody>

                                                        </table>
                                                    </form>
                                                </div>
                                                <!-- end clone tbody if has ticket -->
                                            </div>
                                        <?php endif; ?>
                                        </div>
                                        </div>
                                        </div>