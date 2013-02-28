<div class="row-fluid home">
    <div class="container">
        <div class="row-fluid">
            <div class="span12 featured">
                <div class="info">
                    <h3>If it's happening out there you'll find it here.</h3>
                    <p>Browse 1000s of events. Or create your own events and sell tickets right here.</p>
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/event/create" class="btn btn-large btn-primary">Create an Event</a> (It's free)
                </div>
                <div class="banner">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner.png" alt=""/>
                </div>
            </div>                    
        </div>
        <div class="row-fluid magu-home">
            <div class="span8 magu-listing">
                <h2>Discover events in Ho Chi Minh</h2>
                <form class="form-search home-search">
                    <input type="text" class="input-xlarge search-query" placeholder="Search for concerts, conferences, and more ...">
                    <button type="submit" class="btn btn-success">Search</button>
                </form>
                <?php foreach ($events as $k => $v): ?>
                    <div class="row-fluid magu">
                        <div class="span2 label label-info">
                            <?php echo date('l', strtotime($v['start_time'])); ?><br/>
                            <?php echo date('d-m-Y', strtotime($v['start_time'])); ?>
                        </div>
                        <div class="span10">
                            <div class="title"><a href="<?php echo Yii::app()->request->baseUrl; ?>/event/info/s/<?php echo $v['slug'] ?>"><?php echo $v['title'] ?></a></div>
                            <div class="category">
                                <a href=""><?php echo $v['categories']['primary']['title'] ?></a>
                                <?php if (isset($v['categories']['second'])): ?>
                                    , <a href=""><?php echo $v['categories']['second']['title'] ?></a>
                                <?php endif; ?>
                            </div>
                            <div class="time"><strong>When:</strong> <?php echo "day " . date('d', strtotime($v['start_time'])) . " month " . date('m', strtotime($v['start_time'])) . " year " . date('Y', strtotime($v['start_time'])) . date(' - g:i', strtotime($v['start_time'])); ?> <?php echo Helper::_Vn_meridiem(date('a', strtotime($v['start_time']))); ?></div>
                            <div class="location"><strong>Where:</strong> <?php echo $v['location'] . ", " . $v['city'] ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <a href="" class="pull-right">View more events in Ho Chi Minh <i class="icon-circle-arrow-right"></i></a>
            </div>                    
            <div class="span4 hot-magu">
                <ul>
                    <?php foreach ($popular_categories as $k => $v): ?>
                        <li>
                            <a href="">
                                <div class="img"><img src="<?php echo HelperApp::get_thumbnail($v['thumbnail']) ?>" alt=""/></div>
                                <div class="overlay"></div>
                                <div class="overlayContent">
                                    <div class="category"><?php echo $v['title'] ?></div>
                                    <div class="title"><?php echo $v['description'] ?></div>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>                    
        </div>
        <div class="row-fluid">
            <div class="span12 home_featured">
                <h2>Popular events</h2>
                <div class="row-fluid">
                    <?php foreach ($popular_events as $k => $v): ?>
                        <div class="span4 magu">
                            <div class="img"><a href="<?php echo Yii::app()->request->baseUrl; ?>/event/info/s/<?php echo $v['slug'] ?>"><img src="<?php echo HelperApp::get_thumbnail($v['thumbnail']); ?>" alt=""/></a></div>
                            <div class="title"><a href="<?php echo Yii::app()->request->baseUrl; ?>/event/info/s/<?php echo $v['slug'] ?>"><?php echo $v['title'] ?></a></div>
                            <div class="row-fluid">                                    
                                <div class="span9">
                                    <div class="time"><strong>When:</strong> <?php echo date('d/m/Y', strtotime($v['start_time'])); ?> - <?php echo date('g:i', strtotime($v['start_time'])); ?> <?php echo Helper::_Vn_meridiem(date('a', strtotime($v['start_time']))); ?></div>
                                    <div class="location"><strong>Where:</strong> <?php echo $v['city']; ?></div>
                                </div>
                                <div class="span3">
                                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/event/info/s/<?php echo $v['slug'] ?>" class="btn btn-info">Detail</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>                    
        </div>
    </div> <!-- /container -->
</div>