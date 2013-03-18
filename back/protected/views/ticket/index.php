
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/ticket/">Tickets</a> <span class="divider">/</span> </li>
    <li class="active">All</li>
</ul>

<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/paging.php", array('total' => $total, 'paging' => $paging)); ?>
<table class="table table-bordered table-striped table-center">
    <thead>
        <tr>    
            <th>Visitor</th>
            <th>User</th>
            <th>Type Ticket</th>
            <th>Event</th>
<!--            <th class="row-action"></th>-->
        </tr>
    </thead>
    <tbody>
        <?php if (count($tickets) < 1): ?>
            <tr>
                <td colspan="5" class="align-center">Result not found</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($tickets as $v): ?>
            <tr>
                
                <td style="text-align: left"><?php echo $v['visitor_firstname'].' '.$v['visitor_lastname'] ?><br/>
                    <span class="label label-success"><?php echo $v['visitor_email']?></span>
                </td> 
                
                <td ><a href="<?php echo Yii::app()->request->baseUrl . "/ticket/edit/id/" . $v['id']; ?>"><?php echo $v['user_email'] ?></a></td> 
                  <td ><?php echo $v['ticket_type_name'] ?></td> 
                     <td ><?php echo $v['event_name'] ?></td> 
                
<!--                <td>
                    <a class="btn btn-small btn-danger delete-row" href="<?php //echo Yii::app()->request->baseUrl . "/ticket/delete/id/" . $v['id']; ?>">Delete</a>
                </td>-->


            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/paging.php", array('total' => $total, 'paging' => $paging)); ?>