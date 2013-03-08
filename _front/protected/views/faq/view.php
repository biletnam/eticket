<div class="row-fluid articles">
    <article class="container">
        <section class="wrap radius-body">
            <div class="row-fluid">
                <div class="span8 main">
                    <?php $this->renderPartial('help'); ?>
                    <section id="welcome">
                        <?php $this->renderPartial('search'); ?>
                    </section>

                    <section class="main-content">
                        <nav class="breadcrumbs">
                            <ul class="clearfix">
                                <li>
                                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/faq/">Home page</a>
                                </li>
                                <li><a href="#"><?php echo $faq['category_name'] ?></a></li>
                            </ul>
                            <div class="share-social">
                                <span>Share:</span> 
                                <ul class="clearfix">
                                    <li><a class="icon-social fbook" href="#">facebook</a></li>
                                    <li><a class="icon-social twitter" href="#">twitter</a></li>
                                </ul>
                            </div>
                        </nav>
                        
                        <?php echo $faq['description']; ?>
                        

                        <!--end CONTENT-->
                        <div id="nextsteps">
                            <div id="article_feedback" class="clearfix">
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
                                <a class="btn-style btn-event" href="#">Create an Event</a>
                                <a class="btn btn-info" href="#">Go to My Account</a>
                            </div>
                        </div>

                    </section>
                </div>
                <div class="span4 sidebar right">
                    Sidebar
                </div>
            </div>
        </section>
    </article>
</div>