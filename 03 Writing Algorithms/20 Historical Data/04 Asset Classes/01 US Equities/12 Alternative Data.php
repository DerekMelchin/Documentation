<?
$datasetClass = "QuiverWallStreetBets";
?>

<p class='csharp'>
  To get historical alternative data, call the <code>History&lt;<span class='placeholder-text'>alternativeDataClass</span>&gt;</code> method with the dataset <code>Symbol</code>.
</p>

<p class='python'>
  To get historical alternative data, call the <code>history</code> method with the dataset <code>Symbol</code>.
  This method returns a DataFrame that contains the data point attributes.
</p>

<div class="section-example-container">
    <pre class="csharp">public class USEquityAlternativeDataHistoryAlgorithm : QCAlgorithm
{
    public override void Initialize()
    {
        SetStartDate(2024, 12, 19);
        // Get the Symbol of an asset.
        var symbol = AddEquity("GME").Symbol;
        // Add the alternative dataset and save a reference to its Symbol.
        var datasetSymbol = AddData&lt;QuiverWallStreetBets&gt;(symbol).Symbol;
        // Get the trailing 5 days of <?=$datasetClass?> data for the asset.
        var history = History&lt;<?=$datasetClass?>&gt;(datasetSymbol, 5, Resolution.Daily);
        // Iterate each data point and access its attributes.
        foreach (var dataPoint in history)
        {
            var t = dataPoint.EndTime;
            var sentiment = dataPoint.Sentiment;
        }
    }
}</pre>
    <pre class="python">class USEquityAlternativeDataHistoryAlgorithm(QCAlgorithm):

    def initialize(self) -> None:
        self.set_start_date(2024, 12, 19)
        # Get the Symbol of an asset.
        symbol = self.add_equity('GME').symbol
        # Add the alternative dataset and save a reference to its Symbol.
        dataset_symbol = self.add_data(QuiverWallStreetBets, symbol).symbol
        # Get the trailing 5 days of <?=$datasetClass?> data for the asset in DataFrame format.
        history = self.history(dataset_symbol, 5, Resolution.DAILY)</pre>
</div>

<div class="dataframe-wrapper">
  <table class="dataframe python">
    <thead>
      <tr style="text-align: right;">
        <th></th>
        <th></th>
        <th>date</th>
        <th>mentions</th>
        <th>rank</th>
        <th>sentiment</th>
      </tr>
      <tr>
        <th>symbol</th>
        <th>time</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th rowspan="5" valign="top">GME.QuiverWallStreetBets</th>
        <th>2024-12-15</th>
        <td>2024-12-14</td>
        <td>2</td>
        <td>48</td>
        <td>0.74245</td>
      </tr>
      <tr>
        <th>2024-12-16</th>
        <td>2024-12-15</td>
        <td>1</td>
        <td>136</td>
        <td>-0.51600</td>
      </tr>
      <tr>
        <th>2024-12-17</th>
        <td>2024-12-16</td>
        <td>8</td>
        <td>53</td>
        <td>0.13987</td>
      </tr>
      <tr>
        <th>2024-12-18</th>
        <td>2024-12-17</td>
        <td>17</td>
        <td>32</td>
        <td>0.08564</td>
      </tr>
      <tr>
        <th>2024-12-19</th>
        <td>2024-12-18</td>
        <td>4</td>
        <td>117</td>
        <td>0.61682</td>
      </tr>
    </tbody>
  </table>
</div>



<div class="python section-example-container">
    <pre class="python"># Calculate the changes in sentiment.
sentiment_diff = history.sentiment.diff().iloc[1:]</pre>
</div>

<div class="python section-example-container">
    <pre>symbol                    time      
GME.QuiverWallStreetBets  2024-12-16   -1.25845
                          2024-12-17    0.65587
                          2024-12-18   -0.05423
                          2024-12-19    0.53118
Name: sentiment, dtype: float64</pre>
</div>

<p class='python'>
  If you intend to use the data in the DataFrame to create <code><span class='placeholder-text'>alternativeDataClass</span></code> objects, request that the history request returns the data type you need. 
  Otherwise, LEAN consumes unnecessary computational resources populating the DataFrame.  
  To get a list of dataset objects instead of a DataFrame, call the <code>history[<span class='placeholder-text'>alternativeDataClass</span>]</code> method.
</p>


<div class="python section-example-container">
    <pre class="python"># Get the trailing 5 days of <?=$datasetClass?> data for an asset in <?=$datasetClass?> format. 
