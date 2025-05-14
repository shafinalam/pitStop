@component('mail::message')
# Appointment Confirmation

Dear {{ $appointmentData['client_name'] }},

Thank you for booking an appointment with Car Service Center. Your appointment has been scheduled for:

**Date:** {{ $appointmentData['appointment_date'] }}  
**Time:** {{ $appointmentData['appointment_time'] }}  
**Service Type:** {{ $appointmentData['service_type'] }}  
**Mechanic:** {{ $mechanicData['name'] }} ({{ $mechanicData['specialty'] }})

**Vehicle Information:**  
License Plate: {{ $appointmentData['car_license_number'] }}  
Engine Number: {{ $appointmentData['car_engine_number'] }}

@if(!empty($appointmentData['description']))
**Your Notes:**  
{{ $appointmentData['description'] }}
@endif

Please arrive 10 minutes before your scheduled appointment time. If you need to reschedule or cancel, please contact us at least 24 hours in advance.

@component('mail::button', ['url' => url('/')])
Visit Our Website
@endcomponent

Thank you for choosing Car Service Center.

Regards,  
The Car Service Center Team
@endcomponent 