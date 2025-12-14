<button id="rzp-button">Pay Now</button>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "{{ env('RAZORPAY_KEY') }}",
    "amount": {{ $paymentOrder['amount'] }},
    "currency": "INR",
    "name": "Indian Color Point & Autoglass",
    "description": "Booking Payment",
    "order_id": "{{ $paymentOrder['id'] }}",
    "handler": function (response){
        var form = document.createElement("form");
        form.method = "POST";
        form.action = "{{ route('payment.verify') }}";

        form.innerHTML = `
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="razorpay_payment_id" value="${response.razorpay_payment_id}">
            <input type="hidden" name="razorpay_order_id" value="${response.razorpay_order_id}">
            <input type="hidden" name="razorpay_signature" value="${response.razorpay_signature}">
        `;
        document.body.appendChild(form);
        form.submit();
    },
    "prefill": {
        "name": "{{ $booking->name }}",
        "email": "{{ $booking->email }}"
    },
    "theme": {"color": "#00aaff"}
};
var rzp1 = new Razorpay(options);
document.getElementById('rzp-button').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>
