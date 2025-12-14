@component('mail::message')
# Booking Confirmation

Hello {{ $booking->name }},

Your booking has been successfully received with the following details:

- **Service:** {{ $booking->service }}
- **Date:** {{ $booking->service_date }}
- **Phone:** {{ $booking->phone }}
- **Address:** {{ $booking->address }}
- **Special Request:** {{ $booking->special_request ?? 'N/A' }}

Thank you for choosing our service.

Regards,
**Indian Color Point & Autoglass**
@endcomponent
