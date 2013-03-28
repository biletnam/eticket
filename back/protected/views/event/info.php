
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/event/">Event</a> <span class="divider">/</span> </li>
    <li class="active">Add</li>
</ul>
<?php echo Helper::print_success($message); ?>
<legend>Event Information</legend>
<ul>
    <li>Event title : <?php echo $event['title'] ?></li>
    <li>Start date : <?php echo date('d-m-Y H:i', strtotime($event['start_time'])); ?></li>
    <li>End date : <?php echo date('d-m-Y H:i', strtotime($event['end_time'])); ?></li>
    <li>Total ticket type: <?php echo count($ticket_types); ?></li>
    <?php
    $ticket_sold = 0;
    $total_amount = 0;
    foreach ($ticket_types as $t) {
        $ticket_sold += $t['total_ticket'];
        if ($t['service_fee']) {
            $total = round($t['total_ticket'] * $t['price'] * 1.1, 2);
        } else {
            $total = round($t['total_ticket'] * $t['price'], 2);
        }
        $total_amount += $total;
    }
    ?>

    <li>Tickets Sold : <?php echo $ticket_sold ?></li>
    <li><strong>Total Amount TTD : <span class="label label-info">TT$ <?php echo $total_amount ?> </span></strong></li>
    <li><strong>Total Amount USD : <span class="label label-success">$ <?php echo round($total_amount * ($usd['option_value'] / $ttd['option_value']), 2) ?></span></strong></li>
</ul>

<legend>Client Information</legend>
<ul>
    <li>Client ID : <?php echo $client['id'] ?></li>
    <li>Client name : <?php echo $client['title'] ?></li>
    <li>Email : <?php echo $client['email'] ?></li>
    <li>Joined date : <?php echo date('M d,Y', $client['join_date']) ?></li>
    <li>Country : <?php echo $client['country'] ?></li>
    <li><strong>Paypal account: <?php echo $client['paypal_account'] ?></strong></li>
</ul>
<?php if ($event['is_paid']): ?>
    <div class="alert alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Note!</h4>
        Event was paid.
    </div>
<?php else: ?>
    <form method="POST">
        <input type="hidden" name="temp"/>
        <input type="submit" class="btn btn-primary btn-confirm" value="Confirm">
    </form>
<?php endif; ?>