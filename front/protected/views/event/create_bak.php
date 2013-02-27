<div class="row">
    <div class="container">
        <div class="span12">
            <div class="row-fluid create-magu">
                <div class="row-fluid submit-bar">
                    <div class="pages span7 clearfix">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab1" class="" data-toggle="tab"><i class="icon-pencil"></i>Chi tiết Sự kiện</a>
                                <div class="arrow"></div>
                            </li>
                            <li class="">

                                <a href="#tab2" class="" data-toggle="tab"><i class="icon-search"></i>Xem trước Sự kiện</a>
                                <div class="arrow"></div>
                            </li>
                        </ul>
                    </div>
                    <div class="action span5">
                        <button class="btn btn-large">Save</button>
                        <button class="btn btn-large">Preview</button>
                        <a href="#" class="btn-style make_event_live btn-save button-medium">Make Event Live</a>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="tab1" class="tab-pane active">
                        <form class="form-horizontal form-create-magu">
                            <div class="row-fluid content">
                                <div class="span10 form-magu">

                                    <fieldset>
                                        <div class="step"> <div class="number">1</div>
                                            <h3>Thông tin Sự kiện</h3>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="title">Tên Sự kiện<div class="required">*</div></label>
                                            <div class="controls"><input type="text" class="input-xlarge span11" name="title" id="title"></div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="location">Địa điểm<div class="required">*</div></label>
                                            <div class="controls"><input type="text" class="input-xlarge span11" name="location" id="location"></div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="address">Địa chỉ</label>
                                            <div class="controls"><input type="text" class="input-xlarge span11" name="address" id="address"></div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Thời gian<div class="required">*</div></label>
                                            <div class="controls">

                                                <div class="row-fluid">
                                                    <p class="start-date-title">Ngày bắt đầu</p>
                                                    <div class="input-append date dp3" data-date="<?php if (isset($item->datetime)) echo date('m/d/Y', $item->datetime); ?>" data-date-format="mm/dd/yyyy">
                                                        <input id="start_date" type="text" class="input-medium ico ico-calendar" name="datetime" value="<?php if (isset($item->datetime)) echo date('m/d/Y', $item->datetime); ?>">

                                                        <select name="time_hour" class="input-mini" id="time_hour">
                                                            <?php
                                                            for ($i = 0; $i <= 12; $i++) {
                                                                ?>
                                                                <option value="<?php echo $i; ?>" <?php if (isset($item->datetime) && intval(date('h', $item->datetime)) == $i) echo 'selected='; ?>><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <select name="time_min" class="input-mini" id="time_min">
                                                            <?php
                                                            for ($i = 0; $i <= 59; $i++) {
                                                                ?>
                                                                <option value="<?php echo $i; ?>" <?php if (isset($item->datetime) && intval(date('i', $item->datetime)) == $i) echo 'selected'; ?>><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <select name="time_am" class="input-mini" id="time_am">
                                                            <option value="am" <?php if (isset($item->datetime) && date('a', $item->datetime) == 'am') echo 'selected'; ?>>sáng</option>
                                                            <option value="pm" <?php if (isset($item->datetime) && date('a', $item->datetime) == 'pm') echo 'selected'; ?>>chiều</option>
                                                        </select>
                                                        <label class="checkbox inline">
                                                            <input type="checkbox" value="show" id="show_time">
                                                            Hiện thời gian
                                                        </label>
                                                    </div>

                                                </div>

                                                <div class="row-fluid">
                                                    <p class="end-date-title">Ngày kết thúc</p>


                                                    <div class="input-append date dp3" data-date="<?php if (isset($item->datetime)) echo date('m/d/Y', $item->datetime); ?>" data-date-format="mm/dd/yyyy">
                                                        <input id="end_date" type="text" class="input-medium ico ico-calendar" name="datetime" value="<?php if (isset($item->datetime)) echo date('m/d/Y', $item->datetime); ?>">

                                                        <select name="time_hour" class="input-mini" id="time_hour">
                                                            <?php
                                                            for ($i = 0; $i <= 12; $i++) {
                                                                ?>
                                                                <option value="<?php echo $i; ?>" <?php if (isset($item->datetime) && intval(date('h', $item->datetime)) == $i) echo 'selected='; ?>><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <select name="time_min" class="input-mini" id="time_min">
                                                            <?php
                                                            for ($i = 0; $i <= 59; $i++) {
                                                                ?>
                                                                <option value="<?php echo $i; ?>" <?php if (isset($item->datetime) && intval(date('i', $item->datetime)) == $i) echo 'selected'; ?>><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <select name="time_am" class="input-mini" id="time_am">
                                                            <option value="am" <?php if (isset($item->datetime) && date('a', $item->datetime) == 'am') echo 'selected'; ?>>sáng</option>
                                                            <option value="pm" <?php if (isset($item->datetime) && date('a', $item->datetime) == 'pm') echo 'selected'; ?>>chiều</option>
                                                        </select>
                                                        <label class="checkbox inline">
                                                            <input type="checkbox" value="show" id="show_time">
                                                            Hiện thời gian
                                                        </label>
                                                        <label class="checkbox inline">
                                                            <input type="checkbox" value="repeat" id="repeat">
                                                            This event repeats
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>


                                        </div>

                                        <div class="control-group upload">
                                            <label class="control-label" for="title">Upload hình đại diện</label>
                                            <div class="controls">
                                                <img class="image-default" src="<?php echo Yii::app()->request->baseUrl; ?>/img/default_upload_logo.gif" />
                                                <p class="help-block">Your image must be JPG, GIF, or PNG format and not exceed 2MB. It will be resized to make its width 450px.</p>
                                                <input class="fileupload customfile-input" class="input-xlarge" name="img" type="file">
                                            </div>
                                            <div class="controls"><button class="btn btn-primary" type="button">Upload</button></div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label ">Nội dung Sự kiện  <label class="control-label add-faq"><a href="">+Add FAQs</a></label></label>
                                            <div class="control-group text">
                                                <div class="controls">
                                                    <textarea name="content_magu" cols="100" rows="15" id="mce-content-magu" ><?php if (isset($item->content)) echo $item->content; ?></textarea>
                                                </div>          
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="title">Người tổ chức Sự kiện</label>
                                            <div class="controls host"><input type="text" class="input-xlarge" name="host" id="title"></div>
                                            <div class="control-group text">
                                                <div class="controls">
                                                    <textarea name="content_host" cols="100" rows="15" id="mce-content-host" ><?php if (isset($item->content)) echo $item->content; ?></textarea>
                                                </div>          
                                            </div>
                                        </div>

                                        <!--Step 2-->
                                        <div class="ticket-ridges"></div>
                                        <div class="step"> 
                                            <div class="number">2</div>
                                            <h3>Thông tin vé</h3>
                                        </div>

                                        <div class="add_ticket_container">
                                            <span class="add_ticket_text">Add a ticket:</span>
                                            <a data-type="paid" class="btn-style button-medium eb_button small go add_ticket_class">Paid</a>
                                            <a data-type="free" class=" btn-style button-medium eb_button small go add_ticket_class">Free</a>
                                            <a data-type="donation" class="btn button-medium btn-donate eb_button small default add_ticket_class">Donation</a>
                                        </div>

                                        <div class="form-ticket">    
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Tên vé</th>
                                                        <th>Số lượng vé</th>
                                                        <th>Giá vé</th>
                                                        <th>Phí</th>
                                                        <th>Tổng cộng</th>
                                                        <th>Tình trạng vé</th>
                                                        <th colspan="2"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="ticket_name">
                                                            <input id="ticket_name" name="ticket_name" type="text">
                                                        </td>
                                                        <td class="ticket_quantity">
                                                            <input class="input-small" id="ticket_quantity" name="ticket_quantity" type="text" placeholder="100">
                                                        </td>
                                                        <td class="ticket_fee">
                                                            <input class="input-small" id="ticket_fee" name="ticket_fee" type="text" placeholder="$ 0.00">
                                                        </td>
                                                        <td>
                                                            <span class="price">$  0.00</span>
                                                        </td>
                                                        <td>
                                                            <span class="price">$  0.00</span>
                                                        </td>
                                                        <td>
                                                            <span class="price">Chưa hết vé</span>
                                                        </td>
                                                        <td>
                                                            <a class="setting" href="JavaScript:void(0);">Thiết lập <span class="icon-chevron-down icon-white ico-hide"></span></a>
                                                        </td>
                                                        <td>
                                                            <i class="icon-remove btn-remove"></i>
                                                        </td>
                                                    </tr>
                                                    <tr class="description-ticket">
                                                        <td colspan="8">
                                                            <div class="control-group">
                                                                <div class="control-label">
                                                                    Mô tả vé
                                                                </div>
                                                                <div class="controls">
                                                                    <textarea class="input-xlarge"  rows="3" name="description_ticket" id="description_ticket"></textarea>
                                                                </div>
                                                                <div class="controls">
                                                                    <label class="checkbox">
                                                                        <input id="hide-description-ticket" type="checkbox">
                                                                        Ẩn mô tả vé trên trang Sự kiện
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">Thời gian</label>
                                                                <div class="controls">

                                                                    <div class="row-fluid">
                                                                        <p class="start-date-title">Ngày bắt đầu</p>
                                                                        <div class="input-append date dp3" data-date="<?php if (isset($item->datetime)) echo date('m/d/Y', $item->datetime); ?>" data-date-format="mm/dd/yyyy">
                                                                            <input id="sale-start" type="text" class="input-medium ico ico-calendar" name="datetime" value="<?php if (isset($item->datetime)) echo date('m/d/Y', $item->datetime); ?>">

                                                                            <select name="time_hour" class="input-mini" id="time_hour">
                                                                                <?php
                                                                                for ($i = 0; $i <= 12; $i++) {
                                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>" <?php if (isset($item->datetime) && intval(date('h', $item->datetime)) == $i) echo 'selected='; ?>><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <select name="time_min" class="input-mini" id="time_min">
                                                                                <?php
                                                                                for ($i = 0; $i <= 59; $i++) {
                                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>" <?php if (isset($item->datetime) && intval(date('i', $item->datetime)) == $i) echo 'selected'; ?>><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <select name="time_am" class="input-mini" id="time_am">
                                                                                <option value="am" <?php if (isset($item->datetime) && date('a', $item->datetime) == 'am') echo 'selected'; ?>>sáng</option>
                                                                                <option value="pm" <?php if (isset($item->datetime) && date('a', $item->datetime) == 'pm') echo 'selected'; ?>>chiều</option>
                                                                            </select>
                                                                            <!-- 
                                                                            <label class="checkbox inline">
                                                                                <input type="checkbox" value="show" id="show_time">
                                                                                Hiện thời gian
                                                                            </label>
                                                                            -->
                                                                        </div>

                                                                    </div>

                                                                    <div class="row-fluid">
                                                                        <p class="end-date-title">Ngày kết thúc</p>


                                                                        <div class="input-append date dp3" data-date="<?php if (isset($item->datetime)) echo date('m/d/Y', $item->datetime); ?>" data-date-format="mm/dd/yyyy">
                                                                            <input id="sale-end" type="text" class="input-medium ico ico-calendar" name="datetime" value="<?php if (isset($item->datetime)) echo date('m/d/Y', $item->datetime); ?>">

                                                                            <select name="time_hour" class="input-mini" id="time_hour">
                                                                                <?php
                                                                                for ($i = 0; $i <= 12; $i++) {
                                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>" <?php if (isset($item->datetime) && intval(date('h', $item->datetime)) == $i) echo 'selected='; ?>><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <select name="time_min" class="input-mini" id="time_min">
                                                                                <?php
                                                                                for ($i = 0; $i <= 59; $i++) {
                                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>" <?php if (isset($item->datetime) && intval(date('i', $item->datetime)) == $i) echo 'selected'; ?>><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <select name="time_am" class="input-mini" id="time_am">
                                                                                <option value="am" <?php if (isset($item->datetime) && date('a', $item->datetime) == 'am') echo 'selected'; ?>>sáng</option>
                                                                                <option value="pm" <?php if (isset($item->datetime) && date('a', $item->datetime) == 'pm') echo 'selected'; ?>>chiều</option>
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
                                                                <label for="address" class="control-label">Tickets permitted per order</label>
                                                                <div class="controls">
                                                                    Minimum <input type="text"  class="input-mini ">
                                                                    Maximum <input type="text"  class="input-mini ">
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Service Fees </label>
                                                                <div class="controls">
                                                                    <label class="radio">
                                                                        <input type="radio" checked="" value="option1" id="optionsRadios1" name="optionsRadios">
                                                                        Pass on the fees to the ticket buyer
                                                                    </label>
                                                                    <label class="radio">
                                                                        <input type="radio" value="option2" id="optionsRadios2" name="optionsRadios">
                                                                        Absorb the fees into the ticket price
                                                                    </label>
                                                                    <label class="radio">
                                                                        <input type="radio" value="option3" id="optionsRadios3" name="optionsRadios">
                                                                        Absorb credit card fee and pass on Eventbrite fee to the buyer
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="btn-apply clearfix">
                                                                <a class="btn-style button-medium" href="#">Apply</a>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <td class="ticket_name">
                                                            <input id="ticket_name" name="ticket_name" type="text">
                                                        </td>
                                                        <td class="ticket_quantity">
                                                            <input class="input-small" id="ticket_quantity" name="ticket_quantity" type="text" placeholder="100">
                                                        </td>
                                                        <td colspan="3" class="ticket_fee">
                                                            Free
                                                        </td>
                                                        <td>
                                                            <span class="price">Chưa hết vé</span>
                                                        </td>
                                                        <td>
                                                            <a class="setting" href="JavaScript:void(0);">Thiết lập <span class="icon-chevron-down icon-white ico-hide"></span></a>
                                                        </td>
                                                        <td>
                                                            <i class="icon-remove btn-remove"></i>
                                                        </td>
                                                    </tr>
                                                    <tr class="description-ticket">
                                                        <td colspan="8">
                                                            <div class="control-group">
                                                                <div class="control-label">
                                                                    Mô tả vé
                                                                </div>
                                                                <div class="controls">
                                                                    <textarea class="input-xlarge"  rows="3" name="description_ticket" id="description_ticket"></textarea>
                                                                </div>
                                                                <div class="controls">
                                                                    <label class="checkbox">
                                                                        <input id="hide-description-ticket" type="checkbox">
                                                                        Ẩn mô tả vé trên trang Sự kiện
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">Thời gian</label>
                                                                <div class="controls">

                                                                    <div class="row-fluid">
                                                                        <p class="start-date-title">Ngày bắt đầu</p>
                                                                        <div class="input-append date dp3" data-date="<?php if (isset($item->datetime)) echo date('m/d/Y', $item->datetime); ?>" data-date-format="mm/dd/yyyy">
                                                                            <input id="sale-start" type="text" class="input-medium ico ico-calendar" name="datetime" value="<?php if (isset($item->datetime)) echo date('m/d/Y', $item->datetime); ?>">

                                                                            <select name="time_hour" class="input-mini" id="time_hour">
                                                                                <?php
                                                                                for ($i = 0; $i <= 12; $i++) {
                                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>" <?php if (isset($item->datetime) && intval(date('h', $item->datetime)) == $i) echo 'selected='; ?>><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <select name="time_min" class="input-mini" id="time_min">
                                                                                <?php
                                                                                for ($i = 0; $i <= 59; $i++) {
                                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>" <?php if (isset($item->datetime) && intval(date('i', $item->datetime)) == $i) echo 'selected'; ?>><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <select name="time_am" class="input-mini" id="time_am">
                                                                                <option value="am" <?php if (isset($item->datetime) && date('a', $item->datetime) == 'am') echo 'selected'; ?>>sáng</option>
                                                                                <option value="pm" <?php if (isset($item->datetime) && date('a', $item->datetime) == 'pm') echo 'selected'; ?>>chiều</option>
                                                                            </select>
                                                                            <!--                                                                    
                                                                            <label class="checkbox inline">
                                                                               <input type="checkbox" value="show" id="show_time">
                                                                                Hiện thời gian
                                                                            </label>
                                                                            -->
                                                                        </div>

                                                                    </div>

                                                                    <div class="row-fluid">
                                                                        <p class="end-date-title">Ngày kết thúc</p>


                                                                        <div class="input-append date dp3" data-date="<?php if (isset($item->datetime)) echo date('m/d/Y', $item->datetime); ?>" data-date-format="mm/dd/yyyy">
                                                                            <input id="sale-end" type="text" class="input-medium ico ico-calendar" name="datetime" value="<?php if (isset($item->datetime)) echo date('m/d/Y', $item->datetime); ?>">

                                                                            <select name="time_hour" class="input-mini" id="time_hour">
                                                                                <?php
                                                                                for ($i = 0; $i <= 12; $i++) {
                                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>" <?php if (isset($item->datetime) && intval(date('h', $item->datetime)) == $i) echo 'selected='; ?>><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <select name="time_min" class="input-mini" id="time_min">
                                                                                <?php
                                                                                for ($i = 0; $i <= 59; $i++) {
                                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>" <?php if (isset($item->datetime) && intval(date('i', $item->datetime)) == $i) echo 'selected'; ?>><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <select name="time_am" class="input-mini" id="time_am">
                                                                                <option value="am" <?php if (isset($item->datetime) && date('a', $item->datetime) == 'am') echo 'selected'; ?>>sáng</option>
                                                                                <option value="pm" <?php if (isset($item->datetime) && date('a', $item->datetime) == 'pm') echo 'selected'; ?>>chiều</option>
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
                                                                <label for="address" class="control-label">Tickets permitted per order</label>
                                                                <div class="controls">
                                                                    Minimum <input type="text"  class="input-mini ">
                                                                    Maximum <input type="text"  class="input-mini ">
                                                                </div>
                                                            </div>

                                                            <div class="btn-apply clearfix">
                                                                <a class="btn-style button-medium" href="#">Apply</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <td class="ticket_name">
                                                            <input id="ticket_name" name="ticket_name" type="text">
                                                        </td>
                                                        <td class="ticket_quantity">
                                                            <input class="input-small" id="ticket_quantity" name="ticket_quantity" type="text" placeholder="100">
                                                        </td>
                                                        <td colspan="3" class="ticket_fee">
                                                            Donate
                                                        </td>
                                                        <td>
                                                            <span class="price">Chưa hết vé</span>
                                                        </td>
                                                        <td>
                                                            <a class="setting" href="JavaScript:void(0);">Thiết lập <span class="icon-chevron-down icon-white ico-hide"></span></a>
                                                        </td>
                                                        <td>
                                                            <i class="icon-remove btn-remove"></i>
                                                        </td>
                                                    </tr>
                                                    <tr class="description-ticket">
                                                        <td colspan="8">
                                                            <div class="control-group">
                                                                <div class="control-label">
                                                                    Mô tả vé
                                                                </div>
                                                                <div class="controls">
                                                                    <textarea class="input-xlarge"  rows="3" name="description_ticket" id="description_ticket"></textarea>
                                                                </div>
                                                                <div class="controls">
                                                                    <label class="checkbox">
                                                                        <input id="hide-description-ticket" type="checkbox">
                                                                        Ẩn mô tả vé trên trang Sự kiện
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">Thời gian</label>
                                                                <div class="controls">

                                                                    <div class="row-fluid">
                                                                        <p class="start-date-title">Ngày bắt đầu</p>
                                                                        <div class="input-append date dp3" data-date="<?php if (isset($item->datetime)) echo date('m/d/Y', $item->datetime); ?>" data-date-format="mm/dd/yyyy">
                                                                            <input id="sale-start" type="text" class="input-medium ico ico-calendar" name="datetime" value="<?php if (isset($item->datetime)) echo date('m/d/Y', $item->datetime); ?>">

                                                                            <select name="time_hour" class="input-mini" id="time_hour">
                                                                                <?php
                                                                                for ($i = 0; $i <= 12; $i++) {
                                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>" <?php if (isset($item->datetime) && intval(date('h', $item->datetime)) == $i) echo 'selected='; ?>><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <select name="time_min" class="input-mini" id="time_min">
                                                                                <?php
                                                                                for ($i = 0; $i <= 59; $i++) {
                                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>" <?php if (isset($item->datetime) && intval(date('i', $item->datetime)) == $i) echo 'selected'; ?>><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <select name="time_am" class="input-mini" id="time_am">
                                                                                <option value="am" <?php if (isset($item->datetime) && date('a', $item->datetime) == 'am') echo 'selected'; ?>>sáng</option>
                                                                                <option value="pm" <?php if (isset($item->datetime) && date('a', $item->datetime) == 'pm') echo 'selected'; ?>>chiều</option>
                                                                            </select>
                                                                            <!-- 
                                                                            <label class="checkbox inline">
                                                                                <input type="checkbox" value="show" id="show_time">
                                                                                Hiện thời gian
                                                                            </label>
                                                                            -->
                                                                        </div>

                                                                    </div>

                                                                    <div class="row-fluid">
                                                                        <p class="end-date-title">Ngày kết thúc</p>


                                                                        <div class="input-append date dp3" data-date="<?php if (isset($item->datetime)) echo date('m/d/Y', $item->datetime); ?>" data-date-format="mm/dd/yyyy">
                                                                            <input id="sale-end" type="text" class="input-medium ico ico-calendar" name="datetime" value="<?php if (isset($item->datetime)) echo date('m/d/Y', $item->datetime); ?>">

                                                                            <select name="time_hour" class="input-mini" id="time_hour">
                                                                                <?php
                                                                                for ($i = 0; $i <= 12; $i++) {
                                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>" <?php if (isset($item->datetime) && intval(date('h', $item->datetime)) == $i) echo 'selected='; ?>><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <select name="time_min" class="input-mini" id="time_min">
                                                                                <?php
                                                                                for ($i = 0; $i <= 59; $i++) {
                                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>" <?php if (isset($item->datetime) && intval(date('i', $item->datetime)) == $i) echo 'selected'; ?>><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <select name="time_am" class="input-mini" id="time_am">
                                                                                <option value="am" <?php if (isset($item->datetime) && date('a', $item->datetime) == 'am') echo 'selected'; ?>>sáng</option>
                                                                                <option value="pm" <?php if (isset($item->datetime) && date('a', $item->datetime) == 'pm') echo 'selected'; ?>>chiều</option>
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
                                                                <label for="address" class="control-label">Tickets permitted per order</label>
                                                                <div class="controls">
                                                                    Minimum <input type="text"  class="input-mini ">
                                                                    Maximum <input type="text"  class="input-mini ">
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Service Fees </label>
                                                                <div class="controls">
                                                                    <label class="radio">
                                                                        <input type="radio" checked="" value="option1" id="optionsRadios1" name="optionsRadios">
                                                                        Pass on the fees to the ticket buyer
                                                                    </label>
                                                                    <label class="radio">
                                                                        <input type="radio" value="option2" id="optionsRadios2" name="optionsRadios">
                                                                        Absorb the fees into the ticket price
                                                                    </label>
                                                                    <label class="radio">
                                                                        <input type="radio" value="option3" id="optionsRadios3" name="optionsRadios">
                                                                        Absorb credit card fee and pass on Eventbrite fee to the buyer
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="btn-apply clearfix">
                                                                <a class="btn-style button-medium" href="#">Apply</a>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="8">
                                                            <div class="tickets-footer">
                                                                <div id="event_capacity_container" class="clearfix">
                                                                    <div id="event_capacity_label" class="span3">Event Capacity
                                                                        <input type="text"  class="input-mini ">
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
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="optionCheckbox">Tôi muốn</label>
                                            <div class="controls">
                                                <label class="checkbox inline">
                                                    <input checked="checked"  type="radio" value="show"  name="wanted">
                                                    Pass on fees to the buyer 
                                                </label>
                                                <label class="checkbox inline">
                                                    <input type="radio" value="show"  name="wanted">
                                                    Absorb the fees 
                                                </label>
                                                <label class="checkbox inline">
                                                    <input type="radio" value="show"  name="wanted">
                                                    Customize per ticket type 
                                                </label>
                                            </div>
                                        </div>
                                        <!--End Step 2-->

                                        <div class="ticket-ridges"></div>

                                        <div class="step"> 
                                            <div class="number">3</div>
                                            <h3>Promote your Event Page</h3>
                                        </div>

                                        <div class="control-group">
                                            <label for="select01" class="control-label">Publicize, or keep it private</label>
                                            <div class="controls">
                                                <select id="select01">
                                                    <option>Public</option>
                                                    <option>Private</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Search Categories</label>
                                            <div class="controls">
                                                <select id="select02">

                                                    <option value="" selected="selected">Primary Category</option>
                                                    <option value="sales">Business/Finance/Sales</option>
                                                    <option value="seminars">Classes/Workshops</option>
                                                    <option value="comedy">Comedy</option>
                                                    <option value="conferences">Conferences/Seminars</option>
                                                    <option value="conventions">Conventions/Tradeshows/Expos</option>
                                                    <option value="endurance">Endurance</option>
                                                    <option value="fairs">Festivals/Fairs</option>
                                                    <option value="food">Food/Wine</option>
                                                    <option value="fundraisers">Fundraisers/Charities/Giving</option>
                                                    <option value="testing">Just Testing</option>
                                                    <option value="movies">Movies/Film</option>
                                                    <option value="music">Music/Concerts</option>
                                                    <option value="meetings">Networking/Clubs/Associations</option>
                                                    <option value="entertainment">Other Entertainment</option>
                                                    <option value="other">Other Events</option>
                                                    <option value="recreation">Outdoors/Recreation</option>
                                                    <option value="performances">Performing Arts</option>
                                                    <option value="religion">Religion/Spirituality</option>
                                                    <option value="reunions">Schools/Reunions/Alumni</option>
                                                    <option value="social">Social Events/Mixers</option>
                                                    <option value="sports">Sporting Events</option>
                                                    <option value="travel">Travel</option>

                                                </select>
                                                <select id="select03">

                                                    <option value="" selected="selected">Secondary Category</option>
                                                    <option value="sales">Business/Finance/Sales</option>
                                                    <option value="seminars">Classes/Workshops</option>
                                                    <option value="comedy">Comedy</option>
                                                    <option value="conferences">Conferences/Seminars</option>
                                                    <option value="conventions">Conventions/Tradeshows/Expos</option>
                                                    <option value="endurance">Endurance</option>
                                                    <option value="fairs">Festivals/Fairs</option>
                                                    <option value="food">Food/Wine</option>
                                                    <option value="fundraisers">Fundraisers/Charities/Giving</option>
                                                    <option value="testing">Just Testing</option>
                                                    <option value="movies">Movies/Film</option>
                                                    <option value="music">Music/Concerts</option>
                                                    <option value="meetings">Networking/Clubs/Associations</option>
                                                    <option value="entertainment">Other Entertainment</option>
                                                    <option value="other">Other Events</option>
                                                    <option value="recreation">Outdoors/Recreation</option>
                                                    <option value="performances">Performing Arts</option>
                                                    <option value="religion">Religion/Spirituality</option>
                                                    <option value="reunions">Schools/Reunions/Alumni</option>
                                                    <option value="social">Social Events/Mixers</option>
                                                    <option value="sports">Sporting Events</option>
                                                    <option value="travel">Travel</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label for="optionsCheckbox" class="control-label">Remaining Tickets</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <input type="checkbox" value="option1" id="optionsCheckbox">
                                                    Show the number of tickets remaining on the registration page
                                                </label>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label for="appendedInput" class="control-label">Customize Web Address</label>
                                            <div class="controls">
                                                <div class="input-append">
                                                    <input type="text" size="16" id="appendedInput" class="span7"><span class="add-on">.eventbrite.com</span>
                                                </div>
                                            </div>
                                        </div>

                                    </fieldset>

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab2">
                        <article class="preview-page">
                            <section class="choose-themes border-radius">
                                <form class="form-inline">
                                    <div class="row-fluid">
                                        <div class="themes span9">
                                            <p><a class="current" href="javascript:void(0)">Personalize your theme</a> or <a href="javascript:void(0)">modify colors</a></p>
                                            <div class="tab-themes" id="theme_picker">
                                                <ul class="clearfix">
                                                    <li class="active">
                                                        <a href="#">
                                                            <img src="http://www.placehold.it/90x74"/>
                                                            <label>Classic</label>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <img src="http://www.placehold.it/90x74"/>
                                                            <label>Classic</label>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <img src="http://www.placehold.it/90x74"/>
                                                            <label>Classic</label>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <img src="http://www.placehold.it/90x74"/>
                                                            <label>Classic</label>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <img src="http://www.placehold.it/90x74"/>
                                                            <label>Classic</label>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <img src="http://www.placehold.it/90x74"/>
                                                            <label>Classic</label>
                                                        </a>
                                                    </li>
                                                </ul>

                                                <ul class="custom_colors hide clearfix">
                                                    <?php $arr_title = array('Background', 'Body Text', 'Header Text', 'Box Borders', 'Box Background', 'Header Background', 'Links','Event Title'); ?>
                                                    <?php for ($i = 0; $i < 8; $i++): ?>
                                                        <li>
                                                            <div class="bg-title"><?php echo $arr_title[$i]; ?></div>
                                                            <div class="swatch">                                           
                                                                <a class="color color-id-<?php echo $i; ?>" data-toggle="modal" href="#myModal-<?php echo $i ?>" ></a>
                                                            </div>

                                                            <div class="modal hide fade" id="myModal-<?php echo $i ?>">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                                                    <h3>Choose Color</h3>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="Inline"></div>
                                                                </div>
                                                            </div>

                                                        </li>
                                                    <?php endfor; ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="event-logo span3">
                                            <p>Event Logo</p>
                                            <div class="info">Your image must be JPG, GIF, or PNG format and not exceed 2MB. It will be resized to make its width 450px.</div>
                                            <input type="file"/>
                                            <a class="btn" href="#">Upload</a>
                                        </div>
                                    </div>
                                    <div class="additional_options">
                                        <a class="display-attendees" href="#modelAttends" role="button" data-toggle="modal"></a>
                                        <label class="attendees checkbox">
                                            <input id="attendee" type="checkbox">
                                        </label>
                                        Display Attendees

                                        <label class="checkbox">
                                            <input type="checkbox">
                                        </label>
                                        Allow visitors to see which of their Facebook friends are going
                                        <a href="#modelHTML" role="button" class="pull-right" data-toggle="modal">
                                            Add HTML
                                        </a>

                                        <!-- Modal -->
                                        <section class="modal-group">
                                            <div class="modal hide fade modelHTML" id="modelHTML" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h3 id="myModalLabel">Add HTML</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="header">
                                                        <span class="current">Custom Header</span> | <span>Custom Footer</span>
                                                    </div>
                                                    <section class="content-html">
                                                        <div class="html-header">
                                                            <textarea placeholder="Enter HTML and CSS for your custom header"></textarea>
                                                        </div>
                                                        <div class="html-footer hide">
                                                            <textarea placeholder="Enter HTML and CSS for your custom footer"></textarea>
                                                        </div>
                                                    </section>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                                                    <button class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>

                                            <div class="modal hide fade modelAttendee" id="modelAttends" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h3 id="myModalLabel">Display Attendee Information</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <section class="content-attendee">
                                                        <ul class="clearfix">
                                                            <li>
                                                                <input type="checkbox" id="id_group-show_attendees-first_name" name="group-show_attendees-first_name" data-check="{}">
                                                                <label for="id_group-show_attendees-first_name">First Name</label>
                                                            </li>
                                                            <li>
                                                                <input type="checkbox" id="id_group-show_attendees-last_name" name="group-show_attendees-last_name" data-check="{}">
                                                                <label for="id_group-show_attendees-last_name">Last Name</label>
                                                            </li>
                                                            <li>
                                                                <input type="checkbox" id="id_group-show_attendees-ticket" name="group-show_attendees-ticket" data-check="{}">
                                                                <label for="id_group-show_attendees-ticket">Tickets Ordered</label>
                                                                <span class="required">*</span>
                                                            </li>
                                                            <li>
                                                                <input type="checkbox" id="id_group-show_attendees-home_city" name="group-show_attendees-home_city" data-check="{}">
                                                                <label for="id_group-show_attendees-home_city">City (home address)</label>
                                                                <span class="required">*</span>
                                                            </li>
                                                            <li>
                                                                <input type="checkbox" id="id_group-show_attendees-home_state" name="group-show_attendees-home_state" data-check="{}">
                                                                <label for="id_group-show_attendees-home_state">State (home address)</label>
                                                                <span class="required">*</span>
                                                            </li>
                                                            <li>
                                                                <input type="checkbox" id="id_group-show_attendees-work_city" name="group-show_attendees-work_city" data-check="{}">
                                                                <label for="id_group-show_attendees-work_city">City (work address)</label>
                                                                <span class="required">*</span>
                                                            </li>
                                                            <li>
                                                                <input type="checkbox" id="id_group-show_attendees-work_state" name="group-show_attendees-work_state" data-check="{}">
                                                                <label for="id_group-show_attendees-work_state">State (work address)</label>
                                                                <span class="required">*</span>
                                                            </li>
                                                            <li>
                                                                <input type="checkbox" id="id_group-show_attendees-job_title" name="group-show_attendees-job_title" data-check="{}">
                                                                <label for="id_group-show_attendees-job_title">Job Title</label>
                                                                <span class="required">*</span>
                                                            </li>
                                                            <li>
                                                                <input type="checkbox" id="id_group-show_attendees-company" name="group-show_attendees-company" data-check="{}">
                                                                <label for="id_group-show_attendees-company">Company</label>
                                                                <span class="required">*</span>
                                                            </li>
                                                            <li>
                                                                <input type="checkbox" id="id_group-show_attendees-website" name="group-show_attendees-website" data-check="{}">
                                                                <label for="id_group-show_attendees-website">Website</label>
                                                                <span class="required">*</span>
                                                            </li>
                                                            <li>
                                                                <input type="checkbox" id="id_group-show_attendees-blog" name="group-show_attendees-blog" data-check="{}">
                                                                <label for="id_group-show_attendees-blog">Blog</label>
                                                                <span class="required">*</span>
                                                            </li>
                                                            <ul>
                                                            </ul>
                                                        </ul>
                                                    </section>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                                                    <button class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </form>
                            </section>
                            <div class="toggle-preview down">
                                <img src="<?php echo Yii::app()->request->baseUrl ?>/images/create2_preview_tray.png"/>
                            </div>

                            <section class="preview-frame">
                                <iframe scrolling="no" frameborder="0" src="<?php echo Yii::app()->request->baseUrl ?>/event/preview_page" width="100%" >
                                <p>Your browser does not support iframes.</p>
                                </iframe>
                            </section>
                        </article>
                    </div>
                </div>
                <div id="footer_buttons">
                    <div class="exit">
                        Prefer to create events on the old design?
                        <a href="#">Switch back</a>
                        to the original layout.
                    </div>
                    <div class="f-btn-area clearfix">
                        <button class="btn btn-large">Save</button>
                        <button class="btn btn-large">Preview</button>
                        <a href="#" class="btn-style make_event_live btn-save button-medium">Make Event Live</a>
                    </div>
                </div>

            </div>
        </div>     
    </div>
</div>