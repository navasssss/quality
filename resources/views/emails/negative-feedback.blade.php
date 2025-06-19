<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Negative Feedback Alert</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 30px;">
                    <tr>
                        <td align="center" style="padding-bottom: 20px;">
                            <h2 style="color: #d9534f; margin: 0;">⚠️ Negative Feedback Alert</h2>
                            <p style="color: #888888; font-size: 14px;">A customer submitted a rating of {{ $feedback->satisfaction_rating }}.</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellpadding="10">
                                <tr>
                                    <td style="font-weight: bold; color: #333;">Customer Name:</td>
                                    <td>{{ $feedback->customer_name }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; color: #333;">Email:</td>
                                    <td>{{ $feedback->email }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; color: #333;">Rating:</td>
                                    <td>{{ $feedback->satisfaction_rating }} / 5</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; color: #333;">Improvements Suggested:</td>
                                    <td>{{ $feedback->improvements }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding-top: 30px;">
                            <a href="{{ url('/') }}" style="background-color: #d9534f; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 4px;">View Dashboard</a>
                        </td>
                    </tr>
                    
                    <tr>
                        <td align="center" style="padding-top: 30px; font-size: 12px; color: #888888;">
                            &copy; {{ date('Y') }} AUSQMS. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>
