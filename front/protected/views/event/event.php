<article class="container">
    <div class="event-header">
        <h1><span class="summary"><?php echo $event['title'] ?> - <?php echo $event['city'] ?></span></h1>
        <?php if (date('d-m-Y', strtotime($event['start_time'])) == date('d-m-Y', strtotime($event['end_time']))): ?>
            <h2><?php echo date('l', strtotime($event['start_time'])); ?>, <?php echo date('d/m/Y', strtotime($event['start_time'])); ?> from <?php echo date('g:i', strtotime($event['start_time'])); ?> <?php echo date('a', strtotime($event['start_time'])); ?> to <?php echo date('g:i', strtotime($event['end_time'])); ?> <?php echo date('a', strtotime($event['end_time'])); ?></h2>
        <?php else: ?>
            <h2><?php echo date('l', strtotime($event['start_time'])); ?>, <?php echo date('d/m/Y', strtotime($event['start_time'])); ?> <?php echo date('g:i', strtotime($event['start_time'])); ?> <?php echo  date('a', strtotime($event['start_time'])); ?> - <?php echo date('l', strtotime($event['end_time'])); ?>, <?php echo date('d/m/Y', strtotime($event['end_time'])); ?> <?php echo date('g:i', strtotime($event['end_time'])); ?> <?php echo date('a', strtotime($event['end_time'])); ?></h2>
        <?php endif; ?>
    </div>
    <div class="row-fluid">
        <section class="span8 main">
            <article class="event ticket-info radius-body">
                <form>
                    <div class="heading">Ticket Information</div>
                    <div class="ticket panel_body">
                        <table width="100%"  id="ticket_table" class="ticket_table">
                            <thead>
                                <tr class="ticket_table_head">
                                    <th width="240px" nowrap="nowrap">
                                        Ticket Type 
                                    </th>
                                    <th>Sales End</th>
                                    <th>
                                        &nbsp;
                                    </th>
                                    <th width="60px" align="right">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ticket_types as $v): ?>
                                <?php $is_ended = time() > strtotime($v['sale_end']) ? true : false; ?>
                                    <tr class="ticket_row">
                                        <td class="ticket_type_name">
                                            <?php echo $v['title'] ?>
                                        </td>
                                        <td nowrap="nowrap">
                                            <?php if ($is_ended): ?>
                                                End
                                            <?php else: ?>
                                                <?php if (date('d-m-Y', strtotime($v['sale_end'])) == date('d-m-Y')): ?>
                                                    <?php echo DateTimeFormat::remaining_time(strtotime($v['sale_end'])); ?>
                                                <?php else: ?>
                                                    <?php echo date('d-m-Y', strtotime($v['sale_end'])); ?>
                                                <?php endif; ?>
                                            <?php endif; ?>


                                        </td>
                                        <td nowrap="nowrap">
                                            <?php echo Helper::_types($v['type']); ?>
                                        </td>
                                        <td nowrap="nowrap" align="right">
                                            <?php if($is_ended || $v['remaining'] == 0): ?>
                                            Sold Out
                                            <?php else: ?>
                                            <?php 
                                            $max = $v['maximum'] ? $v['maximum'] : 1; 
                                            $max = $v['remaining'] < $max ? $v['remaining'] : $max;
                                            ?>
                                            <select class="ticket_table_select">
                                                <?php for($i = 1; $i <= $max;$i++): ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?>&nbsp;</option>
                                                <?php endfor;?>
                                            </select>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="ticket-button">
                        <a href ="http://localhost/vsk/front/event/register_to_event" class="btn-style button-medium btn-large">Order now</a>
                    </div>
                </form>
            </article>

            <article class="event details radius-body">
                <div class="heading">Event Details</div>
                <div class="event-body">
                    <section class="description"> <!-- class description is SEO, not css -->
                        <?php echo $event['description']; ?>
                    </section>
                </div>
            </article>

        </section>
        <div class="span4 sidebar">
            <article class="event where radius-body">
                <div class="heading">When & Where</div>
                <div class="event-body">
                    <div class="vcard">
                        <iframe width="270" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?q=<?php echo urlencode($event['address']); ?>;&amp;iwloc=near&amp;z=15&amp;output=embed"></iframe><br />        
                    </div>
                    <div class="vcard">
                        <h6><?php echo $event['location'] ?></h6>
                        <p><?php echo $event['address'] ?>, <?php echo $event['city'] ?> </p>
                    </div>
                    <?php if (date('d-m-Y', strtotime($event['start_time'])) == date('d-m-Y', strtotime($event['end_time']))): ?>
                        <div class="date"><?php echo date('D', strtotime($event['start_time'])); ?>, <?php echo date('d/m/Y', strtotime($event['start_time'])); ?> from <?php echo date('g:i', strtotime($event['start_time'])); ?> <?php echo date('a', strtotime($event['start_time'])); ?> To <?php echo date('g:i', strtotime($event['end_time'])); ?> <?php echo date('a', strtotime($event['end_time'])); ?></div>
                    <?php else: ?>
                        <div class="date"><?php echo date('l', strtotime($event['start_time'])); ?>, <?php echo date('d/m/Y', strtotime($event['start_time'])); ?> <?php echo date('g:i', strtotime($event['start_time'])); ?> <?php echo date('a', strtotime($event['start_time'])); ?> - <?php echo date('l', strtotime($event['end_time'])); ?>, <?php echo date('d/m/Y', strtotime($event['end_time'])); ?> <?php echo date('g:i', strtotime($event['end_time'])); ?> <?php echo date('a', strtotime($event['end_time'])); ?></div>
                    <?php endif; ?>                    
                    <!--
                <div class="panel_icon clearfix">
                    <span class="sprite calendar pull-left ">&nbsp;</span>
                    <a class="add_calendar pull-left" href="#">Add to my calendar</a>
                </div> -->

                    <ul class="other-calendar">
                        <li>
                            <div class="panel_icon clearfix">
                                <span class="sprite outlook pull-left ">&nbsp;</span>
                                <a class=" ico-outlook " href="#">Outlook calendar</a>
                            </div>
                        </li>
                        <li>
                            <div class="panel_icon add_calendar clearfix">
                                <span class="sprite google pull-left ">&nbsp;</span>
                                <a class="" href="#">Google calendar</a>
                            </div>
                        </li>
                        <li>
                            <div class="panel_icon add_calendar clearfix">
                                <span class="sprite yahoo pull-left ">&nbsp;</span>
                                <a class="" href="#">Yahoo calendar</a>
                            </div>
                        </li>
                        <li>
                            <div class="panel_icon add_calendar clearfix">
                                <span class="sprite ical pull-left ">&nbsp;</span>
                                <a class="" href="#">iCal calendar</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </article>
            <article class="event hosted radius-body">
                <div class="heading">Hosted By</div>
                <div class="event-body">
                    <h2>Friends4Growth (Sponsored by Singapore Management University)</h2>
                    <a class="contact-host btn clearfix">
                        <span class="sprite ico-hosted">&nbsp;</span>
                        Contact the Host
                    </a>

                    <div class="panel_icon clearfix">
                        <span class="sprite friend pull-left ">&nbsp;</span>
                        <a href="#" class="">
                            View other Friends4Growth (Sponsored by Singapore Management University) events 
                        </a>
                    </div>

                    <div class="panel_icon clearfix">
                        <span class="sprite subcribe pull-left ">&nbsp;</span>
                        <a href="#" class="add_calendar">
                            Subscribe to receive notifications of future events by this host
                        </a>
                    </div>

                    <ul class="other-calendar">
                        <li>
                            <div class="panel_icon clearfix">
                                <span class="sprite xml pull-left ">&nbsp;</span>
                                <a class="ico-outlook" href="#">View XML Feed</a>
                            </div>
                        </li>
                        <li>
                            <div class="panel_icon add_calendar clearfix">
                                <span class="sprite rss-c pull-left ">&nbsp;</span>
                                <a class="" href="#">Subscribe to RSS Feed</a>
                            </div>
                        </li>
                        <li>
                            <div class="panel_icon add_calendar clearfix">
                                <span class="sprite atom pull-left ">&nbsp;</span>
                                <a class="" href="#">Subscribe to Atom Feed</a>
                            </div>
                        </li>
                        <li>
                            <div class="panel_icon add_calendar clearfix">
                                <span class="sprite google pull-left ">&nbsp;</span>
                                <a class="" href="#">Add to Google</a>
                            </div>
                        </li>
                        <li>
                            <div class="panel_icon add_calendar clearfix">
                                <span class="sprite yahoo pull-left ">&nbsp;</span>
                                <a class="" href="#">Add to My yahoo!</a>
                            </div>
                        </li>
                        <li>
                            <div class="panel_icon add_calendar clearfix">
                                <span class="sprite aol pull-left ">&nbsp;</span>
                                <a class="" href="#">Add to My AOL</a>
                            </div>
                        </li>
                        <li>
                            <div class="panel_icon add_calendar clearfix">
                                <span class="sprite msn pull-left ">&nbsp;</span>
                                <a class="" href="#">Add to My MSN</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </article>
        </div>
    </div>
</article>