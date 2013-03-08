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
                        <!--CONTENT-->
                        <nav class="breadcrumbs">
                            <ul class="clearfix">
                                <li>
                                    <a href="<?php echo Yii::app()->request->baseUrl; ?>">Home page</a>
                                </li>
                                <li><?php echo $category['title']; ?></li>
                            </ul>
                        </nav>

                        <div class="row-fluid list">
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
                <div class="span4 sidebar right">
                    Sidebar
                </div>
            </div>
        </section>
    </article>
</div>