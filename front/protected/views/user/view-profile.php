<div class="container_12 page-view-profile padding-bottom-50px">
    <div class="clearfix">
        <?php if ($user['role'] == 'waiting' || $user['role'] == 'customer'): ?>
            <section class="grid_4 bar-organize">
                <img src="<?php echo HelperApp::get_thumbnail($user['thumbnail'], 'thumbnail') ?>" alt=""/>
                <div class="box-organize-info border">
                    <h6 class="organize-title"><?php echo $user['firstname'] . ' ' . $user['lastname'] ?> 

                        <?php if ($user['id'] == UserControl::getId()): ?>
        <!--<a class="btn-style" href="<?php echo HelperUrl::baseUrl() ?>user/make_profile">Edit</a>-->
                        <?php endif; ?>

                    </h6>
                    <p>
                        Email: <?php echo $user['email'] ?>
                    </p>
                </div>
            </section>
        <?php else: ?>
            <section class="grid_4 bar-organize">
                <img src="<?php echo HelperApp::get_thumbnail($user['organizer_thumbnail'], 'thumbnail') ?>" alt=""/>
                <div class="box-organize-info border">
                    <h6 class="organize-title"><?php echo $user['organizer_title'] ?>
                        <?php if ($user['id'] == UserControl::getId()): ?>
                           
                            <a class="btn-style" href="<?php echo HelperUrl::baseUrl() ?>user/make_profile">Edit</a>
                        <?php endif; ?>
                    </h6>
                    <p>
                        <?php echo $user['organizer_description'] ?>
                    </p>
                </div>
            </section>
        <?php endif; ?>
        <section class="grid_8 box-organize-list-events">
            <div class="organize-list-events-wrap border">
                <div class="header-tab">
                    <ul class="clearfix">
                        <li><a class="<?php if ($current_tab == 'current') echo 'current' ?>" href="javascript:void(0);">Events</a></li>
                        <!--                        <li><a href="#">Feature Events</a></li>
                                                <li><a href="#">Past Events</a></li>-->
                    </ul>
                </div>
                <div class="organize-list-events">
                    <ul>
                        <?php foreach ($list_events as $e): ?>
                            <li>
                                <section class="clearfix">
                                    <div class="col-left">
                                        <a href="<?php echo HelperUrl::baseUrl() ?>event/info/s/<?php echo $e['slug'] ?>">
                                            <img src="<?php echo HelperApp::get_thumbnail($e['thumbnail'], 'home_thumbnail') ?>"/>
                                        </a>
                                    </div>
                                    <div class="col-center">
                                        <?php
                                        $start_time = strtotime($e['start_time']);
                                        $end_time = strtotime($e['end_time']);
                                        ?>
                                        <h6>
                                            <a href="<?php echo HelperUrl::baseUrl() ?>event/info/s/<?php echo $e['slug'] ?>"><?php echo $e['title'] ?></a><br/>
                                            <time>
                                                <?php echo ($e['display_start_time'] == 1) ? " " . date('m/d/Y', $start_time) . " " . date('g:ia', $start_time) : '' ?> 
                                                - 
                                                <?php echo ($e['display_end_time'] == 1) ? " " . date('m/d/Y', $end_time) . " " . date('g:ia', $end_time) : '' ?>
                                            </time>
                                        </h6>
                                        <p>
                                            <?php echo Helper::string_truncate($e['description'], 100) ?>
                                        </p>
                                    </div>
                                    <div class="col-right">
                                        <a class="btn" href="<?php echo HelperUrl::baseUrl() ?>event/info/s/<?php echo $e['slug'] ?>">Attend</a>
                                    </div>
                                </section>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <?php $this->renderFile(Yii::app()->basePath . "/views/_shared/paging.php", array('total' => $total, 'paging' => $paging)); ?>
            </div>
        </section>
    </div>
</div>