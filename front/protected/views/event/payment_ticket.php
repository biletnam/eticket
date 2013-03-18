
<?php $total = 0 ?>
<div class="page-event-detail page-event-register">
    <div class="container_12">
        <div class="clearfix">
            <div class="grid_12">
                <div class="event-header clearfix border border-radius">
                    <div class="pull-left event-header-title">
                        <h1><span class="summary"><?php echo $event['title'] ?></span></h1>
                        <h2>

                            <b>Author: </b><a href="<?php echo HelperUrl::baseUrl() ?>user/view_profile/s/current/u/<?php echo $event['user_id'] ?>"><?php echo $event['firstname']. ' ' . $event['lastname'] ?></a><br/>

                            <?php echo '<b>From:</b> ' . date('l,g:ia F j, Y', strtotime($event['start_time'])) ?><br/>
                            <?php echo '<b>To:</b> ' . date('l,g:ia F j, Y', strtotime($event['end_time'])) ?><br/>

                            <?php echo $event['city_title'] ?><br/>

                        </h2>
                    </div>
                    <div class="pull-right event-header-thumb">
                        <img alt="" src="<?php echo HelperApp::get_thumbnail($event['thumbnail']) ?>"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container_12">
        <div class="clearfix">
            <div class="grid_8">
                <article class="event event-box  ticket-info border border-radius box-shadow-bottom">
                    <form method="POST" action="">                        
                        <div class="heading">Ticket Information</div>
                        <div class="ticket">
                            <table width="100%" class="table ticket_table" id="ticket_table">
                                <thead>
                                    <tr class="ticket_table_head">
                                        <th width="210px">TICKET TYPE</th>
                                        <th>PRICE</th>
                                        <th>FEE</th>
                                        <th width="60px">Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($order_details as $k => $t): ?>

                                        <tr>
                                            <td>
                                                <?php echo $t['title']; ?>
                                            </td>

                                            <td>$<?php echo $t['price'] ?></td>
                                            <td>$<?php echo $t['fee'] ?></td>
                                            <td><?php echo $t['quantity'] ?></td>                                        
                                            <td>$<?php echo $t['total']; ?></td>
                                        </tr>


                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="4" class="align-right text-bold">TOTAL AMOUNT DUE :</td>
                                        <td class="text-bold">$<?php echo $order['total']; ?></td>
                                    </tr>
                                </tbody>


                            </table>

                            <div class="actions clearfix hide">
                                <input type="submit" class="btn pull-right" value="Pay Now"/>
                            </div>

                        </div>
                    </form>
                </article>

                <article class="event event-box  details radius-body border border-radius box-shadow-bottom">
                    <div class="heading">Registration Information</div>
                    <div class="event-body">
                        <form class="form-style" method="post">
                            <div class="alert clearfix countdown">
                                <div class="pull-left timer">14:03</div>
                                <div class="pull-left notification">
                                    <p>Please complete registration within 15:00 minutes.<br/>
                                        After 15:00 minutes, the reservation we're holding will be released to others.</p>
                                </div>
                            </div>
                            
                            <?php echo Helper::print_error($message); ?>
                            
                            <div class="required align-right">
                                * Required Field
                            </div>
                            <div class="box-register-info">
                                <legend class="text-bold">Ticket Buyer</legend>
                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">&nbsp;</label>
                                    <div class="controls pull-left">
                                        Hi, <?php echo UserControl::getEmail(); ?> &nbsp;&nbsp; Not you? <a style="text-decoration: underline" href="<?php echo HelperUrl::baseUrl(); ?>user/signout/">Sign Out</a>
                                    </div>
                                </div>
                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">First Name <span class="required">*</span></label>
                                    <div class="controls pull-left">
                                        <input type="text" class="input-medium" name="firstname" value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : $order['firstname']; ?>"/>
                                    </div>
                                </div>
                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">Last Name <span class="required">*</span></label>
                                    <div class="controls pull-left">
                                        <input type="text" class="input-medium" name="lastname" value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : $order['lastname']; ?>"/>
                                    </div>
                                </div>
                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">Email Address <span class="required">*</span></label>
                                    <div class="controls pull-left">
                                        <input type="text" class="input-medium" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : $order['email']; ?>"/>
                                    </div>
                                </div>
                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">Phone <span class="required">*</span></label>
                                    <div class="controls pull-left">
                                        <input type="text" class="input-medium" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : $order['phone']; ?>"/>
                                    </div>
                                </div>
                            </div>

                            <div class="box-register-info">
                                <legend class="text-bold">Billing Information</legend>

                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">Address <span class="required">*</span></label>
                                    <div class="controls pull-left">
                                        <input type="text" class="input-medium" name="address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : $order['address']; ?>"/>
                                    </div>
                                </div>
                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">City <span class="required">*</span></label>
                                    <div class="controls pull-left">
                                        <select name="city_id" class="input-medium">
                                            <?php foreach ($cities as $k => $v): ?>
                                                <option value="<?php echo $v['id']; ?>" <?php if(isset($_POST['city_id']) && $_POST['city_id'] == $v['id']) echo 'selected'; ?>><?php echo $v['title']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">Zip Code <span class="required">*</span></label>
                                    <div class="controls pull-left">
                                        <input type="text" class="input-medium" name="zipcode" value="<?php echo isset($_POST['zipcode']) ? htmlspecialchars($_POST['zipcode']) : $order['zipcode']; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <?php /*
                              <div class="box-register-info">
                              <legend class="text-bold">Credit Card</legend>
                              <div class="controls-group clearfix">
                              <label class="control-label pull-left">Credit Card <span class="required">*</span></label>
                              <div class="controls pull-left">
                              <select class="input-mini">
                              <option>1</option>
                              </select>
                              </div>
                              </div>
                              <div class="controls-group clearfix">
                              <label class="control-label pull-left">Credit Card Number <span class="required">*</span></label>
                              <div class="controls pull-left">
                              <input type="text" class="input-medium"/>
                              </div>
                              </div>
                              <div class="controls-group clearfix">
                              <label class="control-label pull-left">Expiration Date </label>
                              <div class="controls pull-left">
                              <div class="clearfix">
                              <div class="month-year pull-left">
                              <select>
                              <option>Jan</option>
                              </select>
                              <select>
                              <option>2013</option>
                              </select>
                              </div>
                              <div class="box-what-this pull-left">
                              CSC <span class="required">*</span> <input type="text"/> What's this?
                              </div>
                              </div>
                              <br/>
                              <label><input type="checkbox"/> Save billing and payment info for easy ordering</label>
                              </div>
                              </div>
                              </div>

                              <div class="box-register-info">
                              <legend class="text-bold">Shipping Address</legend>
                              <div class="controls-group clearfix">
                              <label class="control-label pull-left">&nbsp;</label>
                              <div class="controls pull-left">
                              <label><input type="checkbox"/> Save billing and payment info for easy ordering</label>
                              </div>
                              </div>
                              <div class="controls-group clearfix">
                              <label class="control-label pull-left">Country <span class="required">*</span></label>
                              <div class="controls pull-left">
                              <select class="input-mini">
                              <option>1</option>
                              </select>
                              </div>
                              </div>
                              <div class="controls-group clearfix">
                              <label class="control-label pull-left">Address <span class="required">*</span></label>
                              <div class="controls pull-left">
                              <input type="text" class="input-medium"/>
                              </div>
                              </div>
                              <div class="controls-group clearfix">
                              <label class="control-label pull-left">Address</label>
                              <div class="controls pull-left">
                              <input type="text" class="input-medium"/>
                              </div>
                              </div>
                              <div class="controls-group clearfix">
                              <label class="control-label pull-left">City <span class="required">*</span></label>
                              <div class="controls pull-left">
                              <input type="text" class="input-medium"/>
                              </div>
                              </div>
                              <div class="controls-group clearfix">
                              <label class="control-label pull-left">State <span class="required">*</span></label>
                              <div class="controls pull-left">
                              <select class="input-mini">
                              <option>1</option>
                              </select>
                              </div>
                              </div>
                              <div class="controls-group clearfix">
                              <label class="control-label pull-left">Zip Code <span class="required">*</span></label>
                              <div class="controls pull-left">
                              <input type="text" class="input-medium"/>
                              </div>
                              </div>
                              </div>
                             * 
                             */ ?>
                            <div class="actions clearfix">
                                <input type="submit" class="btn pull-right" value="Pay Now"/>
                            </div>
                        </form>
                    </div>
                </article>

            </div>
            <div class="grid_4 sidebar-event">
                <article class="event where border border-radius box-shadow-bottom">
                    <div class="heading">Time &amp; Place</div>
                    <div class="event-body">
                        <div class="vcard">
                            <iframe width="270" scrolling="no" height="250" frameborder="0" src="http://maps.google.com/maps?q=4+Ph%E1%BA%A1m+Ng%E1%BB%8Dc+Th%E1%BA%A1ch%2C+B%E1%BA%BFn+Ngh%C3%A9.+Q.1;&amp;iwloc=near&amp;z=15&amp;output=embed" marginwidth="0" marginheight="0"></iframe><br>        
                            <br/>
                        </div>
                        <div class="vcard">
                            <h6><?php echo $event['location'] ?></h6>
                            <p><?php echo $event['address'] ?>, <?php echo $event['city_title'] ?></p>
                        </div>


                        <?php echo date('l, d/m/Y g:i a', strtotime($event['start_time'])) . ' - ' ?><br/>
                        <?php echo date('l, d/m/Y g:i a', strtotime($event['end_time'])) ?>
                    </div>
                </article>
              
            </div>
        </div>
    </div>
</div>