history = self.history[<?=$datasetClass?>](dataset_symbol, 5, Resolution.DAILY)
# Iterate through each <?=$datasetClass?> object.
for data_point in history:
    t = data_point.end_time
    sentiment = data_point.sentiment</pre>
</div>

<!-- This part is only for US Equities. Not all asset classes -->
  <p>
    Some alternative datasets provide multiple entries per asset per <a href='/docs/v2/writing-algorithms/key-concepts/time-modeling/timeslices'>time step</a>. 
    For example, the <a href='/datasets/extractalpha-true-beats'>True Beats dataset</a> provides EPS and revenue predictions for several upcoming quarters per asset per day.
    <span class='csharp'>In this case, use a nested loop to access all the data point attributes.</span>
    <span class='python'>In this case, to organize the data into a DataFrame, set the <code>flatten</code> argument to <code>True</code>.</span>
  </p>

  <div class="section-example-container">
    <pre class="csharp">public class USEquityTrueBeatsHistoryAlgorithm : QCAlgorithm
{
    public override void Initialize()
    {
        SetStartDate(2024, 1, 3);
        // Get the ExtractAlphaTrueBeats data for AAPL on 01/02/2024.
        var symbol = AddEquity("AAPL", Resolution.Daily).Symbol;
        var datasetSymbol = AddData&lt;ExtractAlphaTrueBeats&gt;(symbol).Symbol;
        var history = History&lt;ExtractAlphaTrueBeats&gt;(
            datasetSymbol, new DateTime(2024, 1, 2), new DateTime(2024, 1, 3), Resolution.Daily
        );
        // Iterate through each day of history.
        foreach (var trueBeats in history)
        {
            // Calculate the mean TrueBeat estimate for this day.
            var t = trueBeats.EndTime;
            var meanTrueBeat = trueBeats.Data
                .Select(estimate => estimate as ExtractAlphaTrueBeat)
                .Average(estimate => estimate.TrueBeat);
        }
    }
}</pre>
    <pre class="python">class USEquityTrueBeatsHistoryAlgorithm(QCAlgorithm):

    def initialize(self) -> None:
        self.set_start_date(2024, 1, 3)
        # Get the ExtractAlphaTrueBeats data for AAPL on 01/02/2024 organized in a flat DataFrame.
        aapl = self.add_equity("AAPL", Resolution.DAILY)
        aapl.true_beats = self.add_data(ExtractAlphaTrueBeats, aapl.symbol).symbol
        history = self.history(
            aapl.true_beats, datetime(2024, 1, 2), datetime(2024, 1, 3), Resolution.DAILY, flatten=True
        )</pre>
  </div>

  <div class="dataframe-wrapper">
    <table class="dataframe python">
      <thead>
        <tr style="text-align: right;">
          <th></th>
          <th></th>
          <th>analystestimatescount</th>
          <th>annual</th>
          <th>earningsmetric</th>
          <th>end</th>
          <th>expectedreportdate</th>
          <th>expertbeat</th>
          <th>fiscalquarter</th>
          <th>fiscalyear</th>
          <th>managementbeat</th>
          <th>quarterly</th>
          <th>time</th>
          <th>trendbeat</th>
          <th>truebeat</th>
        </tr>
        <tr>
          <th>time</th>
          <th>symbol</th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th rowspan="11" valign="top">2024-01-02 12:30:00</th>
          <th>AAPL.ExtractAlphaTrueBeats</th>
          <td>28</td>
          <td>False</td>
          <td>0</td>
          <td>2023-12-31</td>
          <td>2024-01-25</td>
          <td>-0.001241</td>
          <td>4.0</td>
          <td>2023</td>
          <td>0.013694</td>
          <td>True</td>
          <td>2024-01-02 12:30:00</td>
          <td>0.016899</td>
          <td>0.029352</td>
        </tr>
        <tr>
          <th>AAPL.ExtractAlphaTrueBeats</th>
          <td>29</td>
          <td>True</td>
          <td>0</td>
          <td>2024-09-30</td>
          <td>2024-10-24</td>
          <td>NaN</td>
          <td>NaN</td>
          <td>2024</td>
          <td>NaN</td>
          <td>False</td>
          <td>2024-01-02 12:30:00</td>
          <td>NaN</td>
          <td>-0.020608</td>
        </tr>
        <tr>
          <th>AAPL.ExtractAlphaTrueBeats</th>
          <td>24</td>
          <td>False</td>
          <td>0</td>
          <td>2024-03-31</td>
          <td>2024-04-25</td>
          <td>NaN</td>
          <td>1.0</td>
          <td>2024</td>
          <td>NaN</td>
          <td>True</td>
          <td>2024-01-02 12:30:00</td>
          <td>NaN</td>
          <td>-0.016578</td>
        </tr>
        <tr>
          <th>AAPL.ExtractAlphaTrueBeats</th>
          <td>24</td>
          <td>False</td>
          <td>0</td>
          <td>NaT</td>
          <td>NaT</td>
          <td>NaN</td>
          <td>2.0</td>
          <td>2024</td>
          <td>NaN</td>
          <td>True</td>
          <td>2024-01-02 12:30:00</td>
          <td>NaN</td>
          <td>0.011859</td>
        </tr>
        <tr>
          <th>AAPL.ExtractAlphaTrueBeats</th>
          <td>26</td>
          <td>False</td>
          <td>0</td>
          <td>NaT</td>
          <td>NaT</td>
          <td>NaN</td>
          <td>3.0</td>
          <td>2024</td>
          <td>NaN</td>
          <td>True</td>
          <td>2024-01-02 12:30:00</td>
          <td>NaN</td>
          <td>0.017517</td>
        </tr>
        <tr>
          <th>...</th>
          <td>...</td>
          <td>...</td>
          <td>...</td>
          <td>...</td>
          <td>...</td>
          <td>...</td>
          <td>...</td>
          <td>...</td>
          <td>...</td>
          <td>...</td>
          <td>...</td>
          <td>...</td>
          <td>...</td>
        </tr>
        <tr>
          <th>AAPL.ExtractAlphaTrueBeats</th>
          <td>11</td>
          <td>False</td>
          <td>0</td>
          <td>NaT</td>
          <td>NaT</td>
          <td>NaN</td>
          <td>1.0</td>
          <td>2025</td>
          <td>NaN</td>
          <td>True</td>
          <td>2024-01-02 12:30:00</td>
          <td>NaN</td>
          <td>-0.009165</td>
        </tr>
        <tr>
          <th>AAPL.ExtractAlphaTrueBeats</th>
          <td>11</td>
          <td>False</td>
          <td>0</td>
          <td>NaT</td>
          <td>NaT</td>
          <td>NaN</td>
          <td>2.0</td>
          <td>2025</td>
          <td>NaN</td>
          <td>True</td>
          <td>2024-01-02 12:30:00</td>
          <td>NaN</td>
          <td>-0.020219</td>
        </tr>
        <tr>
          <th>AAPL.ExtractAlphaTrueBeats</th>
          <td>11</td>
          <td>False</td>
          <td>0</td>
          <td>NaT</td>
          <td>NaT</td>
          <td>NaN</td>
          <td>3.0</td>
          <td>2025</td>
          <td>NaN</td>
          <td>True</td>
          <td>2024-01-02 12:30:00</td>
          <td>NaN</td>
          <td>-0.042210</td>
        </tr>
        <tr>
          <th>AAPL.ExtractAlphaTrueBeats</th>
          <td>1</td>
          <td>False</td>
          <td>0</td>
          <td>NaT</td>
          <td>NaT</td>
          <td>NaN</td>
          <td>4.0</td>
          <td>2025</td>
          <td>NaN</td>
          <td>True</td>
          <td>2024-01-02 12:30:00</td>
          <td>NaN</td>
          <td>0.000000</td>
        </tr>
        <tr>
          <th>AAPL.ExtractAlphaTrueBeats</th>
          <td>10</td>
          <td>True</td>
          <td>0</td>
          <td>NaT</td>
          <td>NaT</td>
          <td>NaN</td>
          <td>NaN</td>
          <td>2026</td>
          <td>NaN</td>
          <td>False</td>
          <td>2024-01-02 12:30:00</td>
          <td>NaN</td>
          <td>-0.001965</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="python section-example-container">
    <pre class="python"># Calculate the mean TrueBeat estimate for each day.
mean_true_beats_by_day = history.drop('time', axis=1).groupby('time').apply(lambda g: g.truebeat.mean())</pre>
  </div>

  <div class="python section-example-container">
    <pre>time
2024-01-02 12:30:00   -0.007034
dtype: float64</pre>
  </div>

<p>For information on historical data for other alternative datasets, see the documentation in the <a href='/datasets/'>Dataset Market</a>.</p>
