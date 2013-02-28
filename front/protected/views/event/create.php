<?php
$cities = Helper::cities();
?>
<div class="row">
    <div class="container">
        <div class="span12">
            <div class="row-fluid create-magu">
                <div class="tab-content">
                    <div id="tab1" class="tab-pane active">
                        
                        <form class="form-horizontal form-create-magu" method="post" enctype="multipart/form-data" id="event_form">
                            <input type="hidden" name="location_id" value="<?php if(isset($_POST['location_id'])) echo $_POST['location_id']; ?>"/>
                            <div class="row-fluid content">
                                <?php echo Helper::print_error($message); ?>
                                <div class="span10 form-magu">

                                    <fieldset>
                                        <div class="step"> <div class="number">1</div>
                                            <h3>Create an Event</h3>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="title">Add Event Title<div class="required">*</div></label>
                                            <div class="controls"><input type="text" class="input-xlarge span11" name="title" value="<?php if (isset($_POST['title'])) echo htmlspecialchars($_POST['title']); ?>"></div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="location">Loaction<div class="required">*</div></label>
                                            <div class="controls">
                                                <input type="text" id="add_location" class="input-xlarge span11" name="location" value="<?php if (isset($_POST['location'])) echo htmlspecialchars($_POST['location']); ?>">
                                                <img class="loading-location hide" src="<?php echo Yii::app()->request->baseUrl ?>/img/ajax-big-roller.gif" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="address">Address</label>
                                            <div class="controls"><input type="text" class="input-xlarge span11" name="address" value="<?php if (isset($_POST['address'])) echo htmlspecialchars($_POST['address']); ?>"></div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">City</label>
                                            <div class="controls">
                                                <select name="city">
                                                    <?php foreach ($cities as $k => $v): ?>
                                                        <option <?php if (isset($_POST['city']) && $_POST['city'] == $v) echo 'selected'; ?> value="<?php echo $v; ?>"><?php echo $v; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Add When<div class="required">*</div></label>
                                            <div class="controls">

                                                <div class="row-fluid">
                                                    <p class="start-date-title">Event starts</p>
                                                    <div class="input-append date dp3" data-date-format="mm/dd/yyyy">
                                                        <input type="text" class="input-medium ico ico-calendar datetimepicker" name="start_date" value="<?php if (isset($_POST['start_date'])) echo $_POST['start_date']; else echo date('d-m-Y'); ?>">

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
                                                            <input type="checkbox" name="display_start_time" value="1" <?php if (isset($_POST['display_start_time'])) echo 'checked'; ?>>
                                                            Show
                                                        </label>
                                                    </div>

                                                </div>

                                                <div class="row-fluid">
                                                    <p class="end-date-title">Event ends</p>

                                                    <div class="input-append date dp3" data-date-format="mm/dd/yyyy">
                                                        <input type="text" class="input-medium ico ico-calendar datetimepicker" name="end_date" value="<?php if (isset($_POST['end_date'])) echo $_POST['end_date']; else echo date('d-m-Y'); ?>">

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
                                                            <input type="checkbox" name="display_end_time" value="1" <?php if (isset($_POST['display_start_time'])) echo 'checked'; ?>>
                                                            Show
                                                        </label>
                                                        <label class="checkbox inline">
                                                            <input type="checkbox" value="1" name="is_repeat" <?php if (isset($_POST['is_repeat'])) echo 'checked'; ?>>
                                                            Yes, this event repeats.
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>


                                        </div>

                                        <div class="control-group upload">
                                            <label class="control-label" for="title">Upload the logo for your event:</label>
                                            <div class="controls">
                                                <img class="image-default" src="<?php echo Yii::app()->request->baseUrl; ?>/img/default_upload_logo.gif" />
                                                <p class="help-block">Must be JPG, GIF, or PNG smaller than 2MB and larger than 300 x 300 px.</p>
                                                <input class="fileupload customfile-input" class="input-xlarge" name="file" type="file">
                                            </div>
                                            <!--
                                            <div class="controls"><button class="btn btn-primary" type="button">Upload</button></div> -->
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Add Event Details  <!--<label class="control-label add-faq"> <a href="">+Add FAQs</a></label>--></label>
                                                <div class="control-group text">
                                                    <div class="controls">
                                                        <textarea cols="150" rows="15" name="description" class="tinymce"><?php if (isset($_POST['description'])) echo $_POST['description']; ?></textarea>
                                                    </div>          
                                                </div>
                                        </div>                                        

                                        <div class="ticket-ridges"></div>

                                        <div class="step"> 
                                            <div class="number">2</div>
                                            <h3>Option</h3>
                                        </div>

                                        <div class="control-group">
                                            <label for="select01" class="control-label">This event will public and registered.</label>
                                            <div class="controls">
                                                <select name="published">
                                                    <option <?php if (isset($_POST['published']) && $_POST['published']) echo 'selected'; ?> value="1">Yes</option>
                                                    <option <?php if (isset($_POST['published']) && !$_POST['published']) echo 'selected'; ?> value="0">No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Select categories for your event:</label>
                                            <div class="controls">
                                                <select name="primary_cate">

                                                    <option value="0">Primary category</option>                                                    
                                                    <?php foreach ($categories as $k => $v): ?>                
                                                        <option <?php if (isset($_POST['primary_cate']) && $_POST['primary_cate'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id'] ?>"><?php echo $v['title']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <select name="second_cate">

                                                    <option value="0">Secondary category</option>                                                    
                                                    <?php foreach ($categories as $k => $v): ?>                
                                                        <option <?php if (isset($_POST['second_cate']) && $_POST['second_cate'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id'] ?>"><?php echo $v['title']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label for="optionsCheckbox" class="control-label">The number of tickets remaining</label>
                                            <div class="controls">
                                                <label class="checkbox">
                                                    <input type="checkbox" value="1" name="show_tickets" <?php if (isset($_POST['show_tickets'])) echo 'checked' ?> >
                                                    Show number of tickets remaining on the registration page.
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
                        <a href="#" class="btn-style make_event_live btn-save button-medium">Save</a>
                    </div>
                </div>

            </div>
        </div>     
    </div>
</div>