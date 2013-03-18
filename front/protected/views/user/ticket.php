<div class="form-style border border-radius page-detail-ticket">
    <table>
        <tbody>
            <tr>
                <td width="100px" class="text-right"><b>Ticket :</b></td>
                <td> <?php echo $ticket_type['title'] ?> </td>
            </tr>
            <tr>
                <td class="text-right"><b>Event :</b></td>
                <td> <?php echo $ticket_type['event_title'] ?> </td>
            </tr>
            <tr>
                <td class="text-right"><b>Quantity :</b></td>
                <td> <?php echo $ticket_type['total_ticket'] ?> </td>
            </tr>
            <tr>
                <td class="text-right"><b>Price :</b></td>
                <td> <?php echo $ticket_type['price'] ?> </td>
            </tr>
            <tr>
                <td class="text-right"><b>Buy date :</b></td>
                <td> <?php echo date('M j, Y', $ticket_type['date_added']) ?> </td>
            </tr>

            <tr>
                <td class="text-right"><b>Description :</b></td>
                <td> <?php echo $ticket_type['description'] ?> </td>
            </tr>
        </tbody>
    </table>
    <div class="text-right">
        <a class="btn" href="javascript: window.history.go(-1)"><i class="icon icon-back"></i> Back</a>
    </div>
</div>