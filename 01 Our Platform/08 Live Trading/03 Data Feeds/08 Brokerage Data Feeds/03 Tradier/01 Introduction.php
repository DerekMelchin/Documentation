<?php 
echo file_get_contents(DOCS_RESOURCES."/brokerages/introduction-by-brokerage/tradier.php");
?>

<p>The Tradier data feeds are streams of Equity and Option prices directly from Tradier. If you use this data feed and request historical data, the historical data comes from Tradier. If you deploy to the demo environment, Tradier doesn't offer streaming market data due to exchange restrictions related to delayed data, so you must use our data feed.</p>