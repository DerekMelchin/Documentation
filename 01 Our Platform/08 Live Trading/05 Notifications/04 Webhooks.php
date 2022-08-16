<?php echo file_get_contents(DOCS_RESOURCES."/notifications/webhook-intro.html"); ?>

<h4>Set Up in the Deployment Wizard</h4>
<p>Follow these steps to set up webhook notifications in the deployment wizard:</p>

<ol>
    <li>On the Deploy Live page, enable at least one of the notification types.</li>
    <p>The following table shows the supported notification types:</p>

    <table class="table qc-table">
        <thead>
            <tr>
                <th>Notification Type</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Order Events</td>
                <td>Notifications for when the algorithm receives <code>OrderEvent</code> objects</td>
            </tr>
            <tr>
                <td>Insights</td>
                <td>Notifications for when the algorithm emits <code>Insight</code> objects</td>
            </tr>
        </tbody>
    </table>
    <li>Click <span class="button-name">Webhook</span>.</li>
    <li>Enter a URL.</li>
    <li>If you want to add header information, click <span class="button-name">Add Header</span> and then enter a key and value.</li>
    <p>Repeat this step to add multiple header keys and values.</p>
    <li>Click <span class="button-name">Add</span>.</li>
    <p>To add more webhook notifications, click <span class="button-name">Add Notification</span> and then continue from step 2.</p>
</ol>

<h4>Send In Your Code Files</h4>
<?php echo file_get_contents(DOCS_RESOURCES."/notifications/webhook-setup.html"); ?>