<form action="buy.php" method="post">
    <fieldset>
        <div class="form-group">
            <input autocomplete="off" autofocus class="form-control" name="symbol" placeholder="Symbol" type="text"/>
        </div>
        <div class="form-group">
            <input class="form-control" name="shares" placeholder="Shares" type="text"/>
        </div>
        <div class="form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-usd"></span>
                Buy
            </button>
        </div>
    </fieldset>
</form>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Info</h3>
    </div>
    <div class="panel-body text-info">
        <p>If you'd like to buy some stocks, specify a stock and a number of shares and push Buy button.</p>
        <p>Some examples of symbols:</p>
    </div>
    <table class="table table-sm table-striped table-bordered">
        <thead>
            <tr>
                <th>Symbol</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody align="left">
            <tr>
                <td>TWTR</td>
                <td>Twitter, Inc. Common Stock</td>
            </tr>
            <tr>
                <td>AAPL</td>
                <td>Apple Inc.</td>
            </tr>
            <tr>
                <td>GOOG</td>
                <td>Alphabet Inc.</td>
            </tr>
        </tbody>
    </table>
    <div class="text-info">
        <p>More examples <span><strong><a href="http://finance.yahoo.com/" target="_blank">here</a></strong></span></p>
    </div>    
</div>