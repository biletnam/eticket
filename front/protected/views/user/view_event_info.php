<section class="manage-event">
    <?php if (count($event_all_tickets_sold)<1): ?>
        No results.
    <?php else: ?>
        <?php foreach ($event_all_tickets_sold as $e): ?>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th colspan="2">Ticket <?php echo $e['title'] ?></th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td width="200px">All Tickets</td>
                        <td><?php echo $e['quantity'] ?></td>
                    </tr>
                    <tr>
                        <td >In Store</td>
                        <td><?php echo $e['quantity'] - $e['total_ticket'] ?></td>
                    </tr>
                    <tr>
                        <td >Service Fee</td>
                        <td><?php 
                            if($e['service_fee'])
                                echo 'Yes';
                            else
                                echo 'No';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Sold</td>
                        <td><?php echo $e['total_ticket'] ?></td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td>
                            <?php 
                            if($e['service_fee'])
                                echo $e['price']*1.1;
                            else
                                echo $e['price'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-bold align-right">Total Price</td>
                        <td class="text-bold">TT$ <?php 
                            if($e['service_fee'])
                                echo round($e['total_ticket']*$e['price']*1.1 , 2);
                            else
                                echo round($e['total_ticket']*$e['price'] , 2);
                            ?>
                        </td>
                    </tr>
                    

                </tbody>
            </table>
            <br/>
        <?php endforeach; ?>
    <?php endif; ?>
</section>