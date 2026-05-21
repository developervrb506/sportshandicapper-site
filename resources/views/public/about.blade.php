@extends('layouts.public')
@section('title', 'About - INSPIN')

@section('content')
<div class="page">
    @if($aboutContent)
        <div class="content">{!! $aboutContent !!}</div>
    @else
        <h1>About INSPIN</h1>
        <p>INSPIN.com is the premier sports betting analysis platform. Our team of expert handicappers and data scientists have years of experience and unmatched passion for United States' sports.</p>
        <h2>Our Simulation Model</h2>
        <p>The INSPIN simulation model simulates every NFL, NBA, MLB, and NHL game thousands of times. Over the last three years, our model has been up over <strong style="color:#FDB515;">150 units</strong>. A $100 bettor would have netted a profit of $15,000+ and a $1,000 bettor would have won $150,000+.</p>
        <h2>What We Offer</h2>
        <p>We offer picks on NFL, NBA, MLB, NHL, XFL, PGA Golf, and NCAA Basketball and Football. Our packages start at just <strong style="color:#FDB515;">$24.99 per month</strong> and give you access to all of our simulations, consensus data, betting trends, and expert analysis.</p>
        <div style="margin:24px 0;padding:20px 24px;background:rgba(253,181,21,.06);border:1px solid rgba(253,181,21,.2);border-radius:12px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
            <div>
                <div style="color:#FDB515;font-weight:700;font-size:15px;margin-bottom:4px;">No Credit Card Needed</div>
                <div style="color:#9a9a9a;font-size:14px;">Try INSPIN Free for 7 Days — Get Started today with our Free Trial</div>
            </div>
            <button onclick="openModal('join')" style="padding:12px 28px;background:#FDB515;color:#171818;border:none;border-radius:50px;font-weight:700;font-size:14px;cursor:pointer;white-space:nowrap;box-shadow:0 0 16px rgba(253,181,21,.3);">Join Now</button>
        </div>
        <h2>Our Commitment</h2>
        <p>Our team is committed to providing you with the highest level of customer service and support. From our user-friendly website to our 24/7 customer service, we are here to help you succeed.</p>
        <p style="color:#FFFCEE;">If you purchase a package and do not show a net profit at the end of your time period, your package will automatically renew for <strong style="color:#FDB515;">FREE</strong> until you are a winning player following our selections.</p>
    @endif

    @if($experts->count() > 0)
    <div style="margin-top:52px;padding-top:36px;border-top:1px solid rgba(255,252,238,.08);">
        <h2 style="font-family:'Clash Display',sans-serif;font-size:1.5rem;font-weight:500;color:#FFFCEE;margin-bottom:6px;">Meet Our Experts</h2>
        <p style="color:#6e6e6e;margin-bottom:32px;">Our team of professional handicappers brings decades of combined experience to every pick.</p>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(260px,100%),1fr));gap:20px;">
            @foreach($experts as $expert)
            @php $eid = 'bio-'.$expert->id; @endphp
            <div style="background:#212121;border:1px solid rgba(255,252,238,.08);border-radius:12px;padding:24px;display:flex;flex-direction:column;align-items:center;text-align:center;transition:border-color .2s;" onmouseover="this.style.borderColor='rgba(253,181,21,.3)'" onmouseout="this.style.borderColor='rgba(255,252,238,.08)'">

                {{-- Avatar with onerror fallback --}}
                @if($expert->avatar)
                    <img src="{{ asset('storage/uploads/experts/'.$expert->avatar) }}"
                         alt="{{ $expert->name }}"
                         style="width:88px;height:88px;border-radius:50%;object-fit:cover;border:3px solid rgba(253,181,21,.3);margin-bottom:16px;"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div style="display:none;width:88px;height:88px;border-radius:50%;background:#FDB515;align-items:center;justify-content:center;color:#171818;font-weight:800;font-size:28px;margin-bottom:16px;">{{ strtoupper(substr($expert->name,0,1)) }}</div>
                @else
                    <div style="width:88px;height:88px;border-radius:50%;background:#FDB515;display:flex;align-items:center;justify-content:center;color:#171818;font-weight:800;font-size:28px;margin-bottom:16px;">{{ strtoupper(substr($expert->name,0,1)) }}</div>
                @endif

                <div style="font-family:'Clash Display',sans-serif;font-size:1.1rem;font-weight:500;color:#FFFCEE;margin-bottom:4px;">{{ $expert->name }}</div>

                @if($expert->specialty)
                    <div style="font-size:11px;color:#FDB515;font-weight:700;text-transform:uppercase;letter-spacing:.6px;margin-bottom:10px;">{{ $expert->specialty }}</div>
                @endif

                @if($expert->bio)
                @php $longBio = strlen($expert->bio) > 180; @endphp
                <div id="{{ $eid }}" style="color:#6e6e6e;font-size:13px;line-height:1.65;margin:0;overflow:hidden;{{ $longBio ? 'display:-webkit-box;-webkit-line-clamp:4;-webkit-box-orient:vertical;' : '' }}">{{ $expert->bio }}</div>
                @if($longBio)
                <button onclick="toggleBio('{{ $eid }}', this)"
                    style="margin-top:10px;background:none;border:none;color:#FDB515;font-size:12px;font-weight:600;cursor:pointer;padding:0;text-decoration:underline;text-underline-offset:2px;">
                    Show More
                </button>
                @endif
                @endif
            </div>
            @endforeach
        </div>

        <script>
        function toggleBio(id, btn) {
            var el = document.getElementById(id);
            var expanded = el.style.webkitLineClamp === 'unset' || el.style.webkitLineClamp === '';
            if (expanded) {
                el.style.webkitLineClamp = '4';
                el.style.display = '-webkit-box';
                el.style.overflow = 'hidden';
                btn.textContent = 'Show More';
            } else {
                el.style.webkitLineClamp = 'unset';
                el.style.display = 'block';
                el.style.overflow = 'visible';
                btn.textContent = 'Show Less';
            }
        }
        </script>
    </div>
    @endif

    <div style="text-align:center;margin-top:48px;">
        <a href="{{ route('join') }}" style="display:inline-block;padding:13px 40px;background:#FDB515;color:#171818;border-radius:50px;font-weight:700;text-decoration:none;font-size:15px;box-shadow:0 0 20px rgba(253,181,21,.3);">Open a Package</a>
    </div>
</div>
@endsection
