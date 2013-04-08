<?php $total = 0 ?>
<input type="hidden" value="<?php echo $count_down ?>" id="count_down">
<input type="hidden" value="<?php echo HelperUrl::baseUrl() ?>event/info/s/<?php echo $event['slug'] ?>" id="url_back">
<div class="page-event-detail page-event-register">
    <div class="container_12">
        <div class="clearfix">
            <div class="grid_12">
                <div class="event-header clearfix border border-radius">
                    <div class="pull-left event-header-title">
                        <h1><span class="summary"><?php echo $event['title'] ?></span></h1>
                        <h2>


                            <b>Address:</b> <?php echo $event['address'] ?>, <?php echo $event['country_title'] ?><br/>
                            <?php if ($event['address_2'] != ''): ?><b>Address 2:</b>:<?php echo $event['address_2'] ?>, <?php echo $event['country_title'] ?><br/><?php endif; ?>

                            <b>Event Creator: </b><a href="<?php echo HelperUrl::baseUrl() ?>user/view_profile/s/current/u/<?php echo $event['user_id'] ?>"><?php echo ($event['organizer_title'] != "") ? $event['organizer_title'] : $event['firstname'] . ' ' . $event['lastname'] ?></a><br/>

                            <?php echo '<b>From:</b> ' . date('l,g:ia F j, Y', strtotime($event['start_time'])) ?><br/>
                            <?php echo '<b>To:</b> ' . date('l,g:ia F j, Y', strtotime($event['end_time'])) ?><br/>


                        </h2>

                        <?php if ($event['facebook'] != ''): ?>
                            <a href="<?php echo $event['facebook'] ?>"><img class="link-logo" src="<?php echo HelperUrl::baseUrl() ?>images/facebook-logo.png"></a>
                        <?php endif; ?>

                        <?php if ($event['link'] != ''): ?>
                            <a href="<?php echo $event['link'] ?>"><img class="link-logo" src="<?php echo HelperUrl::baseUrl() ?>images/link-logo.png"></a>
                        <?php endif; ?>
                    </div>
                    <div class="pull-right event-header-thumb">


                        <a class="fancybox" href="<?php echo HelperApp::get_thumbnail($event['thumbnail'], 'full') ?>">
                            <img alt="" src="<?php echo HelperApp::get_thumbnail($event['thumbnail'], 'detail') ?>"/>
                        </a>

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
                                        <th width="100px">Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php //print_r($order_details);die; ?>
                                    <?php foreach ($order_details as $k => $t): ?>

                                        <tr>
                                            <td>
                                                <?php echo $t['title']; ?>
                                            </td>

                                            <td>TT$<?php
