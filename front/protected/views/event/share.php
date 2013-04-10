<div id="fb-root"></div>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id))
        return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=104204896436938";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
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

                        <h1><span class="summary"><?php echo $event['title'] ?>  <div class="fb-like" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false"></div></span></h1>

                        <h2>


                            <b>Address:</b> <?php echo $event['address'] ?>, <?php echo $event['country_title'] ?><br/>
                            <?php if ($event['address_2'] != ''): ?><b>Address 2:</b>:<?php echo $event['address_2'] ?>, <?php echo $event['country_title'] ?><br/><?php endif; ?>

                            <b>Event Creator: </b><a href="<?php echo HelperUrl::baseUrl() ?>user/view_profile/s/current/u/<?php echo $event['user_id'] ?>"><?php echo ($event['organizer_title'] != "") ? $event['organizer_title'] : $event['firstname'] . ' ' . $event['lastname'] ?></a><br/>

                            <?php echo '<b>From:</b> ' . date('l,g:ia F j, Y', strtotime($event['start_time'])) ?><br/>
                            <?php echo '<b>To:</b> ' . date('l,g:ia F j, Y', strtotime($event['end_time'])) ?><br/>


                        </h2>

                        <p><i>You can share this event by email or send Link</i></p>
                        <div class="share clearfix">
                            
                            <!-- AddThis Button BEGIN -->
                            <div class="addthis_toolbox addthis_default_style addthis_16x16_style">
                                <a style="float: left;margin-right: 10px;" href="#invite" class="share-email btn-invite"><img style="width: 30px" src="<?php echo HelperUrl::baseUrl() ?>images/share-email.png" /></a>
                                <a class="addthis_button_compact" addthis:url="<?php echo HelperUrl::baseUrl(true); ?>event/info/s/<?php echo $event['slug']; ?>" style="margin-top: 5px;"></a>
                            </div>
                            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=undefined"></script>
                            <!-- AddThis Button END -->
                        </div>
                        <div class="controls">
                            Link: <input type="text" class="event-url input-medium" value="<?php echo HelperUrl::baseUrl(true) ?>event/info/s/<?php echo $event['slug'] ?>">
                        </div>
                    </div>
                    <div class="pull-right event-header-thumb">
                        <a class="fancybox" href="<?php echo HelperApp::get_thumbnail($event['thumbnail'], 'full') ?>">
                            <img alt="" src="<?php echo HelperApp::get_thumbnail($event['thumbnail'], 'detail') ?>"/>
                        </a>
                    </div>
                </div>
            </div>

            <div id="invite" style="display: none">
                <h4>Invite by Email:</h4>
                <form class="form-style" method="post" action="<?php echo HelperUrl::baseUrl() ?>event/invite/s/<?php echo $event['slug'] ?>">
                    <div class="controls-group clearfix">
                        <label class="control-label pull-left">Email</label>
                        <div class="controls pull-left">
                            <textarea type="text" class="input-medium" name="email"></textarea>
                        </div>
                    </div>

                    <div class="controls-group clearfix">
                        <label class="control-label pull-left">&nbsp;</label>
                        <div class="controls pull-left">
                            <input type="submit" class="btn" value="Send"/>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="container_12">
        <div class="clearfix">
            <div class="grid_12">

            </div>

        </div>
    </div>
</div>