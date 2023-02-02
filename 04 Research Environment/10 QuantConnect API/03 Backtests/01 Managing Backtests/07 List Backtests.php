<p>To get the backtests of a project, call the <code>ListBacktests</code> method with the project ID.</p>

<div class="section-example-container">
    <pre class="csharp">var response = api.ListBacktests(projectId);</pre>
    <pre class="python">response = api.ListBacktests(project_id)</pre>
</div>

<?php include(DOCS_RESOURCES."/qc-api/get-project-id-in-research.html"); ?>

<p>The <code>ListBacktests</code> method returns a <code>BacktestList</code> object, which have the following attributes:</p>
<div data-tree='QuantConnect.Api.BacktestList'></div>