<?php
$cities = Helper::cities();
$ticket_status = Helper::ticket_status();
?>
<div class="row">
    <div class="container">
        <div class="span12">
            <div class="row-fluid create-magu">
                <div class="row-fluid submit-bar">
                    <div class="pages span7 clearfix">
                        <ul class="nav nav-tabs">
                            <li class="<?php if ($type == "general") echo 'active'; ?>">
                                <a href="<?php echo Yii::app()->request->baseUrl ?>/event/edit/id/<?php echo $event['id'] ?>/type/general" ><i class="icon-pencil"></i>Thông tin Sự kiện</a>
                                <div class="arrow"></div>
                            </li>
                            <li class="<?php if ($type == "ticket") echo 'active'; ?>">

                                <a href="<?php echo Yii::app()->request->baseUrl ?>/event/edit/id/<?php echo $event['id'] ?>/type/ticket" ><i class="icon-book"></i>Vé</a>
                                <div class="arrow"></div>
                            </li>
                        </ul>
                    </div>
                    <div class="action span5">
                        <!--<button class="btn btn-large">Save</button>
                        <button class="btn btn-large">Preview</button>
                        <a href="#" class="btn-style make_event_live btn-save button-medium">Cập nhật</a> -->
                    </div>
                </div>
                <div class="tab-content">
                    <?php if ($type == "general"): ?>
                        <div id="tab1" class="tab-pane active">
                            <form class="form-horizontal form-create-magu" method="post" enctype="multipart/form-data" id="event_form">
                                <input type="hidden" name="location_id" value="<?php echo isset($_POST['location_id']) ? $_POST['location_id'] : $event['location_id'] ?>"/>
                                <div class="row-fluid content">
                                    <?php echo Helper::print_error($message); ?>
                                    <?php echo Helper::print_success($message); ?>
                                    <div class="span10 form-magu">

                                        <fieldset>
                                            <div class="step"> <div class="number">1</div>
                                                <h3>Thông tin Sự kiện</h3>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="title">Tên Sự kiện<div class="required">*</div></label>
                                                <div class="controls"><input type="text" class="input-xlarge span11" name="title" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : htmlspecialchars($event['title']); ?>"></div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="location">Địa điểm<div class="required">*</div></label>
                                                <div class="controls">
                                                    <input type="text" id="add_location" class="input-xlarge span11" name="location" value="<?php echo isset($_POST['location']) ? htmlspecialchars($_POST['location']) : htmlspecialchars($event['location']); ?>">
                                                    <img class="loading-location hide" src="<?php echo Yii::app()->request->baseUrl ?>/img/ajax-big-roller.gif" />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="address">Địa chỉ</label>
                                                <div class="controls"><input type="text" class="input-xlarge span11" name="address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : htmlspecialchars($event['address']); ?>"></div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Thành phố</label>
                                                <div class="controls">
                                                    <select name="city">
                                                        <?php foreach ($cities as $k => $v): ?>
                                                            <option <?php if (isset($_POST['city']) && $_POST['city'] == $v) echo 'selected'; else if ($event['city'] == $v) echo 'selected'; ?> value="<?php echo $v; ?>"><?php echo $v; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Thời gian<div class="required">*</div></label>
                                                <div class="controls">

                                                    <div class="row-fluid">
                                                        <p class="start-date-title">Ngày bắt đầu</p>
                                                        <div class="input-append date dp3" data-date-format="mm/dd/yyyy">
                                                            <input type="text" class="input-medium ico ico-calendar datetimepicker" name="start_date" value="<?php if (isset($_POST['start_date'])) echo $_POST['start_date']; else echo date('d-m-Y',strtotime($event['start_time'])); ?>">

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
                                                                <input type="checkbox" name="display_start_time" value="1" <?php if (isset($_POST['display_start_time'])) echo 'checked'; else if ($event['display_start_time']) echo 'checked'; ?>>
                                                                Hiện thời gian
                                                            </label>
                                                        </div>

                                                    </div>

                                                    <div class="row-fluid">
                                                        <p class="end-date-title">Ngày kết thúc</p>

                                                        <div class="input-append date dp3" data-date-format="mm/dd/yyyy">
                                                            <input type="text" class="input-medium ico ico-calendar datetimepicker" name="end_date" value="<?php if (isset($_POST['end_date'])) echo $_POST['end_date']; else echo date('d-m-Y',strtotime($event['end_time'])); ?>">

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
                                                                <input type="checkbox" name="display_end_time" value="1" <?php if (isset($_POST['display_end_time'])) echo 'checked'; else if ($event['display_end_time']) echo 'checked'; ?>>
                                                                Hiện thời gian
                                                            </label>
                                                            <label class="checkbox inline">
                                                                <input type="checkbox" value="1" name="is_repeat" <?php if (isset($_POST['is_repeat'])) echo 'checked';else if ($event['is_repeat']) echo 'checked'; ?>>
                                                                Lập lại sự kiện
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>


                                            </div>

                                            <div class="control-group upload">
                                                <label class="control-label" for="title">Upload hình đại diện</label>
                                                <div class="controls">
                                                    <?php if ($event['img'] == ""): ?>
                                                        <img class="image-default" src="<?php echo Yii::app()->request->baseUrl; ?>/img/default_upload_logo.gif" />
                                                    <?php else: ?>
                                                        <img class="image-default default hide" src="<?php echo Yii::app()->request->baseUrl; ?>/img/default_upload_logo.gif" />
                                                        <img class="image-default waiting hide" src="<?php echo Yii::app()->request->baseUrl; ?>/img/ajax-big-roller.gif" />
                                                        <img class="image-default thumbnail" src="<?php echo HelperApp::get_thumbnail($event['thumbnail']); ?>" />
                                                    <?php endif; ?>
                                                    <p class="help-block">Hình ảnh định dạng JPG, PNG, GIF phải lơn hơn kích thước 300x300px và dung lượng nhỏ hơn 2MB</p>
                                                    <input class="fileupload customfile-input" class="input-xlarge" name="file" type="file">
                                                </div>
                                                <!--
                                                <div class="controls"><button class="btn btn-primary" type="button">Upload</button></div> -->
                                                <?php if ($event['img'] != ""): ?>
                                                    <div class="controls" style="margin-top: 10px"><a href="<?php echo Yii::app()->request->baseUrl; ?>/event/remove_thumb/id/<?php echo $event['id'] ?>" class="btn btn-large remove-event-thumb">Xóa</a></div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Nội dung Sự kiện  <!--<label class="control-label add-faq"> <a href="">+Add FAQs</a></label>--></label>
                                                <div class="control-group text">
                                                    <div class="controls">
                                                        <textarea cols="150" rows="15" name="description" class="tinymce"><?php echo isset($_POST['description']) ? $_POST['description'] : $event['description']; ?></textarea>
                                                    </div>          
                                                </div>
                                            </div>                                        

                                            <div class="ticket-ridges"></div>

                                            <div class="step"> 
                                                <div class="number">2</div>
                                                <h3>Thiết lập</h3>
                                            </div>

                                            <div class="control-group">
                                                <label for="select01" class="control-label">Cho phép mọi người đăng ký</label>
                                                <div class="controls">
                                                    <select name="published">
                                                        <option <?php if (isset($_POST['published']) && $_POST['published']) echo 'selected';else if ($event['published']) echo 'selected'; ?> value="1">Có</option>
                                                        <option <?php if (isset($_POST['published']) && !$_POST['published']) echo 'selected';else if (!$event['published']) echo 'selected'; ?> value="0">Không</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Thể loại</label>
                                                <div class="controls">
                                                    <select name="primary_cate">

                                                        <option value="0">Thể loại chính</option>                                                    
                                                        <?php foreach ($categories as $k => $v): ?>                
                                                            <option <?php if (isset($_POST['primary_cate']) && $_POST['primary_cate'] == $v['id']) echo 'selected'; else if ($event['categories']['primary']['id'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id'] ?>"><?php echo $v['title']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <select name="second_cate">

                                                        <option value="0">Thể loại phụ</option>                                                    
                                                        <?php foreach ($categories as $k => $v): ?>                
                                                            <option <?php if (isset($_POST['second_cate']) && $_POST['second_cate'] == $v['id']) echo 'selected'; else if (isset($event['categories']['second']) && $event['categories']['second']['id'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id'] ?>"><?php echo $v['title']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label for="optionsCheckbox" class="control-label">Số lượng vé còn lại</label>
                                                <div class="controls">
                                                    <label class="checkbox">
                                                        <input type="checkbox" value="1" name="show_tickets" <?php if (isset($_POST['show_tickets'])) echo 'checked';else if ($event['show_tickets']) echo 'checked'; ?> >
                                                        Hiển thị số lượng vé còn lại trên trang đăng ký vé
                                                    </label>
                                                </div>
                                            </div>

                                            <?php /*
                                              <div class="control-group">
                                              <label for="appendedInput" class="control-label">Customize Web Address</label>
                                              <div class="controls">
                                              <div class="input-append">
                                              <input type="text" size="16" id="appendedInput" class="span7"><span class="add-on">.eventbrite.com</span>
                                              </div>
                                              </div>
                                              </div> */ ?>

                                        </fieldset>

                                    </div>
                                </div>
                            </form>
                        </div>                    
                    <?php endif; ?>

                    <?php if ($type == "ticket"): ?>
                        <div class="tab-pane active" id="tab2">
                            <div class="row-fluid content" >
                                <div class="alert alert-error hide">
                                    <button type = "button" class = "close" data-dismiss = "alert">×</button>
                                    <h4>Lỗi!</h4>
                                    <div class="msg">

                                    </div>
                                </div>

                                <div class="alert alert-success hide">
                                    <button type = "button" class = "close" data-dismiss = "alert">×</button>
                                    <h4>Chúc mừng!</h4>
                                    <div class="msg">

                                    </div>
                                </div>
                                <div class="span10 form-magu">

                                    <div class="step"> <div class="number">3</div>
                                        <h3>Thông tin Vé</h3>
                                    </div>
                                    <div class="add_ticket_container">
                                        <span class="add_ticket_text">Loại vé:</span>
                                        <a class=" btn button-medium btn-donate eb_button small default add_ticket_class btn-ticket free">Miễn phí</a>
                                        <a class="btn-style button-medium eb_button small go add_ticket_class btn-ticket paid">Trả phí</a>

                                    </div>
                                    <div class="form-ticket" id="event_form">    
                                        <?php foreach ($ticket_types as $k => $v): ?>
                                            <form class="form-horizontal table-ticket <?php echo $v['type'] ?>" method="post" enctype="multipart/form-data" action="<?php echo Yii::app()->request->baseUrl ?>/event/edit_ticket_type/id/<?php echo $v['id']; ?>">           
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th class="head-ticket-name">Tên vé</th>
                                                            <th class="head-ticket-quantity">Số lượng</th>
                                                            <th class="head-ticket-price <?php echo $v['type'] ?>">Giá vé</th>
                                                            <?php if ($v['type'] == "paid"): ?>
                                                                <th>Phí</th>
                                                                <th>Tổng cộng</th>
                                                            <?php endif; ?>
                                                            <th class="head-ticket-status">Tình trạng vé</th>
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
                                                        <td class="ticket_fee"><input type="text" placeholder="0 VNĐ" name="ticket_fee" class="input-mini ticket-fee" value="<?php echo htmlspecialchars(number_format($v['price'], 0, '', '')); ?>"></td>
                                                        <td><span class="price ticket-tax"><?php echo number_format($v['tax']) ?> VNĐ</span></td>
                                                        <?php $total = $v['service_fee'] ? $v['price'] * $v['quantity'] + $v['tax'] : $v['price'] * $v['quantity']; ?>
                                                        <td><span class="price ticket-total"><?php echo number_format($total) ?> VNĐ</span></td>
                                                    <?php else: ?>
                                                        <td class="ticket_fee" class="input-mini">Miễn phí</td>
                                                    <?php endif; ?>

                                                    <td>
                                                        <select class="ticket-status input-small" name="ticket_status">
                                                            <?php foreach ($ticket_status as $tkey => $ts): ?>
                                                                <option <?php if ($v['ticket_status'] == $tkey) echo 'selected'; ?> value="<?php echo $tkey; ?>"><?php echo $ts; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </td>
                                                    <td><a href="#" class="setting">Thiết lập <span class="icon-white ico-hide icon-chevron-down"></span></a></td>
                                                    <td>
                                                        <a href="#" class="apply-ticket icon btn btn-warning">Sửa</a>                        
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo Yii::app()->request->baseUrl ?>/event/delete_ticket_type/id/<?php echo $v['id']; ?>" class="remove-ticket btn btn-danger">Xóa</a>                        
                                                    </td>
                                                    </tr>
                                                    <tr class="description-ticket hide">
                                                        <td colspan="9">
                                                            <div class="control-group">
                                                                <div class="control-label">
                                                                    Mô tả vé
                                                                </div>
                                                                <div class="controls">
                                                                    <textarea name="ticket_description" rows="5" cols="10" class="input-xxlarge ticket-description"><?php echo $v['description']; ?></textarea>
                                                                </div>
                                                                <div class="controls">
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="ticket_hide_description" class="ticket-hide-description" <?php if ($v['hide_description']) echo 'checked'; ?>>
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
                                                                            <input type="text" value="<?php echo htmlspecialchars(date('d-m-Y', strtotime($v['sale_start']))); ?>" name="ticket_start_date" class="input-medium ico ico-calendar datetimepicker ticket-start-date">
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
                                                                        <p class="end-date-title">Ngày kết thúc</p>

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
                                                                <label class="control-label" for="address">Số lượng vé mỗi hóa đơn</label>
                                                                <div class="controls">
                                                                    Tối thiểu <input type="text" class="input-mini ticket-min" name="ticket_min" value="<?php echo htmlspecialchars($v['minimum']); ?>">
                                                                    Tối đa <input type="text" class="input-mini ticket-max" name="ticket_max" value="<?php echo htmlspecialchars($v['maximum']); ?>">
                                                                </div>
                                                            </div>

                                                            <?php if ($v['type'] == "paid"): ?>
                                                                <div class="control-group">
                                                                    <label class="control-label">Phí dịch vụ </label>
                                                                    <div class="controls">

                                                                        <label class="radio">
                                                                            <input type="radio" name="ticket_service_fee" value="0" class="ticket-service-fee" <?php if (!$v["service_fee"]) echo 'checked'; ?>>
                                                                            Trừ phí dịch vụ vào giá vé
                                                                        </label>
                                                                        <label class="radio">
                                                                            <input type="radio" name="ticket_service_fee" value="1" class="ticket-service-fee" <?php if ($v["service_fee"]) echo 'checked'; ?>>
                                                                            Cộng phí dịch vụ vào giá vé
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>

                                                            <div class="btn-apply clearfix">
                                                                <a href="#" class="btn btn-warning pull-right apply-ticket">Sửa</a>
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
                                </div>
                            </div>

                            <!-- clone tbody if has ticket -->
                            <div class="hide">
                                <form class="form-horizontal table-ticket clone paid hide" method="post" enctype="multipart/form-data" action="<?php echo Yii::app()->request->baseUrl ?>/event/add_ticket_type/">           
                                    <table class="table table-bordered table-striped ">
                                        <thead>
                                            <tr>
                                                <th class="head-ticket-name">Tên vé</th>
                                                <th class="head-ticket-quantity">Số lượng</th>
                                                <th class="head-ticket-price">Giá vé</th>
                                                <th>Phí</th>
                                                <th>Tổng cộng</th>
                                                <th class="head-ticket-status">Tình trạng vé</th>
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
                                        <td class="ticket_fee"><input type="text" placeholder="0 VNĐ" name="ticket_fee" class="input-mini ticket-fee"></td>
                                        <td><span class="price ticket-tax">0.00 VNĐ</span></td>
                                        <td><span class="price ticket-total">0.00 VNĐ</span></td>
                                        <td>
                                            <select class="ticket-status input-small" name="ticket_status">
                                                <?php foreach ($ticket_status as $k => $v): ?>
                                                    <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td><a href="#" class="setting">Thiết lập <span class="icon-white ico-hide icon-chevron-down"></span></a></td>
                                        <td>
                                            <a href="#" class="apply-ticket btn btn-info">Thêm</a>
                                            <img class="waiting hide" src="<?php echo Yii::app()->request->baseUrl ?>/img/ajax-circle-ball.gif" style="vertical-align: middle"/>
                                        </td>
                                        <td>
                                            <a href="#" class="remove-ticket clone btn btn-danger">Xóa</a>
                                            <img class="waiting hide" src="<?php echo Yii::app()->request->baseUrl ?>/img/ajax-circle-ball.gif" style="vertical-align: middle"/>
                                        </td>
                                        </tr>
                                        <tr class="description-ticket hide">
                                            <td colspan="9">
                                                <div class="control-group">
                                                    <div class="control-label">
                                                        Mô tả vé
                                                    </div>
                                                    <div class="controls">
                                                        <textarea name="ticket_description" rows="5" cols="10" class="input-xxlarge ticket-description"></textarea>
                                                    </div>
                                                    <div class="controls">
                                                        <label class="checkbox">
                                                            <input type="checkbox" name="ticket_hide_description" class="ticket-hide-description" checked>
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
                                                                <input type="text" value="<?php echo date('d-m-Y'); ?>" name="ticket_start_date" class="input-medium ico ico-calendar datetimepicker ticket-start-date">
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
                                                            <p class="end-date-title">Ngày kết thúc</p>

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
                                                    <label class="control-label" for="address">Số lượng vé mỗi hóa đơn</label>
                                                    <div class="controls">
                                                        Tối thiểu <input type="text" class="input-mini ticket-min" name="ticket_min" value="1">
                                                        Tối đa <input type="text" class="input-mini ticket-max" name="ticket_max">
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Phí dịch vụ </label>
                                                    <div class="controls">

                                                        <label class="radio">
                                                            <input type="radio" name="ticket_service_fee" value="0" checked class="ticket-service-fee">
                                                            Trừ phí dịch vụ vào giá vé
                                                        </label>
                                                        <label class="radio">
                                                            <input type="radio" name="ticket_service_fee" value="1" class="ticket-service-fee">
                                                            Cộng phí dịch vụ vào giá vé
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="btn-apply clearfix">
                                                    <a href="#" class="btn btn-info pull-right apply-ticket">Thêm</a>
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
                                                <th class="head-ticket-name">Tên vé</th>
                                                <th class="head-ticket-quantity">Số lượng</th>
                                                <th class="head-ticket-price free">Giá vé</th>

                                                <th class="head-ticket-status">Tình trạng vé</th>
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
                                        <td class="ticket_fee"class="input-mini">Miễn phí</td>
                                        <td>
                                            <select class="ticket-status input-small" name="ticket_status">
                                                <?php foreach ($ticket_status as $k => $v): ?>
                                                    <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td><a href="JavaScript:void(0);" class="setting">Thiết lập <span class="icon-chevron-down icon-white ico-hide"></span></a></td>
                                        <td>
                                            <a href="#" class="apply-ticket btn btn-info">Thêm</a>
                                            <img class="waiting hide" src="<?php echo Yii::app()->request->baseUrl ?>/img/ajax-circle-ball.gif" style="vertical-align: middle"/>
                                        </td>
                                        <td>
                                            <a href="#" class="remove-ticket clone btn btn-danger">Xóa</a>
                                            <img class="waiting hide" src="<?php echo Yii::app()->request->baseUrl ?>/img/ajax-circle-ball.gif" style="vertical-align: middle"/>
                                        </td>
                                        </tr>
                                        <tr class="description-ticket hide">
                                            <td colspan="9">
                                                <div class="control-group">
                                                    <div class="control-label">
                                                        Mô tả vé
                                                    </div>
                                                    <div class="controls">
                                                        <textarea name="ticket_description" rows="5" cols="10" class="input-xxlarge ticket-description"></textarea>
                                                    </div>
                                                    <div class="controls">
                                                        <label class="checkbox">
                                                            <input type="checkbox" class="ticket-hide-description" name="ticket_hide_description" checked>
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
                                                                <input type="text" value="<?php echo date('d-m-Y'); ?>" name="ticket_start_date" class="input-medium ico ico-calendar datetimepicker ticket-start-date">
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
                                                            <p class="end-date-title">Ngày kết thúc</p>


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
                                                    <label class="control-label" for="address">Số lượng vé mỗi hóa đơn</label>
                                                    <div class="controls">
                                                        Tối thiểu <input type="text" class="input-mini ticket-min" name="ticket_min" value="1">
                                                        Tối đa <input type="text" class="input-mini ticket-max" name="ticket_max">
                                                    </div>
                                                </div>

                                                <div class="btn-apply clearfix">
                                                    <a href="#" class="btn btn-info pull-right apply-ticket">Thêm</a>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>

                                    </table>
                                </form>
                            </div>
                            <!-- end clone -->
                        </div>
                    <?php endif; ?>
                </div>
                <div id="footer_buttons">
                    <!--
                    <div class="exit">
                        Prefer to create events on the old design?
                        <a href="#">Switch back</a>
                        to the original layout.
                    </div> -->
                    <div class="f-btn-area clearfix">
                        <!--
                        <button class="btn btn-large">Save</button>
                        <button class="btn btn-large">Preview</button> -->
                        <?php if ($type != "ticket"): ?>
                            <a href="#" class="btn-style make_event_live btn-save button-medium">Cập nhật</a>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>     
    </div>
</div>