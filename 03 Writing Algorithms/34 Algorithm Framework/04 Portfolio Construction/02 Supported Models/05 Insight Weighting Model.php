<p>The <code>InsightWeightingPortfolioConstructionModel</code> generates target portfolio weights based on the <code>Insight.<span class="csharp">Weight</span><span class="python">weight</span></code> for the last Insight of each Symbol. If the Insight has a direction of <code>InsightDirection.<span class="csharp">Up</span><span class="python">UP</span></code>, the model generates long targets. If the Insight has a direction of <code>InsightDirection.<span class="csharp">Down</span><span class="python">DOWN</span></code>, the model generates short targets. If the sum of all the last active Insight per Symbol is greater than 1, the model factors down each target percent holdings proportionally so the sum is 1. The model takes the absolute value of the <code>Weight</code> of each <code>Insight</code> object and ignores <code>Insight</code> objects that have no <code>Weight</code> value.</p>


<div class="section-example-container">
	<pre class="csharp">// Use InsightWeightingPortfolioConstructionModel to allocate capital based on the latest Insight weights, generating long or short targets as per the Insight direction and adjusting allocations if total weights exceed 1, ensuring portfolio weights reflect current market insights and maintains proper risk management.
SetPortfolioConstruction(new InsightWeightingPortfolioConstructionModel());</pre>
	<pre class="python"># Use InsightWeightingPortfolioConstructionModel to allocate capital based on the latest Insight weights, generating long or short targets as per the Insight direction and adjusting allocations if total weights exceed 1, ensuring portfolio weights reflect current market insights and maintains proper risk management.
self.set_portfolio_construction(InsightWeightingPortfolioConstructionModel())</pre>
</div>

<p>The following table describes the arguments the model accepts:</p>

<table class="qc-table table">
    <thead>
        <tr>
            <th>Argument</th>
            <th>Data Type</th>
            <th>Description</th>
            <th>Default Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code class="python">rebalance</code><code class="csharp">resolution</code></td>
	    <td><code>Resolution</code></td>
	    <td>Rebalancing frequency</td>
            <td><code class="csharp">Resolution.Daily</code><code class="python">Resolution.DAILY</code></td>
        </tr>
        <tr>
            <td><code class="csharp">portfolioBias</code><code class="python">portfolio_bias</code></td>
	        <td><code>PortfolioBias</code></td>
            <td>The bias of the portfolio</td>
            <td><code>PortfolioBias.<span class="csharp">LongShort</span><span class="python">LONG_SHORT</span></code></td>
        </tr>
    </tbody>
</table>

<p>This model supports other data types for the rebalancing frequency argument. For more information about the supported types, see <a href='/docs/v2/writing-algorithms/algorithm-framework/portfolio-construction/key-concepts#07-Rebalance-Frequency'>Rebalance Frequency</a>.</p>
<p>This model removes expired insights from the <a href='/docs/v2/writing-algorithms/algorithm-framework/insight-manager'>Insight Manager</a> during each rebalance. It also removes all insights for a security when the security is removed from the <a href='/docs/v2/writing-algorithms/algorithm-framework/universe-selection/key-concepts'>universe</a>.</p>
<p class='csharp'>For more information about this model, see the <a target="_blank" rel="nofollow" href="https://www.lean.io/docs/v2/lean-engine/class-reference/cs/classQuantConnect_1_1Algorithm_1_1Framework_1_1Portfolio_1_1InsightWeightingPortfolioConstructionModel.html">class reference</a> and <a target="_blank" rel="nofollow" href="https://github.com/QuantConnect/Lean/blob/master/Algorithm.Framework/Portfolio/InsightWeightingPortfolioConstructionModel.cs">implementation</a>.</p>
<p class='python'>For more information about this model, see the <a target="_blank" rel="nofollow" href="https://www.lean.io/docs/v2/lean-engine/class-reference/py/QuantConnect/Algorithm/Framework/Portfolio/InsightWeightingPortfolioConstructionModel/">class reference</a> and <a target="_blank" rel="nofollow" href="https://github.com/QuantConnect/Lean/blob/master/Algorithm.Framework/Portfolio/InsightWeightingPortfolioConstructionModel.py">implementation</a>.</p>

