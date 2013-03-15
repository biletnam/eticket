<aside class="sidebar">
    <div class="sidebar-wrap">
        <div id="filter_date" class="filter">
            <h3>Date</h3>
            <ul>
                <li>
                    <a href="<?php echo Yii::app()->baseUrl?>/event/search">All</a>
<!--                    <span>(68340)</span>-->
                </li>
                <li class="">
                    <a href="<?php echo Yii::app()->baseUrl?>/event/search?date=today">Today</a>
                    
                </li>
                <li class="">
                    <a href="<?php echo Yii::app()->baseUrl?>/event/search?date=tomorrow">Tomorrow</a>
                    
                </li>
                <li class="">
                    <a href="<?php echo Yii::app()->baseUrl?>/event/search?date=week">This Week</a>
                    
                </li>
                <li class="">
                    <a href="<?php echo Yii::app()->baseUrl?>/event/search?date=month">This Month</a>
                    
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
            <h3>Category</h3>
            <ul>
                <li>
                    <a href="<?php echo Yii::app()->baseUrl?>/event/search">All Categories</a>
                    
                </li>
                <?php foreach ($event_categories as $k => $e): ?>
                    <li class="">
                        <a href="<?php echo Yii::app()->baseUrl?>/event/search?cate=<?php echo $e['id']?>"><?php echo $e['title'] ?></a>
                        
                    </li>
                <?php endforeach; ?>

            </ul>
        </div>




        <div id="filter_city" class="filter">
            <h3>Location</h3>
            <ul>
                <?php foreach ($cities as $k => $c): ?>
                    <li class="">
                        <a href="<?php echo Yii::app()->baseUrl?>/event/search?city=<?php echo $c['id']?>"><?php echo $c['title']; ?></a>
                        
                    </li>
                <?php endforeach; ?>

            </ul>
        </div>


    </div>
</aside>