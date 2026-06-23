@extends('layouts.public')
@section('title', 'Cashier | Sportshandicapper')
@section('meta', 'Manage deposits and withdrawals on Sportshandicapper.')

@push('styles')
<style>
.cashier-wrap { max-width: 680px; margin: 0 auto; }
.cashier-tabs { display: flex; gap: 8px; margin-bottom: 28px; background: #0C1020; border-radius: 9999px; padding: 6px; border: 1px solid rgba(255,255,255,0.08); }
.cashier-tab {
    flex: 1; text-align: center; padding: 12px; border-radius: 9999px;
    font-family: 'Inter', sans-serif; font-weight: 700; font-size: 14px;
    color: #94A3B8; cursor: pointer; transition: all .18s; border: none; background: transparent;
}
.cashier-tab.active { background: #1E90FF; color: white; }
.cashier-label {
    font-size: 11px; color: #475569; text-transform: uppercase;
    letter-spacing: 0.15em; margin-bottom: 8px; font-weight: 700; display: block;
    font-family: 'Inter', sans-serif;
}
.cashier-amount-input {
    width: 100%; background: #0A0F1E; border: 1px solid rgba(255,255,255,0.08);
    border-radius: 0.75rem; padding: 16px 18px; color: white; font-size: 22px;
    font-weight: 700; font-family: 'JetBrains Mono', monospace; outline: none;
    margin-bottom: 24px; transition: border-color .2s; box-sizing: border-box;
}
.cashier-amount-input:focus { border-color: rgba(30,144,255,0.4); }
.cashier-quick-amounts { display: flex; gap: 8px; margin-bottom: 28px; flex-wrap: wrap; }
.cashier-quick-amt {
    padding: 8px 16px; background: #0A0F1E; border: 1px solid rgba(255,255,255,0.08);
    border-radius: 9999px; color: #94A3B8; font-size: 13px; font-weight: 700;
    cursor: pointer; transition: all .18s; font-family: 'JetBrains Mono', monospace;
}
.cashier-quick-amt:hover { border-color: rgba(30,144,255,0.3); color: #1E90FF; }
.cashier-methods { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 28px; }
@media (max-width: 520px) { .cashier-methods { grid-template-columns: 1fr; } }
.cashier-method {
    display: flex; align-items: center; gap: 12px;
    background: #0A0F1E; border: 1px solid rgba(255,255,255,0.08);
    border-radius: 0.75rem; padding: 16px; cursor: pointer;
    transition: all .18s; position: relative; opacity: .55;
}
.cashier-method-icon {
    width: 38px; height: 38px; border-radius: 0.6rem;
    background: rgba(30,144,255,.1); display: flex;
    align-items: center; justify-content: center; font-size: 19px; flex-shrink: 0;
}
.cashier-method-name { font-size: 14px; font-weight: 700; color: white; font-family: 'Inter', sans-serif; }
.cashier-method-sub { font-size: 11px; color: #475569; margin-top: 1px; font-family: 'Inter', sans-serif; }
.cashier-method-soon {
    position: absolute; top: 10px; right: 10px;
    font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em;
    background: rgba(99,102,241,0.12); color: #818CF8;
    border: 1px solid rgba(99,102,241,0.25); border-radius: 9999px; padding: 2px 8px;
    font-family: 'Inter', sans-serif;
}
.cashier-submit {
    width: 100%; padding: 16px; background: rgba(30,144,255,0.12);
    color: #1E90FF; border: 1px solid rgba(30,144,255,0.25); border-radius: 0.75rem;
    font-weight: 700; font-size: 15px; cursor: not-allowed;
    font-family: 'Inter', sans-serif; text-align: center;
}
.cashier-note {
    text-align: center; font-size: 12.5px; color: #475569;
    margin-top: 16px; line-height: 1.6; font-family: 'Inter', sans-serif;
}
</style>
@endpush

@section('content')
<div style="border-bottom:1px solid rgba(255,255,255,0.06);background:rgba(0,0,0,0.3);">
    <div class="container-x" style="padding:64px 0 56px;">
        <div class="reveal" style="max-width:760px;margin:0 auto;text-align:center;">
            <p class="eyebrow" style="color:#1E90FF;margin-bottom:16px;">Account</p>
            <h1 style="font-size:clamp(2.5rem,5vw,4rem);font-weight:900;line-height:0.95;letter-spacing:-0.03em;color:white;margin:0 0 16px;">Cashier</h1>
            <p style="font-size:14px;color:#64748B;line-height:1.7;max-width:480px;margin:0 auto;font-family:'Inter',sans-serif;">Manage deposits and withdrawals — secure, fast, and on your terms.</p>
        </div>
    </div>
</div>

<div class="container-x" style="padding:48px 0 80px;">
    <div class="cashier-wrap reveal">
        <div class="cashier-tabs">
            <button type="button" class="cashier-tab active" onclick="setCashierTab('deposit', this)">Deposit</button>
            <button type="button" class="cashier-tab" onclick="setCashierTab('withdraw', this)">Withdraw</button>
        </div>

        <div class="card-premium" style="padding:28px;">
            <label class="cashier-label" id="cashierAmountLabel">Deposit Amount</label>
            <input type="text" class="cashier-amount-input" placeholder="$0.00" disabled>

            <div class="cashier-quick-amounts">
                <span class="cashier-quick-amt">$50</span>
                <span class="cashier-quick-amt">$100</span>
                <span class="cashier-quick-amt">$250</span>
                <span class="cashier-quick-amt">$500</span>
            </div>

            <label class="cashier-label">Payment Method</label>
            <div class="cashier-methods">
                <div class="cashier-method">
                    <div class="cashier-method-icon">💳</div>
                    <div>
                        <div class="cashier-method-name">Credit / Debit Card</div>
                        <div class="cashier-method-sub">Visa, Mastercard, Amex</div>
                    </div>
                    <span class="cashier-method-soon">Soon</span>
                </div>
                <div class="cashier-method">
                    <div class="cashier-method-icon">₿</div>
                    <div>
                        <div class="cashier-method-name">Bitcoin</div>
                        <div class="cashier-method-sub">Crypto deposit</div>
                    </div>
                    <span class="cashier-method-soon">Soon</span>
                </div>
                <div class="cashier-method">
                    <div class="cashier-method-icon">🏦</div>
                    <div>
                        <div class="cashier-method-name">Bank Transfer</div>
                        <div class="cashier-method-sub">ACH / Wire</div>
                    </div>
                    <span class="cashier-method-soon">Soon</span>
                </div>
                <div class="cashier-method">
                    <div class="cashier-method-icon">📱</div>
                    <div>
                        <div class="cashier-method-name">CashApp / Venmo</div>
                        <div class="cashier-method-sub">P2P transfer</div>
                    </div>
                    <span class="cashier-method-soon">Soon</span>
                </div>
            </div>

            <div class="cashier-submit">Cashier Coming Soon</div>
            <p class="cashier-note">We're finalizing secure payment processing. Once live, you'll be able to deposit and withdraw funds directly from this page.</p>
        </div>
    </div>
</div>

<script>
function setCashierTab(tab, btn) {
    document.querySelectorAll('.cashier-tab').forEach(function(b){ b.classList.remove('active'); });
    btn.classList.add('active');
    document.getElementById('cashierAmountLabel').textContent = tab === 'deposit' ? 'Deposit Amount' : 'Withdraw Amount';
}
</script>

@push('scripts')
<script>
(function(){
    var els = document.querySelectorAll('.reveal');
    var obs = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if(e.isIntersecting){ e.target.classList.add('is-visible'); obs.unobserve(e.target); }
        });
    },{threshold:0.08});
    els.forEach(function(el){ obs.observe(el); });
})();
</script>
@endpush
@endsection
