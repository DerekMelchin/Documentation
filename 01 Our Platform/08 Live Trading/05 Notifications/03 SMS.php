<?php echo file_get_contents(DOCS_RESOURCES."/notifications/sms-intro.html"); ?>

<h4>Set Up in the Deployment Wizard</h4>
<p>Follow these steps to set up SMS notifications in the deployment wizard:</p>

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
    <li>Click <span class="button-name">SMS</span>.</li>
    <li>Enter a phone number.</li>
    <li>Click <span class="button-name">Add</span>.</li>
    <p>To add more SMS notifications, click <span class="button-name">Add Notification</span> and then continue from step 2.</p>
</ol>

<h4>Send In Your Code Files</h4>
<?php echo file_get_contents(DOCS_RESOURCES."/notifications/sms-setup.html"); ?>