<div class="row-fluid home">
    <div class="container">
        <div class="row-fluid">
            <div class="span12 featured">
                <div class="info">
                    <h3>Danh bạ Sự kiện ở Việt Nam</h3>
                    <p>Tìm thông tin về Sự kiện đang/sắp diễn ra. Hoặc tạo Sự kiện của riêng bạn và bắt đầu bán vé ngay tại đây.</p>
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/event/create" class="btn btn-large btn-primary">Tạo Sự Kiện</a> (miễn phí)
                </div>
                <div class="banner">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner.png" alt=""/>
                </div>
            </div>                    
        </div>
        <div class="row-fluid magu-home">
            <div class="span8 magu-listing">
                <h2>Tìm Sự kiện trong thành phố Hồ Chí Minh</h2>
                <form class="form-search home-search">
                    <input type="text" class="input-xlarge search-query" placeholder="Tìm kiếm chương trình, sự kiện, hội thảo, ...">
                    <button type="submit" class="btn btn-success">Tìm kiếm</button>
                </form>
                <?php foreach ($events as $k => $v): ?>
                    <div class="row-fluid magu">
                        <div class="span2 label label-info">
                            <?php echo Helper::_Vn_day(date('D', strtotime($v['start_time']))); ?><br/>
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
                            <div class="time"><strong>Khi nào:</strong> <?php echo "ngày " . date('d', strtotime($v['start_time'])) . " tháng " . date('m', strtotime($v['start_time'])) . " năm " . date('Y', strtotime($v['start_time'])) . date(' - g:i', strtotime($v['start_time'])); ?> <?php echo Helper::_Vn_meridiem(date('a', strtotime($v['start_time']))); ?></div>
                            <div class="location"><strong>Ở đâu:</strong> <?php echo $v['location'] . ", " . $v['city'] ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <a href="" class="pull-right">Xem thêm Sự kiện trong thành phố Hồ Chí Minh <i class="icon-circle-arrow-right"></i></a>
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
                <h2>Sự kiện nổi bật</h2>
                <div class="row-fluid">
                    <?php foreach ($popular_events as $k => $v): ?>
                        <div class="span4 magu">
                            <div class="img"><a href="<?php echo Yii::app()->request->baseUrl; ?>/event/info/s/<?php echo $v['slug'] ?>"><img src="<?php echo HelperApp::get_thumbnail($v['thumbnail']); ?>" alt=""/></a></div>
                            <div class="title"><a href="<?php echo Yii::app()->request->baseUrl; ?>/event/info/s/<?php echo $v['slug'] ?>"><?php echo $v['title'] ?></a></div>
                            <div class="row-fluid">                                    
                                <div class="span9">
                                    <div class="time"><strong>Khi nào:</strong> <?php echo date('d/m/Y', strtotime($v['start_time'])); ?> - <?php echo date('g:i', strtotime($v['start_time'])); ?> <?php echo Helper::_Vn_meridiem(date('a', strtotime($v['start_time']))); ?></div>
                                    <div class="location"><strong>Ở đâu:</strong> <?php echo $v['city']; ?></div>
                                </div>
                                <div class="span3">
                                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/event/info/s/<?php echo $v['slug'] ?>" class="btn btn-info">Mua vé</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>                    
        </div>
    </div> <!-- /container -->
</div>