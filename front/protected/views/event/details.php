<div class="page-event-detail">
    <div class="container_12">
        <div class="clearfix">
            <div class="grid_12">
                <div class="event-header clearfix border border-radius">
                    <div class="pull-left event-header-title">
                        <h1><span class="summary"><?php echo $event['title'] ?></span></h1>
                        <h2>
                            Adventure Geek Productions<br/>
                            
                            <?php echo '<b>From:</b> '.date('l,g:ia F j, Y',  strtotime($event['start_time']))?><br/>
                            <?php echo '<b>To:</b> '.date('l,g:ia F j, Y',  strtotime($event['end_time']))?><br/>
                            
                            <?php echo $event['city_title'] ?><br/>
                           
                        </h2>
                    </div>
                    <div class="pull-right event-header-thumb">
                        <img alt="" src="<?php HelperApp::get_thumbnail($event['thumbnail'])?>"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container_12">
        <div class="clearfix">
            <div class="grid_8">
                <article class="event event-box  ticket-info border border-radius box-shadow-bottom">
                    <form method="POST" action="<?php echo HelperUrl::baseUrl() ?>event/register_to_event/event/<?php echo $event['slug']?>">
                        <input type="hidden" name="count_ticket_type" value="<?php echo count($ticket_types);?>">
                        
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
                                    <?php foreach ($ticket_types as $k=>$t):?>
                                    <tr>
                                        <td>
                                            <?php echo $t['title'];?>
                                            <p>Price will go up at any time, as event nears. All ages.</p>
                                        </td>
                                        <td>
                                           
                                            <?php echo date('M j, Y',strtotime($t['sale_end']))?>
                                   
                                        </td>
                                        <td>$<?php echo $t['price']?></td>
                                        <td>$<?php echo $t['tax']?></td>
                                        <td>
                                            <?php echo $t['ticket_available']."/".$t['quantity']?>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                 
                    </form>
                </article>

                <article class="event event-box details radius-body border border-radius box-shadow-bottom">
                    <div class="heading">Event Detail</div>
                    <div class="event-body">
                        <section class="description"> <!-- class description is SEO, not css -->
                            <?php echo $event['description'];?>
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
                            <p><?php echo $event['address']?>, <?php echo $event['city_title']?></p>
                        </div>
                      
                        
                         <?php echo date('l, d/m/Y g:i a',  strtotime($event['start_time'])).' - '?><br/>
                        <?php echo date('l, d/m/Y g:i a',  strtotime($event['end_time']))?>
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

                    </div>
                </article>
            </div>
        </div>
    </div>
</div>