@extends('user.main')
@section('content')
<div style="padding:20px; max-width:900px; margin:auto;">

<!-- Print Button -->
<div style="text-align:right; margin-bottom:20px;">
    <button onclick="printInvoice()" style="padding:10px 22px; background:#000; color:#fff; border:none; border-radius:6px; font-weight:600; cursor:pointer;">🖨 Print</button>
</div>

<!-- Invoice Wrapper -->
<div id="invoice-area" style="background:#fff; color:#000; padding:30px; border-radius:15px; box-shadow:0 0 25px rgba(0,0,0,0.2);">

    <!-- Header -->
    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #000; padding-bottom:15px;">
        <div><img src="{{ asset('img/logo2 .png') }}" alt="Logo" style="width:120px;"></div>
        <div style="text-align:right;">
            <h2 style="margin:0;">AutoCare Garage</h2>
            <p style="margin:2px 0; font-size:14px;">Kushinagar, Uttar Pradesh</p>
            <p style="margin:2px 0; font-size:14px;">+91 9876543210</p>
            <p style="margin:2px 0; font-size:14px;">support@autocare.com</p>
        </div>
    </div>

    <!-- Invoice Info -->
    <div style="margin-top:25px; display:flex; justify-content:space-between;">
        <div>
            <p><strong>Invoice No:</strong> #INV-2025-0081</p>
            <p><strong>Invoice Date:</strong> 02 Dec 2025</p>
            <p><strong>Due Date:</strong> 05 Dec 2025</p>
        </div>
        <div>
            <p><strong>Customer:</strong> Abhishek Raj</p>
            <p><strong>Phone:</strong> 8978756455</p>
            <p><strong>Address:</strong> Barwa Bazar, Kushinagar</p>
            <p><strong>Email:</strong> abhishek@example.com</p>
        </div>
    </div>

    <!-- Services Table -->
    <table style="width:100%; margin-top:20px; border-collapse:collapse;">
        <thead>
            <tr>
                <th style="border:1px solid #000; padding:10px; background:#000; color:#fff;">Service</th>
                <th style="border:1px solid #000; padding:10px; background:#000; color:#fff;">Description</th>
                <th style="border:1px solid #000; padding:10px; background:#000; color:#fff;">Price (₹)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border:1px solid #000; padding:10px;">Full Car Service</td>
                <td style="border:1px solid #000; padding:10px;">Complete checkup, oil service, filter replacement</td>
                <td style="border:1px solid #000; padding:10px;">1500</td>
            </tr>
            <tr>
                <td style="border:1px solid #000; padding:10px;">Engine Wash</td>
                <td style="border:1px solid #000; padding:10px;">Deep clean engine compartment</td>
                <td style="border:1px solid #000; padding:10px;">600</td>
            </tr>
            <tr>
                <td style="border:1px solid #000; padding:10px;">Wheel Alignment</td>
                <td style="border:1px solid #000; padding:10px;">Advanced laser alignment</td>
                <td style="border:1px solid #000; padding:10px;">400</td>
            </tr>
        </tbody>
    </table>

    <!-- Totals -->
    <div style="margin-top:25px; float:right; width:300px; padding:15px; border:2px solid #000; border-radius:12px; background:#f9f9f9;">
        <p style="display:flex; justify-content:space-between;"><span>Subtotal:</span> <span>2500</span></p>
        <p style="display:flex; justify-content:space-between;"><span>GST (18%):</span> <span>450</span></p>
        <p style="display:flex; justify-content:space-between; font-weight:bold; font-size:18px; border-top:2px solid #000; padding-top:5px;"><span>Total:</span> <span>2950</span></p>
    </div>

    <!-- Signature -->
    <div style="margin-top:80px; text-align:right;">
        <p>Authorized Signature</p>
        <img src="{{ asset('img/logo2 .png') }}" alt="Signature" style="width:150px; opacity:0.7;">
    </div>

</div>

<script>
function printInvoice(){
    const printArea = document.getElementById('invoice-area').innerHTML;
    const original = document.body.innerHTML;
    document.body.innerHTML = printArea;
    window.print();
    document.body.innerHTML = original;
}
</script>

</div>
@endsection
