<?php 
$getRenameBacktestsText = function($link=NULL)
{
	echo "
<p>We give an arbitrary name (for example, \"Smooth Apricot Chicken\") to your backtest result files, but you can follow these steps to rename them:</p>
<ol>
	";

	if (!is_null($link))
	{
		echo "
		<li>Open the <a href='{$link}'>backtest history</a> of the project.</li>
		";
	}

	echo "
    <li>Hover over the backtest you want to rename and then click the <span class='icon-name'>
pencil</span> icon that appears.</li>
    <img class='docs-image' src='https://cdn.quantconnect.com/i/tu/rename-backtest-result.png'>
    <li>Enter the new backtest name and then click <span class='button-name'>OK</span>.</li>
</ol>
	";
}

?>
