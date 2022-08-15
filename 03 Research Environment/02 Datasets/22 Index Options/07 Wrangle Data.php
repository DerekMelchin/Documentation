<?php
include(DOCS_RESOURCES."/datasets/wrangle-data.php");
$assetClass = 'Index Options';
$singularAssetClass = 'Index Option contract';
$pluralAssetClass = 'Index Option contracts';
$historicalDataLink = "/docs/v2/research-environment/datasets/index-options#04-Get-Historical-Data";
$primarySymbolPy = 'contract_symbol';
$primarySymbolC = 'contractSymbol';
$primaryTicker = '';
$secondarySymbol = '';
$dataFrameImages = array(
    'https://cdn.quantconnect.com/i/tu/index-option-research-data-1.jpg',
    'https://cdn.quantconnect.com/i/tu/index-option-research-data-2.jpg',
    'https://cdn.quantconnect.com/i/tu/index-option-research-data-3.jpg',
    'https://cdn.quantconnect.com/i/tu/index-option-research-data-4.jpg',
    'https://cdn.quantconnect.com/i/tu/index-option-research-data-5.jpg',
    'https://cdn.quantconnect.com/i/tu/index-option-research-data-6.jpg'
);
$dataFrameColumnName = 'close';
$columnNameEnglish = 'close';
$supportsTrades = true;
$supportsQuotes = true;
$supportsTicks = false;
$supportsAltData = false;
$supportsOpenInterest = true;
$supportsOptionHistory = true;
$contractExpiryDate = 'datetime(2022, 4, 14)';
$getWrangleDataText($assetClass, $singularAssetClass, $pluralAssetClass, $historicalDataLink, $primarySymbolPy, $primarySymbolC, $primaryTicker, $secondarySymbol, $dataFrameImages, $dataFrameColumnName, $columnNameEnglish, $supportsTrades, $supportsQuotes, $supportsTicks, $supportsAltData, $supportsOpenInterest, $supportsOptionHistory, $contractExpiryDate);
?>
