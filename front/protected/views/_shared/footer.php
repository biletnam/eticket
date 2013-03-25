<?php $gallerys = HelperGlobal::get_publish(); ?>
<footer class="footer">
    <div class="city-land">&nbsp;</div>
    <div class="footer-main">
        <div class="container_12">
            <section class="clearfix block-main">
                <span class="grid_3 main-link">
                    <h6 class="ai">Main Links</h6>
                    <ul>
                        <li><a href="<?php echo HelperUrl::baseUrl() ?>">Home</a></li>
                        <li><a href="<?php echo HelperUrl::baseUrl() ?>page/index/s/about-us">About Us</a></li>
                        <li><a href="<?php echo HelperUrl::baseUrl() ?>page/index/s/services">Services</a></li>
                        <li><a href="<?php echo HelperUrl::baseUrl() ?>page/index/s/e-ticket">E-Ticket</a></li>
                        <li><a href="<?php echo HelperUrl::baseUrl() ?>page/contact_us">Contact Us</a></li>
                        <li><a href="<?php echo HelperUrl::baseUrl() ?>page/index/s/site-map">Site Map</a></li>
                    </ul>
                </span>
                <span class="grid_3 social-icon">
                    <h6 class="ai">Social Media</h6>
                    <ul class="clearfix">
                        <li><a href="#"><img src="<?php echo HelperUrl::baseUrl() ?>img/social/1.png"/></a></li>
                        <li><a href="#"><img src="<?php echo HelperUrl::baseUrl() ?>img/social/2.png"/></a></li>
                        <li><a href="#"><img src="<?php echo HelperUrl::baseUrl() ?>img/social/3.png"/></a></li>
                        <li><a href="#"><img src="<?php echo HelperUrl::baseUrl() ?>img/social/4.png"/></a></li>
                        <li><a href="#"><img src="<?php echo HelperUrl::baseUrl() ?>img/social/5.png"/></a></li>
                        <li><a href="#"><img src="<?php echo HelperUrl::baseUrl() ?>img/social/6.png"/></a></li>
                        <li><a href="#"><img src="<?php echo HelperUrl::baseUrl() ?>img/social/7.png"/></a></li>
                        <li><a href="#"><img src="<?php echo HelperUrl::baseUrl() ?>img/social/8.png"/></a></li>
                        <li><a href="#"><img src="<?php echo HelperUrl::baseUrl() ?>img/social/9.png"/></a></li>
                    </ul>
                </span>
                <span class="grid_3 footer-gallery">
                    <h6 class="ai">Events</h6>
                    <ul class="clearfix">

                        <?php foreach ($gallerys as $g): ?>
                        <li><a href="<?php echo HelperUrl::baseUrl()?>event/info/s/<?php echo $g['slug']?>"><img src="<?php echo HelperApp::get_thumbnail($g['thumbnail'], 'small') ?>"/></a></li>
                        <?php endforeach; ?>

                    </ul>
                </span>
                <span class="grid_3 footer-contact-us">
                    <h6 class="ai">Contact Us</h6>
                    <form class="form-contact_us" method="post" action="<?php echo HelperUrl::baseUrl() ?>page/Contact_us_ajax">
                        <div class="controls-group">
                            <input class="ai yourname" type="text" name="your_name" placeholder="Name:"/>
                        </div>
                        <div class="controls-group">
                            <input class="ai email" type="text" name="email" placeholder="Email:"/>
                        </div>
                        <div class="controls-group">
                            <textarea class="ai message" name="message" placeholder="Message:"></textarea>
                        </div>
                        <div class="form-actions clearfix">
                            <input class="ai pull-right btn-send-email" type="submit" value="Submit"/>
                        </div>
                        <div class="alert alert-error hide">
                            <strong>Error!</strong>
                            <p class="error-message">

                            </p>
                        </div>
                        <div class="alert alert-success hide" style="padding-right: 10px;margin-bottom: 0;margin-top:9px">
                            <p style="margin-bottom: 0">Thank you for your submitting.</p>
                        </div>
                    </form>
                </span>
            </section>
            <section class="copyright">
                <p>Copyright &copy; by All Rights Reserved</p>
            </section>
        </div>
    </div>
</footer>
</div>

<script type="text/javascript" src="<?php echo HelperUrl::baseUrl(); ?>js/libs.js"></script>
<script type="text/javascript" src="<?php echo HelperUrl::baseUrl(); ?>js/flexslider.js"></script>

<script type="text/javascript" src="<?php echo HelperUrl::baseUrl(); ?>/js/tiny_mce/tiny_mce.js"></script>    
<script type="text/javascript" src="<?php echo HelperUrl::baseUrl(); ?>js/fancybox/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="<?php echo HelperUrl::baseUrl(); ?>js/jquery.html5-placeholder-shim.js"></script>
<script type="text/javascript" src="<?php echo HelperUrl::baseUrl(); ?>js/app.js?v=04032013"></script>

</body>
</html>