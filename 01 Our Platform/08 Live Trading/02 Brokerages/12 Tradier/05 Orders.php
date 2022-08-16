<p>We model the Tradier API by supporting several order types and the <code>TimeInForce</code> order property. Tradier partially supports order updates, but does not support trading during extended market hours. When you deploy live algorithms, you can place manual orders through the IDE.</p>

<h4>Order Types</h4>
<p>Tradier supports the following order types:</p>

<ul>
    <li><code>MarketOrder</code></li>
    <li><code>LimitOrder</code></li>
    <li><code>StopMarketOrder</code></li>
    <li><code>StopLimitOrder</code></li>
    <li><code>LimitIfTouchedOrder</code></li>
    <li><code>ExerciseOption</code></li>
</ul>

<div class="section-example-container">
    <pre class="csharp">MarketOrder(_symbol, quantity);
LimitOrder(_symbol, quantity, limitPrice);
StopMarketOrder(_symbol, quantity, stopPrice);
StopLimitOrder(_symbol, quantity, stopPrice, limitPrice);
LimitIfTouchedOrder(_symbol, quantity, triggerPrice, limitPrice);
ExerciseOption(_optionSymbol, quantity);</pre>
    <pre class="python">self.MarketOrder(self.symbol, quantity)
self.LimitOrder(self.symbol, quantity, limit_price)
self.StopMarketOrder(self.symbol, quantity, stop_price)
self.StopLimitOrder(self.symbol, quantity, stop_price, limit_price)
self.LimitIfTouchedOrder(self.symbol, quantity, trigger_price, limit_price)
self.ExerciseOption(self.option_symbol, quantity)</pre>
</div>

<h4>Time In Force</h4>
<p>We model the <code>TimeInForce</code> order property from the Tradier API. Tradier supports the following <code>TimeInForce</code> instructions:</p>

<ul>
    <li><code>Day</code></li>
    <li><code>GoodTilCanceled</code></li>
    <li><code>GoodTilDate</code></li>
</ul>

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

<h4>Updates</h4>
<p>We model the Tradier API by supporting some order updates. You can define the following members of an <code>UpdateOrderFields</code> object to update active orders:</p>

<ul>
    
    <li><code>LimitPrice</code></li>
    <li><code>StopPrice</code><code></code></li><li><code>TriggerPrice</code></li><li><code>Tag</code></li>
</ul>

<div class="section-example-container">
    <pre class="csharp">var ticket = StopLimitOrder(_symbol, quantity, stopPrice, limitPrice, tag);
var orderFields = new UpdateOrderFields { <br>    LimitPrice = newLimitPrice,<br>    StopPrice = newStopPrice,<br>    Tag = newTag<br>};
ticket.Update(orderFields);</pre>
    <pre class="python">ticket = self.StopLimitOrder(self.symbol, quantity, stop_price, limit_price, tag)<br>update_fields = UpdateOrderFields()<br>update_fields.LimitPrice = new_limit_price<br>update_fields.StopPrice = new_stop_price
update_fields.Tag = new_tag
ticket.Update(update_fields)</pre>
</div>

<p>If you need to update the quantity of an order, cancel the order and then submit a new order with the desired quantity.</p>

<div class="section-example-container">
    <pre class="csharp">var ticket = LimitOrder(_symbol, quantity, limitPrice);
ticket.Cancel();
ticket = LimitOrder(_symbol, newQuantity, newLimitPrice);</pre>
    <pre class="python">ticket = self.LimitOrder(self.symbol, quantity, limit_price)
ticket.Cancel()
ticket = self.LimitOrder(self.symbol, new_quantity, new_limit_price)</pre>
</div>


<h4>Extended Market Hours</h4>
<p>Tradier does not support extended market hours trading. If you place an order outside of regular trading hours, the order will be processed at market open.</p>

<h4>Automatic Cancellations</h4>
<p>Tradier automatically cancels the open orders that your algorithm has for securities that perform a reverse split.</p>

