<div id="search_container">
    <h2>
        Search our Help Center 
    </h2>
    <form class="form-horizontal support-search-big" id="support-search" action="<?php echo Yii::app()->request->baseUrl; ?>/faq/search/" method="get">
        <fieldset>
            <input type="text" value="" maxlength="100" name="q" id="q" placeholder="Have a question?  Ask or enter a search term here...." class="input-xlarge" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
            <input type="submit" value="Search" class="btn action_button action_button_go btn-search button-medium" id="support-search-submit">
        </fieldset>
    </form>
</div>