<form action="sell.php" method="post">
    <fieldset>
        <div class="form-group">
            <select class="form-control" name="symbol">
                <option disabled selected value>Symbol</option>
                <?php foreach ($symbols as $symbol): ?> 
                    <option value="<?= $symbol ?>"><?= $symbol ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-usd"></span>
                Sell
            </button>
        </div>
    </fieldset>
</form>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Info</h3>
    </div>
    <div class="panel-body text-info">
        <p>Choice the Symbol, which you'd like to sell and push Sell button</p>
    </div>
</div>