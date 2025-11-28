@extends('admin.main')

@section('title', 'Customer Details')

@section('content')

<div class="card" style="padding: 20px; background:#2c2c2c; color:white; border-radius:12px;">
    <h2 style="margin-bottom: 15px;">Customer Details</h2>

    <div style="display:flex; gap:25px; align-items:flex-start; flex-wrap:wrap;">

        {{-- Profile Image --}}
        <div>
            <img src="{{ asset('uploads/profile/' . $customer->profile_image) }}"
                 width="150" height="150"
                 style="border-radius:10px; object-fit:cover; border:3px solid #ff4d4d;">
        </div>

        {{-- Information --}}
        <div style="flex:1;">
            <table style="width:100%; border-collapse:collapse;">
                <tr><th style="padding:10px;">Name</th><td style="padding:10px;">{{ $customer->name }}</td></tr>
                <tr><th style="padding:10px;">Email</th><td style="padding:10px;">{{ $customer->email }}</td></tr>
                <tr><th style="padding:10px;">Phone</th><td style="padding:10px;">{{ $customer->phone }}</td></tr>
                <tr><th style="padding:10px;">Address</th><td style="padding:10px;">{{ $customer->address }}</td></tr>
                <tr><th style="padding:10px;">City</th><td style="padding:10px;">{{ $customer->city }}</td></tr>
                <tr><th style="padding:10px;">Pincode</th><td style="padding:10px;">{{ $customer->pincode }}</td></tr>
                <tr><th style="padding:10px;">Status</th>
                    <td style="padding:10px;">
                        @if($customer->status == 1)
                            <span style="color:green; font-weight:bold;">Active</span>
                        @else
                            <span style="color:red; font-weight:bold;">Inactive</span>
                        @endif
                    </td>
                </tr>
                <tr><th style="padding:10px;">Member Since</th>
                    <td style="padding:10px;">
                        {{ \Carbon\Carbon::parse($customer->created_at)->format('d M Y') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Back Button --}}
    <div style="margin-top:25px;">
        <a href="{{ url()->previous() }}" style="background:#ff4d4d; color:white; padding:10px 20px; border-radius:5px; text-decoration:none;">
            ← Back to Customer List
        </a>
    </div>
</div>

@endsection
