@extends('emails.email-template')
​
@section('content')
    <tr>
        <td style="height: 30px; padding-top: 12px">
            <h1
                style="
                    font-style: normal;
                    font-weight: bold;
                    font-size: 24px;
                    line-height: 40px;
                    text-align: center;
                    color: #1d1e2d;
                "
            >
            {{ __('messages.title') }}
            </h1>
        </td>
    </tr>
    <tr>
        <td style="padding: 12px 36px 0">
            <h1
                style="
                    font-style: normal;
                    font-weight: normal;
                    font-size: 16px;
                    line-height: 24px;
                    color: #1d1e2d;
                "
            >
            {{ __('messages.greeting') }}, {{ $booking->first_name }}
            </h1>

            <p>{{ __('messages.details') }}</p>
            <table style="border-collapse: collapse; width: 100%; max-width: 600px; margin: 20px auto; background-color: #f1f1f1;">
                <tr>
                    <th style="padding: 10px; text-align: left; background-color: #e0e0e0; border: 1px solid #ccc;">{{ __('messages.tracking_number') }}</th>
                    <th style="padding: 10px; text-align: left; background-color: #e0e0e0; border: 1px solid #ccc;">{{ __('messages.drop_off_date') }}</th>
                    <th style="padding: 10px; text-align: left; background-color: #e0e0e0; border: 1px solid #ccc;">{{ __('messages.quantity') }}</th>
                    <th style="padding: 10px; text-align: left; background-color: #e0e0e0; border: 1px solid #ccc;">{{ __('messages.total_amount') }}</th>
                </tr>
                <tr>
                    <td style="padding: 10px; text-align: left; background-color: white; border: 1px solid #ccc;">{{ $booking->tracking_number  }}</td>
                    <td style="padding: 10px; text-align: left; background-color: white; border: 1px solid #ccc;">{{ $booking->drop_off_date  }}</td>
                    <td style="padding: 10px; text-align: left; background-color: white; border: 1px solid #ccc;">{{ $booking->first_name  }}</td>
                    <td style="padding: 10px; text-align: left; background-color: white; border: 1px solid #ccc;">{{ $booking->total_price  }}</td>
                </tr>
                
            </table>
        </td>
    </tr>
    <ul>
        {{-- <li>Tracking Number: {{ $booking->tracking_number }}</li> --}}
        <li>Name: {{ $booking->first_name }} {{ $booking->last_name }}</li>
        <li>Email: {{ $booking->email }}</li>
        <li>Phone Number: {{ $booking->phone_number }}</li>
    </ul>
​
    <tr>
        <td style="padding: 32px 56px 42px 56px; text-align: center;">
            <a
                href="{{ env('FRONTEND_URL') . '/booking-confirmation/' . $booking->id }}"
                target="_blank"
                style="
                    padding: 10px 16px;
                    font-size: 14px;
                    line-height: 16px;
                    background: transparent;
                    border: 1px solid #0363ed;
                    color: #0363ed;
                    letter-spacing: 1.25px;
                    box-sizing: border-box;
                    border-radius: 4px;
                    font-weight: bold;
                    cursor: pointer;
                    text-decoration: none;
                "
            >
                {{ __('messages.go_to_details') }}
            </a>
        </td>
    </tr>
    <tr>
        <td style="padding: 12px 26px 22px 26px; text-align: center;">
            <a
                href="https://maps.app.goo.gl/e22kL8pgtkfc24RD9"
                target="_blank"
                style="
                    padding: 10px 16px;
                    font-size: 14px;
                    line-height: 16px;
                    background: transparent;
                    border: 1px solid #0363ed;
                    color: #0363ed;
                    letter-spacing: 1.25px;
                    box-sizing: border-box;
                    border-radius: 4px;
                    font-weight: bold;
                    cursor: pointer;
                    text-decoration: none;
                "
            >
            {{ __('messages.go_to_map') }}
            </a>
        </td>
    </tr>
@endsection