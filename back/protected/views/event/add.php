<?php
$countries = Helper::countries();
$ticket_status = Helper::ticket_status();
$ticket_types = Helper::ticket_types();
?>
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/event/">Event</a> <span class="divider">/</span> </li>
    <li class="active">Add</li>
</ul>
<legend>Add an new event</legend>


<?php echo Helper::print_error($message); ?>
<!--
<ul class="nav nav-tabs">
    <li class="active">
        <a data-toggle="tab" href="#tab-0">Thông tin chung</a>
    </li>
    <li>
        <a data-toggle="tab" href="#tab-1">Vé</a>
    </li>
</ul> -->
<form class="form-horizontal" method="post" enctype="multipart/form-data" id="event_form">    
    <div class="tab-content">

        <div id="tab-0" class="tab-pane active">

            <input type="hidden" name="location_id" value="0"/>
            <div class="control-group">
                <label class="control-label">Event title</label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" name="title" value="<?php if (isset($_POST['title'])) echo htmlspecialchars($_POST['title']); ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Upload the logo for your event</label>
                <div class="controls">
                    <input type="file" name="file"/>
                    <p class="help-block">Must be JPG, GIF, or PNG smaller than 2MB and larger than 300 x 300 px.</p>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" style="padding-top: 0px"s>Select categories for your event</label>
                <div class="controls">            
                    <select name="primary_cate" class="span3">
                        <option value="0">Primary category</option>
                        <?php foreach ($categories as $k => $v): ?>                
                            <option <?php if (isset($_POST['primary_cate']) && $_POST['primary_cate'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id'] ?>"><?php echo $v['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="second_cate" class="span3">
                        <option value="0">Secondary category</option>
                        <?php foreach ($categories as $k => $v): ?>                
                            <option <?php if (isset($_POST['second_cate']) && $_POST['second_cate'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id'] ?>"><?php echo $v['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">The name of your location</label>
                <div class="controls">
                    <input type="text" id="add_location" class="input-xxlarge" name="location" value="<?php if (isset($_POST['location'])) echo htmlspecialchars($_POST['location']); ?>">
                    <img class="loading-location hide" src="<?php echo Yii::app()->request->baseUrl ?>/img/ajax-big-roller.gif" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Address</label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" name="address" value="<?php if (isset($_POST['address'])) echo htmlspecialchars($_POST['address']); ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">City</label>
                <div class="controls">
                    <select name="country">
                        <?php foreach ($countries as $k => $v): ?>
                            <option <?php if (isset($_POST['country']) && $_POST['country'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id']; ?>"><?php echo $v['id']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Event starts</label>
                <div class="controls">
                    <input type="text" class="datetimepicker input-medium" name="start_date" value="<?php if (isset($_POST['start_date'])) echo $_POST['start_date']; else echo date('d-m-Y'); ?>" />
                    <select name="start_hour" class="span1">
                        <?php for ($i = 0; $i < 24; $i++): ?>
                            <option <?php if (isset($_POST['start_hour']) && $_POST['start_hour'] == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                        <?php endfor; ?>
                    </select> h 
                    <select name="start_minute" class="span1">
                        <?php for ($i = 0; $i < 60; $i++): ?>
                            <option <?php if (isset($_POST['start_minute']) && $_POST['start_minute'] == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                        <?php endfor; ?>
                    </select>
                    <label class="checkbox inline">
                        <input type="checkbox" name="display_start_time" value="1" <?php if (isset($_POST['display_start_time'])) echo 'checked'; ?>> Show
                    </label>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Event ends</label>
                <div class="controls">
                    <input type="text" class="datetimepicker input-medium" name="end_date" value="<?php if (isset($_POST['end_date'])) echo $_POST['end_date']; else echo date('d-m-Y'); ?>" />
                    <select name="end_hour" class="span1">
                        <?php for ($i = 0; $i < 24; $i++): ?>
                            <option <?php if (isset($_POST['end_hour']) && $_POST['end_hour'] == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                        <?php endfor; ?>
                    </select> h 
                    <select name="end_minute" class="span1">
                        <?php for ($i = 0; $i < 60; $i++): ?>
                            <option <?php if (isset($_POST['end_minute']) && $_POST['end_minute'] == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                        <?php endfor; ?>
                    </select>
                    <label class="checkbox inline">
                        <input type="checkbox" name="display_end_time" value="1" <?php if (isset($_POST['display_start_time'])) echo 'checked'; ?>> Show
                    </label>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Event Repeats?</label>
                <div class="controls">

                    <label class="radio">
                        <input type="radio" name="is_repeat" value="1" <?php if (isset($_POST['is_repeat']) && $_POST['is_repeat'] == 1) echo 'checked'; ?>>
                        Yes
                    </label>
                    <label class="radio">
                        <input type="radio" name="is_repeat" value="0" <?php if (isset($_POST['is_repeat']) && $_POST['is_repeat'] == 0) echo 'checked'; ?> checked>
                        No
                    </label>

                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Event Details</label>
                <div class="controls">
                    <textarea  name="description" class="span8 tinymce" rows="20"><?php if (isset($_POST['description'])) echo $_POST['description']; ?></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Publish</label>
                <div class="controls">
                    <label class="radio">
                        <input type="radio" name="published" value="1" <?php if (isset($_POST['published']) && $_POST['published'] == 1) echo 'checked'; ?> checked>
                        Yes
                    </label>
                    <label class="radio">
                        <input type="radio" name="published" value="0" <?php if (isset($_POST['published']) && $_POST['published'] == 0) echo 'checked'; ?>>
                        No
                    </label>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Show number of tickets</label>
                <div class="controls">
                    <label class="radio">
                        <input type="radio" name="show_tickets" value="1" <?php if (isset($_POST['show_tickets']) && $_POST['show_tickets'] == 1) echo 'checked'; ?> checked>
                        Yes
                    </label>
                    <label class="radio">
                        <input type="radio" name="show_tickets" value="0" <?php if (isset($_POST['show_tickets']) && $_POST['show_tickets'] == 0) echo 'checked';  ?>>
                        No
                    </label>
                </div>
            </div>

            <div class="form-actions">        
                <!--<button type="button" class="btn btn-continue">Tiếp tục &raquo;</button> -->
                <button style="margin-left: 50px" type="submit" class="btn btn-primary">Save</button>
            </div>

        </div>
        <?php /*
        <div id="tab-1" class="tab-pane">
            <div class="control-group">
                <label class="control-label">Hiển thị số lượng vé</label>
                <div class="controls">
                    <label class="radio">
                        <input type="radio" name="show_tickets" value="1" <?php if (isset($_POST['show_tickets']) && $_POST['show_tickets'] == 1) echo 'checked'; ?> checked>
                        Có
                    </label>
                    <label class="radio">
                        <input type="radio" name="show_tickets" value="0" <?php if (isset($_POST['show_tickets']) && $_POST['show_tickets'] == 0) echo 'checked'; ?>>
                        Không
                    </label>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Loại vé</label>
                <div class="controls">
                    <button class="btn btn-ticket free">Vé miễn phí</button>
                    <button style="margin-left: 20px" class="btn btn-info btn-ticket paid">Vé thu phí</button>
                </div>
            </div>
            
            
            <table class="table table-bordered table-striped table-ticket <?php if (!isset($_POST['ticket_id'])) echo 'hide' ?>">
                <thead>
                    <tr>
                        <th>Tên vé</th>
                        <th>Số lượng</th>
                        <th>Giá vé</th>
                        <th>Phí</th>
                        <th>Tổng cộng</th>
                        <th>Tình trạng vé</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <!-- check if has $_POST['ticket_id'] -->
                <?php if (isset($_POST['ticket_id'])): ?>

                    <?php foreach ($_POST['ticket_id'] as $k => $v): ?>

                        <?php                        
                        $ticket_type = $_POST['ticket_id'][$k];
                        if (array_search($ticket_type, array_flip($ticket_types)) === false)
                            continue;
                        ?>

                        <tbody class="ticket-info <?php echo $ticket_type; ?>">
                            <tr>
                                <input type="hidden" name="ticket_id[<?php echo $k; ?>]" value="<?php echo $ticket_type; ?>" class="ticket-id"/>
                                <td class="ticket_name"><input type="text" name="ticket_name[<?php echo $k; ?>]" class="input-medium ticket-name" value="<?php if(isset($_POST['ticket_name'][$k])) echo htmlspecialchars($_POST['ticket_name'][$k]); ?>"></td>
                                <td class="ticket_quantity"><input type="text" placeholder="0" name="ticket_quantity[<?php echo $k; ?>]" class="input-mini quantity ticket-quantity" value="<?php if(isset($_POST['ticket_quantity'][$k])) echo htmlspecialchars($_POST['ticket_quantity'][$k]); ?>"></td>
                                
                                <?php if($ticket_type == "paid"): ?>
                                
                                <?php                                 
                                $ticket_price = (int)$_POST['ticket_quantity'][$k] * $_POST['ticket_fee'][$k];
                                $ticket_tax = Yii::app()->getParams()->itemAt('ticket_tax') * $ticket_price;
                                $ticket_price = $_POST['ticket_service_fee'][$k] == 1 ? $ticket_price + $ticket_tax : $ticket_price;
                                ?>
                                <td class="ticket_fee"><input type="text" placeholder="0 VNĐ" name="ticket_fee[<?php echo $k; ?>]" class="input-mini ticket-fee" value="<?php if(isset($_POST['ticket_fee'][$k])) echo htmlspecialchars($_POST['ticket_fee'][$k]); ?>"></td>
                                <td><span class="price ticket-tax"><?php echo number_format($ticket_tax) ?> VNĐ</span></td>
                                <td><span class="price ticket-total"><?php echo number_format($ticket_price) ?> VNĐ</span></td>
                                <?php else: ?>
                                    <td class="ticket_fee" colspan="3" class="input-mini">Miễn phí</td>
                                <?php endif;?>
                                
                                <td>
                                    <select class="ticket-status input-small" name="ticket_status[<?php echo $k; ?>]">
                                        <?php foreach ($ticket_status as $tkey => $v): ?>
                                            <option <?php if(isset($_POST['ticket_status'][$k]) && $_POST['ticket_status'][$k] == $tkey) echo 'selected'; ?> value="<?php echo $tkey; ?>"><?php echo $v; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><a href="#" class="setting">Thiết lập <span class="icon-white ico-hide icon-chevron-down"></span></a></td>
                                <td><a href="#" class="remove-ticket"><i class="icon-remove btn-remove"></i></a></td>
                            </tr>
                            <tr class="description-ticket hide">
                                <td colspan="8">
                                    <div class="control-group">
                                        <div class="control-label">
                                            Mô tả vé
                                        </div>
                                        <div class="controls">
                                            <textarea name="ticket_description[<?php echo $k; ?>]" rows="3" class="input-xlarge ticket-description"><?php if(isset($_POST['ticket_description'][$k])) echo $_POST['ticket_description'][$k]; ?></textarea>
                                        </div>
                                        <div class="controls">
                                            <label class="checkbox">
                                                <input type="checkbox" name="ticket_hide_description[<?php echo $k; ?>]" class="ticket-hide-description" <?php if(isset($_POST['ticket_hide_description'][$k])) echo 'checked'; ?>>
                                                Ẩn mô tả vé trên trang Vé Sự Kiện
                                            </label>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Thời gian</label>
                                        <div class="controls">

                                            <div class="row-fluid ticket-date">
                                                <p class="start-date-title">Ngày bắt đầu</p>
                                                <div data-date-format="mm/dd/yyyy" data-date="" class="input-append date dp3">
                                                    <input type="text" value="<?php if(isset($_POST['ticket_start_date'][$k])) echo htmlspecialchars ($_POST['ticket_start_date'][$k]); ?>" name="ticket_start_date[<?php echo $k; ?>]" class="input-medium datetimepicker ticket-start-date">
                                                    <select id="time_hour" class="input-mini ticket-start-hour" name="ticket_start_hour[<?php echo $k; ?>]">
                                                        <?php for ($i = 0; $i < 24; $i++): ?>
                                                            <option <?php if (isset($_POST['ticket_start_hour'][$k]) && $_POST['ticket_start_hour'][$k] == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                    <select id="time_min" class="input-mini ticket-start-minute" name="ticket_start_minute[<?php echo $k; ?>]">
                                                        <?php for ($i = 0; $i < 60; $i++): ?>
                                                            <option <?php if (isset($_POST['ticket_start_minute'][$k]) && $_POST['ticket_start_minute'][$k] == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
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
                                                <p class="end-date-title">Ngày kết thúc</p>

                                                <div data-date-format="mm/dd/yyyy" data-date="" class="input-append date dp3">
                                                    <input type="text" value="<?php if(isset($_POST['ticket_end_date'][$k])) echo htmlspecialchars ($_POST['ticket_end_date'][$k]); ?>" name="ticket_end_date[<?php echo $k; ?>]" class="input-medium ico ico-calendar datetimepicker ticket-end-date">

                                                    <select id="time_hour" class="input-mini ticket-end-hour" name="ticket_end_hour[<?php echo $k; ?>]">
                                                        <?php for ($i = 0; $i < 24; $i++): ?>
                                                            <option <?php if (isset($_POST['ticket_end_hour'][$k]) && $_POST['ticket_end_hour'][$k] == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                    <select id="time_min" class="input-mini ticket-end-minute" name="ticket_end_minute[<?php echo $k; ?>]">
                                                        <?php for ($i = 0; $i < 60; $i++): ?>
                                                            <option <?php if (isset($_POST['ticket_end_minute'][$k]) && $_POST['ticket_end_minute'][$k] == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
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
                                        <label class="control-label" for="address">Số lượng vé mỗi hóa đơn</label>
                                        <div class="controls">
                                            Tối thiểu <input type="text" class="input-mini ticket-min" name="ticket_min[<?php echo $k; ?>]" value="<?php if(isset($_POST['ticket_min'][$k])) echo htmlspecialchars ($_POST['ticket_min'][$k]); ?>">
                                            Tối đa <input type="text" class="input-mini ticket-max" name="ticket_max[<?php echo $k; ?>]" value="<?php if(isset($_POST['ticket_max'][$k])) echo htmlspecialchars ($_POST['ticket_max'][$k]); ?>">
                                        </div>
                                    </div>
                                    
                                    <?php if($ticket_type == "paid"): ?>
                                    <div class="control-group">
                                        <label class="control-label">Phí dịch vụ </label>
                                        <div class="controls">

                                            <label class="radio">
                                                <input type="radio" name="ticket_service_fee[<?php echo $k; ?>]" value="0" class="ticket-service-fee" <?php if(isset($_POST["ticket_service_fee"][$k]) && $_POST["ticket_service_fee"][$k] == 0) echo 'checked'; ?>>
                                                Trừ phí dịch vụ vào giá vé
                                            </label>
                                            <label class="radio">
                                                <input type="radio" name="ticket_service_fee[<?php echo $k; ?>]" value="1" class="ticket-service-fee" <?php if(isset($_POST["ticket_service_fee"][$k]) && $_POST["ticket_service_fee"][$k] == 1) echo 'checked'; ?>>
                                                Cộng phí dịch vụ vào giá vé
                                            </label>
                                        </div>
                                    </div>
                                    <?php endif;?>

                                    <div class="btn-apply clearfix">
                                        <a href="#" class="btn btn-primary pull-right">Áp dụng</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>

                    <?php endforeach; ?>

                <?php endif; ?>
                        
                <tfoot>
                    <tr>
                        <td colspan="8">
                            <div class="tickets-footer">
                                <div class="clearfix" id="event_capacity_container">
                                    <div class="span3" id="event_capacity_label">Tổng số vé
                                        <input type="text" readonly="" class="input-mini total-ticket disabled" name="total_ticket" value="<?php if(isset($_POST['total_ticket'])) echo $_POST['total_ticket'] ?>">
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
            </table>

            <div class="form-actions">        
                <button type="button" class="btn btn-previous">&laquo; Quay lại</button>
                <button style="margin-left: 50px" type="submit" class="btn btn-primary">Thêm</button>
            </div>
        </div> */ ?>

    </div>
</form>

<!-- clone tbody if has ticket -->

<?php /*
<div class="hide">
    <table>
        <tbody class="ticket-info clone paid">
            <tr>
        <input type="hidden" name="" value="paid" class="ticket-id"/>
        <td class="ticket_name"><input type="text" name="" class="input-medium ticket-name"></td>
        <td class="ticket_quantity"><input type="text" placeholder="0" name="" class="input-mini quantity ticket-quantity"></td>
        <td class="ticket_fee"><input type="text" placeholder="0 VNĐ" name="" class="input-mini ticket-fee"></td>
        <td><span class="price ticket-tax">0 VNĐ</span></td>
        <td><span class="price ticket-total">0 VNĐ</span></td>
        <td>
            <select class="ticket-status input-small" name="">
                <?php foreach ($ticket_status as $k => $v): ?>
                    <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                <?php endforeach; ?>
            </select>
        </td>
        <td><a href="#" class="setting">Thiết lập <span class="icon-white ico-hide icon-chevron-down"></span></a></td>
        <td><a href="#" class="remove-ticket"><i class="icon-remove btn-remove"></i></a></td>
        </tr>
        <tr class="description-ticket hide">
            <td colspan="8">
                <div class="control-group">
                    <div class="control-label">
                        Mô tả vé
                    </div>
                    <div class="controls">
                        <textarea name="" rows="3" class="input-xlarge ticket-description"></textarea>
                    </div>
                    <div class="controls">
                        <label class="checkbox">
                            <input type="checkbox" name="" class="ticket-hide-description" checked>
                            Ẩn mô tả vé trên trang Vé Sự Kiện
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Thời gian</label>
                    <div class="controls">

                        <div class="row-fluid ticket-date">
                            <p class="start-date-title">Ngày bắt đầu</p>
                            <div data-date-format="mm/dd/yyyy" data-date="" class="input-append date dp3">
                                <input type="text" value="<?php echo date('d-m-Y'); ?>" name="" class="input-medium datetimepicker ticket-start-date">
                                <select id="time_hour" class="input-mini ticket-start-hour" name="">
                                    <?php for ($i = 0; $i < 24; $i++): ?>
                                        <option <?php if (date("H") == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select id="time_min" class="input-mini ticket-start-minute" name="">
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
                            <p class="end-date-title">Ngày kết thúc</p>

                            <div data-date-format="mm/dd/yyyy" data-date="" class="input-append date dp3">
                                <input type="text" value="<?php echo date('d-m-Y', strtotime("+1 month")); ?>" name="" class="input-medium ico ico-calendar datetimepicker ticket-end-date">

                                <select id="time_hour" class="input-mini ticket-end-hour" name="">
                                    <?php for ($i = 0; $i < 24; $i++): ?>
                                        <option <?php if (date("H") == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select id="time_min" class="input-mini ticket-end-minute" name="">
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
                    <label class="control-label" for="address">Số lượng vé mỗi hóa đơn</label>
                    <div class="controls">
                        Tối thiểu <input type="text" class="input-mini ticket-min" name="" value="1">
                        Tối đa <input type="text" class="input-mini ticket-max" name="">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Phí dịch vụ </label>
                    <div class="controls">

                        <label class="radio">
                            <input type="radio" name="" id="optionsRadios2" value="0" checked class="ticket-service-fee">
                            Trừ phí dịch vụ vào giá vé
                        </label>
                        <label class="radio">
                            <input type="radio" name="" id="optionsRadios1" value="1" class="ticket-service-fee">
                            Cộng phí dịch vụ vào giá vé
                        </label>
                    </div>
                </div>

                <div class="btn-apply clearfix">
                    <a href="#" class="btn btn-primary pull-right">Áp dụng</a>
                </div>
            </td>
        </tr>
        </tbody>
        <tbody class="ticket-info clone free hide">
            <tr>
        <input type="hidden" name="" value="free" class="ticket-id"/>
        <td class="ticket_name"><input type="text" name="" class="input-medium ticket-name"></td>
        <td class="ticket_quantity"><input type="text" placeholder="0" name="" class="input-mini quantity ticket-quantity"></td>
        <td class="ticket_fee" colspan="3" class="input-mini">Miễn phí</td>
        <td>
            <select class="ticket-status input-small" name="">
                <?php foreach ($ticket_status as $k => $v): ?>
                    <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                <?php endforeach; ?>
            </select>
        </td>
        <td><a href="JavaScript:void(0);" class="setting">Thiết lập <span class="icon-chevron-down icon-white ico-hide"></span></a></td>
        <td><a href="#" class="remove-ticket"><i class="icon-remove btn-remove"></i></a></td>
        </tr>
        <tr class="description-ticket hide">
            <td colspan="8">
                <div class="control-group">
                    <div class="control-label">
                        Mô tả vé
                    </div>
                    <div class="controls">
                        <textarea name="" rows="3" class="input-xlarge ticket-description"></textarea>
                    </div>
                    <div class="controls">
                        <label class="checkbox">
                            <input type="checkbox" class="ticket-hide-description" name="" checked>
                            Ẩn mô tả vé trên trang Vé Sự Kiện
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Thời gian</label>
                    <div class="controls">

                        <div class="row-fluid ticket-date">
                            <p class="start-date-title">Ngày bắt đầu</p>
                            <div data-date-format="mm/dd/yyyy" data-date="" class="input-append date dp3">
                                <input type="text" value="<?php echo date('d-m-Y'); ?>" name="" class="input-medium datetimepicker ticket-start-date">
                                <select id="time_hour" class="input-mini ticket-start-hour" name="">
                                    <?php for ($i = 0; $i < 24; $i++): ?>
                                        <option <?php if (date("H") == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select id="time_min" class="input-mini ticket-start-minute" name="">
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
                            <p class="end-date-title">Ngày kết thúc</p>


                            <div data-date-format="mm/dd/yyyy" data-date="" class="input-append date dp3">
                                <input type="text" value="<?php echo date('d-m-Y', strtotime("+1 month")); ?>" name="" class="input-medium ico ico-calendar datetimepicker ticket-end-date">

                                <select id="time_hour" class="input-mini ticket-end-hour" name="">
                                    <?php for ($i = 0; $i < 24; $i++): ?>
                                        <option <?php if (date("H") == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select id="time_min" class="input-mini ticket-end-minute" name="">
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
                    <label class="control-label" for="address">Số lượng vé mỗi hóa đơn</label>
                    <div class="controls">
                        Tối thiểu <input type="text" class="input-mini ticket-min" name="" value="1">
                        Tối đa <input type="text" class="input-mini ticket-max" name="">
                    </div>
                </div>

                <div class="btn-apply clearfix">
                    <a href="#" class="btn btn-primary pull-right">Áp dụng</a>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<!-- end clone -->
 * 
 * 
 */?>