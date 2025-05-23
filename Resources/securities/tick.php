<? include(DOCS_RESOURCES."/securities/data-definitions/ticks.php"); ?>

<p> In backtests, LEAN groups ticks into one millisecond buckets. In live trading, LEAN groups ticks into ~70-millisecond buckets. To get the <code>Tick</code> objects in the <code>Slice</code>, index the <code>Ticks</code> property of the <code>Slice</code> with a <code class="csharp">Symbol</code><code class="python">symbol</code>. If the <?=$securityName?> doesn't actively trade or you are in the same time step as when you added the <?=$securityName?> subscription, the <code>Slice</code> may not contain data for your <code class="csharp">Symbol</code><code class="python">symbol</code>. To avoid issues, check if the <code>Slice</code> contains data for your <?=$securityName?> before you index the <code>Slice</code> with the <?=$securityName?> <code class="csharp">Symbol</code><code class="python">symbol</code>.</p>

<div class='section-example-container'>
    <pre class='csharp'>public override void OnData(Slice slice)
{
    if (slice.Ticks.ContainsKey(<?=$cSharpVariable?>))
    {
        var ticks = slice.Ticks[<?=$cSharpVariable?>];
        foreach (var tick in ticks)
        {
            var price = tick.Price;
        }
    }
}
</pre>
    <pre class='python'>def on_data(self, slice: Slice) -> None:
    ticks = slice.ticks.get(<?=$pythonVariable?>, [])   # Empty if not found
    for tick in ticks:
        price = tick.price</pre>
</div>

<p>You can also iterate through the <code>Ticks</code> dictionary. The keys of the dictionary are the <code>Symbol</code> objects and the values are the <code class='csharp'>List&lt;Tick&gt;</code><code class='python'>list[Tick]</code> objects.</p>
<div class='section-example-container'>
    <pre class='csharp'>public override void OnData(Slice slice)
{
    foreach (var kvp in slice.Ticks)
    {
        var symbol = kvp.Key;
        var ticks = kvp.Value;
        foreach (var tick in ticks)
        {
            var price = tick.Price;
        }
    }
}</pre>
    <pre class='python'>def on_data(self, slice: Slice) -> None:
    for symbol, ticks in slice.ticks.items():
        for tick in ticks:
            price = tick.price</pre>
</div>

<p>Tick data is raw and unfiltered, so it can contain bad ticks that skew your trade results. For example, some ticks come from dark pools, which aren't tradable. We recommend you only use tick data if you understand the risks and are able to perform your own online tick filtering.</p>

<p><code>Tick</code> objects have the following properties:</p>
<div data-tree='QuantConnect.Data.Market.Tick'></div>
