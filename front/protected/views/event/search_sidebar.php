<aside class="sidebar span3">
    <div class="sidebar-wrap">
        <div id="filter_date" class="filter">
            <h3>Ngày</h3>
            <ul>
                <li class="active">
                    <a href="<?php echo Yii::app()->baseUrl?>/event/search">Tất cả</a>
                    <span>(68340)</span>
                </li>
                <li class="">
                    <a href="<?php echo Yii::app()->baseUrl?>/event/search?date=today">Hôm nay</a>
                    <span>(2314)</span>
                </li>
                <li class="">
                    <a href="<?php echo Yii::app()->baseUrl?>/event/search?date=tomorrow">Ngày mai</a>
                    <span>(2771)</span>
                </li>
                <li class="">
                    <a href="<?php echo Yii::app()->baseUrl?>/event/search?date=week">Trong tuần</a>
                    <span>(12552)</span>
                </li>
<!--                <li class="">
                    <a href="#">Cuối tuần</a>
                    <span>(5231)</span>
                </li>-->
                <li class="">
                    <a href="<?php echo Yii::app()->baseUrl?>/event/search?date=month">Trong tháng</a>
                    <span>(32789)</span>
                </li>
            </ul>
        </div>




<!--        <div id="filter_price" class="filter">
            <h3>Giá vé</h3>
            <ul>
                <li class="active">
                    <a href="#">Tất cả</a>
                    <span>(68340)</span>
                </li>
                <li class="">
                    <a href="#">Miễn phí</a>
                    <span>(24242)</span>
                </li>
                <li class="">
                    <a href="#">Giá thấp</a>
                    <span>(13330)</span>
                </li>
                <li class="">
                    <a href="#">Giá trung bình</a>
                    <span>(15684)</span>
                </li>
                <li class="">
                    <a href="#">Giá cao</a>
                    <span>(16210)</span>
                </li>
            </ul>
        </div>-->




        <div id="filter_category" class="filter">
            <h3>Lĩnh vực</h3>
            <ul>
                <li class="active">
                    <a href="<?php echo Yii::app()->baseUrl?>/event/search">Tất Cả</a>
                    <span>(68340)</span>
                </li>
                <?php foreach ($event_categories as $k => $e): ?>
                    <li class="">
                        <a href="<?php echo Yii::app()->baseUrl?>/event/search?cate=<?php echo $e['id']?>"><?php echo $e['title'] ?></a>
                        <span>(68340)</span>
                    </li>
                <?php endforeach; ?>

            </ul>
        </div>




        <div id="filter_city" class="filter">
            <h3>Tỉnh / Thành phố</h3>
            <ul>
                <?php foreach ($cities as $k => $c): ?>
                    <li class="">
                        <a href="<?php echo Yii::app()->baseUrl?>/event/search?city=<?php echo $c?>"><?php echo $c; ?></a>
                        <span>(2583)</span>
                    </li>
                <?php endforeach; ?>

            </ul>
        </div>


    </div>
</aside>