@extends('admin.layouts.admin')
@section('title', ($pick->exists ? 'Edit Pick' : 'New Pick') . ' - INSPIN Admin')
@section('page-title', $pick->exists ? 'Edit Pick' : 'New Pick')

@section('content')
<div style="max-width:900px;">
    <form method="POST"
          action="{{ $pick->exists ? route('admin.picks.update', $pick) : route('admin.picks.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if($pick->exists) @method('PUT') @endif

        {{-- Game Info --}}
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h2>Game Info</h2></div>
            <div class="card-body">
                <div class="form-grid-3">
                    <div class="form-group">
                        <label>Sport <span class="required">*</span></label>
                        <select name="sport" class="form-control">
                            @foreach($sports as $s)
                                <option value="{{ $s }}" {{ old('sport', $pick->sport) === $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        @error('sport')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Game Date <span class="required">*</span></label>
                        <input type="date" name="game_date" class="form-control" value="{{ old('game_date', $pick->game_date?->format('Y-m-d')) }}">
                        @error('game_date')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Game Time <span style="color:#64748b;font-weight:400;font-size:12px;">(ET)</span></label>
                        <input type="time" name="game_time" class="form-control" value="{{ old('game_time', $pick->game_time ? \Carbon\Carbon::parse($pick->game_time)->format('H:i') : '') }}">
                        @error('game_time')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group full">
                        <label>Venue</label>
                        <input type="text" name="venue" class="form-control" placeholder="e.g. SoFi Stadium, Inglewood CA" value="{{ old('venue', $pick->venue) }}">
                        @error('venue')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Teams --}}
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h2>Teams</h2></div>
            <div class="card-body">
                <div class="form-grid-2">
                    <div>
                        <div class="form-section-title">Team 1</div>
                        <div class="form-group" style="margin-bottom:12px;">
                            <label>Team Name <span class="required">*</span></label>
                            <input type="text" name="team1_name" id="team1Name" class="form-control" value="{{ old('team1_name', $pick->team1_name) }}" placeholder="e.g. Kansas City Chiefs" oninput="updatePercentLabels()">
                            @error('team1_name')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group" style="margin-bottom:12px;">
                            <label>Rotation #</label>
                            <input type="number" name="team1_rotation" class="form-control" value="{{ old('team1_rotation', $pick->team1_rotation) }}" placeholder="e.g. 101">
                        </div>
                        <div class="form-group" style="margin-bottom:12px;">
                            <label id="label1">Betting % (Team 1)</label>
                            <input type="number" name="team1_percent" id="team1Percent" class="form-control" min="0" max="100" value="{{ old('team1_percent', $pick->team1_percent) }}" placeholder="e.g. 55">
                        </div>
                        <div class="form-group">
                            <label>Logo</label>
                            <input type="file" name="team1_logo" class="form-control" accept="image/*" onchange="previewImg(this,'prev1')">
                            @if($pick->team1_logo)
                                <img id="prev1" src="{{ asset('storage/'.$pick->team1_logo) }}" class="img-preview">
                            @else
                                <img id="prev1" src="" class="img-preview" style="display:none;">
                            @endif
                            @error('team1_logo')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div>
                        <div class="form-section-title">Team 2</div>
                        <div class="form-group" style="margin-bottom:12px;">
                            <label>Team Name <span class="required">*</span></label>
                            <input type="text" name="team2_name" id="team2Name" class="form-control" value="{{ old('team2_name', $pick->team2_name) }}" placeholder="e.g. Buffalo Bills" oninput="updatePercentLabels()">
                            @error('team2_name')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group" style="margin-bottom:12px;">
                            <label>Rotation #</label>
                            <input type="number" name="team2_rotation" class="form-control" value="{{ old('team2_rotation', $pick->team2_rotation) }}" placeholder="e.g. 102">
                        </div>
                        <div class="form-group" style="margin-bottom:12px;">
                            <label id="label2">Betting % (Team 2)</label>
                            <input type="number" name="team2_percent" id="team2Percent" class="form-control" min="0" max="100" value="{{ old('team2_percent', $pick->team2_percent) }}" placeholder="e.g. 45">
                        </div>
                        <div class="form-group">
                            <label>Logo</label>
                            <input type="file" name="team2_logo" class="form-control" accept="image/*" onchange="previewImg(this,'prev2')">
                            @if($pick->team2_logo)
                                <img id="prev2" src="{{ asset('storage/'.$pick->team2_logo) }}" class="img-preview">
                            @else
                                <img id="prev2" src="" class="img-preview" style="display:none;">
                            @endif
                            @error('team2_logo')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pick Details --}}
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h2>Pick Details</h2></div>
            <div class="card-body">
                <div class="form-group full" style="margin-bottom:16px;">
                    <label>Bet Type</label>
                    <select name="pick_type" id="pickType" class="form-control" onchange="updatePercentLabels()" style="max-width:240px;">
                        <option value="">— Select Type —</option>
                        <option value="Pointspread" {{ old('pick_type', $pick->pick_type) === 'Pointspread' ? 'selected' : '' }}>Pointspread</option>
                        <option value="Moneyline" {{ old('pick_type', $pick->pick_type) === 'Moneyline' ? 'selected' : '' }}>Moneyline</option>
                        <option value="Total" {{ old('pick_type', $pick->pick_type) === 'Total' ? 'selected' : '' }}>Total (Over/Under)</option>
                    </select>
                    <small style="color:#64748b;display:block;margin-top:4px;">Selecting a type will update the % labels on the Teams section above.</small>
                </div>
                <div class="form-group full" style="margin-bottom:16px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                        <label style="margin:0;">Pick Recommendation <span class="required">*</span></label>
                        <button type="button" onclick="checkPickQuality()" id="checkPickBtn" style="display:inline-flex;align-items:center;gap:6px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:8px;padding:6px 14px;font-size:13px;font-weight:600;color:#374151;cursor:pointer;transition:all 0.15s;">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Check Quality with Claude
                        </button>
                    </div>
                    <textarea name="pick" id="pickText" class="form-control" rows="3" placeholder="e.g. Chiefs -3.5 (-110)">{{ old('pick', $pick->pick) }}</textarea>
                    @error('pick')<div class="form-error">{{ $message }}</div>@enderror
                    <div id="pickQualityResult" style="display:none;margin-top:10px;padding:14px 16px;border-radius:8px;border:1px solid;font-size:13px;"></div>
                </div>
                <div class="form-grid-3">
                    <div class="form-group">
                        <label>Stars <span class="required">*</span></label>
                        <select name="stars" class="form-control" id="starsSelect">
                            @foreach([1,2,3,4,5] as $n)
                                <option value="{{ $n }}" {{ old('stars', $pick->stars) == $n ? 'selected' : '' }}>{{ str_repeat('★', $n) }} ({{ $n }})</option>
                            @endforeach
                            <option value="10" {{ old('stars', $pick->stars) == 10 ? 'selected' : '' }}>★★★★★★★★★★ Whale (10)</option>
                        </select>
                        @error('stars')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Expert</label>
                        <select name="expert_name" class="form-control">
                            <option value="">— None —</option>
                            @foreach($experts as $expert)
                                <option value="{{ $expert->name }}" {{ old('expert_name', $pick->expert_name) === $expert->name ? 'selected' : '' }}>{{ $expert->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Units (bet size)</label>
                        <input type="number" name="units" step="0.1" class="form-control" value="{{ old('units', $pick->units) }}" placeholder="e.g. 2.0">
                    </div>
                    <div class="form-group">
                        <label>Related Article</label>
                        <select name="related_article_id" class="form-control">
                            <option value="">— None —</option>
                            @foreach($articles as $article)
                                <option value="{{ $article->id }}" {{ old('related_article_id', $pick->related_article_id) == $article->id ? 'selected' : '' }}>{{ Str::limit($article->title, 45) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div style="display:flex;gap:24px;margin-top:16px;flex-wrap:wrap;">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $pick->is_active ?? true) ? 'checked' : '' }}>
                        Active (visible on site)
                    </label>
                    <label class="form-check" id="whaleCheckWrap">
                        <input type="checkbox" name="is_whale_exclusive" id="whaleCheck" value="1" {{ old('is_whale_exclusive', $pick->is_whale_exclusive) ? 'checked' : '' }}>
                        Whale Exclusive
                    </label>
                </div>
            </div>
        </div>

        {{-- Grading --}}
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h2>Result & Grading</h2></div>
            <div class="card-body">
                <div class="form-grid-3">
                    <div class="form-group">
                        <label>Result</label>
                        <select name="result" class="form-control" id="resultSelect">
                            <option value="pending" {{ old('result', $pick->result ?? 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="win"     {{ old('result', $pick->result) === 'win'     ? 'selected' : '' }}>Win</option>
                            <option value="loss"    {{ old('result', $pick->result) === 'loss'    ? 'selected' : '' }}>Loss</option>
                            <option value="push"    {{ old('result', $pick->result) === 'push'    ? 'selected' : '' }}>Push</option>
                        </select>
                    </div>
                    <div class="form-group" id="unitsResultWrap">
                        <label>Unit Result (manual grading)</label>
                        <input type="number" name="units_result" step="0.01" class="form-control" value="{{ old('units_result', $pick->units_result) }}" placeholder="e.g. +3.00 or -2.00">
                        <div class="form-hint">Win: +units, Loss: -units, Push: 0.00. Example: 3-star pick at +100 = +3.00</div>
                        @error('units_result')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Simulation Result</label>
                        <select name="simulation_result" class="form-control">
                            <option value="">— None —</option>
                            <option value="Win"  {{ old('simulation_result', $pick->simulation_result) === 'Win'  ? 'selected' : '' }}>Win</option>
                            <option value="Loss" {{ old('simulation_result', $pick->simulation_result) === 'Loss' ? 'selected' : '' }}>Loss</option>
                            <option value="Push" {{ old('simulation_result', $pick->simulation_result) === 'Push' ? 'selected' : '' }}>Push</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M5 13l4 4L19 7"/></svg>
                {{ $pick->exists ? 'Update Pick' : 'Create Pick' }}
            </button>
            <a href="{{ route('admin.picks.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewImg(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}

// ── Pick Quality Checker ─────────────────────────────────────
function checkPickQuality() {
    const sport   = document.querySelector('[name="sport"]').value;
    const team1   = document.querySelector('[name="team1_name"]').value.trim();
    const team2   = document.querySelector('[name="team2_name"]').value.trim();
    const pick    = document.getElementById('pickText').value.trim();
    const gameDate= document.querySelector('[name="game_date"]').value;

    if (!pick) { alert('Enter the pick text first.'); return; }
    if (!team1 || !team2) { alert('Enter both team names first.'); return; }

    const btn = document.getElementById('checkPickBtn');
    btn.disabled = true;
    btn.textContent = '⏳ Checking…';

    const resultEl = document.getElementById('pickQualityResult');
    resultEl.style.display = 'none';

    fetch('{{ route('admin.ai.check-pick') }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ sport, team1, team2, pick, game_date: gameDate }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.error) {
            resultEl.style.background = '#fef2f2'; resultEl.style.borderColor = '#fecaca'; resultEl.style.color = '#991b1b';
            resultEl.innerHTML = '✗ ' + data.error;
        } else {
            const passed = data.passed;
            resultEl.style.background = passed ? '#f0fdf4' : '#fffbeb';
            resultEl.style.borderColor = passed ? '#bbf7d0' : '#fde68a';
            resultEl.style.color = '#0f172a';

            let html = `<div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <span style="font-size:18px;">${passed ? '✅' : '⚠️'}</span>
                <strong>${data.summary}</strong>
                <span style="margin-left:auto;background:${passed?'#16a34a':'#d97706'};color:#fff;padding:2px 10px;border-radius:12px;font-size:12px;font-weight:700;">Score: ${data.score}/10</span>
            </div>`;

            if (data.issues && data.issues.length) {
                html += `<div style="margin-bottom:8px;"><strong style="color:#dc2626;">Issues:</strong><ul style="margin:4px 0 0 16px;padding:0;">`;
                data.issues.forEach(i => { html += `<li style="margin-bottom:2px;">${i}</li>`; });
                html += '</ul></div>';
            }
            if (data.suggestions && data.suggestions.length) {
                html += `<div><strong style="color:#d97706;">Suggestions:</strong><ul style="margin:4px 0 0 16px;padding:0;">`;
                data.suggestions.forEach(s => { html += `<li style="margin-bottom:2px;">${s}</li>`; });
                html += '</ul></div>';
            }
            resultEl.innerHTML = html;
        }
        resultEl.style.display = 'block';
    })
    .catch(() => {
        resultEl.style.background='#fef2f2'; resultEl.style.borderColor='#fecaca'; resultEl.style.color='#991b1b';
        resultEl.innerHTML = '✗ Quality check failed. Please try again.';
        resultEl.style.display = 'block';
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Check Quality with Claude';
    });
}

// Auto-check whale when stars = 10
document.getElementById('starsSelect').addEventListener('change', function() {
    const whaleCheck = document.getElementById('whaleCheck');
    if (this.value === '10') {
        whaleCheck.checked = true;
    }
});

// Show/hide units_result based on result
function toggleUnitsResult() {
    const result = document.getElementById('resultSelect').value;
    const wrap = document.getElementById('unitsResultWrap');
    wrap.style.opacity = result === 'pending' ? '0.4' : '1';
}
document.getElementById('resultSelect').addEventListener('change', toggleUnitsResult);
toggleUnitsResult();

// Dynamic percent labels based on bet type
function updatePercentLabels() {
    var type = document.getElementById('pickType') ? document.getElementById('pickType').value : '';
    var t1 = (document.getElementById('team1Name') ? document.getElementById('team1Name').value : '') || 'Team 1';
    var t2 = (document.getElementById('team2Name') ? document.getElementById('team2Name').value : '') || 'Team 2';
    var l1 = document.getElementById('label1');
    var l2 = document.getElementById('label2');
    if (!l1 || !l2) return;
    if (type === 'Total') {
        l1.textContent = 'Over %';
        l2.textContent = 'Under %';
        if (document.getElementById('team1Percent')) document.getElementById('team1Percent').placeholder = 'e.g. 72 (Over)';
        if (document.getElementById('team2Percent')) document.getElementById('team2Percent').placeholder = 'e.g. 28 (Under)';
    } else if (type === 'Moneyline') {
        l1.textContent = t1 + ' Win %';
        l2.textContent = t2 + ' Win %';
        if (document.getElementById('team1Percent')) document.getElementById('team1Percent').placeholder = 'e.g. 65';
        if (document.getElementById('team2Percent')) document.getElementById('team2Percent').placeholder = 'e.g. 35';
    } else if (type === 'Pointspread') {
        l1.textContent = t1 + ' (Favored) %';
        l2.textContent = t2 + ' (Underdog) %';
        if (document.getElementById('team1Percent')) document.getElementById('team1Percent').placeholder = 'e.g. 60';
        if (document.getElementById('team2Percent')) document.getElementById('team2Percent').placeholder = 'e.g. 40';
    } else {
        l1.textContent = 'Betting % (Team 1)';
        l2.textContent = 'Betting % (Team 2)';
    }
}
document.addEventListener('DOMContentLoaded', updatePercentLabels);
</script>
@endpush
