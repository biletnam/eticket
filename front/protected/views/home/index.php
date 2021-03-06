<?php if (isset($_GET['register']) && $_GET['register']): ?>
    <section class="container_12 register-success">
        <div class="grid_12">
            <div class="alert alert-success">
                <h4>Congratulations! Your registration was successful.</h4>
                <p>You may now browse and purchase tickets from any event you wish to attend.</p>

                <p>If you registered as an ‘Event Organizer’ this section of your account will firstly need to be approved. This usually takes 24-48 hrs. Once you are approved we will send you an email confirming this</p>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- start: Flexslider -->

<section class="slider container_12">

    <div class="grid_12">
        <div id="flex1" class="flexslider">
            <ul class="slides">
                <?php foreach ($sliders as $s): ?>
                    <li>
                        <img src="<?php echo HelperApp::get_thumbnail($s['thumbnail'], 'homepage') ?>" alt="<?php echo $s['title'] ?>" />
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

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
                <?php foreach ($events as $k => $v): ?>
                    <li>
                        <h6 class="bebasneue"><?php echo date('d F Y', strtotime($v['start_time'])) ?></h6>
                        <div class="border-style">&nbsp;</div>
                        <div class="clearfix">
                            <div class="event-thumbnail pull-left">
                                <a href="<?php echo HelperUrl::baseUrl() ?>event/info/s/<?php echo $v['slug'] ?>">
                                    <img src="<?php echo HelperApp::get_thumbnail($v['thumbnail'], 'home_thumbnail'); ?>"/>
                                </a>
                            </div>
                            <div class="event-summary pull-left">
                                <div>
                                    <p><?php echo Helper::string_truncate(strip_tags($v['description']), 80) ?></p>
                                </div>
                                <a class="bebasneue" href="<?php echo HelperUrl::baseUrl() ?>event/info/s/<?php echo $v['slug'] ?>">Get A Ticket</a>
                            </div>
                        </div>
                        <h6 class="bebasneue event-title"><a href="<?php echo HelperUrl::baseUrl() ?>event/info/s/<?php echo $v['slug'] ?>"><?php echo $v['title']; ?></a></h6>
                    </li>
                <?php endforeach; ?>
            </ul>
        </span>
    </div>
</section>