<div id="search_container">
    <h2>
        Tìm kiếm
    </h2>
    <form class="form-horizontal support-search-big" id="support-search" action="<?php echo Yii::app()->request->baseUrl; ?>/faq/search/" method="get">
        <fieldset>
            <input type="text" value="" maxlength="100" name="q" id="q" placeholder="Bạn vui lòng nhập vào đây điều bạn đang thắc mắc ..." class="input-xlarge" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
            <input type="submit" value="Tìm" class=" action_button action_button_go btn-style btn-search button-medium" id="support-search-submit">
        </fieldset>
    </form>
</div>