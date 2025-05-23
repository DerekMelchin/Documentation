<h4>Example <?=$number?>: Kelly Criterion Sizing Using Previous Trades</h4>
<p>The following algorithm uses the previous trades to update the win probability and expected return of each trade of the EMA cross strategy of SPY, by the concept of Bayes Theorem. The updated figures are used for position sizing through Kelly Criterion.</p>
<div class="section-example-container testable">
    <pre class="csharp">public class TradeStatisticsAlgorithm : QCAlgorithm
{
    private Symbol _spy;
    private ExponentialMovingAverage _ema;

    public override void Initialize()
    {
        SetStartDate(2024, 8, 12);
        SetEndDate(2024, 9, 1);
        SetCash(1000000);

        // Request SPY data to trade.
        _spy = AddEquity("SPY").Symbol;
        // Create an EMA indicator to generate trade signals.
        _ema = EMA(_spy, 20, Resolution.Daily);
        // Warm-up indicator for immediate readiness.
        WarmUpIndicator(_spy, _ema, Resolution.Daily);

        // Set up a trade builder to track the trade statistics; we are interested in open-to-close round trade.
        SetTradeBuilder(new TradeBuilder(FillGroupingMethod.FlatToFlat, FillMatchingMethod.FIFO));
    }

    public override void OnData(Slice slice)
    {
        if (slice.Bars.TryGetValue(_spy, out var bar))
        {
            // Trend-following strategy using price and EMA.
            // If the price is above EMA, SPY is in an uptrend, and we buy it.
            var sign = 0m;
            if (bar.Close &gt; _ema &amp;&amp; !Portfolio[_spy].IsLong)
            {
                sign = 1m;
            }
            else if (bar.Close &lt; _ema &amp;&amp; !Portfolio[_spy].IsShort)
            {
                sign = -1m;
            }
            else
            {
                return;
            }
            
            var size = 1m;
            var trades = TradeBuilder.ClosedTrades;
            
            if (trades.Count &gt; 4)
            {
                // Use the trade builder to obtain the win rate and % return of the last five trades to calculate position size.
                var lastFiveTrades = trades.OrderBy(x =&gt; x.ExitTime).TakeLast(5);
                var probWin = lastFiveTrades.Count(x =&gt; x.IsWin) / 5m;
                var winSize = lastFiveTrades.Average(x =&gt; x.ProfitLoss / x.EntryPrice);
                // Use the Kelly Criterion to calculate the order size.
                size = probWin - (1 - probWin) / winSize;
            }
            
            SetHoldings(_spy, sign * size);
        }
    }
}</pre>
    <pre class="python">class TradeStatisticsAlgorithm(QCAlgorithm):
    def initialize(self) -&gt; None:
        self.set_start_date(2024, 8, 12)
        self.set_end_date(2024, 9, 1)
        self.set_cash(1000000)

        # Request SPY data to trade.
        self.spy = self.add_equity("SPY").symbol
        # Create an EMA indicator to generate trade signals.
        self._ema = self.ema(self.spy, 20, Resolution.DAILY)
        # Warm-up indicator for immediate readiness.
        self.warm_up_indicator(self.spy, self._ema, Resolution.DAILY)

        # Set up a trade builder to track the trade statistics; we are interested in open-to-close round trade.
        self.set_trade_builder(TradeBuilder(FillGroupingMethod.FLAT_TO_FLAT, FillMatchingMethod.FIFO))

    def on_data(self, slice: Slice) -&gt; None:
        bar = slice.bars.get(self.spy)
        if not bar:
            return
        # Trend-following strategy using price and EMA.
        # If the price is above EMA, SPY is in an uptrend, and we buy it.
        sign = 0
        if bar.close &gt; self._ema.current.value and not self.portfolio[self.spy].is_long:
            sign = 1
        elif bar.close &lt; self._ema.current.value and not self.portfolio[self.spy].is_short:
            sign = -1
        else:
            return

        size = 1
        trades = self.trade_builder.closed_trades

        if len(trades) &gt; 4:
            # Use the trade builder to obtain the win rate and % return of the last five trades to calculate position size.
            last_five_trades = sorted(trades, key=lambda x: x.exit_time)[-5:]
            prob_win = len([x for x in last_five_trades if x.is_win]) / 5
            win_size = np.mean([x.profit_loss / x.entry_price for x in last_five_trades])
            # Use the Kelly Criterion to calculate the order size.
            size = max(0, prob_win - (1 - prob_win) / win_size)

        self.set_holdings(self.spy, size * sign)</pre>
</div>
