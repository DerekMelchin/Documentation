<?php
$methodTyping = $consolidationHandlerType == "QuoteBar" ? "&lt;QuoteBar&gt;" : "";
?>

<p <?=$this->shortcutClass1?>>You can also use the <code>Consolidate</code> helper method to create period consolidators and register them for automatic updates. With just one line of code, you can create data in any time period based on a <code class='python'>timedelta</code><code class='csharp'>TimeSpan</code> or <code>Resolution</code> object:</p>

<ul {$this->shortcutClass1}>
    <li class='csharp'><code>TimeSpan</code> Periods</li>
    <li class='python'><code>timedelta</code> Periods</li>
    <div class='section-example-container'>
		<pre class='csharp'>_consolidator = Consolidate<?=$methodTyping?>(_symbol, TimeSpan.<?=$this->timeSpanPeriod?>, <?=$this->shortCutTickTypeArg?>ConsolidationHandler);</pre>
		<pre class='python'>self.consolidator = self.Consolidate(self.symbol, timedelta(<?=$this->timeDeltaPeriod?>), <?=$this->shortCutTickTypeArg?>self.consolidation_handler)</pre>
	</div>

    <li><code>Resolution</code> Periods</li>
    <div class='section-example-container'>
		<pre class='csharp'>_consolidator = Consolidate<?=$methodTyping?>(_symbol, Resolution.<?=$this->resolutionPeriod?>, <?=$this->shortCutTickTypeArg?>ConsolidationHandler);</pre>
		<pre class='python'>self.consolidator = self.Consolidate(self.symbol, Resolution.<?=$this->resolutionPeriod?>, <?=$this->shortCutTickTypeArg?>self.consolidation_handler)</pre>
	</div>
</ul>

<?php include(DOCS_RESOURCES."/consolidators/get-shortcut-text.php"); ?>