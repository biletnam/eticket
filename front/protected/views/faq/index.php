<div class="row-fluid articles page-faq container_12 padding-bottom-50px">
    <article class="container grid_12">
        <section class="wrap radius-body border border-radius">
            <div class="row-fluid clearfix">
                <div class="span8 main pull-left">
                    <?php $this->renderPartial('help'); ?>
                    <section id="welcome">
                        <?php $this->renderPartial('search'); ?>

                        <div id="intro">
                            <h3>New to eTicket?</h3>
                            <section class="row-fluid clearfix">
                                <div class="span5 intro-left pull-left">
                                    <img src="<?php echo HelperUrl::baseUrl() ?>/images/thumb_feature_tutorial.jpg" alt="">
                                </div>
                                <article class="span7 intro-right pull-left">
                                    <p>
                                        From sample pages to FAQ's for beginners, here's what you need to get started. Remember, Eventbrite's free to use if your event is free, so go ahead and create a test event page to give things a try! 
                                    </p>
                                    <p>
                                        You can enter a search term in <strong>Search</strong> on top. Or you can refer about the topics often asked in the list below.
                                    </p>
                                    <nav class="hide">
                                        <a href="#">View our help for beginners</a>
                                        <a href="#">View all videos</a>
                                    </nav>
                                </article>
                            </section>
                        </div>
                    </section>

                    <section class="main-content">
                        <?php $total_categories = count($categories); ?>
                        <?php for($i = 0;$i < ceil($total_categories / 2); $i++): ?>
                        <?php 
                        $cate_1 = $categories[($i * 2)];
                        $cate_2 = isset($categories[($i * 2) + 1])  ? $categories[($i * 2) + 1] : null;
                        ?>
                        <div class="row-fluid list clearfix">
                            <div class="span6">
                                <h3> <?php echo $cate_1['title'] ?></h3>
                                <ul>
                                    <?php foreach($cate_1['faqs'] as $f): ?>
                                    <li>
                                        <a href="<?php echo HelperUrl::baseUrl() ?>faq/view/s/<?php echo $f['slug'] ?>"><?php echo $f['title'] ?></a>
                                    </li>
                                    <?php endforeach;?>
                                </ul>
                                <a href="<?php echo HelperUrl::baseUrl()."faq/category/c/".$cate_1['slug']."/"; ?>" class="view-all">View all</a>
                            </div>
                            <?php if($cate_2): ?>
                            <div class="span6">
                                <h3> <?php echo $cate_2['title'] ?></h3>
                                <ul>
                                    <?php foreach($cate_2['faqs'] as $f): ?>
                                    <li>
                                        <a href="<?php echo HelperUrl::baseUrl() ?>faq/view/s/<?php echo $f['slug'] ?>"><?php echo $f['title'] ?></a>
                                    </li>
                                    <?php endforeach;?>
                                </ul>
                                <a href="<?php echo HelperUrl::baseUrl()."faq/category/c/".$cate_2['slug']."/"; ?>" class="view-all">View all</a>
                            </div>
                            <?php endif;?>
                        </div>
                        <?php endfor;?>
                    </section>

                </div>
                <div class="span4 sidebar right pull-left">
                    &nbsp;
                </div>
            </div>
        </section>
    </article>
</div>