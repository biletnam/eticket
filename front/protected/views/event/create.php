<?php
$countries = Helper::countries();
?>
<div class="container_12">
    
    <div class="event-bar clearfix">
        <div class="grid_12">
            <ul class="clearfix">
                <li class="active"><a class="active bebasneue" href="#"><i class="icon icon-edit-white hide"></i>Event Information</a></li>
                <li class=""><a class=" bebasneue" href="#"><i class="icon icon-ticket hide"></i>Ticket Information</a></li>
                <?php /*<li class="<?php if ($type == "share") echo 'active'; ?>"><a class="<?php if ($type == "share") echo 'active'; ?> bebasneue" href="<?php echo HelperUrl::baseUrl(); ?>event/edit/id/<?php echo $event['id'] ?>/type/share"><i class="icon icon-ticket hide"></i>Share Event</a></li>*/?>
                <?php /* <li><a class="" href="<?php echo HelperUrl::baseUrl()?>event/gallery/id/<?php echo $event['id'];?>"><i class="icon icon-ticket"></i>Gallery</a></li> */ ?>
            </ul>
        </div>
    </div>
    
    <div class="grid_12 padding-bottom-50px">
        <form id="event_form" enctype="multipart/form-data" method="POST" class="form-style form-create-event border">
            <input type="hidden" name="location_id" value="<?php if (isset($_POST['location_id'])) echo $_POST['location_id']; ?>"/>
            <?php echo Helper::print_error($message); ?>
            <div class="content">

             

                <div class="controls-group clearfix">
                    <label for="title" class="control-label pull-left">Event Title<span class="required">*</span></label>
                    <div class="controls pull-left">
                        <input type="text" name="title" value="<?php if (isset($_POST['title'])) echo htmlspecialchars($_POST['title']); ?>" class="input-xxlarge span11">
                    </div>
                </div>

                <div class="controls-group clearfix hide">
                    <label for="location" class="control-label pull-left ">Location<span class="required">*</span></label>
                    <div class="controls pull-left event-location">
                        <input type="text" value="<?php if (isset($_POST['location'])) echo htmlspecialchars($_POST['location']); ?>" name="location" class="input-xxlarge span11" id="add_location">
                        <img src="<?php echo HelperUrl::baseUrl() ?>img/ajax-big-roller.gif" class="loading-location hide">
                    </div>
                </div>

                <div class="controls-group clearfix">
                    <label for="address" class="control-label pull-left">Address<span class="required">*</span></label>
                    <div class="controls pull-left">
                        <input type="text" value="<?php if (isset($_POST['address'])) echo htmlspecialchars($_POST['address']); ?>" name="address" class="input-xxlarge span11">
                    </div>
                </div>

                <div class="controls-group clearfix">
                    <label for="address" class="control-label pull-left">Address 2</label>
                    <div class="controls pull-left">
                        <input type="text" value="<?php if (isset($_POST['address_2'])) echo htmlspecialchars($_POST['address_2']); ?>" name="address_2" class="input-xxlarge span11">
                    </div>
                </div>

                <div class="controls-group clearfix">
                    <label class="control-label pull-left" for="address">City<span class="required">*</span></label>
                    <div class="controls pull-left"><input type="text" class="input-xxlarge span11" name="city" value="<?php if (isset($_POST['city'])) echo htmlspecialchars($_POST['city']); ?>"></div>
                </div>
                <div class="controls-group clearfix">
                    <label class="control-label pull-left">Country<span class="required">*</span></label>
                    <div class="controls pull-left">
                        <?php //print_r($countries);die; ?>
                        <select name="country">
                            <?php foreach ($countries as $k => $v): ?>
                                <option <?php if (isset($_POST['country']) && $_POST['country'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id']; ?>"><?php echo $v['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="controls-group clearfix">
                    <label class="control-label pull-left">Date & Time<span class="required">*</span></label>
                    <div class="controls pull-left">

                        <div class="row-fluid">
                            <p class="start-date-title">Event start</p>
                            <div data-date-format="mm/dd/yyyy" class="input-append date dp3">
                                <input type="text" value="<?php
                                if (isset($_POST['start_date']))
                                    echo $_POST['start_date'];
                                else
                                    echo date('d-m-Y');
                                ?>" name="start_date" class="input-mini ico ico-calendar datetimepicker">

                                <select name="start_hour" class="input-mini">
                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                        <option <?php if (isset($_POST['start_hour']) && $_POST['start_hour'] == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="start_minute" class="input-mini">
                                    <?php for ($i = 0; $i < 60; $i++): ?>
                                        <option <?php if (isset($_POST['start_minute']) && $_POST['start_minute'] == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                    <?php endfor; ?>
                                </select>       
                                <select name="start_am_pm">
                                    <option <?php if (isset($_POST['start_am_pm']) && $_POST['start_am_pm'] == 'am') echo 'selected' ?> value="am">AM</option>
                                    <option <?php if (isset($_POST['start_am_pm']) && $_POST['start_am_pm'] == 'pm') echo 'selected' ?> value="pm">PM</option>
                                </select>
                                <label class="checkbox inline hide">
                                    <input type="checkbox" value="1" name="display_start_time" <?php if (isset($_POST['display_start_time'])) echo 'checked'; ?>>
                                    Show
                                </label>
                            </div>

                        </div>
                        <br/>
                        <div class="row-fluid">
                            <p class="end-date-title">Event end</p>

                            <div data-date-format="mm/dd/yyyy" class="input-append date dp3">
                                <input type="text" value="<?php
                                if (isset($_POST['end_date']))
                                    echo $_POST['end_date'];
                                else
                                    echo date('d-m-Y');
                                ?>" name="end_date" class="input-mini ico ico-calendar datetimepicker">

                                <select name="end_hour" class="input-mini" id="time_hour">
                                    <?php for ($i = 0; $i <= 12; $i++): ?>
                                        <option <?php if (isset($_POST['end_hour']) && $_POST['end_hour'] == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="end_minute" class="input-mini" id="time_min">
                                    <?php for ($i = 0; $i < 60; $i++): ?>
                                        <option <?php if (isset($_POST['end_minute']) && $_POST['end_minute'] == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                    <?php endfor; ?>
                                </select>                    
                                <select name="end_am_pm">
                                    <option <?php if (isset($_POST['end_am_pm']) && $_POST['end_am_pm'] == 'am') echo 'selected' ?> value="am">AM</option>
                                    <option <?php if (isset($_POST['end_am_pm']) && $_POST['end_am_pm'] == 'pm') echo 'selected' ?> value="pm">PM</option>
                                </select>
                                <label class="checkbox inline hide">
                                    <input type="checkbox" value="1" name="display_end_time" <?php if (isset($_POST['display_start_time'])) echo 'checked'; ?>>
                                    Show
                                </label>
                                <?php /*                                <label class="checkbox inline">
                                  <input type="checkbox" name="is_repeat" value="1" <?php if (isset($_POST['is_repeat'])) echo 'checked'; ?>>
                                  Yes, This is event repeat
                                  </label> */ ?>
                            </div>

                        </div>
                    </div>


                </div>

                <div class="controls-group clearfix upload">
                    <label for="title" class="control-label pull-left">Event Logo:</label>
                    <div class="controls pull-left">
                        <div class="event-logo pull-left">
                            <img src="<?php echo HelperUrl::baseUrl() ?>img/default_upload_logo.gif" class="image-default logo-default">
                            <img class="image-default waiting hide" src="<?php echo HelperUrl::baseUrl() ?>img/ajax-big-roller.gif" />
                            <input type="hidden" name="event_id" value=""/>
                            <input type="hidden" name="file_temp" class="file_temp" value="<?php if (isset($_POST['file_temp'])) echo $_POST['file_temp']; ?>"/>
                            <input type="hidden" name="name_temp" class="name_temp" value="<?php if (isset($_POST['name_temp'])) echo $_POST['name_temp']; ?>"/>
                        </div>
                        <div class="event-logo-upload pull-left">
                            <p class="help-block">Image must be JPG, GIF or PNG.<br/> Image must be 1920 x 1080 px and smaller than 2MB.
                            </p>
                            <div><input type="file" name="file" class="fileupload customfile-input"></div>
                            <div class="error1"></div>
                        </div>
                    </div>

                    <?php /* <div class="controls pull-left"><button class="btn btn-primary" type="button">Upload</button></div> */ ?>
                </div>
                <div class="controls-group clearfix">
                    <label class="control-label pull-left">Event Description</label>
                    <div class="controls-group clearfix text">
                        <div class="controls pull-left">
                            <textarea class="tinymce" name="description" rows="10" cols="93" id="description" ><?php if (isset($_POST['description'])) echo $_POST['description']; ?></textarea>
                        </div>          
                    </div>
                </div>                                        



                <div class="controls-group clearfix">
                    <label class="control-label pull-left">Facebook URL</label>
                    <div class="controls pull-left"><input type="text" class="input-xxlarge span11" name="facebook" value="<?php if (isset($_POST['facebook'])) echo htmlspecialchars($_POST['facebook']); ?>"></div>
                </div>

                <div class="controls-group clearfix">
                    <label class="control-label pull-left">Event URL</label>
                    <div class="controls pull-left"><input type="text" class="input-xxlarge span11" name="link" value="<?php if (isset($_POST['link'])) echo htmlspecialchars($_POST['link']); ?>"></div>
                </div>

                <div class="controls-group clearfix hide">
                    <label class="control-label pull-left" for="select01">This event will public and registered.</label>
                    <div class="controls pull-left">
                        <select class="input-mini" name="published">
                            <option <?php if (isset($_POST['published']) && $_POST['published']) echo 'selected'; ?> value="1">Yes</option>
                            <option <?php if (isset($_POST['published']) && !$_POST['published']) echo 'selected'; ?> value="0">No</option>
                        </select>
                    </div>
                </div>

                <div class="controls-group clearfix">
                    <label class="control-label pull-left">Event Category</label>
                    <div class="controls pull-left">
                        <select class="input-medium" name="primary_cate">

                            <option value="0">--- Category ---</option>                                                    
                            <?php foreach ($categories as $k => $v): ?>                
                                <option <?php if (isset($_POST['primary_cate']) && $_POST['primary_cate'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id'] ?>"><?php echo $v['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select class="input-medium hide" name="second_cate">

                            <option value="0">Secondary category</option>                                                    
                            <?php foreach ($categories as $k => $v): ?>                
                                <option <?php if (isset($_POST['second_cate']) && $_POST['second_cate'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id'] ?>"><?php echo $v['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="controls-group clearfix hide">
                    <label class="control-label pull-left" for="optionsCheckbox">&nbsp;</label>
                    <div class="controls pull-left">
                        <div class="rowElem">
                            <div class="jq-plugin clearfix">
                                <label class="checkbox number-ticket">
                                    <input type="checkbox" name="show_tickets" value="1" <?php if (isset($_POST['show_tickets'])) echo 'checked' ?>>
                                    CHECK HERE TO SHOW THE NUMBER OF TICKETS REMAINING
                                </label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="controls-group clearfix">
                    <label class="control-label pull-left" for="optionsCheckbox">&nbsp;</label>
                    <div class="controls pull-left clearfix">
                        <input type="submit" class="btn pull-right" value="Save Event"/>
                    </div>
                </div>

            </div>
    </div>
</form>
</div>
</div>