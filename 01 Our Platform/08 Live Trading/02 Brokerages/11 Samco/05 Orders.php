<p>We model the Samco API by supporting several order types, supporting order properties, and order updates. When you deploy live algorithms, you can place manual orders through the IDE.</p>

<h4>Order Types</h4>

<p>Samco supports the following order types:</p>

<ul>
    <li><code>MarketOrder</code></li>
    <li><code>LimitOrder</code></li>
    <li><code>StopMarketOrder</code></li>
    <li><code>StopLimitOrder</code></li>
    <li><code>MarketOnOpenOrder</code></li>
    <li><code>MarketOnCloseOrder</code></li>
    <li><code>LimitIfTouchedOrder</code></li>
</ul>

<div class="section-example-container">
    <pre class="csharp">MarketOrder(_symbol, quantity);
LimitOrder(_symbol, quantity, limitPrice);
StopMarketOrder(_symbol, quantity, stopPrice);
StopLimitOrder(_symbol, quantity, stopPrice, limitPrice);
MarketOnOpenOrder(_symbol, quantity);
MarketOnCloseOrder(_symbol, quantity);
LimitIfTouchedOrder(_symbol, quantity, triggerPrice, limitPrice);</pre>
    <pre class="python">self.MarketOrder(self.symbol, quantity)
self.LimitOrder(self.symbol, quantity, limit_price)
self.StopMarketOrder(self.symbol, quantity, stop_price)
self.StopLimitOrder(self.symbol, quantity, stop_price, limit_price)
self.MarketOnOpenOrder(self.symbol, quantity)
self.MarketOnCloseOrder(self.symbol, quantity)
self.LimitIfTouchedOrder(self.symbol, quantity, trigger_price, limit_price)</pre>
</div>

<h4>Order Properties</h4>

<p>We model custom order properties from the Samco API. The following table describes the members of the <code>IndiaOrderProperties</code> object that you can set to customize order execution:</p>

<table class="table qc-table">
    <thead>
        <tr>
            <th style="width: 25%">Property</th>
            <th style="width: 75%">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>Exchange</code></td>
            <td>Select the exchange for sending the order to. The following instructions are available:
                <ul>
                    <li><code>NSE</code></li>
                    <li><code>BSE</code></li>
                </ul>
            </td>
        </tr>
        <tr>
            <td><code>ProductType</code></td>
            <td>
                A <code>ProductType</code> instruction to apply to the order. The <code>IndiaProductType</code> enumeration has the following members:
                <div data-tree='QuantConnect.Orders.IndiaOrderProperties.IndiaProductType'></div>
            </td>
        </tr>
        <tr>
            <td><code>TimeInForce</code></td>
            <td>A <code>TimeInForce</code> instruction to apply to the order. The following instructions are available:
                <ul>
                    <li><code>Day</code></li>
                    <li><code>GoodTilCanceled</code></li>
                    <li><code>GoodTilDate</code></li>
                </ul>
            </td>
        </tr>
    </tbody>
</table>


<div class="section-example-container">
    <pre class="csharp">public override void Initialize()
{
    // Set default order properties
    DefaultOrderProperties = new IndiaOrderProperties(Exchange.NSE, IndiaOrderProperties.IndiaProductType.NRML)
    {
        TimeInForce = TimeInForce.GoodTilCanceled,
    };
}

public override void OnData(Slice slice)
{
    // Use default order order properties
    LimitOrder(_symbol, quantity, limitPrice);
    
    // Override the default order properties
    LimitOrder(_symbol, quantity, limitPrice, 
               orderProperties: new IndiaOrderProperties(Exchange.BSE, IndiaOrderProperties.IndiaProductType.MIS)
               {
                   TimeInForce = TimeInForce.Day,
               };
    LimitOrder(_symbol, quantity, limitPrice, 
               orderProperties: new IndiaOrderProperties(Exchange.BSE, IndiaOrderProperties.IndiaProductType.CNC)
               {
                   TimeInForce = TimeInForce.GoodTilDate,
               };
}</pre>
    <pre class="python">def Initialize(self) -&gt; None:
    # Set the default order properties
    self.DefaultOrderProperties = IndiaOrderProperties(Exchange.NSE, IndiaOrderProperties.IndiaProductType.NRML)
    self.DefaultOrderProperties.TimeInForce = TimeInForce.GoodTilCanceled

def OnData(self, slice: Slice) -&gt; None:
    # Use default order order properties
    self.LimitOrder(self.symbol, quantity, limit_price)
    
    # Override the default order properties
    order_properties = IndiaOrderProperties(Exchange.BSE, IndiaOrderProperties.IndiaProductType.MIS)
    order_properties.TimeInForce = TimeInForce.Day
    self.LimitOrder(self.symbol, quantity, limit_price, orderProperties=order_properties)

    order_properties = IndiaOrderProperties(Exchange.BSE, IndiaOrderProperties.IndiaProductType.CNC)
    order_properties.TimeInForce = TimeInForce.GoodTilDate
    self.LimitOrder(self.symbol, quantity, limit_price, orderProperties=order_properties)</pre>
</div>


<h4>Updates</h4>
<p>We model the Samco API by supporting order updates.</p>

<div class="section-example-container">
    <pre class="csharp">var ticket = LimitOrder(_symbol, quantity, limitPrice);
var updateSettings = new UpdateOrderFields();
updateSettings.LimitPrice = newLimitPrice;
ticket.Update(updateSettings);</pre>
    <pre class="python">ticket = self.LimitOrder(self.symbol, quantity, limit_price)
updateSettings = UpdateOrderFields()
updateSettings.LimitPrice = new_limit_price
ticket.Update(updateSettings)</pre>
</div>

