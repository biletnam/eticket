<div class="row-fluid articles page-faq container_12 padding-bottom-50px">
    <article class="container grid_12">
        <section class="wrap radius-body border border-radius">
            <div class="row-fluid clearfix">
                <div class="span8 main pull-left">
                    <?php $this->renderPartial('help'); ?>
                    <section id="welcome">
                        <?php $this->renderPartial('search'); ?>
                    </section>
                    <section class="main-content">
                        <div class="breadcrumbs">
                            <ul class="clearfix">
                                <li>
                                    <a href="<?php echo HelperUrl::baseUrl() ?>faq">FAQ</a>
                                </li>
                                <li><a href="<?php echo HelperUrl::baseUrl() ?>faq/category/c/<?php echo $faq['category_slug'] ?>"><?php echo $faq['category_name'] ?></a></li>
                            </ul>
                            <div class="share-social hide">
                                <span>Share:</span> 
                                <ul class="clearfix">
                                    <li><a class="icon-social fbook" href="#">facebook</a></li>
                                    <li><a class="icon-social twitter" href="#">twitter</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="entry-content">
                        <?php echo $faq['description']; ?>
                        </div>

                        <!--end CONTENT-->
                        <div id="nextsteps">
                            <div id="article_feedback" class="clearfix hide">
                                <div class="submitted_feedback clearfix">
                                    <span>Did you find this article useful?</span>
                                    <a href="#" class="icon-rate smile">Yes</a>
                                    <a href="#" class="icon-rate sad">No</a>
                                </div>
                                <div class="questions">
                                    Have more questions?
                                    <a href="#">Contact us!</a>
                                </div>
                            </div>
                            <div class="callstoaction clearfix">
                                <a class="btn-style btn-primary btn-event" href="<?php echo HelperUrl::baseUrl() ?>event/create">Create an Event</a>
                                <a class="btn-style btn-inverse" href="<?php echo HelperUrl::baseUrl() ?>user/account">Go to My Account</a>
                            </div>
                        </div>

                    </section>
                </div>
                <div class="span4 sidebar right pull-left">
                    Sidebar
                </div>
            </div>
        </section>
    </article>
</div>