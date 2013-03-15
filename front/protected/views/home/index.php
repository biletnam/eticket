<!-- start: Flexslider -->
<section class="slider">


    <div id="flex1" class="flexslider">
        <ul class="slides">

            <li>
                <img src="<?php echo HelperUrl::baseUrl(); ?>img/banner.png" alt="" />
            </li>

            <li>
                <img src="<?php echo HelperUrl::baseUrl(); ?>img/banner_1.png" alt="" />
            </li>
        </ul>
    </div>



</section>
<!-- end: Flexslider -->

<section class="content home">
    <div class="container_12 clearfix events">
        <span class="grid_12">
            <div class="heading">
                <h1 class="bebasneue">
                    Events
                </h1>
            </div>
            <ul class="clearfix">
                <?php foreach($events as $k => $v): ?>
                <li>
                    <h6 class="bebasneue"><?php echo date('d F Y',strtotime($v['start_time'])) ?></h6>
                    <div class="border-style">&nbsp;</div>
                    <div class="cleafix">
                        <div class="event-thumbnail pull-left">
                            <a href="<?php echo HelperUrl::baseUrl()?>event/info/s/<?php echo $v['slug']?>">
                                <img src="<?php echo HelperApp::get_thumbnail($v['thumbnail']); ?>"/>
                            </a>
                        </div>
                        <div class="event-summary pull-left">
                            <div>
                                <p><?php echo Helper::string_truncate(strip_tags($v['description']),100) ?></p>
                            </div>
                            <a class="bebasneue" href="<?php echo HelperUrl::baseUrl()?>event/info/s/<?php echo $v['slug']?>">Get A Ticket</a>
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </span>
    </div>
</section>