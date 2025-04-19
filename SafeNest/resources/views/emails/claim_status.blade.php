<!DOCTYPE html>
<html>
<head>
    <title>Claim Status Notification</title>
</head>
<body>
    <h2>Hello {{ $claim->user->name }},</h2>

    <p>Your claim (ID: {{ $claim->Claim_ID }}) for policy <strong>{{ $claim->policy->Title }}</strong> has been <strong>{{ $claim->Status }}</strong>.</p>

    @if($claim->Status === 'Rejected')
        <p>Unfortunately, your claim has not been approved. If you have any questions, please contact us for further clarification.</p>
    @elseif($claim->Status === 'Approved')
        <p>Good news! Your claim has been approved. We’ll follow up with next steps shortly.</p>
    @endif

    <p>Thank you for using SafeNest Insurance.</p>
</body>
</html>
