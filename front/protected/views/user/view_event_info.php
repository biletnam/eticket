<section class="manage-event">
    <?php if (count($event_all_tickets_sold)<1): ?>
        No results.
    <?php else: ?>
        <table class="table table-bordered table-striped">
            <thead>
                    <tr>
                        <th colspan="2">Summary</th>
                    </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($event_all_tickets_sold as $e): ?>
                <tr>
                    <td width="200px">Ticket <?php echo $e['title'] ?></td>
                    <td>TT$
                        <?php 
                            if($e['service_fee']){
                                $total_price_ticket_type = round($e['total_ticket']*$e['price']*1.1 , 2);
                                echo $total_price_ticket_type;
                            }
                            else{
                                $total_price_ticket_type = round($e['total_ticket']*$e['price'] , 2);
                                echo $total_price_ticket_type;
                            }
                            $total += $total_price_ticket_type;
                        ?> 
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td class="text-bold align-right">Total Price</td>
                    <td class="text-bold">TT$ <?php echo $total; ?></td>
                </tr>
            </tbody>
        </table>
        <br/>
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
                        <td>Stock</td>
                        <td><?php echo $e['quantity'] - $e['total_ticket'] ?></td>
                    </tr>
                    <tr>
                        <td>Service Fee</td>
                        <td><?php 
                            if($e['service_fee'])
                                echo 'Customer Paid';
                            else
                                echo 'Client Paid';
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