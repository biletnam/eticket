
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/event/">Event</a> <span class="divider">/</span> </li>
    <li class="active">Add</li>
</ul>

<legend>Event Information</legend>
<ul>
    <li>Event title: <?php echo $event['title'] ?></li>
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
    <li>Tickets Sold :<?php echo $ticket_sold ?></li>
    <li><strong>Total Amount : TT$ <?php echo $total_amount ?> </strong></li>
</ul>

<legend>Client Information</legend>
<ul>
    <li>Client ID : <?php echo $client['id'] ?></li>
    <li>Client name : <?php echo $client['title'] ?></li>
    <li>Email : <?php echo $client['email'] ?></li>
    <li>Joined date : <?php echo date('M d,Y',$client['join_date']) ?></li>
    <li>Country : <?php echo $client['country'] ?></li>
    <li><strong>Paypal account: <?php echo $client['paypal_account'] ?></strong></li>
</ul>

<a class="btn btn-primary" href="#">Send Money</a>