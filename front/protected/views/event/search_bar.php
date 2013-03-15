<div id="search_bar">
    <form action="" method="get" name="searchform" id="searchform" class="form-search clearfix">
        <?php foreach ($query_string as $k => $v): ?>
            <?php if ($k == "city" || $k == "cate") continue; ?>
            <input type="hidden" name="<?php echo $k; ?>" value="<?php echo $v; ?>"/>
        <?php endforeach; ?>

        <input type="text" autocomplete="off" placeholder="Title" maxlength="50" class="search-title" name="title" value="<?php if (isset($_GET['title'])) echo $_GET['title']; ?>">
        <!--<input type="text" autocomplete="off" value="" maxlength="50" class="search-location" name="city" id="cityfield" placeholder="Location" value="<?php if (isset($_GET['city'])) echo $_GET['city']; ?>">-->
        <select class="search-location pull-left" name="city">
            <option value="0">--Choose a city--</option>
            <?php foreach($cities as $c): ?>
            <option <?php if(isset($_GET['city']) && $_GET['city'] == $c['id']) echo 'selected' ?> value="<?php echo $c['id'] ?>"><?php echo $c['title'] ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn search_button button-submit">Find Events</button>
    </form>
</div>