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
                        <a style="float: left;margin-right: 10px;display: none" href="<?php echo HelperUrl::baseUrl() ?>event/share/s/<?php echo $event['slug'] ?>"><img class="link-logo" style="width: 60px" src="<?php echo HelperUrl::baseUrl() ?>images/share.png" ></a>
                        <!-- AddThis Button BEGIN -->
                        <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
                            <a class="addthis_button_compact"></a><a class="addthis_counter addthis_bubble_style"></a>
                        </div>
                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=undefined"></script>
                        <!-- AddThis Button END -->

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
                                        <?php /* <th>FEE</th> */ ?>
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
                                            <td>TT$<?php
                                            if ($t['service_fee'])
                                                echo $t['price'] * 1.1;
                                            else
                                                echo $t['price'];
                                                ?>
                                            </td>
                                            <?php /* <td>$<?php echo $t['price']*1.1 ?></td> */ ?>
                                            <td>                             
                                                <?php if (intval($t['remaining']) == 0 && intval($t['total_ticket']) > 0): ?>
                                                    SOLD OUT
                                                <?php else: ?>
                                                    <?php
                                                    $remaining = intval($t['remaining']) > intval($t['minimum']) ? intval($t['remaining']) : intval($t['minimum']);
                                                    ?>
                                                    <select name="ticket_type[<?php echo $t['id']; ?>]">
                                                        <option value='0'>0</option>
                                                        <?php for ($i = intval($t['minimum']); $i <= $remaining; $i++): ?>

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
                            <input type="submit" <?php if (count($ticket_types) == 0): ?>class="hide"<?php endif; ?> class="btn pull-right" value="Order now">
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
                            <iframe width="270" scrolling="no" height="250" frameborder="0" src="http://maps.google.com/maps?q=<?php echo urlencode($event['address']); ?>;&amp;iwloc=near&amp;z=15&amp;output=embed" marginwidth="0" marginheight="0"></iframe><br>        
                            <br/>
                        </div>
                        <div class="vcard">

                            <p>Address: <?php echo $event['address'] ?>, <?php echo $event['country_title'] ?></p>
                            <?php if ($event['address_2'] != ''): ?>
                                <p>Address 2: <?php echo $event['address_2'] ?>, <?php echo $event['country_title'] ?></p>
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