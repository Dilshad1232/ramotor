@extends('admin.main')

@section('title', 'Generate Bill')

@section('content')

<style>
/* FIX: A4 invoice content black */
#printSection, #printSection * {
    color: #000 !important;
}

.page-title {
    text-align:center;
    color:#D81324;
    margin-bottom:20px;
    font-size:1.8rem;
    font-weight:700;
}

.billing-wrapper {
    max-width:1000px;
    margin:auto;
    display:flex;
    flex-direction:column;
    gap:25px;
}

.billing-card {
    background:#ffffff;
    padding:25px;
    border-radius:18px;
    border:1px solid #dcdcdc;
    box-shadow:0 0 10px rgba(0,0,0,0.08);
}

.input-box {
    padding:10px;
    border-radius:8px;
    border:1px solid #bbb;
    width:250px;
    margin-right:10px;
}

.btn {
    padding:8px 15px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-weight:600;
}
.search-btn { background:#D81324; color:white; }
.add-btn { background:#009933; color:white; margin-top:10px; }
.generate-btn { background:#000; color:white; margin-top:15px; }

.billing-table { width:100%; border-collapse:collapse; margin-top:10px; }
.billing-table th, .billing-table td { padding:10px; border:1px solid #ddd; text-align:center; }
.billing-table tr:nth-child(even) { background:#f9f9f9; }
.amount-words { font-style:italic; font-size:0.9rem; margin-top:5px; }

@media print {
    body * { visibility:hidden; }
    #printSection, #printSection * { visibility:visible !important; }
    #printSection {
        position:absolute;
        top:0; left:0;
        width:210mm !important;
        min-height:297mm !important;
        padding:20px;
        background:white;
        font-family:Arial, sans-serif;
    }
    #printSection button { display:none; }
}
</style>

<h2 class="page-title">🧾 Generate User Bill</h2>

<div class="billing-wrapper">

    {{-- Search User --}}
    <div class="card billing-card">
        <div class="card-header">
            <input type="text" id="userSearch" placeholder="Enter Name or Email" class="input-box">
            <button onclick="searchUser()" class="btn search-btn">Search User</button>
        </div>

        {{-- User Info --}}
        <div class="user-info" style="display:none; margin-top:20px;">
            <h3>User Details</h3>
            <p><strong>Name:</strong> <span id="userName"></span></p>
            <p><strong>Email:</strong> <span id="userEmail"></span></p>
            <p><strong>Phone:</strong> <span id="userPhone"></span></p>
            <p><strong>Address:</strong> <span id="userAddress"></span></p>
        </div>
    </div>

    {{-- Add Products --}}
    <div class="card billing-card">
        <h3>Add Products</h3>

        <table class="billing-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Discount (%)</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="productBody"></tbody>
        </table>

        <button onclick="addRow()" class="btn add-btn">+ Add Product</button>

        <div class="bill-summary">
            <h4>Grand Total: ₹<span id="grandTotal">0</span></h4>
            <p class="amount-words" id="amountWords"></p>
            <button onclick="generateBill()" class="btn generate-btn">Generate Bill</button>
        </div>
    </div>
</div>

{{-- ===========================
     PRINT BILL SECTION
=========================== --}}
<div id="printSection" style="display:none; padding:20px; width:210mm; background:white; margin:auto;">

    {{-- Header (Single Row) --}}
    <div class="header-row" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <div class="left">
            <img src="{{ asset('img/logo2 .png') }}" style="width:120px;">
        </div>
        <div class="center" style="text-align:center; flex:1; color:#D81324;">
            <h5 ><b style="margin:0; color: #D81324 !important;">MULTI BRAND FOUR WHEELER SERVICE CENTER</b></h5>
            {{-- <b style="margin:0; color: #D81324 !important;">MULTI BRAND FOUR WHEELER SERVICE CENTER</b> --}}
        </div>
        <div class="right" style="text-align:right; font-size:0.9rem; color:#D81324;">
            <p style="margin:0;"><strong>GST No:</strong> 23ABCDE1234F1Z5</p>
            <p style="margin:0;"><strong>Mobile:</strong> +91 8460522117</p>
            <p style="margin:0;"><strong>Date:</strong> <span id="invDate"></span></p>
            <p style="margin:0;"><strong>Invoice No:</strong> <span id="invNumber"></span></p>
        </div>
    </div>
    <hr>

    {{-- User Details --}}
    <h3>User Details</h3>
    <table style="width:100%; margin-bottom:20px;">
        <tr>
            <td><strong>Name:</strong> <span id="p_userName"></span></td>
            <td><strong>Email:</strong> <span id="p_userEmail"></span></td>
        </tr>
        <tr>
            <td><strong>Phone:</strong> <span id="p_userPhone"></span></td>
            <td><strong>Address:</strong> <span id="p_userAddress"></span></td>
        </tr>
    </table>

    {{-- Products Table --}}
    <h3>Products</h3>
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th style="border:1px solid #000; padding:8px;">Product</th>
                <th style="border:1px solid #000; padding:8px;">Qty</th>
                <th style="border:1px solid #000; padding:8px;">Price</th>
                <th style="border:1px solid #000; padding:8px;">Discount</th>
                <th style="border:1px solid #000; padding:8px;">Total</th>
                
            </tr>
        </thead>
        <tbody id="printProductBody"></tbody>
    </table>

    {{-- Grand Total & Amount in Words --}}
    <h2 style="text-align:right; margin-top:20px;">
        Grand Total: ₹<span id="p_grandTotal"></span>
    </h2>
    <p id="p_amountWords" style="text-align:right; font-style:italic; margin-top:5px;"></p>

    {{-- Footer --}}
    <div style="margin-top:60px; text-align:center;">
        <p>Thank you for your business!</p>
        <p>Bank Details: ABC Bank, A/C: 1234567890, IFSC: ABCD0123456</p>
    </div>

    {{-- Print Button --}}
    <button onclick="window.print()" class="btn" style="background:#dcd6d6; color:white; margin-top:20px;">
        Print Bill
    </button>
</div>

<script>
let productBody = document.getElementById('productBody');
let grandTotalEl = document.getElementById('grandTotal');

/* SEARCH USER */
function searchUser(){
    let query = document.getElementById('userSearch').value;
    fetch("{{ route('admin.search-user') }}?q="+query)
    .then(res => res.json())
    .then(data=>{
        if(data.status==='success'){
            document.querySelector('.user-info').style.display='block';
            document.getElementById('userName').innerText = data.user.name;
            document.getElementById('userEmail').innerText = data.user.email;
            document.getElementById('userPhone').innerText = data.user.phone ?? '-';
            document.getElementById('userAddress').innerText = data.user.address ?? '-';
        } else {
            alert(data.message);
            document.querySelector('.user-info').style.display='none';
        }
    });
}

/* ADD ROW */
function addRow(){
    let tr = document.createElement('tr');
    tr.innerHTML = `
        <td><input type="text" class="pname" placeholder="Enter Product Name"></td>
        <td><input type="number" value="1" min="1" class="qty" oninput="calcTotal(this)"></td>
        <td><input type="number" value="0" min="0" class="price" oninput="calcTotal(this)"></td>
        <td><input type="number" value="0" min="0" max="100" class="discount" oninput="calcTotal(this)"></td>
        <td class="total">0</td>
        <td><button onclick="removeRow(this)" class="btn" style="background:#D81324;color:white;">X</button></td>
    `;
    productBody.appendChild(tr);
}

/* CALCULATE TOTAL */
function calcTotal(el){
    let tr = el.closest('tr');
    let qty = parseFloat(tr.querySelector('.qty').value) || 1;
    let price = parseFloat(tr.querySelector('.price').value) || 0;
    let discount = parseFloat(tr.querySelector('.discount').value) || 0;
    let total = price * qty * (1 - discount/100);
    tr.querySelector('.total').innerText = total.toFixed(2);
    updateGrandTotal();
}

/* REMOVE ROW */
function removeRow(btn){
    btn.closest('tr').remove();
    updateGrandTotal();
}

/* UPDATE GRAND TOTAL */
function updateGrandTotal(){
    let total = 0;
    document.querySelectorAll('.total').forEach(td=>{
        total += parseFloat(td.innerText) || 0;
    });
    grandTotalEl.innerText = total.toFixed(2);
    document.getElementById('amountWords').innerText = numberToWords(total);
}

/* GENERATE BILL */
function generateBill(){
    document.getElementById("printSection").style.display = "block";
    document.getElementById("invNumber").innerText = "INV" + Date.now();
    document.getElementById("invDate").innerText = new Date().toLocaleDateString();
    document.getElementById("p_userName").innerText = document.getElementById("userName").innerText;
    document.getElementById("p_userEmail").innerText = document.getElementById("userEmail").innerText;
    document.getElementById("p_userPhone").innerText = document.getElementById("userPhone").innerText;
    document.getElementById("p_userAddress").innerText = document.getElementById("userAddress").innerText;

    document.getElementById("printProductBody").innerHTML = "";
    document.querySelectorAll("#productBody tr").forEach(tr => {
        let name = tr.querySelector(".pname").value;
        let qty = tr.querySelector(".qty").value;
        let price = tr.querySelector(".price").value;
        let dis = tr.querySelector(".discount").value;
        let total = tr.querySelector(".total").innerText;

        document.getElementById("printProductBody").innerHTML += `
            <tr>
                <td style="border:1px solid #000; padding:8px;">${name}</td>
                <td style="border:1px solid #000; padding:8px;">${qty}</td>
                <td style="border:1px solid #000; padding:8px;">${price}</td>
                <td style="border:1px solid #000; padding:8px;">${dis}%</td>
                <td style="border:1px solid #000; padding:8px;">${total}</td>
            </tr>
        `;
    });

    document.getElementById("p_grandTotal").innerText = grandTotalEl.innerText;
    document.getElementById("p_amountWords").innerText = numberToWords(parseFloat(grandTotalEl.innerText));
}

/* Number to Words (Indian) */
function numberToWords(amount) {
    const words = ["","One","Two","Three","Four","Five","Six","Seven","Eight","Nine","Ten",
        "Eleven","Twelve","Thirteen","Fourteen","Fifteen","Sixteen","Seventeen","Eighteen","Nineteen"];
    const tens = ["","","Twenty","Thirty","Forty","Fifty","Sixty","Seventy","Eighty","Ninety"];

    if(amount === 0) return "Zero";

    let num = Math.floor(amount);
    let str = "";

    if(num >= 100000) {
        str += words[Math.floor(num/100000)] + " Lakh ";
        num %= 100000;
    }
    if(num >= 1000) {
        str += words[Math.floor(num/1000)] + " Thousand ";
        num %= 1000;
    }
    if(num >= 100) {
        str += words[Math.floor(num/100)] + " Hundred ";
        num %= 100;
    }
    if(num > 0) {
        if(num < 20) str += words[num] + " ";
        else str += tens[Math.floor(num/10)] + " " + words[num%10] + " ";
    }
    return str + "Rupees Only";
}
</script>















@endsection
