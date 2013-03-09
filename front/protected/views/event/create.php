<div class="container_12">
    <div class="grid_12 padding-bottom-50px">
        <form id="event_form" enctype="multipart/form-data" method="post" class="form-style form-create-event border">
            <input type="hidden" value="" name="location_id">
            <div class="content">
                <div class="alert alert-error">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <h4>Error!</h4>
                    Message 1.<br>
                </div>

                <div class="step">
                    <div class="number"><span>1</span></div>
                    <h3>Event Information</h3>
                </div>

                <div class="controls-group clearfix">
                    <label for="title" class="control-label pull-left">Add Event Title<span class="required">*</span></label>
                    <div class="controls pull-left"><input type="text" value="" name="title" class="input-xxlarge span11"></div>
                </div>
                <div class="controls-group clearfix">
                    <label for="location" class="control-label pull-left">Location<span class="required">*</span></label>
                    <div class="controls pull-left">
                        <input type="text" value="" name="location" class="input-xxlarge span11" id="add_location">
                        <img src="/vsk_old/front/img/ajax-big-roller.gif" class="loading-location hide">
                    </div>
                </div>
                <div class="controls-group clearfix">
                    <label for="address" class="control-label pull-left">Address</label>
                    <div class="controls pull-left"><input type="text" value="" name="address" class="input-xxlarge span11"></div>
                </div>
                <div class="controls-group clearfix">
                    <label class="control-label pull-left">City</label>
                    <div class="controls pull-left">
                        <select name="city">
                            <option value="1" selected="">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                </div>
                <div class="controls-group clearfix">
                    <label class="control-label pull-left">Add When<span class="required">*</span></label>
                    <div class="controls pull-left">

                        <div class="row-fluid">
                            <p class="start-date-title">Event start</p>
                            <div data-date-format="mm/dd/yyyy" class="input-append date dp3">
                                <input type="text" value="09-03-2013" name="start_date" class="input-mini ico ico-calendar datetimepicker">

                                <select class="input-mini" name="start_hour">
                                    <option value="0" selected="">00</option>
                                    <option value="1">01</option>
                                    <option value="2">02</option>
                                    <option value="3">03</option>
                                    <option value="4">04</option>
                                    <option value="5">05</option>
                                    <option value="6">06</option>
                                    <option value="7">07</option>
                                    <option value="8">08</option>
                                    <option value="9">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                </select>
                                <select class="input-mini" name="start_minute">
                                    <option value="0" selected="">00</option>
                                    <option value="1">01</option>
                                    <option value="2">02</option>
                                    <option value="3">03</option>
                                    <option value="4">04</option>
                                    <option value="5">05</option>
                                    <option value="6">06</option>
                                    <option value="7">07</option>
                                    <option value="8">08</option>
                                    <option value="9">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                    <option value="32">32</option>
                                    <option value="33">33</option>
                                    <option value="34">34</option>
                                    <option value="35">35</option>
                                    <option value="36">36</option>
                                    <option value="37">37</option>
                                    <option value="38">38</option>
                                    <option value="39">39</option>
                                    <option value="40">40</option>
                                    <option value="41">41</option>
                                    <option value="42">42</option>
                                    <option value="43">43</option>
                                    <option value="44">44</option>
                                    <option value="45">45</option>
                                    <option value="46">46</option>
                                    <option value="47">47</option>
                                    <option value="48">48</option>
                                    <option value="49">49</option>
                                    <option value="50">50</option>
                                    <option value="51">51</option>
                                    <option value="52">52</option>
                                    <option value="53">53</option>
                                    <option value="54">54</option>
                                    <option value="55">55</option>
                                    <option value="56">56</option>
                                    <option value="57">57</option>
                                    <option value="58">58</option>
                                    <option value="59">59</option>
                                </select>                                                        
                                <label class="checkbox inline">
                                    <input type="checkbox" value="1" name="display_start_time">
                                    Show
                                </label>
                            </div>

                        </div>
                        <br/>
                        <div class="row-fluid">
                            <p class="end-date-title">Event end</p>

                            <div data-date-format="mm/dd/yyyy" class="input-append date dp3">
                                <input type="text" value="09-03-2013" name="end_date" class="input-mini ico ico-calendar datetimepicker">

                                <select id="time_hour" class="input-mini" name="end_hour">
                                    <option value="0" selected="">00</option>
                                    <option value="1">01</option>
                                    <option value="2">02</option>
                                    <option value="3">03</option>
                                    <option value="4">04</option>
                                    <option value="5">05</option>
                                    <option value="6">06</option>
                                    <option value="7">07</option>
                                    <option value="8">08</option>
                                    <option value="9">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                </select>
                                <select id="time_min" class="input-mini" name="end_minute">
                                    <option value="0" selected="">00</option>
                                    <option value="1">01</option>
                                    <option value="2">02</option>
                                    <option value="3">03</option>
                                    <option value="4">04</option>
                                    <option value="5">05</option>
                                    <option value="6">06</option>
                                    <option value="7">07</option>
                                    <option value="8">08</option>
                                    <option value="9">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                    <option value="32">32</option>
                                    <option value="33">33</option>
                                    <option value="34">34</option>
                                    <option value="35">35</option>
                                    <option value="36">36</option>
                                    <option value="37">37</option>
                                    <option value="38">38</option>
                                    <option value="39">39</option>
                                    <option value="40">40</option>
                                    <option value="41">41</option>
                                    <option value="42">42</option>
                                    <option value="43">43</option>
                                    <option value="44">44</option>
                                    <option value="45">45</option>
                                    <option value="46">46</option>
                                    <option value="47">47</option>
                                    <option value="48">48</option>
                                    <option value="49">49</option>
                                    <option value="50">50</option>
                                    <option value="51">51</option>
                                    <option value="52">52</option>
                                    <option value="53">53</option>
                                    <option value="54">54</option>
                                    <option value="55">55</option>
                                    <option value="56">56</option>
                                    <option value="57">57</option>
                                    <option value="58">58</option>
                                    <option value="59">59</option>
                                </select>                                                     
                                <label class="checkbox inline">
                                    <input type="checkbox" value="1" name="display_end_time">
                                    Show
                                </label>
                                <label class="checkbox inline">
                                    <input type="checkbox" name="is_repeat" value="1">
                                    Yes, This is event repeat
                                </label>
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
                            <textarea class="tinymce" name="description" rows="10" cols="93" id="description" ></textarea>
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
                            <option value="1" selected="">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>

                <div class="controls-group clearfix">
                    <label class="control-label pull-left">Select categories for your event</label>
                    <div class="controls pull-left">
                        <select class="input-medium" name="primary_cate">
                            <option value="0">Primary category</option>                                                    
                        </select>
                        <select class="input-medium" name="second_cate">
                            <option value="0">Secondary category</option>                                                    
                        </select>
                    </div>
                </div>

                <div class="controls-group clearfix">
                    <label class="control-label pull-left" for="optionsCheckbox">The number of tickets remaining</label>
                    <div class="controls pull-left">
                        <label class="checkbox">
                            <input type="checkbox" name="show_tickets" value="1">
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