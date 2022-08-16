<p>We model the <a target='_blank' href='https://qnt.co/atreyu'>Atreyu Trading</a> API by supporting several order types, order properties, and order updates. When you deploy live algorithms, you can place manual orders through the IDE.</p>

<h4>Order Types</h4>
<p><a target='_blank' href='https://qnt.co/atreyu'>Atreyu Trading</a> supports the following order types:</p>
<ul>
    <li><code>MarketOrder</code></li>
    <li><code>LimitOrder</code></li>
    <li><code>MarketOnCloseOrder</code></li>
</ul>

<div class="section-example-container">
    <pre class="csharp">MarketOrder(_symbol, quantity);
LimitOrder(_symbol, quantity, limitPrice);
MarketOnCloseOrder(_symbol, quantity);</pre>
    <pre class="python">self.MarketOrder(self.symbol, quantity)
self.LimitOrder(self.symbol, quantity, limit_price)
self.MarketOnCloseOrder(self.symbol, quantity)</pre>
</div>

<p>Only integer order quantities are supported.</p>



<h4>Order Properties</h4>
<p>We model custom order properties from the <a target='_blank' href='https://qnt.co/atreyu'>Atreyu Trading</a> API. The following table describes the members of the <code>AtreyuOrderProperties</code> object that you can set to customize order execution:</p>

<table class="table qc-table">
   <thead>
      <tr>
         <th style="width: 25%">Property</th>
         <th style="width: 75%">Description</th>
      </tr>
   </thead>
   <tbody>
      <tr>
         <td><code>TimeInForce</code></td>
         <td>A <code>TimeInForce</code> instruction to apply to the order. The <code>Day</code> <code>TimeInForce</code> is supported.</td>
      </tr>
      <tr>
         <td><code>PostOnly</code></td>
         <td>A flag to signal that the order must only add liquidity to the order book and not take liquidity from the order book.</td>
      </tr>
   </tbody>
</table>


<div class="section-example-container">
    <pre class="csharp">public override void Initialize()
{
    // Set default order properties
    DefaultOrderProperties = new AtreyuOrderProperties
    {
        TimeInForce = TimeInForce.Day,
        PostOnly = false
    };
}

public override void OnData(Slice slice)
{
    // Use default order order properties
    LimitOrder(_symbol, quantity, limitPrice);
    
    // Override the default order properties
    LimitOrder(_symbol, quantity, limitPrice,
               orderProperties: new AtreyuOrderProperties 
               { 
                   TimeInForce = TimeInForce.Day,
                   PostOnly = true 
               });
}</pre>
    <pre class="python">def Initialize(self) -&gt; None:
    # Set the default order properties
    self.DefaultOrderProperties = AtreyuOrderProperties()
    self.DefaultOrderProperties.TimeInForce = TimeInForce.Day
    self.DefaultOrderProperties.PostOnly = False

def OnData(self, slice: Slice) -&gt; None:
    # Use default order order properties
    self.LimitOrder(self.symbol, quantity, limit_price)
    
    # Override default order properties
    order_properties = AtreyuOrderProperties()
    order_properties.TimeInForce = TimeInForce.Day
    order_properties.PostOnly = True
    self.LimitOrder(self.symbol, quantity, limit_price, orderProperties = order_properties)</pre>
</div>

<h4>Updates</h4>
<p>We model the <a target='_blank' href='https://qnt.co/atreyu'>Atreyu Trading</a> API by supporting order updates. You can define the following members of an <code>UpdateOrderFields</code> object to update active orders:</p>

<ul>
    <li><code>Quantity</code></li>
    <li><code>LimitPrice</code></li>
    <li><code>Tag</code></li>
</ul>

<div class="section-example-container">
    <pre class="csharp">var ticket = LimitOrder(symbol, quantity, limitPrice, tag);
var orderFields = new UpdateOrderFields { <br>    Quantity = newQuantity,<br>    LimitPrice = newLimitPrice,<br>    Tag = newTag<br>};
ticket.Update(orderFields);</pre>
    <pre class="python">ticket = self.LimitOrder(symbol, quantity, limit_price, tag)<br>update_fields = UpdateOrderFields()
update_fields.Quantity = new_quantity
update_fields.LimitPrice = new_limit_price
update_fields.Tag = new_tag
ticket.Update(update_fields)</pre>
</div>

