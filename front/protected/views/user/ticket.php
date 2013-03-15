<div class="form-style border">
    <table>
        <tbody>
            <tr>
                <td width="100px"><b>Ticket :</b></td>
                <td> <?php echo $ticket_type['title'] ?> </td>
            </tr>
            <tr>
                <td><b>Event :</b></td>
                <td> <?php echo $ticket_type['event_title'] ?> </td>
            </tr>

            <tr>
                <td><b>Price :</b></td>
                <td> <?php echo $ticket_type['price'] ?> </td>
            </tr>



            <tr>
                <td><b>Buy Day :</b></td>
                <td> <?php echo date('M j, Y', $ticket_type['date_added']) ?> </td>
            </tr>

            <tr>
                <td><b>Description :</b></td>
                <td> <?php echo $ticket_type['description'] ?> </td>
            </tr>
        </tbody>
    </table>
    <div>
        <a class="btn-style btn-primary" href="javascript: window.history.go(-1)">Detail</a>
    </div>
</div>