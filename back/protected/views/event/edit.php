<?php
$cities = Helper::cities();
$ticket_status = Helper::ticket_status();
?>
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/event/">Event</a> <span class="divider">/</span> </li>
    <li class="active">Edit <span class="divider">/</span> </li>
    <li class="active"><?php echo $event['title'] ?></li>
</ul>
<legend>Edit an event: <?php echo $event['title'] ?></legend>
<?php echo Helper::print_success($message); ?>
<?php echo Helper::print_error($message); ?>
<ul class="nav nav-tabs">
    <li class="<?php if ($type == "general") echo 'active' ?>">
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/event/edit/id/<?php echo $event['id'] ?>/type/general">Information</a>
    </li>
    <li class="<?php if ($type == "ticket") echo 'active' ?>">
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/event/edit/id/<?php echo $event['id'] ?>/type/ticket">Ticket</a>
    </li>
    <li class="<?php if ($type == "gallery") echo 'active' ?>">
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/event/gallery/id/<?php echo $event['id'] ?>/">Gallery</a>
    </li>
    <li class="<?php if ($type == "seo") echo 'active' ?>">
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/event/seo/id/<?php echo $event['id'] ?>/">SEO</a>
    </li>
  
</ul>

<?php if ($type == "general"): ?>
    <form class="form-horizontal" method="post" enctype="multipart/form-data" id="event_form">   
        <input type="hidden" name="location_id" value="<?php echo $event['location_id'] ?>"/>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <img class="img-polaroid" src="<?php echo HelperApp::get_thumbnail($event['thumbnail']); ?>" />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Event title</label>
            <div class="controls">
                <input type="text" class="input-xxlarge" name="title" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : htmlspecialchars($event['title']); ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Upload the logo for event</label>
            <div class="controls">
                <input type="file" name="file"/>
                <p class="help-block">Must be JPG, GIF, or PNG smaller than 2MB and larger than 300 x 300 px.</p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Select categories for your event</label>
            <div class="controls">            
                <select name="primary_cate" class="span3">
                    <option value="0">Primary category</option>
                    <?php foreach ($categories as $k => $v): ?>                
                        <option <?php if (isset($_POST['primary_cate']) && $_POST['primary_cate'] == $v['id']) echo 'selected'; else if ($event['categories']['primary']['id'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id'] ?>"><?php echo $v['title']; ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="second_cate" class="span3">
                    <option value="0">Secondary category</option>
                    <?php foreach ($categories as $k => $v): ?>                
                        <option <?php if (isset($_POST['second_cate']) && $_POST['second_cate'] == $v['id']) echo 'selected'; else if (isset($event['categories']['second']) && $event['categories']['second']['id'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id'] ?>"><?php echo $v['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">The name of your location</label>
            <div class="controls">
                <input type="text" id="add_location" class="input-xxlarge" name="location" value="<?php echo isset($_POST['location']) ? htmlspecialchars($_POST['location']) : htmlspecialchars($event['location']); ?>">
                <img class="loading-location hide" src="<?php echo Yii::app()->request->baseUrl ?>/img/ajax-big-roller.gif" />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Address</label>
            <div class="controls">
                <input type="text" class="input-xxlarge" name="address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : htmlspecialchars($event['address']); ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Ciy</label>
            <div class="controls">
                <select name="city">
                    <?php foreach ($cities as $k => $v): ?>
                        <option <?php if (isset($_POST['city']) && $_POST['city'] == $v) echo 'selected'; else if ($event['city'] == $v) echo 'selected'; ?> value="<?php echo $v; ?>"><?php echo $v; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Event starts</label>
            <div class="controls">
                <input type="text" class="datetimepicker input-medium" name="start_date" value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : date('d-m-Y', strtotime($event['start_time'])); ?>" />
                <select name="start_hour" class="span1">
                    <?php for ($i = 0; $i < 24; $i++): ?>
                        <option <?php if (isset($_POST['start_hour']) && $_POST['start_hour'] == $i) echo 'selected'; else if ((int) date('H', strtotime($event['start_time'])) == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                    <?php endfor; ?>
                </select> h 
                <select name="start_minute" class="span1">
                    <?php for ($i = 0; $i < 60; $i++): ?>
                        <option <?php if (isset($_POST['start_minute']) && $_POST['start_minute'] == $i) echo 'selected'; else if ((int) date('i', strtotime($event['start_time'])) == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                    <?php endfor; ?>
                </select>
                <label class="checkbox inline">
                    <input type="checkbox" name="display_start_time" value="1" <?php if (isset($_POST['display_start_time'])) echo 'checked'; else if ($event['display_start_time']) echo 'checked'; ?>> Show
                </label>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Event ends</label>
            <div class="controls">
                <input type="text" class="datetimepicker input-medium" name="end_date" value="<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : date('d-m-Y', strtotime($event['end_time'])); ?>" />
                <select name="end_hour" class="span1">
                    <?php for ($i = 0; $i < 24; $i++): ?>
                        <option <?php if (isset($_POST['end_hour']) && $_POST['end_hour'] == $i) echo 'selected'; else if ((int) date('H', strtotime($event['end_time'])) == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                    <?php endfor; ?>
                </select> h 
                <select name="end_minute" class="span1">
                    <?php for ($i = 0; $i < 60; $i++): ?>
                        <option <?php if (isset($_POST['end_minute']) && $_POST['end_minute'] == $i) echo 'selected'; else if ((int) date('i', strtotime($event['end_time'])) == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                    <?php endfor; ?>
                </select>
                <label class="checkbox inline">
                    <input type="checkbox" name="display_end_time" value="1" <?php if (isset($_POST['display_end_time'])) echo 'checked'; else if ($event['display_end_time']) echo 'checked'; ?>> Show
                </label>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Event repeats? </label>
            <div class="controls">

                <label class="radio">
                    <input type="radio" name="is_repeat" value="1" <?php if (isset($_POST['is_repeat']) && $_POST['is_repeat']) echo 'checked'; else if ($event['is_repeat']) echo 'checked'; ?>>
                    Yes
                </label>
                <label class="radio">
                    <input type="radio" name="is_repeat" value="0" <?php if (isset($_POST['is_repeat']) && !$_POST['is_repeat']) echo 'checked'; else if (!$event['is_repeat']) echo 'checked'; ?>>
                    No
                </label>

            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Event Details</label>
            <div class="controls">
                <textarea  name="description" class="span8 tinymce" rows="20"><?php echo isset($_POST['description']) ? $_POST['description'] : $event['description']; ?></textarea>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Publish</label>
            <div class="controls">
                <label class="radio">
                    <input type="radio" name="published" value="1" <?php if (isset($_POST['published']) && $_POST['published']) echo 'checked'; else if ($event['published']) echo 'checked'; ?>>
                    Yes
                </label>
                <label class="radio">
                    <input type="radio" name="published" value="0" <?php if (isset($_POST['published']) && !$_POST['published']) echo 'checked'; else if (!$event['published']) echo 'checked'; ?>>
                    No
                </label>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Show number of tickets</label>
            <div class="controls">
                <label class="radio">
                    <input type="radio" name="show_tickets" value="1" <?php if (isset($_POST['show_tickets']) && $_POST['show_tickets'] == 1) echo 'checked'; else if ($event['show_tickets']) echo 'checked'; ?>>
                    Yes
                </label>
                <label class="radio">
                    <input type="radio" name="show_tickets" value="0" <?php if (isset($_POST['show_tickets']) && $_POST['show_tickets'] == 0) echo 'checked'; else if (!$event['show_tickets']) echo 'checked'; ?>>
                    No
                </label>
            </div>
        </div>


        <div class="form-actions">        
            <button type="submit" class="btn btn-primary">Save</button>
        </div>        

    </form>
<?php endif; ?>

<?php if ($type == "ticket"): ?>
    <div class="alert alert-error hide">
        <button type = "button" class = "close" data-dismiss = "alert">×</button>
        <h4>Error!</h4>
        <div class="msg">

        </div>
    </div>

    <div class="alert alert-success hide">
        <button type = "button" class = "close" data-dismiss = "alert">×</button>
        <h4>Success!</h4>
        <div class="msg">

        </div>
    </div>
    <div id="event_form">
        <p>Type of prices<a href="#" class="btn btn-ticket free" style="margin-left:20px">Free</a>
            <a href="#" style="margin-left: 20px" class="btn btn-info btn-ticket paid">Cost</a></p><br/>

        <?php foreach ($ticket_types as $k => $v): ?>
            <form class="form-horizontal table-ticket <?php echo $v['type'] ?>" method="post" enctype="multipart/form-data" action="<?php echo Yii::app()->request->baseUrl ?>/event/edit_ticket_type/id/<?php echo $v['id']; ?>">           
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="head-ticket-name">Ticket name</th>
                            <th class="head-ticket-quantity">Quantity</th>
                            <th class="head-ticket-price <?php echo $v['type'] ?>">Price</th>
                            <?php if ($v['type'] == "paid"): ?>
                                <th>Fee</th>
                                <th>Total</th>
                            <?php endif; ?>
                            <th class="head-ticket-status">Status of ticket</th>
                            <th class="head-ticket-action" colspan="3"></th>
                        </tr>
                    </thead>
                    <!-- check if has $_POST['ticket_id'] -->

                    <tbody class="loading hide">
                        <tr>
                            <td colspan="<?php echo $v['type'] == "paid" ? 10 : 8; ?>"><img class="waiting" src="<?php echo Yii::app()->request->baseUrl ?>/img/ajax-big-roller.gif" /></td>
                        </tr>
                    </tbody>

                    <tbody class="ticket-info <?php echo $v['type']; ?>">
                        <tr>
                    <input type="hidden" name="ticket_id" value="<?php echo $v['id']; ?>" class="ticket-id"/>
                    <td class="ticket_name"><input type="text" name="ticket_name" class="input-small ticket-name" value="<?php echo htmlspecialchars($v['title']); ?>"></td>
                    <td class="ticket_quantity"><input type="text" placeholder="0" name="ticket_quantity" class="input-mini quantity ticket-quantity" value="<?php echo htmlspecialchars($v['quantity']); ?>"></td>

                    <?php if ($v['type'] == "paid"): ?>
                    <td class="ticket_fee"><input type="text" placeholder="0" name="ticket_fee" class="input-mini ticket-fee" value="<?php echo htmlspecialchars(number_format($v['price'],0,'','')); ?>"></td>
                        <td><span class="price ticket-tax"><?php echo '$'.number_format($v['tax']) ?> </span></td>
                        <?php $total = $v['service_fee'] ? $v['price'] * $v['quantity'] + $v['tax'] : $v['price'] * $v['quantity']; ?>
                        <td><span class="price ticket-total"><?php echo '$'.number_format($total) ?> </span></td>
                    <?php else: ?>
                        <td class="ticket_fee" class="input-mini">Free</td>
                    <?php endif; ?>

                    <td>
                        <select class="ticket-status input-small" name="ticket_status">
                            <?php foreach ($ticket_status as $tkey => $ts): ?>
                                <option <?php if ($v['ticket_status'] == $tkey) echo 'selected'; ?> value="<?php echo $tkey; ?>"><?php echo $ts; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><a href="#" class="setting">Options<span class="icon-white ico-hide icon-chevron-down"></span></a></td>
                    <td>
                        <a href="#" class="apply-ticket icon"><i class="icon-edit"></i></a>                        
                    </td>
                    <td>
                        <a href="<?php echo Yii::app()->request->baseUrl ?>/event/delete_ticket_type/id/<?php echo $v['id']; ?>" class="remove-ticket"><i class="icon-remove btn-remove"></i></a>                        
                    </td>
                    </tr>
                    <tr class="description-ticket hide">
                        <td colspan="8">
                            <div class="control-group">
                                <div class="control-label">
                                    Ticket Description:
                                </div>
                                <div class="controls">
                                    <textarea name="ticket_description" rows="3" class="input-xlarge ticket-description"><?php echo $v['description']; ?></textarea>
                                </div>
                                <div class="controls">
                                    <label class="checkbox">
                                        <input type="checkbox" name="ticket_hide_description" class="ticket-hide-description" <?php if ($v['hide_description']) echo 'checked'; ?>>
                                         Auto Hide Description
                                    </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Time: </label>
                                <div class="controls">

                                    <div class="row-fluid ticket-date">
                                        <p class="start-date-title">Start Sale</p>
                                        <div data-date-format="mm/dd/yyyy" data-date="" class="input-append date dp3">
                                            <input type="text" value="<?php echo htmlspecialchars(date('d-m-Y', strtotime($v['sale_start']))); ?>" name="ticket_start_date" class="input-medium datetimepicker ticket-start-date">
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
                                        <p class="end-date-title">End Sale</p>

                                        <div data-date-format="mm/dd/yyyy" data-date="" class="input-append date dp3">
                                            <input type="text" value="<?php echo htmlspecialchars(date('d-m-Y', strtotime($v['sale_end']))); ?>" name="ticket_end_date" class="input-medium ico ico-calendar datetimepicker ticket-end-date">

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

                            <div class="control-group">
                                <label class="control-label" for="address">Tickets per Order:</label>
                                <div class="controls">
                                    Minimum <input type="text" class="input-mini ticket-min" name="ticket_min" value="<?php echo htmlspecialchars($v['minimum']); ?>">
                                    Maximum <input type="text" class="input-mini ticket-max" name="ticket_max" value="<?php echo htmlspecialchars($v['maximum']); ?>">
                                </div>
                            </div>

                            <?php if ($v['type'] == "paid"): ?>
                                <div class="control-group">
                                    <label class="control-label">Service Fee</label>
                                    <div class="controls">

                                        <label class="radio">
                                            <input type="radio" name="ticket_service_fee" value="0" class="ticket-service-fee" <?php if (!$v["service_fee"]) echo 'checked'; ?>>
                                             INCLUDE fees into total ticket price
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="ticket_service_fee" value="1" class="ticket-service-fee" <?php if ($v["service_fee"]) echo 'checked'; ?>>
                                             ADD fees on top of total ticket price
                                        </label>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="btn-apply clearfix">
                                <a href="#" class="btn btn-primary pull-right apply-ticket">Save</a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                    <?php /*
                      <tfoot>
                      <tr>
                      <td colspan="8">
                      <div class="tickets-footer">
                      <div class="clearfix" id="event_capacity_container">
                      <div class="span3" id="event_capacity_label">Tổng số vé
                      <input type="text" readonly="" class="input-mini total-ticket disabled" name="total_ticket" value="<?php if (isset($_POST['total_ticket'])) echo $_POST['total_ticket'] ?>">
                      </div>
                      <!--
                      <div class="add_ticket_container span7">
                      Add a ticket:
                      <button class="btn btn-small">Action</button>
                      <button class="btn btn-small">Action</button>
                      <button class="btn btn-small">Action</button>
                      </div>
                      -->
                      </div>
                      </div>
                      </td>
                      </tr>
                      </tfoot>
                     */ ?>

                </table>
                <input type="submit" class="hide"/>
            </form>
        <?php endforeach; ?>
    </div>
    <!-- clone tbody if has ticket -->
    <div class="hide">
        <form class="form-horizontal table-ticket clone paid hide" method="post" enctype="multipart/form-data" action="<?php echo Yii::app()->request->baseUrl ?>/event/add_ticket_type/">           
            <table class="table table-bordered table-striped ">
                <thead>
                    <tr>
                        <th class="head-ticket-name">Ticket name</th>
                        <th class="head-ticket-quantity">Quantity</th>
                        <th class="head-ticket-price">Price</th>
                        <th>Fee</th>
                        <th>Total</th>
                        <th class="head-ticket-status">Status</th>
                        <th class="head-ticket-action" colspan="3"></th>
                    </tr>
                </thead>
                <tbody class="loading hide">
                    <tr>
                        <td colspan="10"><img class="waiting" src="<?php echo Yii::app()->request->baseUrl ?>/img/ajax-big-roller.gif" /></td>
                    </tr>
                </tbody>
                <tbody class="ticket-info">            
                    <tr>
                <input type="hidden" name="event_id" value="<?php echo $event['id'] ?>"/>        
                <input type="hidden" name="ticket_type" value="paid" class="ticket-type"/>
                <input type="hidden" name="ticket_id" value="" class="ticket-id"/>
                <td class="ticket_name"><input type="text" name="ticket_name" class="input-small ticket-name"></td>
                <td class="ticket_quantity"><input type="text" placeholder="0" name="ticket_quantity" class="input-mini quantity ticket-quantity"></td>
                <td class="ticket_fee"><input type="text" placeholder="0" name="ticket_fee" class="input-mini ticket-fee"></td>
                <td><span class="price ticket-tax">0.00</span></td>
                <td><span class="price ticket-total">0.00</span></td>
                <td>
                    <select class="ticket-status input-small" name="ticket_status">
                        <?php foreach ($ticket_status as $k => $v): ?>
                            <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><a href="#" class="setting">Option <span class="icon-white ico-hide icon-chevron-down"></span></a></td>
                <td>
                    <a href="#" class="apply-ticket"><i class="icon-ok"></i></a>
                    <img class="waiting hide" src="<?php echo Yii::app()->request->baseUrl ?>/img/ajax-circle-ball.gif" style="vertical-align: middle"/>
                </td>
                <td>
                    <a href="#" class="remove-ticket clone"><i class="icon-remove btn-remove"></i></a>
                    <img class="waiting hide" src="<?php echo Yii::app()->request->baseUrl ?>/img/ajax-circle-ball.gif" style="vertical-align: middle"/>
                </td>
                </tr>
                <tr class="description-ticket hide">
                    <td colspan="8">
                        <div class="control-group">
                            <div class="control-label">
                                Ticket description:
                            </div>
                            <div class="controls">
                                <textarea name="ticket_description" rows="3" class="input-xlarge ticket-description"></textarea>
                            </div>
                            <div class="controls">
                                <label class="checkbox">
                                    <input type="checkbox" name="ticket_hide_description" class="ticket-hide-description" checked>
                                    Auto Hide Description
                                </label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Time:</label>
                            <div class="controls">

                                <div class="row-fluid ticket-date">
                                    <p class="start-date-title">Start Sale</p>
                                    <div data-date-format="mm/dd/yyyy" data-date="" class="input-append date dp3">
                                        <input type="text" value="<?php echo date('d-m-Y'); ?>" name="ticket_start_date" class="input-medium datetimepicker ticket-start-date">
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
                                        <!-- 
                                        <label class="checkbox inline">
                                            <input type="checkbox" value="show" id="show_time">
                                            Hiện thời gian
                                        </label>
                                        -->
                                    </div>

                                </div>

                                <div class="row-fluid ticket-date">
                                    <p class="end-date-title">End Sale</p>

                                    <div data-date-format="mm/dd/yyyy" data-date="" class="input-append date dp3">
                                        <input type="text" value="<?php echo date('d-m-Y', strtotime("+1 month")); ?>" name="ticket_end_date" class="input-medium ico ico-calendar datetimepicker ticket-end-date">

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

                        <div class="control-group">
                            <label class="control-label" for="address">Tickets per Order: </label>
                            <div class="controls">
                                Minimum <input type="text" class="input-mini ticket-min" name="ticket_min" value="1">
                                Maximum <input type="text" class="input-mini ticket-max" name="ticket_max">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Service Fee: </label>
                            <div class="controls">

                                <label class="radio">
                                    <input type="radio" name="ticket_service_fee" value="0" checked class="ticket-service-fee">
                                     INCLUDE fees into total ticket price
                                </label>
                                <label class="radio">
                                    <input type="radio" name="ticket_service_fee" value="1" class="ticket-service-fee">
                                     ADD fees on top of total ticket price
                                </label>
                            </div>
                        </div>

                        <div class="btn-apply clearfix">
                            <a href="#" class="btn btn-primary pull-right apply-ticket">Save</a>
                        </div>
                    </td>
                </tr>
                </tbody>       
            </table>
        </form>
        <form class="form-horizontal table-ticket clone free hide" method="post" enctype="multipart/form-data" action="<?php echo Yii::app()->request->baseUrl ?>/event/add_ticket_type/">           
            <table class="table table-bordered table-striped ">
                <thead>
                    <tr>
                        <th class="head-ticket-name">Ticket name</th>
                        <th class="head-ticket-quantity">Quantity</th>
                        <th class="head-ticket-price free">Price</th>

                        <th class="head-ticket-status">Status</th>
                        <th class="head-ticket-action" colspan="3"></th>
                    </tr>
                </thead>
                <tbody class="loading hide">
                    <tr>
                        <td colspan="8"><img class="waiting" src="<?php echo Yii::app()->request->baseUrl ?>/img/ajax-big-roller.gif" /></td>
                    </tr>
                </tbody>
                <tbody class="ticket-info">
                    <tr>
                <input type="hidden" name="event_id" value="<?php echo $event['id'] ?>"/>        
                <input type="hidden" name="ticket_type" value="free" class="ticket-type"/>
                <input type="hidden" name="ticket_id" value="" class="ticket-id"/>
                <td class="ticket_name"><input type="text" name="ticket_name" class="input-small ticket-name"></td>
                <td class="ticket_quantity"><input type="text" placeholder="0" name="ticket_quantity" class="input-mini quantity ticket-quantity"></td>
                <td class="ticket_fee"class="input-mini">Free</td>
                <td>
                    <select class="ticket-status input-small" name="ticket_status">
                        <?php foreach ($ticket_status as $k => $v): ?>
                            <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><a href="JavaScript:void(0);" class="setting">Option<span class="icon-chevron-down icon-white ico-hide"></span></a></td>
                <td>
                    <a href="#" class="apply-ticket"><i class="icon-ok"></i></a>
                    <img class="waiting hide" src="<?php echo Yii::app()->request->baseUrl ?>/img/ajax-circle-ball.gif" style="vertical-align: middle"/>
                </td>
                <td>
                    <a href="#" class="remove-ticket clone"><i class="icon-remove btn-remove"></i></a>
                    <img class="waiting hide" src="<?php echo Yii::app()->request->baseUrl ?>/img/ajax-circle-ball.gif" style="vertical-align: middle"/>
                </td>
                </tr>
                <tr class="description-ticket hide">
                    <td colspan="8">
                        <div class="control-group">
                            <div class="control-label">
                                Ticket Description:
                            </div>
                            <div class="controls">
                                <textarea name="ticket_description" rows="3" class="input-xlarge ticket-description"></textarea>
                            </div>
                            <div class="controls">
                                <label class="checkbox">
                                    <input type="checkbox" class="ticket-hide-description" name="ticket_hide_description" checked>
                                    Auto Hide Description
                                </label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Time:</label>
                            <div class="controls">

                                <div class="row-fluid ticket-date">
                                    <p class="start-date-title">Start sale</p>
                                    <div data-date-format="mm/dd/yyyy" data-date="" class="input-append date dp3">
                                        <input type="text" value="<?php echo date('d-m-Y'); ?>" name="ticket_start_date" class="input-medium datetimepicker ticket-start-date">
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
                                        <!--                                                                    
                                        <label class="checkbox inline">
                                           <input type="checkbox" value="show" id="show_time">
                                            Hiện thời gian
                                        </label>
                                        -->
                                    </div>

                                </div>

                                <div class="row-fluid ticket-date">
                                    <p class="end-date-title">End Sale</p>


                                    <div data-date-format="mm/dd/yyyy" data-date="" class="input-append date dp3">
                                        <input type="text" value="<?php echo date('d-m-Y', strtotime("+1 month")); ?>" name="ticket_end_date" class="input-medium ico ico-calendar datetimepicker ticket-end-date">

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

                        <div class="control-group">
                            <label class="control-label" for="address">Tickets per Order: </label>
                            <div class="controls">
                                Minimum <input type="text" class="input-mini ticket-min" name="ticket_min" value="1">
                                Maximum <input type="text" class="input-mini ticket-max" name="ticket_max">
                            </div>
                        </div>

                        <div class="btn-apply clearfix">
                            <a href="#" class="btn btn-primary pull-right apply-ticket">Save</a>
                        </div>
                    </td>
                </tr>
                </tbody>

            </table>
        </form>
    </div>
    <!-- end clone -->

<?php endif; ?>