//                                                if($t['service_fee'])
//                                                    echo $t['price']*1.1;
//                                                else
                                            echo $t['price'];
                                                ?>
                                            </td>
                                            <td><?php echo $t['quantity'] ?></td>                                        
                                            <td>TT$<?php echo $t['total']; ?></td>
                                        </tr>


                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="3" class="align-right text-bold">TOTAL AMOUNT DUE :</td>
                                        <td class="text-bold">TT$<?php echo $order['total']; ?></td>
                                    </tr>
                                </tbody>


                            </table>

                            <div class="actions clearfix hide">
                                <input type="submit" class="btn pull-right" value="Pay Now"/>
                            </div>

                        </div>
                    </form>
                </article>

                <article class="event event-box  details radius-body border border-radius box-shadow-bottom payment-ticket">
                    <div class="heading">Registration Information</div>
                    <div class="event-body">
                        <form class="form-style" method="post">
                            <div class="alert clearfix countdown" style="margin-bottom: 20px;">

                                <?php
                                $expired_time = $token['date_expired'] - time();
                                $minute = 0;
                                $second = 0;

                                $minute = (int) ($expired_time / 60);
                                $second = (int) ($expired_time % 60);
                                ?>
                                <div class="pull-left timer"><?php echo $minute . ":" . $second; ?></div>
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
                                <legend class="text-bold">Payment Type</legend>
                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">&nbsp;</label>
                                    <div class="controls pull-left clearfix">
                                        <div class="pull-left" style="margin-right: 50px;">
                                            <input class="payment-type normal" type="radio" name="payment_type" value="paypal" <?php if (isset($_POST['payment_type']) && $_POST['payment_type'] == "normal") echo 'checked';else echo 'checked'; ?> /> 
                                            <img style="width: auto" src="<?php echo HelperUrl::baseUrl(); ?>images/PayPal-icon.jpg"/>
                                        </div>
                                        <div class="pull-left">
                                            <input class="payment-type direct" type="radio" name="payment_type" value="direct_payment" <?php if (isset($_POST['payment_type']) && $_POST['payment_type'] == "direct_payment") echo 'checked'; ?> />
                                            <img style="width: auto" src="<?php echo HelperUrl::baseUrl(); ?>images/credit-card.jpg"/>
                                        </div>
                                    </div>
                                </div>
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
                                        <input type="text" class="input-medium" name="firstname" value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : ($order['firstname'] != "" ? $order['firstname'] : UserControl::getFirstname()); ?>"/>
                                    </div>
                                </div>
                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">Last Name <span class="required">*</span></label>
                                    <div class="controls pull-left">
                                        <input type="text" class="input-medium" name="lastname" value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : ($order['lastname'] != "" ? $order['lastname'] : UserControl::getLastname()); ?>"/>
                                    </div>
                                </div>
                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">Email Address <span class="required">*</span></label>
                                    <div class="controls pull-left">
                                        <input type="text" class="input-medium" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ($order['email'] != "" ? $order['email'] : UserControl::getEmail()); ?>"/>
                                    </div>
                                </div>
                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">Phone <span class="required">*</span></label>
                                    <div class="controls pull-left">
                                        <input type="text" class="input-medium" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ($order['phone'] != "" ? $order['phone'] : (isset($user_metas['phone'])) ? $user_metas['phone'] : '' ); ?>"/>
                                    </div>
                                </div>
                            </div>

                            <div class="box-register-info">
                                <legend class="text-bold">Billing Information</legend>

                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">Address <span class="required">*</span></label>
                                    <div class="controls pull-left">
                                        <input type="text" class="input-medium" name="address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ($order['address'] != "" ? $order['address'] : (isset($user_metas['address'])) ? $user_metas['address'] : '' ); ?>"/>
                                    </div>
                                </div>

                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">Address 2</label>
                                    <div class="controls pull-left">
                                        <input type="text" class="input-medium" name="address_2" value="<?php echo isset($_POST['address_2']) ? htmlspecialchars($_POST['address_2']) : ($order['address_2'] != "" ? $order['address_2'] : (isset($user_metas['address_2'])) ? $user_metas['address_2'] : '' ); ?>"/>
                                    </div>
                                </div>

                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">City <span class="required">*</span></label>
                                    <div class="controls pull-left">
                                        <input type="text" class="input-medium" name="city" value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ($order['city'] != "" ? $order['city'] : (isset($user_metas['city'])) ? $user_metas['city'] : '' ); ?>"/>
                                    </div>
                                </div>
                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">Country <span class="required">*</span></label>
                                    <div class="controls pull-left">
                                        <select name="country_id" class="input-medium">
                                            <?php foreach ($countries as $k => $v): ?>
                                                <option value="<?php echo $v['id']; ?>" <?php echo (isset($_POST['country_id']) && $_POST['country_id'] == $v['id']) ? 'selected' : (UserControl::getCountryId() == $v['id'] ? 'selected' : ''); ?>><?php echo $v['title']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="box-register-info <?php echo isset($_POST['payment_type']) && $_POST['payment_type'] == "direct_payment" ? "" : "hide"; ?> payment-infomation">
                                <legend class="text-bold">Card Information</legend>

                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">Card Type <span class="required">*</span></label>
                                    <div class="controls pull-left">
                                        <select name="card_type" class="input-medium">
                                            <?php foreach (Helper::get_card_types() as $k => $v): ?>
                                                <option value="<?php echo $k; ?>" <?php echo isset($_POST['card_type']) && $_POST['card_type'] == $k ? 'selected' : ''; ?>><?php echo $v; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">Cardholder Name <span class="required">*</span></label>
                                    <div class="controls pull-left">
                                        <input type="text" class="input-medium" name="card_name" value="<?php echo isset($_POST['card_name']) ? htmlspecialchars($_POST['card_name']) : ""; ?>"/>
                                    </div>
                                </div>

                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">Card Number <span class="required">*</span></label>
                                    <div class="controls pull-left">
                                        <input type="text" class="input-medium" name="card_number" value="<?php echo isset($_POST['card_number']) ? htmlspecialchars($_POST['card_number']) : ""; ?>"/>
                                    </div>
                                </div>
                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">Expiration [ mm / yyyy ] <span class="required">*</span></label>
                                    <div class="controls pull-left">
                                        <input type="text" class="input-mini" name="card_month" value="<?php echo isset($_POST['card_month']) ? htmlspecialchars($_POST['card_month']) : ""; ?>"/>
                                        <input type="text" class="input-mini" name="card_year" value="<?php echo isset($_POST['card_year']) ? htmlspecialchars($_POST['card_year']) : ""; ?>"/>
                                    </div>
                                </div>
                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">CVV Number <span class="required">*</span></label>
                                    <div class="controls pull-left">
                                        <input type="text" class="input-mini" name="cvv_number" value="<?php echo isset($_POST['cvv_number']) ? htmlspecialchars($_POST['cvv_number']) : ""; ?>"/>
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

                            <p>Address: <?php echo $event['address'] ?>, <?php echo $event['country_title'] ?></p>
                            <?php if ($event['address_2'] != ''): ?>
                                <p>Address 2:<?php echo $event['address_2'] ?>, <?php echo $event['country_title'] ?></p>
                            <?php endif; ?>
                        </div>


                        <?php echo date('l, d/m/Y g:i a', strtotime($event['start_time'])) . ' - ' ?><br/>
                        <?php echo date('l, d/m/Y g:i a', strtotime($event['end_time'])) ?>
                    </div>
                </article>

            </div>
        </div>
    </div>

</div>