@extends('layouts.public')
@section('title', 'Contact Us | Sportshandicapper')
@section('meta', 'Get in touch with Sportshandicapper — chat with an agent, talk to our AI assistant, or send a support ticket.')

@push('styles')
<style>
    .comm-section-label {
        font-size: 11px; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.18em; color: #1E90FF; margin-bottom: 24px;
        display: flex; align-items: center; gap: 10px; font-family:'Inter',sans-serif;
    }
    .comm-section-label::after {
        content: ''; flex: 1; height: 1px;
        background: linear-gradient(90deg, rgba(30,144,255,0.25), transparent);
    }

    .comm-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 56px; }
    @media (max-width: 760px) { .comm-grid { grid-template-columns: 1fr; } }

    .comm-card { padding: 28px; display: flex; flex-direction: column; gap: 16px; position: relative; overflow: hidden; }
    .comm-card-num {
        position: absolute; top: 18px; right: 22px;
        font-size: 11px; font-weight: 800; color: rgba(255,255,255,0.06);
        letter-spacing: 1px; font-family:'JetBrains Mono',monospace;
    }
    .comm-card-icon {
        width: 52px; height: 52px; border-radius: 0.75rem;
        background: rgba(30,144,255,0.08); border: 1px solid rgba(30,144,255,0.2);
        display: flex; align-items: center; justify-content: center;
        font-size: 24px; flex-shrink: 0;
    }
    .comm-card-title { font-size: 1.1rem; font-weight: 900; color: white; margin: 0 0 4px; }
    .comm-card-badge {
        display: inline-block; font-size: 10px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.1em;
        padding: 2px 10px; border-radius: 9999px; font-family:'Inter',sans-serif;
        background: rgba(74,222,128,0.1); color: #4ade80;
        border: 1px solid rgba(74,222,128,0.25);
    }
    .comm-card-badge.soon {
        background: rgba(99,102,241,0.12); color: #818CF8; border-color: rgba(99,102,241,0.25);
    }
    .comm-card-desc { font-size: 13.5px; color: #64748B; line-height: 1.7; margin: 0; flex: 1; font-family:'Inter',sans-serif; }

    /* Contact method rows inside Talk card */
    .talk-row {
        display: flex; align-items: center; gap: 12px;
        padding: 11px 14px; background: rgba(0,0,0,0.3);
        border: 1px solid rgba(255,255,255,0.06); border-radius: 0.6rem;
        text-decoration: none; transition: border-color .2s, background .2s;
    }
    .talk-row:hover { border-color: rgba(30,144,255,0.3); background: rgba(30,144,255,0.04); }
    .talk-row-icon {
        width: 36px; height: 36px; border-radius: 0.5rem;
        display: flex; align-items: center; justify-content: center;
        font-size: 17px; flex-shrink: 0;
    }
    .talk-row-label { font-size: 14px; font-weight: 700; color: white; font-family:'Inter',sans-serif; }
    .talk-row-sub { font-size: 11px; color: #475569; margin-top: 1px; font-family:'Inter',sans-serif; }

    /* Status badge */
    .agent-status {
        display: flex; align-items: center; gap: 8px;
        padding: 9px 14px; border-radius: 0.6rem;
        background: rgba(239,68,68,.06); border: 1px solid rgba(239,68,68,.15);
        font-size: 12px; color: #94A3B8; font-family:'Inter',sans-serif;
    }
    .agent-dot { width: 7px; height: 7px; border-radius: 50%; background: #4a4a4a; flex-shrink:0; }
    .agent-dot.online { background: #4ade80; box-shadow: 0 0 6px rgba(74,222,128,.5); }

    /* Ticket form */
    .ticket-form-wrap {
        background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.08);
        border-radius: 0.75rem; padding: 24px; margin-top: 4px;
    }
    .ticket-input {
        width: 100%; background: #0A0F1E; border: 1px solid rgba(255,255,255,0.08);
        border-radius: 0.5rem; padding: 11px 14px; color: white;
        font-size: 14px; outline: none; font-family: 'Inter', sans-serif;
        transition: border-color .2s; box-sizing: border-box;
    }
    .ticket-input:focus { border-color: rgba(30,144,255,0.4); }
    .ticket-label {
        display: block; font-size: 11px; color: #475569;
        text-transform: uppercase; letter-spacing: 0.15em; margin-bottom: 6px; font-weight: 700;
        font-family:'Inter',sans-serif;
    }

    /* Social connect */
    .connect-grid { display: flex; flex-wrap: wrap; gap: 12px; }
    .connect-item {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 18px; background: #0C1020;
        border: 1px solid rgba(255,255,255,0.08); border-radius: 0.75rem;
        text-decoration: none; transition: border-color .2s, transform .2s;
        min-width: 130px;
    }
    .connect-item:hover { border-color: rgba(30,144,255,0.3); transform: translateY(-1px); }
    .connect-item span { font-size: 13px; font-weight: 700; color: white; font-family:'Inter',sans-serif; }
</style>
@endpush

@section('content')

{{-- ── Hero ── --}}
<div style="border-bottom:1px solid rgba(255,255,255,0.06);background:rgba(0,0,0,0.3);">
    <div class="container-x" style="padding:64px 0 56px;">
        <div class="reveal" style="max-width:760px;">
            <p class="eyebrow" style="color:#1E90FF;margin-bottom:16px;">Support</p>
            <h1 style="font-size:clamp(2.5rem,5vw,4.5rem);font-weight:900;line-height:0.95;letter-spacing:-0.03em;color:white;margin:0 0 24px;">
                Communications <span style="color:#1E90FF;">Center</span>
            </h1>
            <p style="font-size:clamp(15px,1.4vw,18px);color:#64748B;line-height:1.75;max-width:600px;margin:0;font-family:'Inter',sans-serif;">We're here to help. Choose the best way to reach us and we'll get back to you fast.</p>
        </div>
    </div>
</div>

<div class="container-x" style="padding:56px 0 80px;">

    @if(session('ticket_success'))
    <div class="reveal" style="background:rgba(74,222,128,.08);border:1px solid rgba(74,222,128,.25);border-radius:0.75rem;padding:16px 20px;margin-bottom:32px;display:flex;align-items:center;gap:12px;">
        <span style="font-size:20px;">✓</span>
        <div>
            <div style="font-size:14px;font-weight:700;color:#4ade80;font-family:'Inter',sans-serif;">Ticket submitted successfully</div>
            <div style="font-size:13px;color:#64748B;margin-top:2px;font-family:'Inter',sans-serif;">We'll follow up at {{ session('ticket_email') }} within 24 hours.</div>
        </div>
    </div>
    @endif

    {{-- Section 1: Contact Us --}}
    <div class="comm-section-label reveal">Contact Us</div>

    <div class="comm-grid">

        {{-- 1. Live Chat --}}
        <div class="comm-card card-premium reveal">
            <span class="comm-card-num">01</span>
            <div class="comm-card-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1E90FF" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
            </div>
            <div>
                <div class="comm-card-title">Chat with an Agent</div>
                <span class="comm-card-badge" style="background:rgba(239,68,68,.1);color:#ef4444;border-color:rgba(239,68,68,.25);">Offline</span>
            </div>
            <p class="comm-card-desc">Connect directly with a Customer Service representative. When our team is online you'll chat live — when offline your message goes straight to help@sportshandicapper.com.</p>
            <div class="agent-status">
                <div class="agent-dot"></div>
                <span>No agents online right now</span>
            </div>
            <a href="mailto:help@sportshandicapper.com" class="btn-primary" style="width:100%;">Email Support</a>
        </div>

        {{-- 2. Chatbot --}}
        <div class="comm-card card-premium reveal" style="transition-delay:60ms;">
            <span class="comm-card-num">02</span>
            <div class="comm-card-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1E90FF" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="10" rx="2"/><circle cx="12" cy="5" r="2"/><path d="M12 7v4"/><line x1="8" y1="16" x2="8" y2="16"/><line x1="16" y1="16" x2="16" y2="16"/></svg>
            </div>
            <div>
                <div class="comm-card-title">SH Assistant</div>
                <span class="comm-card-badge">Available 24/7</span>
            </div>
            <p class="comm-card-desc">Get instant answers about picks, packages, how the site works, or anything Sportshandicapper-related. Our AI assistant is available around the clock — no waiting.</p>
            <button onclick="toggleChat()" class="btn-primary" style="width:100%;">Open Chatbot</button>
        </div>

        {{-- 3. Talk with Us --}}
        <div class="comm-card card-premium reveal" style="transition-delay:120ms;">
            <span class="comm-card-num">03</span>
            <div class="comm-card-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1E90FF" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.06 9.81a19.79 19.79 0 01-3.07-8.72A2 2 0 012 .93h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
            </div>
            <div>
                <div class="comm-card-title">Talk with Us</div>
                <div style="font-size:12px;color:#475569;margin-top:2px;font-family:'Inter',sans-serif;">Phone, WhatsApp &amp; Telegram</div>
            </div>
            <p class="comm-card-desc">Reach us directly on your preferred platform. We're available by phone — messaging apps are being set up.</p>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <a href="tel:+16104715405" class="talk-row">
                    <div class="talk-row-icon" style="background:rgba(30,144,255,.08);">📞</div>
                    <div>
                        <div class="talk-row-label">(610) 471-5405</div>
                        <div class="talk-row-sub">Phone</div>
                    </div>
                </a>
                <div class="talk-row" style="opacity:.5;cursor:default;">
                    <div class="talk-row-icon" style="background:rgba(37,211,102,.08);">💬</div>
                    <div>
                        <div class="talk-row-label">WhatsApp</div>
                        <div class="talk-row-sub">Coming soon</div>
                    </div>
                </div>
                <div class="talk-row" style="opacity:.5;cursor:default;">
                    <div class="talk-row-icon" style="background:rgba(0,136,204,.08);">✈️</div>
                    <div>
                        <div class="talk-row-label">Telegram</div>
                        <div class="talk-row-sub">Coming soon</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 5. Email Us --}}
        <div class="comm-card card-premium reveal" style="transition-delay:240ms;">
            <span class="comm-card-num">05</span>
            <div class="comm-card-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1E90FF" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v16H4z"/><path d="M22 6l-10 7L2 6"/></svg>
            </div>
            <div>
                <div class="comm-card-title">Email Us</div>
                <div style="font-size:12px;color:#475569;margin-top:2px;font-family:'Inter',sans-serif;">We respond within 24 hours</div>
            </div>
            <p class="comm-card-desc">Prefer email? Send us a message directly and our Customer Service team will get back to you.</p>
            <a href="mailto:help@sportshandicapper.com" class="btn-primary" style="width:100%;">help@sportshandicapper.com</a>
        </div>

        {{-- 6. FAQ's --}}
        <div class="comm-card card-premium reveal" style="transition-delay:300ms;">
            <span class="comm-card-num">06</span>
            <div class="comm-card-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1E90FF" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12" y2="17"/></svg>
            </div>
            <div>
                <div class="comm-card-title">FAQ's</div>
                <span class="comm-card-badge soon">Coming Soon</span>
            </div>
            <p class="comm-card-desc">Quick answers to the most common questions about picks, packages, and how Sportshandicapper works.</p>
            <a href="{{ route('faq') }}" class="btn-secondary" style="width:100%;">View FAQ's</a>
        </div>

        {{-- 4. Send a Ticket --}}
        <div class="comm-card card-premium reveal" id="ticket" style="transition-delay:180ms;">
            <span class="comm-card-num">04</span>
            <div class="comm-card-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1E90FF" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12V7H5a2 2 0 010-4h14v4"/><path d="M3 5v14a2 2 0 002 2h16v-5"/><path d="M18 12a2 2 0 000 4h4v-4z"/></svg>
            </div>
            <div>
                <div class="comm-card-title">Send a Ticket</div>
                <div style="font-size:12px;color:#475569;margin-top:2px;font-family:'Inter',sans-serif;">We respond within 24 hours</div>
            </div>
            <p class="comm-card-desc">Submit a support request and our Customer Service team will follow up. All tickets are tracked so the right rep handles it.</p>
            <button onclick="document.getElementById('ticketFormInner').style.display=document.getElementById('ticketFormInner').style.display==='none'?'block':'none';this.textContent=document.getElementById('ticketFormInner').style.display==='block'?'Close Form':'Open Ticket Form';"
                    class="btn-secondary" id="ticketToggleBtn" style="width:100%;">
                Open Ticket Form
            </button>
            <div id="ticketFormInner" style="display:none;">
                <div class="ticket-form-wrap">
                    <form method="POST" action="{{ route('contact.ticket') }}">
                        @csrf
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                            <div>
                                <label class="ticket-label">Your Name *</label>
                                <input type="text" name="customer_name" required class="ticket-input"
                                       value="{{ auth()->user()->name ?? old('customer_name') }}" placeholder="Full name">
                            </div>
                            <div>
                                <label class="ticket-label">Email *</label>
                                <input type="email" name="customer_email" required class="ticket-input"
                                       value="{{ auth()->user()->email ?? old('customer_email') }}" placeholder="your@email.com">
                            </div>
                        </div>
                        <div style="margin-bottom:12px;">
                            <label class="ticket-label">Subject *</label>
                            <input type="text" name="subject" required class="ticket-input"
                                   value="{{ old('subject') }}" placeholder="e.g. I can't access my picks">
                        </div>
                        <div style="margin-bottom:16px;">
                            <label class="ticket-label">Message *</label>
                            <textarea name="message" required rows="3" class="ticket-input"
                                      placeholder="Describe your issue in detail…" style="resize:vertical;">{{ old('message') }}</textarea>
                        </div>
                        @if($errors->any())
                        <div style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);border-radius:0.5rem;padding:10px 14px;margin-bottom:12px;font-size:13px;color:#ef4444;font-family:'Inter',sans-serif;">
                            @foreach($errors->all() as $error)<div>• {{ $error }}</div>@endforeach
                        </div>
                        @endif
                        <button type="submit" class="btn-primary" style="width:auto;">Submit Ticket</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    {{-- Section 2: Connect with Us --}}
    <div class="comm-section-label reveal">Connect with Us</div>

    <div class="connect-grid reveal" style="margin-bottom:60px;">
        {{-- TODO: replace with real Sportshandicapper social links once available --}}
        <a href="#" class="connect-item">
            <img src="{{ asset('images/social-facebook.png') }}" alt="Facebook" style="width:24px;height:24px;object-fit:contain;">
            <span>Facebook</span>
        </a>
        <a href="#" class="connect-item">
            <img src="{{ asset('images/social-instagram.png') }}" alt="Instagram" style="width:24px;height:24px;object-fit:contain;">
            <span>Instagram</span>
        </a>
        <a href="#" class="connect-item">
            <img src="{{ asset('images/social-twitter.png') }}" alt="X / Twitter" style="width:24px;height:24px;object-fit:contain;">
            <span>X / Twitter</span>
        </a>
        <a href="#" class="connect-item">
            <img src="{{ asset('images/social-youtube.png') }}" alt="YouTube" style="width:24px;height:24px;object-fit:contain;">
            <span>YouTube</span>
        </a>
        <div class="connect-item" style="opacity:.45;cursor:default;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="white"><path d="M16.6 5.82c-.93-.93-1.45-2.18-1.45-3.5h-3.2v13.93c0 1.6-1.3 2.9-2.9 2.9a2.9 2.9 0 01-2.9-2.9 2.9 2.9 0 012.9-2.9c.32 0 .63.05.92.14V10.3a6.1 6.1 0 00-.92-.07c-3.36 0-6.08 2.72-6.08 6.08S6.6 22.4 9.96 22.4s6.08-2.72 6.08-6.08V9.1c1.3.93 2.9 1.48 4.6 1.48v-3.2c-1.5 0-2.8-.6-4.04-1.56z"/></svg>
            <span>TikTok</span>
        </div>
    </div>

    {{-- Section 3: Hours & Legal --}}
    <div class="comm-section-label reveal">Hours &amp; Legal</div>
    <div class="reveal" style="display:flex;flex-wrap:wrap;gap:16px;margin-bottom:60px;">
        <div class="talk-row" style="flex:1;min-width:240px;cursor:default;">
            <div class="talk-row-icon" style="background:rgba(30,144,255,.08);">🕗</div>
            <div>
                <div class="talk-row-label">Monday – Sunday</div>
                <div class="talk-row-sub">8:00 AM – 10:00 PM Eastern</div>
            </div>
        </div>
        <a href="{{ route('terms') }}" class="talk-row" style="flex:1;min-width:240px;">
            <div class="talk-row-icon" style="background:rgba(30,144,255,.08);">📋</div>
            <div>
                <div class="talk-row-label">Terms &amp; Conditions</div>
                <div class="talk-row-sub">Read our terms of service</div>
            </div>
        </a>
        <a href="{{ route('privacy') }}" class="talk-row" style="flex:1;min-width:240px;">
            <div class="talk-row-icon" style="background:rgba(30,144,255,.08);">🔒</div>
            <div>
                <div class="talk-row-label">Privacy Policy</div>
                <div class="talk-row-sub">How we handle your data</div>
            </div>
        </a>
    </div>

    {{-- CTA --}}
    <div class="reveal" style="text-align:center;padding:36px;background:rgba(30,144,255,0.03);border:1px solid rgba(30,144,255,0.1);border-radius:1rem;">
        <div style="font-size:1.3rem;font-weight:900;color:white;margin-bottom:8px;">Need access to premium picks?</div>
        <div style="font-size:14px;color:#64748B;margin-bottom:20px;font-family:'Inter',sans-serif;">Join Sportshandicapper and get expert picks, analysis, and simulation model results.</div>
        <a href="{{ route('join') }}" class="btn-primary" style="padding:13px 40px;">Get Started Free</a>
    </div>

</div>

<script>
    if (window.location.hash === '#ticket') {
        document.getElementById('ticketFormInner').style.display = 'block';
        document.getElementById('ticketToggleBtn').textContent = 'Close Form';
        setTimeout(function(){ document.getElementById('ticket').scrollIntoView({behavior:'smooth', block:'start'}); }, 150);
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
