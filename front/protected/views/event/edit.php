<div class="container_12">
    <div class="event-bar clearfix">
        <div class="grid_12">
            <ul class="clearfix">
                <li><a href="#"><i class="icon icon-edit-white"></i>Event Information</a></li>
                <li><a class="active" href="#"><i class="icon icon-ticket"></i>Ticket</a></li>
            </ul>
        </div>
    </div>
    <div class="clearfix">
        <div class="grid_12 page-create-ticket">
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
                        <a class="btn btn-type-price  btn-donate eb_button small default add_ticket_class btn-ticket free">Free</a>
                        <a class="btn-style button-medium eb_button small go add_ticket_class btn-ticket paid">Cost</a>

                    </div>
                    <div id="event_form" class="form-ticket">    
                    </div>
                </div>

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
                            <input type="hidden" value="13" name="event_id">        
                            <input type="hidden" class="ticket-type" value="paid" name="ticket_type">
                            <input type="hidden" class="ticket-id" value="" name="ticket_id">
                            <td class="ticket_name"><input type="text" class="input-mini ticket-name" name="ticket_name"></td>
                            <td class="ticket_quantity"><input type="text" class="input-mini quantity ticket-quantity" name="ticket_quantity" placeholder="0"></td>
                            <td class="ticket_fee"><input type="text" class="input-mini ticket-fee" name="ticket_fee" placeholder="0 USD"></td>
                            <td><span class="price ticket-tax">0.00 USD</span></td>
                            <td><span class="price ticket-total">0.00 USD</span></td>
                            <td>
                                <select name="ticket_status" class="ticket-status">
                                    <option value="1">Sell</option>
                                    <option value="0">Hide</option>
                                </select>
                            </td>
                            <td><a class="setting" href="#">Option <i class="icon ico-hide icon-chevron-down"></i></a></td>
                            <td>
                                <a class="apply-ticket btn-style btn-info" href="#">Add <i class="icon icon-add"></i></a>
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
                                                    <input type="text" class="input-mini ico ico-calendar datetimepicker ticket-start-date " name="ticket_start_date">
                                                    <select name="ticket_start_hour" class="input-mini ticket-start-hour" id="time_hour">
                                                        <option value="0">00</option>
                                                        <option value="1">01</option>
                                                        <option value="2">02</option>
                                                        <option value="3">03</option>
                                                        <option value="4">04</option>
                                                        <option value="5">05</option>
                                                        <option value="6">06</option>
                                                        <option value="7">07</option>
                                                        <option value="8">08</option>
                                                        <option value="9" selected="">09</option>
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
                                                    <select name="ticket_start_minute" class="input-mini ticket-start-minute" id="time_min">
                                                        <option value="0">00</option>
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
                                                        <option value="42" selected="">42</option>
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

                                                <div class="input-append date dp3" data-date="" data-date-format="mm/dd/yyyy">
                                                    <input type="text" class="input-mini ico ico-calendar datetimepicker ticket-end-date " name="ticket_end_date">

                                                    <select name="ticket_end_hour" class="input-mini ticket-end-hour" id="time_hour">
                                                        <option value="0">00</option>
                                                        <option value="1">01</option>
                                                        <option value="2">02</option>
                                                        <option value="3">03</option>
                                                        <option value="4">04</option>
                                                        <option value="5">05</option>
                                                        <option value="6">06</option>
                                                        <option value="7">07</option>
                                                        <option value="8">08</option>
                                                        <option value="9" selected="">09</option>
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
                                                    <select name="ticket_end_minute" class="input-mini ticket-end-minute" id="time_min">
                                                        <option value="0">00</option>
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
                                                        <option value="42" selected="">42</option>
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
                                                INCLUDE fees into total ticket price
                                            </label>
                                            <br/>
                                            <label class="radio">
                                                <input type="radio" class="ticket-service-fee" value="1" name="ticket_service_fee">
                                                ADD fees on top of total ticket price
                                            </label>
                                        </div>
                                    </div>
                                    <div class="controls-group clearfix">
                                        <label class="control-label pull-left clearfix">&nbsp;</label>
                                        <div class="controls clearfix pull-left">
                                            <div class="btn-apply clearfix">
                                                <a class="btn-style btn-info pull-right apply-ticket" href="#">Add  <i class="icon icon-add"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>       
                        </table>
                    </form>
                    <form action="/vsk_old/front/event/add_ticket_type/" enctype="multipart/form-data" method="post" class="form-horizontal table-ticket clone free hide form-create-ticket">           
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
                            <input type="hidden" value="13" name="event_id">        
                            <input type="hidden" class="ticket-type" value="free" name="ticket_type">
                            <input type="hidden" class="ticket-id" value="" name="ticket_id">
                            <td class="ticket_name"><input type="text" class="input-mini ticket-name" name="ticket_name"></td>
                            <td class="ticket_quantity"><input type="text" class="input-mini quantity ticket-quantity" name="ticket_quantity" placeholder="0"></td>
                            <td class="ticket_fee">Free</td>
                            <td>
                                <select name="ticket_status" class="ticket-status">
                                    <option value="1">Sell</option>
                                    <option value="0">Hide</option>
                                </select>
                            </td>
                            <td><a class="setting" href="JavaScript:void(0);">Option <i class="icon-chevron-down icon ico-hide"></i></a></td>
                            <td>
                                <a class="apply-ticket btn-style btn-info" href="#">Add <i class="icon icon-add"></i></a>
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
                                                    <input type="text" class="input-mini ico ico-calendar datetimepicker ticket-start-date " name="ticket_start_date">
                                                    <select name="ticket_start_hour" class="input-mini ticket-start-hour" id="time_hour">
                                                        <option value="0">00</option>
                                                        <option value="1">01</option>
                                                        <option value="2">02</option>
                                                        <option value="3">03</option>
                                                        <option value="4">04</option>
                                                        <option value="5">05</option>
                                                        <option value="6">06</option>
                                                        <option value="7">07</option>
                                                        <option value="8">08</option>
                                                        <option value="9" selected="">09</option>
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
                                                    <select name="ticket_start_minute" class="input-mini ticket-start-minute" id="time_min">
                                                        <option value="0">00</option>
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
                                                        <option value="42" selected="">42</option>
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

                                                </div>

                                            </div>

                                            <div class="row-fluid ticket-date">
                                                <p class="end-date-title">End Sales</p>


                                                <div class="input-append date dp3" data-date="" data-date-format="mm/dd/yyyy">
                                                    <input type="text" class="input-mini ico ico-calendar datetimepicker ticket-end-date" name="ticket_end_date" >

                                                    <select name="ticket_end_hour" class="input-mini ticket-end-hour" id="time_hour">
                                                        <option value="0">00</option>
                                                        <option value="1">01</option>
                                                        <option value="2">02</option>
                                                        <option value="3">03</option>
                                                        <option value="4">04</option>
                                                        <option value="5">05</option>
                                                        <option value="6">06</option>
                                                        <option value="7">07</option>
                                                        <option value="8">08</option>
                                                        <option value="9" selected="">09</option>
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
                                                    <select name="ticket_end_minute" class="input-mini ticket-end-minute" id="time_min">
                                                        <option value="0">00</option>
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
                                                        <option value="42" selected="">42</option>
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
                                                <a class="btn-style btn-info pull-right apply-ticket" href="#">Add <i class="icon icon-add"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            </tbody>

                        </table>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>