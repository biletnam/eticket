<?php
$cities = Helper::cities();
?>

<div class="row">
    <div class="container">
        <article class="row-fluid find-magu">
            <?php $this->renderPartial('search_sidebar', array('event_categories' => $event_categories, 'cities' => $cities, 'query_string' => $query_string)); ?>
            <section class="search span9">
                <?php $this->renderPartial('search_bar', array('query_string' => $query_string)); ?>


                <div id="search_results">
                    <div class="alert-message clearfix">
                        <strong>
                            Danh sách sự kiện ở Việt Nam
                        </strong>
                        <div id="sort_results">
                            <form action="?">
                                Sắp xếp: 
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
                            <?php foreach ($events as $e): ?>
                                <li class="clearfix">
                                    <div class="date">
                                        <p><strong>SUN</strong>Aug 19</p>
                                    </div>
                                    <div class="summary">
                                        <h4><a href="#"><?php echo $e['title']?></a></h4>
                                        <span><?php echo $e['categories']['primary']['title']?><?php echo isset($e['categories']['second']['title']) ? ", ".$e['categories']['second']['title'] : ''?> </span>
                                        <div class="clearfix"><label>Thời gian: </label><?php echo ($e['display_start_time']==1) ? " ".$e['start_time'] : ''?>
                                        <?php echo ($e['display_end_time']==1) ? ' - '.$e['end_time'] : ''?>
                                            <?php echo ($e['is_repeat']==1) ? '(Tổ chức thường xuyên)': ''?>
                                        </div>
                                        <div class="clearfix"><label>Địa Điểm:</label>  <?php echo $e['location']?> - <?php echo $e['city']?></div>
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