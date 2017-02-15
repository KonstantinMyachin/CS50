<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Transaction</th>
            <th>Date/Time</th>
            <th>Symbol</th>
            <th>Name</th>
            <th>Shares</th>
            <th>Price</th>
            <th>Current Price</th>
        </tr>
    </thead>
    <tbody align="left">
        <?php foreach ($transactions as $transaction): ?>       
        <tr>
            <th scope="row"><?= $transaction["i"] ?></th>
            <?php if ($transaction["type"] == "BUY"): ?>
                <td class="bg-success">
            <?php else: ?>
                <td class="bg-danger">
            <?php endif ?>
            <?= $transaction["type"] ?></td>
            <td><?= $transaction["date"] ?></td>
            <td><?= $transaction["symbol"] ?></td>
            <td><?= $transaction["name"] ?></td>
            <td><?= $transaction["shares"] ?></td>
            <td>$<?= number_format($transaction["price"], 2, '.', ',') ?></td>
            <td><strong>$<?= number_format($transaction["currentPrice"], 2, '.', ',') ?> 
            <?php if ($transaction["price"] < $transaction["currentPrice"]): ?>
                <span class="glyphicon glyphicon-triangle-top text-success">
            <?php elseif ($transaction["price"] > $transaction["currentPrice"]): ?>
                <span class="glyphicon glyphicon-triangle-bottom text-danger">
            <?php endif ?>
            </span></strong></td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>