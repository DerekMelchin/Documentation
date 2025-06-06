<p>The following table describes errors you may see when deploying to IB:</p>

<table class="table qc-table">
    <thead>
        <tr>
            <th>Error Message(s)</th>
            <th>Possible Cause and Fix</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td nowrap>
                <div class="error-messages">Login failed.</div>
            </td>
            <td>
                The credentials you provided are incorrect. Typically, the password contains
                leading and/or trailing white spaces. Copy the password to a text editor to ensure
                the password is correct. 
                If you can't log in to Trader Workstation (TWS) with your credentials, contact IB. If you can log in to TWS but can't log in to the deployment wizard, <a href='https://www.quantconnect.com/contact'>contact us</a> and provide the algorithm Id and deployment Id.
            </td>
        </tr>
        <tr>
            <td nowrap>
                <div class="error-messages">Login to the IB Gateway failed because<br>a user account-tasks is required.</div>
            </td>
            <td>
                Download <a rel='nofollow' target='_blank' href='https://www.interactivebrokers.com/en/trading/ibgateway-stable.php'>IB Gateway</a>, run it, and follow the instructions provided.
            </td>
        </tr>
        <tr>
            <td rowspan="2">
                <div class="error-messages">An existing session was detected and will not be automatically disconnected.</div>
            <br>
                <div class="error-messages">Historical Market Data Service error message: Trading TWS session is connected from a different IP address.</div>
            </td>
        </tr>
        <tr>
            <td>
                IB still recognizes your previous live deployment as being partially connected.
                It can take a minute to fully disconnect. 
                For more information, see <a href='https://www.quantconnect.com/docs/v2/cloud-platform/live-trading/brokerages/interactive-brokers#12-Security-and-Stability'>Security and Stability > Connections</a>.
            </td>
        </tr>
        <tr>
            <td rowspan="2">
                <div class="error-messages">The two factor authentication request timed out.</div>
            <br>
                <div class="error-messages">A security dialog was detected for Code Card Authentication.</div>
            <br>
                <div class="error-messages">Unknown message window detected: Challenge: 123 456</div>
            </td>
        </tr>
        <tr>
            <td>
                You haven't replied to the two factor authentication requests. 
                The code card authentication ("Challenge") is triggered when you don't reply to the IB mobile 2FA requests.
                Ensure your IB Key device has sufficient battery for the time you expect to receive the notification. 
                If you don't receive a notification, see <a rel='nofollow' target='_blank' href='https://ibkr.info/article/3234'>I am not receiving IBKR Mobile notifications</a> on the IB website.
            </td>
        </tr>
        <tr>
            <td>
                <div class="error-messages">API support is not available for accounts that support free trading.</div>
            </td>
            <td>
                Upgrade your plan from IBKR Lite to IBKR Pro.
            </td>
        </tr>
        <tr>
            <td>
                <div class="error-messages">No security definition has been found for the request.</div>
            </td>
            <td>
                Your algorithm added an invalid or unsupported security. For example, a delisted stock, an expired contract, inexistent contract (invalid expiration date or strike price), or a warrant (unsupported). If the security should be valid and <a href='/docs/v2/cloud-platform/live-trading/brokerages/interactive-brokers#04-Asset-Classes'>supported</a>, open a <a href='/docs/v2/cloud-platform/organizations/support'>support ticket</a> and attach the live deployment Id.
                The algorithm will continue running, but it won't trade the security. If you don't want to deploy to an account with an invalid or unsupported security, set <code class="csharp">Settings.IgnoreUnknownAssets</code><code class="python">self.settings.ignore_unknown_assets</code> is <code class="csharp">false</code><code class="python">False</code>. 
            </td>
        </tr>
        <tr>
            <td rowspan="2">
                <div class="error-messages">Requested market data is not subscribed.</div>
            <br>
                <div class="error-messages">Historical Market Data Service error message: No market data permissions for ...</div>
            </td>
        </tr>
        <tr>
            <td>
                Your algorithm uses the <a href='/docs/v2/cloud-platform/datasets/interactive-brokers'>Interactive Brokers Data Provider</a>, but you don't have a subscription to it. 
                <a href='/docs/v2/cloud-platform/datasets/interactive-brokers#09-Pricing'>Subscribe to the data bundle you need</a>, contact IB, or re-deploy the algorithm with a different data provider. 
                Try the <a href='/docs/v2/cloud-platform/datasets/quantconnect'>QuantConnect</a> or the <a href='/docs/v2/cloud-platform/datasets/interactive-brokers#07-Hybrid-Data-Provider'>hybrid QuantConnect + Interactive Brokers</a> data providers on QuantConnect Cloud or try a third-party provider.
            </td>
        </tr>
        <tr>
            <td>
                <div class="error-messages">Timeout waiting for brokerage response for brokerage order id 37 lean id 31</div>
            </td>
            <td>
                IB didn't respond to an order request. Stop and re-deploy the algorithm. On the next deployment, LEAN retrieves this order or the positions it opened or closed.
            </td>
        </tr>
        <? if ($localPlatformOrCli){ ?>
        <tr>
            <td>
                <div class="error-messages">Could not find file '/root/ibgateway/ibgateway'.</div>
            </td>
            <td>
                Your Docker installation has pulled the ARM platform version of the LEAN Docker image. This version doesn't include IB Gateway, because QuantConnect doesn't support <a rel='nofollow' target='_blank' href='https://qnt.co/interactivebrokers'>Interactive Brokers</a> integration with ARM chips (e.g.: Apple M1, M2, and M3 chips).
            </td>
        </tr>
        <?}?>
    </tbody>
</table>

<p>To view the description of less common errors, see <a rel='nofollow' target='_blank' href="https://ibkrcampus.com/ibkr-api-page/twsapi-doc/#api-error-codes">Error Codes</a> in the TWS API Documentation. If you need further support, <a href='/docs/v2/cloud-platform/organizations/support#06-Open-New-Tickets'>open a new support ticker</a> and add the live deployment with the error.</p>