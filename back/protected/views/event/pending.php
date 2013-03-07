
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/event/">Event</a> <span class="divider">/</span> </li>
    <li class="active">All</li>
</ul>
<p><a href="<?php echo Yii::app()->request->baseUrl; ?>/event/add/" class="btn btn-primary">Add an new event</a></p> 
<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/paging.php", array('total' => $total, 'paging' => $paging)); ?>
<table class="table table-bordered table-striped table-center">
    <thead>
        <tr>          
            <th class="row-img"></th>
            <th>Event Title</th>
            <th>Category</th>            
            <th>Location</th>
            <th>Time</th>
            <th class="row-action"></th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($events) < 1): ?>
            <tr>
                <td colspan="6" class="align-center">Result not found</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($events as $v): ?>
            <tr id="tr_<?php echo $v['id'] ?>">
                <td><img width="50" class="img-polaroid" src="<?php echo HelperApp::get_thumbnail($v['thumbnail'], 'small') ?>" /></td>
                <td style="text-align: left"><a href="<?php echo Yii::app()->request->baseUrl . "/event/edit/id/" . $v['id']; ?>"><?php echo $v['title'] ?></a></td>    
                <td>
                    <?php foreach ($v['categories'] as $c): ?>
                        <p><a href="<?php echo Yii::app()->request->baseUrl; ?>/category/edit/id/<?php echo $c['id'] ?>"><?php echo $c['title'] ?></a></p>
                    <?php endforeach; ?>
                </td>
                <td>
                    <a href="<?php echo Yii::app()->request->baseUrl ?>/location/id/<?php echo $v['location_id'] ?>"><?php echo $v['location'] ?></a><br/>
                    <span class="label label-success"><?php echo $v['city'] ?></span>
                </td>
                <td>
                    <p>Start: <span class="label"><?php echo date('d-m-Y H:i', strtotime($v['start_time'])); ?></span></p>
                    <p>End: <span class="label"><?php echo date('d-m-Y H:i', strtotime($v['end_time'])); ?></span></p>
                </td>

                <td class="align-left">
                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            Actions
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="approved" href="<?php echo HelperUrl::baseUrl() . "event/approved/id/" . $v['id'] . '/user/' . $v['author']; ?>">Approved</a></li>
                            <li>
                                <a class="fancybox destroy remove-<?php echo $v['id'] ?>" href="#event<?php echo $v['id']; ?>" value="<?php echo HelperUrl::baseUrl() . "event/destroy/id/" . $v['id']; ?>">
                                    Disqualify
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div id="event<?php echo $v['id'] ?>" class="hide span8">
                        <div class="row-fluid">
                            <legend>Disqualify event: <?php echo $v['title'] ?></legend>
                            <form class="form-horizontal frm-approve" action="<?php echo HelperUrl::baseUrl() . "event/destroy/id/" . $v['id']; ?>" method="POST">
                                <div class="alert alert-success hide">
                                    <button data-dismiss="alert" class="close" type="button">×</button>
                                    <h4>Congratulations!</h4>Disqualify successfully.
                                </div>
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label">Reason</label>
                                        <div class="controls">
                                            <textarea class="span8 note" name="note"></textarea>
                                        </div>
                                    </div>

                                    <a class="btn btn-danger btn-destroy" href="<?php echo HelperUrl::baseUrl() . "event/destroy" ?>" value="<?php echo $v['id'] ?>">Disqualify</a>
                                    <input type="hidden" class="event_id" name="id" value="<?php echo $v['id'] ?>"/>
                                    <input type="hidden" class="user_email" name="user_email" value="<?php if (isset($v['email']) && $v['email'] != NULL) echo $v['email']; else echo 'ntnhanbk@gmail.com'; ?>"/>
                                </fieldset>
                            </form>
                        </div>
                    </div>



                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/paging.php", array('total' => $total, 'paging' => $paging)); ?>