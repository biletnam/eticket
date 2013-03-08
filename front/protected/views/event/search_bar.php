<div id="search_bar">
    <form action="" method="get" name="searchform" id="searchform" class="form-search clearfix">
        <?php foreach ($query_string as $k => $v): ?>
            <?php if ($k == "city" || $k == "cate") continue; ?>
            <input type="hidden" name="<?php echo $k; ?>" value="<?php echo $v; ?>"/>
        <?php endforeach; ?>

        <input type="text" autocomplete="off" placeholder="Tìm kiếm (vd: âm nhạc, giáo dục)" maxlength="50" class="search-title" name="cate" value="<?php if (isset($_GET['cate'])) echo $_GET['cate']; ?>">
        <input type="text" autocomplete="off" value="" maxlength="50" class="search-location" name="city" id="cityfield" placeholder="Tỉnh / Thành phố" value="<?php if (isset($_GET['city'])) echo $_GET['city']; ?>">
        <button type="submit" class="btn-style search_button button-medium button-submit">Tìm Sự Kiện</button>
    </form>
</div>