<div class="page padding-bottom-50px">
    <div class="container_12">
        <div class="cleafix">
            <section class="grid_12">
                <article class="border border-radius form-style">
                    <div class="page-thumbnail">
                        <?php if($page['thumbnail']): ?>
                        <img src="<?php echo HelperApp::get_thumbnail($page['thumbnail'],'full') ?>"/>
                        <br/><br/>
                        <?php endif; ?>
                    </div>
                    
                    <?php echo $page['content']; ?>
                </article>
            </section>
        </div>
    </div>
</div>