<h4>Order Types</h4>
<p>The following table describes the available order types for each asset class that <?= $cloudPlatform ? "our OANDA integration" : "the <code>OANDABrokerageModel</code>" ?> supports:</p>

<table class="qc-table table" id='order-types-table'>
   <thead>
      <tr>
        <th style='width: 50%'>Order Type</th>
        <th style='width: 25%'>Forex</th>
        <th style='width: 25%'>CFD</th>
      </tr>
   </thead>
   <tbody>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/market-orders'>Market</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
      </tr>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/limit-orders'>Limit</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
      </tr>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/stop-market-orders'>Stop market</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
      </tr>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/stop-limit-orders'>Stop limit</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
      </tr>
   </tbody>
</table>

<style>
#order-types-table td:not(:first-child), 
#order-types-table th:not(:first-child) {
    text-align: center;
}
</style>

<h4>Time In Force</h4>
<p><?php if ($writingAlgorithms) { ?>
  The <code>OANDABrokerageModel</code> the <code class='csharp'>GoodTilCanceled</code><code class='python'>GOOD_TIL_CANCELED</code> <a href='/docs/v2/writing-algorithms/trading-and-orders/order-properties#03-Time-In-Force'>TimeInForce</a>. 
<?php } else { ?>
  We model the <code class='csharp'>GoodTilCanceled</code><code class='python'>GOOD_TIL_CANCELED</code> <a href='/docs/v2/writing-algorithms/trading-and-orders/order-properties#03-Time-In-Force'>TimeInForce</a> from the OANDA API. 
<?php } ?></p>

<?php if ($writingAlgorithms) { ?>
<div class="section-example-container">
    <pre class="csharp">DefaultOrderProperties.TimeInForce = TimeInForce.GoodTilCanceled;
LimitOrder(_symbol, quantity, limitPrice);</pre>
    <pre class="python">self.default_order_properties.time_in_force = TimeInForce.GOOD_TIL_CANCELED
self.limit_order(self._symbol, quantity, limit_price)</pre>
</div>
<?php } ?>


<h4>Updates</h4>
<p><?= $writingAlgorithms ? "The <code>OANDABrokerageModel</code> supports" : "We model the OANDA API by supporting" ?> <a href='/docs/v2/writing-algorithms/trading-and-orders/order-management/order-tickets#04-Update-Orders'>order updates</a>.</p>
