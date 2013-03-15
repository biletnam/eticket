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
                        <!--CONTENT-->
                        <div class="breadcrumbs">
                            <ul class="clearfix">
                                <li>
                                    <a href="<?php echo HelperUrl::baseUrl() ?>faq">FAQ</a>
                                </li>
                                <li><?php echo $category['title']; ?></li>
                            </ul>
                        </div>

                        <div class="row-fluid list clearfix">
                            <div class="span6">
                                <h3><?php echo $category['title']; ?></h3>
                                <ul>
                                    <?php foreach($faqs as $k=>$v): ?>
                                    <li>
                                        <a href="<?php echo Yii::app()->request->baseUrl."/faq/view/s/".$v['slug']; ?>">
                                            <?php echo $v['title']; ?>
                                        </a>
                                    </li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                        </div>
                        <!--END CONTENT-->
                        <?php $this->renderFile(Yii::app()->basePath . "/views/_shared/paging.php",array('paging'=>$paging)); ?>

                    </section>

                </div>
                <div class="span4 sidebar right pull-left">
                    Sidebar
                </div>
            </div>
        </section>
    </article>
</div>