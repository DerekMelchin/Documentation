# region imports
from AlgorithmImports import *
from QuantConnect.Indicators.CandlestickPatterns import *
import plotly.express as px
# endregion

class IndicatorImageGeneratorAlgorithm(QCAlgorithm):
        
    def generate(self, name, indicator, df):
        columns = set(df.columns).intersection(indicator.get('columns', '') + ['price'])
        df = df.drop(columns=columns).dropna().reset_index()
        try:
            if "current" in df.columns:
                fig = px.line(df, x="index", y="current", title=indicator['title'])
            else:
                fig = px.line(df, x="index", y=list(df.columns)[1], title=indicator['title'])
            
            path = self.object_store.get_file_path(f"{name}.png")
            fig.write_image(path, width=1200, height=630, format='png')
                        
        except Exception as e:
            self.log(f"{name} unable to plot :: {e}")

    def Initialize(self):
        self.SetStartDate(2021,1,1)

        qb = QuantBook()
        qb.AddEquity("SPY", Resolution.Daily)
        qb.AddEquity("QQQ", Resolution.Daily)
        qb.SetStartDate(self.StartDate)
        symbol = Symbol.Create("SPY", SecurityType.Equity, Market.USA)
        reference = Symbol.Create("QQQ", SecurityType.Equity, Market.USA)
        option_symbol = Symbol.CreateOption("SPY", Market.USA, OptionStyle.American, OptionRight.Call, 375, datetime(2021, 1, 8))
        option_mirror_symbol = Symbol.CreateOption("SPY", Market.USA, OptionStyle.American, OptionRight.Put, 375, datetime(2021, 1, 8))
        
        interest_rate_model = InterestRateProvider()
        dividend_yield_model = DividendYieldProvider(symbol)

        indicators = {
            'bollinger-bands':
            {
                'code': BollingerBands(30, 2),
                'title' : 'BB(symbol, 30, 2)',
                'columns' : ['bandwidth','percentb','standarddeviation']
            },
            'absolute-price-oscillator':
            {
                'code': AbsolutePriceOscillator(10, 20, MovingAverageType.Simple),
                'title' : 'APO(symbol, 10, 20, MovingAverageType.Simple)',
                'columns' : ['fast','slow']
            },
            'acceleration-bands':
            {
                'code': AccelerationBands("", 10, 4, MovingAverageType.Simple),
                'title' : 'ABANDS(symbol, 10, 4, MovingAverageType.Simple)',
                'columns' : []
            },
            'accumulation-distribution':
            {
                'code': AccumulationDistribution(),
                'title' : 'AD(symbol)',
                'columns' : []
            },
            'accumulation-distribution-oscillator':
            {
                'code': AccumulationDistributionOscillator(10, 20),
                'title' : 'ADOSC(symbol, 10, 20)',
                'columns' : []
            },
            'arnaud-legoux-moving-average':
            {
                'code': ArnaudLegouxMovingAverage(10, 6, 0.85),
                'title' : 'ALMA(symbol, 10, 6, 0.85)',
                'columns' : []
            },
            'aroon-oscillator':
            {
                'code': AroonOscillator(10, 20),
                'title' : 'AROON(symbol, 10, 20)',
                'columns' : []
            },
            'augen-price-spike':
            {
                'code': AugenPriceSpike(3),
                'title' : 'APS(symbol, 3)',
                'columns' : []
            },
            'auto-regressive-integrated-moving-average':
            {
                'code': AutoRegressiveIntegratedMovingAverage(1, 1, 1, 20, True),
                'title' : 'ARIMA(symbol, 1, 1, 1, 20)',
                'columns' : []
            },
            'average-directional-index':
            {
                'code': AverageDirectionalIndex(20),
                'title' : 'ADX(symbol, 20)',
                'columns' : []
            },
            'average-directional-movement-index-rating':
            {
                'code': AverageDirectionalMovementIndexRating(20),
                'title' : 'ADXR(symbol, 20)',
                'columns' : []
            },
            'average-true-range':
            {
                'code': AverageTrueRange(20, MovingAverageType.Simple),
                'title' : 'ATR(symbol, 20, MovingAverageType.Simple)',
                'columns' : []
            },
            'awesome-oscillator':
            {
                'code': AwesomeOscillator(10, 20, MovingAverageType.Simple),
                'title' : 'AO(symbol, 10, 20, MovingAverageType.Simple)',
                'columns' : ['fastao', 'slowao']
            },
            'balance-of-power':
            {
                'code': BalanceOfPower(),
                'title' : 'BOP(symbol)',
                'columns' : []
            },
            'chaikin-money-flow':
            {
                'code': ChaikinMoneyFlow("SPY", 20),
                'title' : 'CMF(symbol, 20)',
                'columns' : []
            },
            'chande-kroll-stop':
            {
                'code': ChandeKrollStop(10, 1, 9),
                'title' : 'CKS(symbol, 10, 1, 9)',
                'columns' : []
            },
            'chande-momentum-oscillator':
            {
                'code': ChandeMomentumOscillator(20),
                'title' : 'CMO(symbol, 20)',
                'columns' : []
            },
            'choppiness-index':
            {
                'code': ChoppinessIndex(14),
                'title' : 'CHOP(symbol, 14)',
                'columns' : []
            },
            'commodity-channel-index':
            {
                'code': CommodityChannelIndex(20, MovingAverageType.Simple),
                'title' : 'CCI(symbol, 20, MovingAverageType.Simple)',
                'columns' : ['typicalpriceaverage', 'typicalpricemeandeviation']
            },
            'connors-relative-strength-index':
            {
                'code': ConnorsRelativeStrengthIndex(3, 2, 100),
                'title' : 'CRSI(symbol, 3, 2, 100)',
                'columns' : []
            },
            'coppock-curve':
            {
                'code': CoppockCurve(11, 14, 10),
                'title' : 'CC(symbol, 11, 14, 10)',
                'columns' : []
            },
            'de-marker-indicator':
            {
                'code': DeMarkerIndicator(20, MovingAverageType.Simple),
                'title' : 'DEM(symbol, 20, MovingAverageType.Simple)',
                'columns' : []
            },
            'derivative-oscillator':
            {
                'code': DerivativeOscillator("DerivativeOscillator", 14, 5, 3, 9),
                'title' : 'DO(symbol, 14, 5, 3, 9)',
                'columns' : []
            },
            'detrended-price-oscillator':
            {
                'code': DetrendedPriceOscillator(20),
                'title' : 'DPO(symbol, 20)',
                'columns' : []
            },
            'donchian-channel':
            {
                'code': DonchianChannel(20, 20),
                'title' : 'DCH(symbol, 20, 20)',
                'columns' : []
            },
            'double-exponential-moving-average':
            {
                'code': DoubleExponentialMovingAverage(20),
                'title' : 'DEMA(symbol, 20)',
                'columns' : []
            },
            'ease-of-movement-value':
            {
                'code': EaseOfMovementValue(1, 10000),
                'title' : 'EMV(symbol, 1, 10000)',
                'columns' : []
            },
            'exponential-moving-average':
            {
                'code': ExponentialMovingAverage(20, 0.5),
                'title' : 'EMA(symbol, 20, 0.5)',
                'columns' : []
            },
            'fisher-transform':
            {
                'code': FisherTransform(20),
                'title' : 'FISH(symbol, 20)',
                'columns' : []
            },
            'force-index':
            {
                'code': ForceIndex(13),
                'title' : 'FI(symbol, 13)',
                'columns' : []
            },
            'fractal-adaptive-moving-average':
            {
                'code': FractalAdaptiveMovingAverage(20, 198),
                'title' : 'FRAMA(symbol, 20, 198)',
                'columns' : []
            },
            'heikin-ashi':
            {
                'code': HeikinAshi(),
                'title' : 'HeikinAshi(symbol)',
                'columns' : ['volume']
            },
            'hilbert-transform':
            {
                'code': HilbertTransform(7, 0.635, 0.338),
                'title' : 'HT(symbol, 7, 0.635, 0.338)',
                'columns' : []
            },
            'hull-moving-average':
            {
                'code': HullMovingAverage(20),
                'title' : 'HMA(symbol, 20)',
                'columns' : []
            },
            'hurst-exponent':
            {
                'code': HurstExponent(32),
                'title' : 'HE(symbol, 32)',
                'columns' : []
            },
            'ichimoku-kinko-hyo':
            {
                'code': IchimokuKinkoHyo(9, 26, 17, 52, 26, 26),
                'title' : 'ICHIMOKU(symbol, 9, 26, 17, 52, 26, 26)',
                'columns' : ['chikou']
            },
            'identity':
            {
                'code': Identity("SPY"),
                'title' : 'Identity(symbol)',
                'columns' : []
            },
            'internal-bar-strength':
            {
                'code': InternalBarStrength(),
                'title' : 'IBS(symbol)',
                'columns' : []
            },
            'kaufman-adaptive-moving-average':
            {
                'code': KaufmanAdaptiveMovingAverage(20, 10, 20),
                'title' : 'KAMA(symbol, 20, 10, 20)',
                'columns' : []
            },
            'kaufman-efficiency-ratio':
            {
                'code': KaufmanEfficiencyRatio(20),
                'title' : 'KER(symbol, 20)',
                'columns' : []
            },
            'keltner-channels':
            {
                'code': KeltnerChannels(20, 2, MovingAverageType.Simple),
                'title' : 'KCH(symbol, 20, 2, MovingAverageType.Simple)',
                'columns' : ['averagetruerange']
            },
            'least-squares-moving-average':
            {
                'code': LeastSquaresMovingAverage(20),
                'title' : 'LSMA(symbol, 20)',
                'columns' : ['slope']
            },
            'linear-weighted-moving-average':
            {
                'code': LinearWeightedMovingAverage(20),
                'title' : 'LWMA(symbol, 20)',
                'columns' : []
            },
            'log-return':
            {
                'code': LogReturn(20),
                'title' : 'LOGR(symbol, 20)',
                'columns' : []
            },
            'mass-index':
            {
                'code': MassIndex(9, 25),
                'title' : 'MASS(symbol, 9, 25)',
                'columns' : []
            },
            'maximum':
            {
                'code': Maximum(20),
                'title' : 'MAX(symbol, 20)',
                'columns' : []
            },
            'mc-ginley-dynamic':
            {
                'code': McGinleyDynamic(10),
                'title' : 'MGD(symbol, 10)',
                'columns' : []
            },
            'mid-point':
            {
                'code': MidPoint(20),
                'title' : 'MIDPOINT(symbol, 20)',
                'columns' : []
            },
            'mid-price':
            {
                'code': MidPrice(20),
                'title' : 'MIDPRICE(symbol, 20)',
                'columns' : []
            },
            'mean-absolute-deviation':
            {
                'code': MeanAbsoluteDeviation(20),
                'title' : 'MAD(symbol, 20)',
                'columns' : ['mean']
            },
            'mesa-adaptive-moving-average':
            {
                'code': MesaAdaptiveMovingAverage(0.5, 0.05),
                'title' : 'MAMA(symbol, 0.5, 0.05)',
                'columns' : ['fama']
            },
            'minimum':
            {
                'code': Minimum(20),
                'title' : 'MIN(symbol, 20)',
                'columns' : []
            },
            'momentum':
            {
                'code': Momentum(20),
                'title' : 'MOM(symbol, 20)',
                'columns' : []
            },
            'momentum-percent':
            {
                'code': MomentumPercent(20),
                'title' : 'MOMP(symbol, 20)',
                'columns' : []
            },
            'momersion':
            {
                'code': MomersionIndicator(10, 20),
                'title' : 'MOMERSION(symbol, 10, 20)',
                'columns' : []
            },
            'money-flow-index':
            {
                'code': MoneyFlowIndex(20),
                'title' : 'MFI(symbol, 20)',
                'columns' : ['positivemoneyflow', 'negativemoneyflow', 'previoustypicalprice']
            },
            'moving-average-convergence-divergence':
            {
                'code': MovingAverageConvergenceDivergence(12, 26, 9, MovingAverageType.Exponential),
                'title' : 'MACD(symbol, 12, 26, 9, MovingAverageType.Exponential)',
                'columns' : ['fast', 'slow']
            },
            'normalized-average-true-range':
            {
                'code': NormalizedAverageTrueRange(20),
                'title' : 'NATR(symbol, 20)',
                'columns' : []
            },
            'on-balance-volume':
            {
                'code': OnBalanceVolume(),
                'title' : 'OBV(symbol)',
                'columns' : []
            },
            'parabolic-stop-and-reverse':
            {
                'code': ParabolicStopAndReverse(0.02, 0.02, 0.2),
                'title' : 'PSAR(symbol, 0.02, 0.02, 0.2)',
                'columns' : []
            },
            'percentage-price-oscillator':
            {
                'code': PercentagePriceOscillator(10, 20, MovingAverageType.Simple),
                'title' : 'PPO(symbol, 10, 20, MovingAverageType.Simple)',
                'columns' : ['fast', 'slow']
            },
            'pivot-points-high-low':
            {
                'code': PivotPointsHighLow(10, 10, 100),
                'title' : 'PPHL(symbol, 10, 10, 100)',
                'columns' : []
            },
            'rate-of-change':
            {
                'code': RateOfChange(10),
                'title' : 'ROC(symbol, 10)',
                'columns' : []
            },
            'rate-of-change-percent':
            {
                'code': RateOfChangePercent(10),
                'title' : 'ROCP(symbol, 10)',
                'columns' : []
            },
            'rate-of-change-ratio':
            {
                'code': RateOfChangeRatio(10),
                'title' : 'ROCR(symbol, 10)',
                'columns' : []
            },
            'regression-channel':
            {
                'code': RegressionChannel(20, 2),
                'title' : 'RC(symbol, 20, 2)',
                'columns' : ['slope']
            },
            'relative-daily-volume':
            {
                'code': RelativeDailyVolume(2),
                'title' : 'RDV(symbol, 2)',
                'columns' : []
            },
            'relative-moving-average':
            {
                'code': RelativeMovingAverage(20),
                'title' : 'RMA(symbol, 20)',
                'columns' : ['shortaverage', 'mediumaverage', 'longaverage']
            },
            'relative-strength-index':
            {
                'code': RelativeStrengthIndex(14),
                'title' : 'RSI(symbol, 14)',
                'columns' : ['averagegain', 'averageloss']
            },
            'relative-vigor-index':
            {
                'code': RelativeVigorIndex(20, MovingAverageType.Simple),
                'title' : 'RVI(symbol, 20, MovingAverageType.Simple)',
                'columns' : []
            },
            'rogers-satchell-volatility':
            {
                'code': RogersSatchellVolatility(30),
                'title' : 'RSV(symbol, 30)',
                'columns' : []
            },
            'schaff-trend-cycle':
            {
                'code': SchaffTrendCycle(5, 10, 20, MovingAverageType.Exponential),
                'title' : 'STC(symbol, 5, 10, 20, MovingAverageType.Exponential)',
                'columns' : []
            },
            'sharpe-ratio':
            {
                'code': SharpeRatio(22, 0.03),
                'title' : 'SR(symbol, 22, 0.03)',
                'columns' : []
            },
            'simple-moving-average':
            {
                'code': SimpleMovingAverage(20),
                'title' : 'SMA(symbol, 20)',
                'columns' : ['rollingsum']
            },
            'smoothed-on-balance-volume':
            {
                'code': SmoothedOnBalanceVolume(20),
                'title' : 'SOBV(symbol, 20)',
                'columns' : ['onbalancevolume']
            },
            'sortino-ratio':
            {
                'code': SortinoRatio(22),
                'title' : 'SORTINO(symbol, 22)',
                'columns' : []
            },
            'squeeze-momentum':
            {
                'code': SqueezeMomentum("SM", 20, 2, 20, 1.5),
                'title' : 'SM(symbol, 20, 2, 20, 1.5)',
                'columns' : ["bollinger_bands", "keltner_channels"]
            },
            'standard-deviation':
            {
                'code': StandardDeviation(22),
                'title' : 'STD(symbol, 22)',
                'columns' : []
            },
            'stochastic':
            {
                'code': Stochastic(20, 10, 20),
                'title' : 'STO(symbol, 20, 10, 20)',
                'columns' : []
            },
            'stochastic-relative-strength-index':
            {
                'code': StochasticRelativeStrengthIndex(14, 14, 3, 3),
                'title' : 'SRSI(symbol, 14, 14, 3, 3)',
                'columns' : ["k", "d"]
            },
            'sum':
            {
                'code': Sum(20),
                'title' : 'SUM(symbol, 20)',
                'columns' : []
            },
            'super-trend':
            {
                'code': SuperTrend(20, 2, MovingAverageType.Wilders),
                'title' : 'STR(symbol, 20, 2, MovingAverageType.Wilders)',
                'columns' : ['basicupperband', 'basiclowerband', 'currenttrailingupperband', 'currenttrailinglowerband']
            },
            'swiss-army-knife':
            {
                'code': SwissArmyKnife(20, 0.2, SwissArmyKnifeTool.Gauss),
                'title' : 'SWISS(symbol, 20, 0.2, SwissArmyKnifeTool.Gauss)',
                'columns' : []
            },
            't3-moving-average':
            {
                'code': T3MovingAverage(30, 0.7),
                'title' : 'T3(symbol, 30, 0.7)',
                'columns' : []
            },
            'time-series-forecast':
            {
                'code': TimeSeriesForecast(3),
                'title' : 'TSF(symbol, 3)',
                'columns' : []
            },
            'triangular-moving-average':
            {
                'code': TriangularMovingAverage(20),
                'title' : 'TRIMA(symbol, 20)',
                'columns' : []
            },
            'triple-exponential-moving-average':
            {
                'code': TripleExponentialMovingAverage(20),
                'title' : 'TEMA(symbol, 20)',
                'columns' : []
            },
            'trix':
            {
                'code': Trix(20),
                'title' : 'TRIX(symbol, 20)',
                'columns' : []
            },
            'true-range':
            {
                'code': TrueRange(),
                'title' : 'TR(symbol)',
                'columns' : []
            },
            'true-strength-index':
            {
                'code': TrueStrengthIndex(25, 13, 7, MovingAverageType.Exponential),
                'title' : 'TSI(symbol, 25, 13, 7, MovingAverageType.Exponential)',
                'columns' : ['signal']
            },
            'ultimate-oscillator':
            {
                'code': UltimateOscillator(5, 10, 20),
                'title' : 'ULTOSC(symbol, 5, 10, 20)',
                'columns' : []
            },
            'value-at-risk':
            {
                'code': ValueAtRisk(252, 0.95),
                'title' : 'VAR(symbol, 252, 0.95)',
                'columns' : []
            },
            'variable-index-dynamic-average':
            {
                'code': VariableIndexDynamicAverage(20),
                'title' : 'VIDYA(symbol, 20)',
                'columns' : []
            },
            'variance':
            {
                'code': Variance(20),
                'title' : 'VAR(symbol, 20)',
                'columns' : []
            },
            'volume-weighted-average-price-indicator':
            {
                'code': VolumeWeightedAveragePriceIndicator(20),
                'title' : 'VWAP(symbol, 20)',
                'columns' : []
            },
            'volume-weighted-moving-average':
            {
                'code': VolumeWeightedMovingAverage(20),
                'title' : 'VWMA(symbol, 20)',
                'columns' : []
            },
            'vortex':
            {
                'code': Vortex(14),
                'title' : 'VTX(symbol, 14)',
                'columns' : ["plusvortex", "minusvortex"]
            },
            'wilder-accumulative-swing-index':
            {
                'code': WilderAccumulativeSwingIndex(20),
                'title' : 'ASI(symbol, 20)',
                'columns' : []
            },
            'wilder-moving-average':
            {
                'code': WilderMovingAverage(20),
                'title' : 'WWMA(symbol, 20)',
                'columns' : []
            },
            'wilder-swing-index':
            {
                'code': WilderSwingIndex(20),
                'title' : 'SI(symbol, 20)',
                'columns' : []
            },
            'williams-percent-r':
            {
                'code': WilliamsPercentR(20),
                'title' : 'WILR(symbol, 20)',
                'columns' : ['maximum', 'minimum']
            },
            'zero-lag-exponential-moving-average':
            {
                'code': ZeroLagExponentialMovingAverage(10),
                'title' : 'ZLEMA(symbol, 10)',
                'columns' : []
            },
        }

        special_indicators = {
            'advance-decline-difference':
            {
                'code': AdvanceDeclineDifference(""),
                'title' : 'ADDIFF([symbol, reference])',
                'columns' : []
            },
            'advance-decline-ratio':
            {
                'code': AdvanceDeclineRatio(""),
                'title' : 'ADR([symbol, reference])',
                'columns' : []
            },
            'advance-decline-volume-ratio':
            {
                'code': AdvanceDeclineVolumeRatio(""),
                'title' : 'ADVR([symbol, reference])',
                'columns' : []
            },
            'arms-index':
            {
                'code': ArmsIndex(""),
                'title' : 'TRIN([symbol, reference])',
                'columns' : []
            },
            'alpha':
            {
                'code': Alpha("", symbol, reference, 20),
                'title' : 'A(symbol, reference, 20)',
                'columns' : []
            },
            'beta':
            {
                'code': Beta("", symbol, reference, 20),
                'title' : 'B(symbol, reference, 20)',
                'columns' : []
            },
            'correlation':
            {
                'code': Correlation("", symbol, reference, 20, correlationType=CorrelationType.Pearson),
                'title' : 'C(symbol, reference, 20, correlationType=CorrelationType.Pearson)',
                'columns' : []
            },
            'filtered-identity':
            {
                'code': qb.FilteredIdentity("SPY", filter = lambda x: x.Close > x.Open),
                'title' : 'FilteredIdentity(symbol, filter = lambda x: x.Close > x.Open)',
                'columns' : []
            },
            'intraday-vwap': # 'intraday-vwap'
            {
                'code': IntradayVwap("SPY"),
                'title' : 'VWAP(symbol)',
                'columns' : []
            },
            'mc-clellan-oscillator':
            {
                'code': McClellanOscillator(""),
                'title' : 'MOSC([symbol, reference])',
                'columns' : []
            },
            'mc-clellan-summation-index':
            {
                'code': McClellanSummationIndex(""),
                'title' : 'MSI([symbol, reference])',
                'columns' : []
            },
            'target-downside-deviation':
            {
                'code': IndicatorExtensions.Of(TargetDownsideDeviation(50), RateOfChange(1)),
                'title' : 'TDD(symbol, 50)',
                'columns' : []
            },
            'time-profile':
            {
                'code': TimeProfile("", 3, 0.70, 0.05),
                'title' : 'TP(symbol, 3, 0.70, 0.05)',
                'columns' : []
            },
            'volume-profile':
            {
                'code': VolumeProfile("", 3, 0.70, 0.05),
                'title' : 'VP(symbol, 3, 0.70, 0.05)',
                'columns' : []
            },
            'zig-zag':
            {
                'code': ZigZag(0.05, 1),
                'title' : 'ZZ(symbol, 0.05, 1)',
                'columns' : ["high_pivot", "low_pivot", "pivot_type"]
            },
        }
        option_indicators = {
            'implied-volatility':
            {
                'code': ImpliedVolatility(option_symbol, interest_rate_model, dividend_yield_model, option_mirror_symbol),
                'title' : 'IV(option_symbol, option_mirror_symbol)',
                'columns' : []
            },
            'delta':
            {
                'code': Delta(option_symbol, interest_rate_model, dividend_yield_model, option_mirror_symbol),
                'title' : 'D(option_symbol, option_mirror_symbol)',
                'columns' : []
            },
            'gamma':
            {
                'code': Gamma(option_symbol, interest_rate_model, dividend_yield_model, option_mirror_symbol),
                'title' : 'G(option_symbol, option_mirror_symbol)',
                'columns' : []
            },
            'vega':
            {
                'code': Vega(option_symbol, interest_rate_model, dividend_yield_model, option_mirror_symbol),
                'title' : 'V(option_symbol, option_mirror_symbol)',
                'columns' : []
            },
            'theta':
            {
                'code': Theta(option_symbol, interest_rate_model, dividend_yield_model, option_mirror_symbol),
                'title' : 'T(option_symbol, option_mirror_symbol)',
                'columns' : []
            },
            'rho':
            {
                'code': Rho(option_symbol, interest_rate_model, dividend_yield_model, option_mirror_symbol),
                'title' : 'R(option_symbol, option_mirror_symbol)',
                'columns' : []
            }
        }

        for name, indicator in indicators.items():
            code = indicator['code']
            df = qb.Indicator(code, 'SPY', timedelta(365) , Resolution.Daily)
            try:
                self.generate(name, indicator, df)
            except Exception as e:
                self.Debug(e)

        history = qb.History[TradeBar](["SPY", "QQQ"], timedelta(365), Resolution.Daily)
        option_history = qb.History[QuoteBar]([option_symbol, option_mirror_symbol], timedelta(365), Resolution.Daily)

        roc = RateOfChange(1)
        indicator['code'] = IndicatorExtensions.Of(TargetDownsideDeviation(50), roc)
        indicator['title'] = 'TDD("SPY", 50)'
        index, values = [], []

        for bars in history:
            bar = bars.get("SPY")
            roc.Update(bar.EndTime, bar.Close)
            if indicator['code'].IsReady:
                index.append(bar.EndTime)
                values.append(indicator['code'].Current.Value)

        df = pd.DataFrame(values, index=index, columns=["targetdownsidedeviation"])
        self.generate("target-downside-deviation", indicator, df)

        index, values = [], []
        indicator = special_indicators.get('advance-decline-difference')
        indicator['code'] = qb.ADDIFF(["SPY","QQQ"])
        for bars in history:
            indicator['code'].Update(bars.get("SPY"))
            indicator['code'].Update(bars.get("QQQ"))
            if indicator['code'].IsReady:
                index.append(bars.Time)
                values.append(indicator['code'].Current.Value)
        df = pd.DataFrame(values, index=index, columns=["advancedeclinedifference"])
        self.generate("advance-decline-difference", indicator, df)

        index, values = [], []
        indicator = special_indicators.get('advance-decline-ratio')
        indicator['code'] = qb.ADR(["SPY","QQQ"])
        for bars in history:
            indicator['code'].Update(bars.get("SPY"))
            indicator['code'].Update(bars.get("QQQ"))
            if indicator['code'].IsReady:
                index.append(bars.Time)
                values.append(indicator['code'].Current.Value)
        df = pd.DataFrame(values, index=index, columns=["advancedeclineratio"])
        self.generate("advance-decline-ratio", indicator, df)

        index, values = [], []
        indicator = special_indicators.get('advance-decline-volume-ratio')
        indicator['code'] = qb.ADVR(["SPY","QQQ"])
        for bars in history:
            indicator['code'].Update(bars.get("SPY"))
            indicator['code'].Update(bars.get("QQQ"))
            if indicator['code'].IsReady:
                index.append(bars.Time)
                values.append(indicator['code'].Current.Value)
        df = pd.DataFrame(values, index=index, columns=["advancedeclinevolumeratio"])
        self.generate("advance-decline-volume-ratio", indicator, df)

        index, values = [], []
        indicator = special_indicators.get('alpha')
        indicator['code'] = qb.A("SPY","QQQ", 1, 20)
        for bars in history:
            indicator['code'].Update(bars.get("SPY"))
            indicator['code'].Update(bars.get("QQQ"))
            if indicator['code'].IsReady:
                index.append(bars.Time)
                values.append(indicator['code'].Current.Value)
        df = pd.DataFrame(values, index=index, columns=["alpha"])
        self.generate("alpha", indicator, df)
        
        index, values = [], []
        indicator = special_indicators.get('beta')
        indicator['code'] = qb.B("SPY","QQQ", 20)
        for bars in history:
            indicator['code'].Update(bars.get("SPY"))
            indicator['code'].Update(bars.get("QQQ"))
            if indicator['code'].IsReady:
                index.append(bars.Time)
                values.append(indicator['code'].Current.Value)
        df = pd.DataFrame(values, index=index, columns=["beta"])
        self.generate("beta", indicator, df)
        
        index, values = [], []
        indicator = special_indicators.get('correlation')
        indicator['code'] = qb.C("SPY","QQQ", 20, CorrelationType.Pearson)
        for bars in history:
            indicator['code'].Update(bars.get("SPY"))
            indicator['code'].Update(bars.get("QQQ"))
            if indicator['code'].IsReady:
                index.append(bars.Time)
                values.append(indicator['code'].Current.Value)
        df = pd.DataFrame(values, index=index, columns=["correlation"])
        self.generate("correlation", indicator, df)

        index, values = [], []
        indicator = special_indicators.get('arms-index')
        indicator['code'] = qb.TRIN(["SPY","QQQ"])
        for bars in history:
            indicator['code'].Update(bars.get("SPY"))
            indicator['code'].Update(bars.get("QQQ"))
            if indicator['code'].IsReady:
                index.append(bars.Time)
                values.append(indicator['code'].Current.Value)
        df = pd.DataFrame(values, index=index, columns=["armsindex"])
        self.generate("arms-index", indicator, df)

        index, values = [], []
        indicator = special_indicators.get('mc-clellan-oscillator')
        indicator['code'] = qb.MOSC(["SPY","QQQ"])
        for bars in history:
            indicator['code'].Update(bars.get("SPY"))
            indicator['code'].Update(bars.get("QQQ"))
            if indicator['code'].IsReady:
                index.append(bars.Time)
                values.append(indicator['code'].Current.Value)
        df = pd.DataFrame(values, index=index, columns=["mcclellanoscillator"])
        self.generate("mc-clellan-oscillator", indicator, df)

        index, values = [], []
        indicator = special_indicators.get('mc-clellan-summation-index')
        indicator['code'] = qb.MSI(["SPY","QQQ"])
        for bars in history:
            indicator['code'].Update(bars.get("SPY"))
            indicator['code'].Update(bars.get("QQQ"))
            if indicator['code'].IsReady:
                index.append(bars.Time)
                values.append(indicator['code'].Current.Value)
        df = pd.DataFrame(values, index=index, columns=["mcclellansummationindex"])
        self.generate("mc-clellan-summation-index", indicator, df)
        
        index, values = [], []
        indicator = special_indicators.get('intraday-vwap')
        for bars in history:
            indicator['code'].Update(bars.get("SPY"))
            if indicator['code'].IsReady:
                index.append(bars.Time)
                values.append(indicator['code'].Current.Value)
        df = pd.DataFrame(values, index=index, columns=["intradayvwap"])
        self.generate("intraday-vwap", indicator, df)

        index, values = [], []
        indicator = special_indicators.get('time-profile')
        for bars in history:
            indicator['code'].Update(bars.get("SPY"))
            if indicator['code'].IsReady:
                index.append(bars.Time)
                values.append(indicator['code'].Current.Value)
        df = pd.DataFrame(values, index=index, columns=["timeprofile"])
        self.generate("time-profile", indicator, df)

        index, values = [], []
        indicator = special_indicators.get('volume-profile')
        for bars in history:
            indicator['code'].Update(bars.get("SPY"))
            if indicator['code'].IsReady:
                index.append(bars.Time)
                values.append(indicator['code'].Current.Value)
        df = pd.DataFrame(values, index=index, columns=["volumeprofile"])
        self.generate("volume-profile", indicator, df)

        index, values = [], []
        indicator = special_indicators.get('filtered-identity')
        for bars in history:
            indicator['code'].Update(bars.get("SPY"))
            if indicator['code'].IsReady:
                index.append(bars.Time)
                values.append(indicator['code'].Current.Value)
        df = pd.DataFrame(values, index=index, columns=["filteredidentity"])
        self.generate("filtered-identity", indicator, df)
        
        index, values = [], []
        indicator = special_indicators.get("zig-zag")
        indicator['code'] = qb.ZZ("SPY", 0.05, 1)
        for bars in history:
            indicator['code'].Update(bars.get("SPY"))
            if indicator['code'].IsReady:
                index.append(bars.Time)
                values.append([
                    indicator['code'].Current.Value, 
                    indicator['code'].high_pivot.current.value,
                    indicator['code'].low_pivot.current.value]
                )
        df = pd.DataFrame(values, index=index, columns=["zigzag", "highpivot", "lowpivot"])
        self.generate("zig-zag", indicator, df)
        
        times = set(bars.get("SPY").EndTime for bars in history).intersection(bars.get(option_symbol).EndTime for bars in option_history)
        history = [bar for bar in history if bar.get("SPY").EndTime in times]
        option_history = [bar for bar in option_history if bar.get(option_symbol).EndTime in times]
        
        for name, indicator in option_indicators.items():
            index, values = [], []
            for bars, quotebars in zip(history, option_history):
                indicator['code'].Update(IndicatorDataPoint(symbol, bars.get("SPY").EndTime, bars.get("SPY").Close))
                indicator['code'].Update(IndicatorDataPoint(option_symbol, quotebars.get(option_symbol).EndTime, quotebars.get(option_symbol).Close))
                indicator['code'].Update(IndicatorDataPoint(option_mirror_symbol, quotebars.get(option_mirror_symbol).EndTime, quotebars.get(option_mirror_symbol).Close))
                if indicator['code'].IsReady:
                    index.append(bars.get("SPY").EndTime)
                    values.append(indicator['code'].Current.Value)
            df = pd.DataFrame(values, index=index, columns=[name.replace('-', '')])
            self.generate(name, indicator, df)

        self.Quit()
