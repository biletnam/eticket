<div class="pagination clearfix">
    <div class="pull-left">
        <form class="form-search" method="get">
            <input type="text" class="input-medium search-query" name="s" placeholder="Content" value="<?php echo isset($_GET['s']) ? trim($_GET['s']) : ""; ?>"/>
            <button type="submit" class="btn">Search</button>
        </form>
    </div>
    <?php if(isset($paging)): ?>
    <div class="pull-right">
        <span class="total-records pull-left"><strong><?php echo number_format($total); ?></strong> result</span>
        <ul class="pull-right"><?php echo $paging; ?></ul>
    </div>
    <?php endif;?>
</div>
