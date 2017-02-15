<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Symbol</th>
            <th>Name</th>
            <th>Shares</th>
            <th>Price</th>
            <th>TOTAL</th>
        </tr>
    </thead>
    <tfoot align="left" class="text-info">
        <tr class="bg-info">
            <th scope="row"><?= count($positions) + 1?></th>
            <td><strong>CASH</strong></td>
            <td><strong>Available Balance</strong></td>
            <td></td>
            <td></td>
            <td><strong>$<?= number_format($user["cash"], 2, '.', ',')?></strong></td>
        </tr>
    </tfoot>    
    <tbody align="left">
        <?php foreach ($positions as $position): ?>       
        <tr>
            <th scope="row"><?= $position["i"] ?></th>
            <td><?= $position["symbol"] ?></td>
            <td><?= $position["name"] ?></td>
            <td><?= $position["shares"] ?></td>
            <td>$<?= $position["price"] ?></td>
            <td>$<?= number_format(($position["shares"] * $position["price"] ), 2, '.', ',')?></td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>