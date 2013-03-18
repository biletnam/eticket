<div class="page-event-detail">
    <div class="container_12">

        <?php echo Helper::print_info(); ?>
        <?php echo Helper::print_warning(); ?>
    </div>
    <div class="container_12">
        <div class="clearfix">
            <div class="grid_12">
                <div class="event-header clearfix border border-radius">
                    <div class="pull-left event-header-title">
                        
                        <h1><span class="summary"><?php echo $event['title'] ?></span></h1>
                        <h2>

                            <b>Author: </b><a href="<?php echo HelperUrl::baseUrl() ?>user/view_profile/s/current/u/<?php echo $event['user_id'] ?>"><?php echo $event['firstname']. ' ' . $event['lastname'] ?></a><br/>
                            
                            <?php echo '<b>From:</b> '.date('l,g:ia F j, Y',  strtotime($event['start_time']))?><br/>
                            <?php echo '<b>To:</b> '.date('l,g:ia F j, Y',  strtotime($event['end_time']))?><br/>
                            
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
                    <form method="POST">
                        <input type="hidden" name="count_ticket_type" value="<?php echo count($ticket_types); ?>">

                        <div class="heading">Ticket Information</div>
                        <div class="ticket">
                            <table width="100%" class="table ticket_table" id="ticket_table">
                                <thead>
                                    <tr class="ticket_table_head">
                                        <th width="210px">TICKET TYPE</th>
                                        <th>SALES END</th>
                                        <th>PRICE</th>
                                        <th>FEE</th>
                                        <th width="60px" align="right">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ticket_types as $k => $t): ?>
                                        <tr>
                                            <td>
                                                <?php echo $t['title']; ?>                                                
                                            </td>
                                            <td>

                                                <?php echo date('M j, Y', strtotime($t['sale_end'])) ?>

                                            </td>
                                            <td>$<?php echo $t['price'] ?></td>
                                            <td>$<?php echo $t['tax'] ?></td>
                                            <td>                             
                                                <?php if ((int) $t['remaining'] == 0 && (int)$t['total_ticket'] > 0): ?>
                                                SOLD OUT
                                                <?php else: ?>
                                                    <?php 
                                                    
                                                    $remaining = $t['remaining'] > (int)$t['minimum'] ? $t['remaining'] : (int)$t['minimum'];
                                                    ?>
                                                    <select name="ticket_type[<?php echo $t['id']; ?>]">
                                                        <option value='0'>0</option>
                                                        <?php for ($i = $t['minimum']; $i <= $remaining; $i++): ?>

                                                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                                        <?php endfor; ?>

                                                    </select>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="ticket-button clearfix">
                            <input type="submit" class="btn pull-right" value="Order now">
                        </div>
                    </form>
                </article>

                <article class="event event-box details radius-body border border-radius box-shadow-bottom">
                    <div class="heading">Event Detail</div>
                    <div class="event-body">
                        <section class="description"> <!-- class description is SEO, not css -->
                            <?php echo $event['description']; ?>
                        </section>
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
                <article class="event hosted border border-radius box-shadow-bottom">
                    <div class="heading">Hosted By</div>
                    <div class="event-body">
                        <h2>Friends4Growth (Sponsored by Singapore Management University)</h2>
                        <a class="contact-host btn-style clearfix">
                            <i class="icon ico-hosted"></i>
                            Contact the Host
                        </a>

                        <!--                        
                                                <div class="panel_icon clearfix">
                                                    <span class="sprite friend pull-left ">&nbsp;</span>
                                                    <a class="" href="#">
                                                        View other Friends4Growth (Sponsored by Singapore Management University) events 
                                                    </a>
                                                </div>
                        
                                                <div class="panel_icon clearfix">
                                                    <span class="sprite subcribe pull-left ">&nbsp;</span>
                                                    <a class="add_calendar" href="#">
                                                        Subscribe to receive notifications of future events by this host
                                                    </a>
                                                </div>
                        
                                                <ul class="other-calendar">
                                                    <li>
                                                        <div class="panel_icon clearfix">
                                                            <span class="sprite xml pull-left ">&nbsp;</span>
                                                            <a href="#" class="ico-outlook">View XML Feed</a>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="panel_icon add_calendar clearfix">
                                                            <span class="sprite rss-c pull-left ">&nbsp;</span>
                                                            <a href="#" class="">Subscribe to RSS Feed</a>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="panel_icon add_calendar clearfix">
                                                            <span class="sprite atom pull-left ">&nbsp;</span>
                                                            <a href="#" class="">Subscribe to Atom Feed</a>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="panel_icon add_calendar clearfix">
                                                            <span class="sprite google pull-left ">&nbsp;</span>
                                                            <a href="#" class="">Add to Google</a>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="panel_icon add_calendar clearfix">
                                                            <span class="sprite yahoo pull-left ">&nbsp;</span>
                                                            <a href="#" class="">Add to My yahoo!</a>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="panel_icon add_calendar clearfix">
                                                            <span class="sprite aol pull-left ">&nbsp;</span>
                                                            <a href="#" class="">Add to My AOL</a>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="panel_icon add_calendar clearfix">
                                                            <span class="sprite msn pull-left ">&nbsp;</span>
                                                            <a href="#" class="">Add to My MSN</a>
                                                        </div>
                                                    </li>
                                                </ul>-->

                    </div>
                </article>
            </div>
        </div>
    </div>
</div>