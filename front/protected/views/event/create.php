<?php
$cities = Helper::cities();
?>
<div class="container_12">
    <div class="grid_12 padding-bottom-50px">
        <form id="event_form" enctype="multipart/form-data" method="POST" class="form-style form-create-event border">
            <input type="hidden" name="location_id" value="<?php if (isset($_POST['location_id'])) echo $_POST['location_id']; ?>"/>
            <?php echo Helper::print_error($message); ?>
            <div class="content">

                <div class="step">
                    <div class="number"><span>1</span></div>
                    <h3>Event Information</h3>
                </div>

                <div class="controls-group clearfix">
                    <label for="title" class="control-label pull-left">Add Event Title<span class="required">*</span></label>
                    <div class="controls pull-left">
                        <input type="text" name="title" value="<?php if (isset($_POST['title'])) echo htmlspecialchars($_POST['title']); ?>" class="input-xxlarge span11">
                    </div>
                </div>
                <div class="controls-group clearfix">
                    <label for="location" class="control-label pull-left ">Location<span class="required">*</span></label>
                    <div class="controls pull-left event-location">
                        <input type="text" value="<?php if (isset($_POST['location'])) echo htmlspecialchars($_POST['location']); ?>" name="location" class="input-xxlarge span11" id="add_location">
                        <img src="<?php echo HelperUrl::baseUrl()?>img/ajax-big-roller.gif" class="loading-location hide">
                    </div>
                </div>
                <div class="controls-group clearfix">
                    <label for="address" class="control-label pull-left">Address</label>
                    <div class="controls pull-left">
                        <input type="text" value="<?php if (isset($_POST['address'])) echo htmlspecialchars($_POST['address']); ?>" name="address" class="input-xxlarge span11">
                    </div>
                </div>
                <div class="controls-group clearfix">
                    <label class="control-label pull-left">City</label>
                    <div class="controls pull-left">
                        <?php //print_r($cities);die; ?>
                        <select name="city">
                            <?php foreach ($cities as $k => $v): ?>
                                <option <?php if (isset($_POST['city']) && $_POST['city'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id']; ?>"><?php echo $v['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="controls-group clearfix">
                    <label class="control-label pull-left">Add When<span class="required">*</span></label>
                    <div class="controls pull-left">

                        <div class="row-fluid">
                            <p class="start-date-title">Event start</p>
                            <div data-date-format="mm/dd/yyyy" class="input-append date dp3">
                                <input type="text" value="<?php if (isset($_POST['start_date'])) echo $_POST['start_date']; else echo date('d-m-Y'); ?>" name="start_date" class="input-mini ico ico-calendar datetimepicker">

                                <select name="start_hour" class="input-mini">
                                    <?php for ($i = 0; $i < 24; $i++): ?>
                                        <option <?php if (isset($_POST['start_hour']) && $_POST['start_hour'] == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="start_minute" class="input-mini">
                                    <?php for ($i = 0; $i < 60; $i++): ?>
                                        <option <?php if (isset($_POST['start_minute']) && $_POST['start_minute'] == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                    <?php endfor; ?>
                                </select>       

                                <label class="checkbox inline">
                                    <input type="checkbox" value="1" name="display_start_time" <?php if (isset($_POST['display_start_time'])) echo 'checked'; ?>>
                                    Show
                                </label>
                            </div>

                        </div>
                        <br/>
                        <div class="row-fluid">
                            <p class="end-date-title">Event end</p>

                            <div data-date-format="mm/dd/yyyy" class="input-append date dp3">
                                <input type="text" value="<?php if (isset($_POST['end_date'])) echo $_POST['end_date']; else echo date('d-m-Y'); ?>" name="end_date" class="input-mini ico ico-calendar datetimepicker">

                                <select name="end_hour" class="input-mini" id="time_hour">
                                    <?php for ($i = 0; $i < 24; $i++): ?>
                                        <option <?php if (isset($_POST['end_hour']) && $_POST['end_hour'] == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="end_minute" class="input-mini" id="time_min">
                                    <?php for ($i = 0; $i < 60; $i++): ?>
                                        <option <?php if (isset($_POST['end_minute']) && $_POST['end_minute'] == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i < 10 ? "0$i" : $i; ?></option>
                                    <?php endfor; ?>
                                </select>                    

                                <label class="checkbox inline">
                                    <input type="checkbox" value="1" name="display_end_time" <?php if (isset($_POST['display_start_time'])) echo 'checked'; ?>>
                                    Show
                                </label>
<!--                                <label class="checkbox inline">
                                    <input type="checkbox" name="is_repeat" value="1" <?php if (isset($_POST['is_repeat'])) echo 'checked'; ?>>
                                    Yes, This is event repeat
                                </label>-->
                            </div>

                        </div>
                    </div>


                </div>

                <div class="controls-group clearfix upload">
                    <label for="title" class="control-label pull-left">Upload the photo for your event:</label>
                    <div class="controls pull-left">
                        <img src="<?php echo HelperUrl::baseUrl() ?>img/default_upload_logo.gif" class="image-default">
                        <p class="help-block">Must be JPG, GIF, or PNG smaller than 2MB and larger than 300x300 px</p>
                        <input type="file" name="file" class="fileupload customfile-input">
                    </div>
                    <!--
                    <div class="controls pull-left"><button class="btn btn-primary" type="button">Upload</button></div> -->
                </div>
                <div class="controls-group clearfix">
                    <label class="control-label pull-left">Event Description</label>
                    <div class="controls-group clearfix text">
                        <div class="controls pull-left">
                            <textarea class="tinymce" name="description" rows="10" cols="93" id="description" ><?php if (isset($_POST['description'])) echo $_POST['description']; ?></textarea>
                        </div>          
                    </div>
                </div>                                        

                <div class="ticket-ridges"></div>

                <div class="step"> 
                    <div class="number"><span>2</span></div>
                    <h3>Option</h3>
                </div>

                <div class="controls-group clearfix">
                    <label class="control-label pull-left" for="select01">This event will public and registered.</label>
                    <div class="controls pull-left">
                        <select class="input-mini" name="published">
                            <option <?php if (isset($_POST['published']) && $_POST['published']) echo 'selected'; ?> value="1">Yes</option>
                            <option <?php if (isset($_POST['published']) && !$_POST['published']) echo 'selected'; ?> value="0">No</option>
                        </select>
                    </div>
                </div>

                <div class="controls-group clearfix">
                    <label class="control-label pull-left">Select categories for your event</label>
                    <div class="controls pull-left">
                        <select class="input-medium" name="primary_cate">

                            <option value="0">Primary category</option>                                                    
                            <?php foreach ($categories as $k => $v): ?>                
                                <option <?php if (isset($_POST['primary_cate']) && $_POST['primary_cate'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id'] ?>"><?php echo $v['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select class="input-medium" name="second_cate">

                            <option value="0">Secondary category</option>                                                    
                            <?php foreach ($categories as $k => $v): ?>                
                                <option <?php if (isset($_POST['second_cate']) && $_POST['second_cate'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id'] ?>"><?php echo $v['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="controls-group clearfix">
                    <label class="control-label pull-left" for="optionsCheckbox">The number of tickets remaining</label>
                    <div class="controls pull-left">
                        <label class="checkbox">
                            <input type="checkbox" name="show_tickets" value="1" <?php if (isset($_POST['show_tickets'])) echo 'checked' ?>>
                            Show number of tickets remaining on the registration page
                        </label>
                    </div>
                </div>


                <div class="controls-group clearfix">
                    <label class="control-label pull-left" for="optionsCheckbox">&nbsp;</label>
                    <div class="controls pull-left clearfix">
                        <input type="submit" class="btn pull-right" value="SAVE"/>
                    </div>
                </div>

            </div>
    </div>
</form>
</div>
</div>