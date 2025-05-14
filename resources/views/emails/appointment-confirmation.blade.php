<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Appointment Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            color: #3498db;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .footer {
            font-size: 12px;
            color: #777;
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Appointment Confirmation</h1>
        
        <p>Dear {{ $appointmentData['client_name'] ?? 'Client' }},</p>
        
        <p>Thank you for booking an appointment with Car Service Center. Your appointment has been scheduled for:</p>
        
        <div class="details">
            <p><strong>Date:</strong> {{ $appointmentData['appointment_date'] ?? 'To be determined' }}</p>
            <p><strong>Time:</strong> {{ $appointmentData['appointment_time'] ?? 'To be determined' }}</p>
            <p><strong>Service Type:</strong> {{ $appointmentData['service_type'] ?? 'General Service' }}</p>
            <p><strong>Mechanic:</strong> {{ $mechanicData['name'] ?? 'To be assigned' }} ({{ $mechanicData['specialty'] ?? 'General Service' }})</p>
            
            <p><strong>Vehicle Information:</strong><br>
            License Plate: {{ $appointmentData['car_license_number'] ?? 'Not provided' }}<br>
            Engine Number: {{ $appointmentData['car_engine_number'] ?? 'Not provided' }}</p>
            
            @if(!empty($appointmentData['description']))
            <p><strong>Your Notes:</strong><br>
            {{ $appointmentData['description'] }}</p>
            @endif
        </div>
        
        <p>Please arrive 10 minutes before your scheduled appointment time. If you need to reschedule or cancel, please contact us at least 24 hours in advance.</p>
        
        <p>Thank you for choosing Car Service Center.</p>
        
        <p>Regards,<br>
        The Car Service Center Team</p>
        
        <div class="footer">
            <p>© {{ date('Y') }} Car Service Center. All rights reserved.</p>
        </div>
    </div>
</body>
</html> 