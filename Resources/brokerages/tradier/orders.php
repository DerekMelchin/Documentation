<h4>Order Types</h4>

<p>The following table describes the available order types for each asset class that <?= $cloudPlatform ? "our Tradier integration" : "the <code>TradierBrokerageModel</code>" ?> supports:</p>

<table class="qc-table table" id='order-types-table'>
   <thead>
      <tr>
        <th style='width: 50%'>Order Type</th>
        <th style='width: 25%'>Equity</th>
        <th style='width: 25%'>Equity Options</th>
      </tr>
   </thead>
   <tbody>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/market-orders'>MarketOrder</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
      </tr>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/limit-orders'>LimitOrder</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
      </tr>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/stop-market-orders'>StopMarketOrder</a></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
        <td><img src="https://cdn.quantconnect.com/i/tu/check.png" alt="green check" width="15px;"></td>
      </tr>
      <tr>
        <td><a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/stop-limit-orders'>StopLimitOrder</a></td>
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
<p><?= $writingAlgorithms ? "The <code>TradierBrokerageModel</code> supports" : "We model the Tradier API by supporting" ?> the following <a href='/docs/v2/writing-algorithms/trading-and-orders/order-properties#03-Time-In-Force'>TimeInForce</a> instructions:</p>

<ul>
    <li><code>Day</code></li>
    <li><code>GoodTilCanceled</code></li>
    <li><code>GoodTilDate</code></li>
</ul>

<?php if ($writingAlgorithms) { ?>
<div class="section-example-container">
    <pre class="csharp">public override void Initialize()
{
    // Set the default order properties
    DefaultOrderProperties.TimeInForce = TimeInForce.GoodTilCanceled;
}

public override void OnData(Slice slice)
{
    // Use default order order properties
    LimitOrder(_symbol, quantity, limitPrice);
    
    // Override the default order properties
    LimitOrder(_symbol, quantity, limitPrice, 
               orderProperties: new OrderProperties
               { 
                   TimeInForce = TimeInForce.Day 
               });
    LimitOrder(_symbol, quantity, limitPrice, 
               orderProperties: new OrderProperties
               { 
                   TimeInForce = TimeInForce.GoodTilDate(new DateTime(year, month, day)) 
               });
}</pre>
    <pre class="python">def Initialize(self) -&gt; None:
    # Set the default order properties
    self.DefaultOrderProperties.TimeInForce = TimeInForce.GoodTilCanceled

def OnData(self, slice: Slice) -&gt; None:
    # Use default order order properties
    self.LimitOrder(self.symbol, quantity, limit_price)
    
    # Override the default order properties
    order_properties = OrderProperties()
    order_properties.TimeInForce = TimeInForce.Day
    self.LimitOrder(self.symbol, quantity, limit_price, orderProperties=order_properties)

    order_properties.TimeInForce = TimeInForce.GoodTilDate(datetime(year, month, day))
    self.LimitOrder(self.symbol, quantity, limit_price, orderProperties=order_properties)</pre>
</div>
<?php } ?>

<h4>Updates</h4>
<p><?= $writingAlgorithms ? "The <code>TradierBrokerageModel</code> supports" : "We model the Tradier API by supporting" ?> most <a href='/docs/v2/writing-algorithms/trading-and-orders/order-management/order-tickets#04-Update-Orders'>order updates</a>. To update the quantity of an order, cancel the order and then submit a new order with the desired quantity.</p>


<h4>Extended Market Hours</h4>
<p><?= $cloudPlatform ? "Tradier" : "The <code>TradierBrokerageModel</code>" ?> doesn't support extended market hours trading. If you place an order outside of regular trading hours, the order will be processed at market open.</p>

<h4>Automatic Cancellations</h4>
<p>If you have open orders for a security when it performs a reverse split, <?= $cloudPlatform ? "Tradier" : "the <code>TradierBrokerageModel</code>" ?> automatically cancels your orders.</p>

