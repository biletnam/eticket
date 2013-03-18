<?php
$cities = Helper::cities();
?>

<div class="row page-search padding-bottom-50px">
    <div class="container container_12">
        <article class="row-fluid find-magu grid_12 border">
            <?php $this->renderPartial('search_sidebar', array('event_categories' => $event_categories, 'cities' => $cities, 'query_string' => $query_string)); ?>
            <section class="search search-content">
                <?php $this->renderPartial('search_bar', array('query_string' => $query_string,'cities' => $cities)); ?>


                <div id="search_results">
                    <div class="alert-message clearfix">
                        <strong>
                            List Events
                        </strong>
                        <div id="sort_results" class="hide">
                            <form action="?">
                                Sort: 
                                <select>
                                    <option value="#">
                                        Ngày tháng
                                    </option>
                                    <option selected="" value="#">
                                        Hợp lý
                                    </option>
                                </select>
                            </form>
                        </div> 
                    </div>
                    <div class="list-result">
                        <ul>
                            <?php if(count($events)<1):?>
                            <li class="clearfix">
                                No events found.
                            </li>
                            <?php endif;?>
                            <?php foreach ($events as $e): ?>
                                <li class="clearfix">
                                    <div class="date">
                                        <a href="<?php echo HelperUrl::baseUrl() ?>event/info/s/<?php echo $e['slug'] ?>">
                                            <img src="<?php echo HelperApp::get_thumbnail($e['thumbnail']) ?>" alt=""/>
                                        </a>
                                    </div>
                                    <div class="summary">
                                        <h4><a href="<?php echo HelperUrl::baseUrl() ?>event/info/s/<?php echo $e['slug'] ?>"><?php echo $e['title']?></a></h4>
                                        <span><?php echo $e['categories']['primary']['title']?><?php echo isset($e['categories']['second']['title']) ? ", ".$e['categories']['second']['title'] : ''?> </span>
                                        <?php 
                                        $start_time = strtotime($e['start_time']);
                                        $end_time = strtotime($e['end_time']);
                                        ?>
                                        <div class="clearfix"><label>Start Time: </label><?php echo ($e['display_start_time']==1) ? " ".date('M d, Y', $start_time )." at ".date('g:ia',$start_time) : ''?></div>
                                        <div class="clearfix"><label>End Time: </label><?php echo ($e['display_end_time']==1) ? " " .date('M d, Y', $end_time )." at ".date('g:ia',$end_time)  : ''?>
                                            <?php //echo ($e['is_repeat']==1) ? '(Tổ chức thường xuyên)': ''?></div>
                                        <div class="clearfix"><label>Location:</label>  <?php echo $e['location']?> - <?php echo $e['city_title']?></div>
                                    </div>
                                </li>
                            <?php endforeach; ?>

                        </ul>
                    </div>
                    <?php $this->renderFile(Yii::app()->basePath . "/views/_shared/paging.php", array('total' => $total, 'paging' => $paging)); ?>
                </div>


            </section>
        </article>
    </div>
</div>