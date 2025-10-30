<p>The <code>SectorWeightingPortfolioConstructionModel</code> generates target portfolio weights based on the <code class="csharp">CompanyReference.IndustryTemplateCode</code><code class="python">company_reference.industry_template_code</code> provided by the <a href="/datasets/morning-star-us-fundamentals">US Fundamental dataset</a>. The target percent holdings of each sector is 1/S where S is the number of sectors and the target percent holdings of each security is 1/N where N is the number of securities of each sector. If the insight has a direction of <code>InsightDirection.<span class="csharp">Up</span><span class="python">UP</span></code>, the model generates long targets. If the insight has a direction of <code>InsightDirection.<span class="csharp">Down</span><span class="python">DOWN</span></code>, the model generates short targets. The model ignores <code>Insight</code> objects for Symbols that have no <code class="csharp">CompanyReference.IndustryTemplateCode</code><code class="python">company_reference.industry_template_code</code>.</p>

<div class="section-example-container">
	<pre class="csharp">// Use SectorWeightingPortfolioConstructionModel to ensure diversified sector exposure and balanced allocation, aligning portfolio weights with sector insights while managing long and short positions based on insight direction.
SetPortfolioConstruction(new SectorWeightingPortfolioConstructionModel());</pre>
	<pre class="python"># Use SectorWeightingPortfolioConstructionModel to ensure diversified sector exposure and balanced allocation, aligning portfolio weights with sector insights while managing long and short positions based on insight direction.
self.set_portfolio_construction(SectorWeightingPortfolioConstructionModel())</pre>
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
    </tbody>
</table>

<p>This model supports other data types for the rebalancing frequency argument. For more information about the supported types, see <a href='/docs/v2/writing-algorithms/algorithm-framework/portfolio-construction/key-concepts#07-Rebalance-Frequency'>Rebalance Frequency</a>.</p>
<p>This model removes expired insights from the <a href='/docs/v2/writing-algorithms/algorithm-framework/insight-manager'>Insight Manager</a> during each rebalance. It also removes all insights for a security when the security is removed from the <a href='/docs/v2/writing-algorithms/algorithm-framework/universe-selection/key-concepts'>universe</a>.</p>
<p class='csharp'>For more information about this model, see the <a target="_blank" rel="nofollow" href="https://www.lean.io/docs/v2/lean-engine/class-reference/cs/classQuantConnect_1_1Algorithm_1_1Framework_1_1Portfolio_1_1SectorWeightingPortfolioConstructionModel.html">class reference</a> and <a target="_blank" rel="nofollow" href="https://github.com/QuantConnect/Lean/blob/master/Algorithm.Framework/Portfolio/SectorWeightingPortfolioConstructionModel.cs">implementation</a>.</p>
<p class='python'>For more information about this model, see the <a target="_blank" rel="nofollow" href="https://www.lean.io/docs/v2/lean-engine/class-reference/py/QuantConnect/Algorithm/Framework/Portfolio/SectorWeightingPortfolioConstructionModel/">class reference</a> and <a target="_blank" rel="nofollow" href="https://github.com/QuantConnect/Lean/blob/master/Algorithm.Framework/Portfolio/SectorWeightingPortfolioConstructionModel.py">implementation</a>.</p>
