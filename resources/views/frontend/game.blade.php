@extends('layouts.app')

@section('content')
<style>
    .gs-wrap {
        min-height: 100vh;
        background: radial-gradient(ellipse at top, #2b2416 0%, #0a0806 60%, #050403 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 24px 16px 60px;
        position: relative;
        overflow: hidden;
    }
    .gs-wrap::before {
        content: '';
        position: absolute; inset: 0;
        background:
            radial-gradient(circle at 20% 15%, rgba(201,168,76,0.10), transparent 40%),
            radial-gradient(circle at 85% 75%, rgba(140,144,126,0.12), transparent 45%);
        pointer-events: none;
    }
    .gs-title {
        font-family: 'Marcellus', serif;
        font-size: 2.6rem;
        letter-spacing: 4px;
        background: linear-gradient(90deg, #C9A84C, #f0d98a, #C9A84C);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin: 6px 0 2px;
        text-align: center;
    }
    .gs-subtitle {
        color: #a89a6a;
        font-size: 12.5px;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin-bottom: 18px;
    }
    .gs-hud {
        width: 100%; max-width: 720px;
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 10px; z-index: 2; position: relative;
        font-family: 'Jost', sans-serif;
    }
    .gs-pill {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(201,168,76,0.3);
        border-radius: 30px;
        padding: 7px 16px;
        color: #f0e6c8;
        font-size: 13px;
        display: flex; align-items: center; gap: 7px;
    }
    .gs-pill b { color: #C9A84C; font-size: 15px; }
    .gs-lives span { color: #e74c3c; font-size: 15px; margin-left: 2px; }
    .gs-stage {
        position: relative;
        width: 100%; max-width: 720px;
        aspect-ratio: 4 / 3;
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid rgba(201,168,76,0.25);
        box-shadow: 0 30px 90px rgba(0,0,0,0.6), 0 0 0 1px rgba(255,255,255,0.03);
        background: linear-gradient(180deg, #1a1710 0%, #0d0b08 100%);
    }
    .gs-stage canvas { display: block; width: 100%; height: 100%; touch-action: none; cursor: crosshair; }
    .gs-floor {
        position: absolute; left: 0; right: 0; bottom: 0; height: 14%;
        background: linear-gradient(180deg, rgba(90,60,20,0.0), rgba(40,26,10,0.9));
        pointer-events: none;
    }
    .gs-overlay {
        position: absolute; inset: 0;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        background: rgba(5,4,3,0.72);
        backdrop-filter: blur(3px);
        text-align: center; padding: 24px; gap: 14px;
        transition: opacity .25s ease;
    }
    .gs-overlay.hidden { display: none; }
    .gs-btn {
        background: linear-gradient(135deg, #C9A84C, #a8863a);
        color: #1a1608; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;
        border: none; padding: 13px 34px; border-radius: 30px; font-size: 13.5px;
        cursor: pointer; box-shadow: 0 8px 24px rgba(201,168,76,0.35);
        transition: transform .15s ease;
    }
    .gs-btn:hover { transform: translateY(-2px); }
    .gs-btn-ghost {
        background: transparent; color: #f0e6c8; border: 1.5px solid rgba(255,255,255,0.25);
        padding: 11px 28px; border-radius: 30px; font-size: 13px; cursor: pointer;
    }
    .gs-big { font-family: 'Marcellus', serif; font-size: 2.1rem; color: #f0e6c8; }
    .gs-score-final { font-size: 3.2rem; color: #C9A84C; font-weight: 800; font-family: 'Marcellus', serif; }
    .gs-note { color: #9a8c66; font-size: 12.5px; max-width: 340px; }
</style>

<div class="gs-wrap">
    <div class="gs-title">GOLDEN SLICE</div>
    <div class="gs-subtitle">Swipe to slice · avoid the bombs · chase your best</div>

    <div class="gs-hud">
        <div class="gs-pill">🏆 Best <b id="gsBestLabel">{{ $best }}</b></div>
        <div class="gs-pill" id="gsScorePill">Score <b id="gsScoreLabel">0</b></div>
        <div class="gs-pill gs-lives">Lives <span id="gsLivesLabel">●●●</span></div>
    </div>

    <div class="gs-stage" id="gsStage">
        <canvas id="gsCanvas"></canvas>
        <div class="gs-floor"></div>

        <div class="gs-overlay" id="gsStartOverlay">
            <div class="gs-big">Ready?</div>
            <div class="gs-note">Swipe across the fruit as it launches up. Miss 3 and it's over. One bomb and it's over instantly. Chain slices fast for a combo multiplier!</div>
            <button class="gs-btn" id="gsStartBtn">Start Playing</button>
        </div>

        <div class="gs-overlay hidden" id="gsOverOverlay">
            <div class="gs-big">Game Over</div>
            <div class="gs-score-final" id="gsFinalScore">0</div>
            <div class="gs-note" id="gsNewBestNote"></div>
            <div style="display:flex; gap:12px; margin-top:6px;">
                <button class="gs-btn" id="gsRetryBtn">Play Again</button>
                <a href="{{ route('game.leaderboard') }}" class="gs-btn-ghost" style="text-decoration:none; display:inline-block;">Leaderboard</a>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    const canvas = document.getElementById('gsCanvas');
    const ctx = canvas.getContext('2d');
    const stage = document.getElementById('gsStage');
    const startOverlay = document.getElementById('gsStartOverlay');
    const overOverlay = document.getElementById('gsOverOverlay');
    const scoreLabel = document.getElementById('gsScoreLabel');
    const livesLabel = document.getElementById('gsLivesLabel');
    const bestLabel = document.getElementById('gsBestLabel');
    const finalScoreEl = document.getElementById('gsFinalScore');
    const newBestNote = document.getElementById('gsNewBestNote');

    let best = parseInt(bestLabel.textContent) || 0;
    const FRUIT = ['🍉', '🍎', '🍊', '🍇', '🍓', '🥝', '🍍', '🍑'];
    const BOMB = '💣';

    let W, H, DPR;
    function resize() {
        DPR = window.devicePixelRatio || 1;
        W = stage.clientWidth; H = stage.clientHeight;
        canvas.width = W * DPR; canvas.height = H * DPR;
        ctx.setTransform(DPR, 0, 0, DPR, 0, 0);
    }
    resize();
    window.addEventListener('resize', resize);

    let items = [], trail = [], particles = [];
    let score = 0, lives = 3, combo = 0, comboBest = 0, lastSliceAt = 0;
    let running = false, spawnTimer = 0, spawnInterval = 1100, elapsed = 0;
    const GRAVITY = 1500;

    function reset() {
        items = []; trail = []; particles = [];
        score = 0; lives = 3; combo = 0; comboBest = 0; elapsed = 0; spawnInterval = 1100;
        scoreLabel.textContent = '0';
        livesLabel.textContent = '●●●';
    }

    function spawnItem() {
        const isBomb = Math.random() < 0.12;
        const emoji = isBomb ? BOMB : FRUIT[Math.floor(Math.random() * FRUIT.length)];
        const x = W * (0.18 + Math.random() * 0.64);
        const vy = -(H * 1.15 + Math.random() * H * 0.25);
        const vx = (Math.random() - 0.5) * W * 0.35;
        items.push({ emoji, x, y: H + 30, vx, vy, r: W * 0.045, isBomb, sliced: false, sliceT: 0, rot: (Math.random() - 0.5) * 2 });
    }

    function pointDist(px, py, x1, y1, x2, y2) {
        const A = px - x1, B = py - y1, C = x2 - x1, D = y2 - y1;
        const dot = A * C + B * D, len = C * C + D * D;
        let t = len ? dot / len : -1;
        t = Math.max(0, Math.min(1, t));
        const xx = x1 + t * C, yy = y1 + t * D;
        return Math.hypot(px - xx, py - yy);
    }

    function sliceCheck(x1, y1, x2, y2) {
        const now = performance.now();
        for (const it of items) {
            if (it.sliced) continue;
            const d = pointDist(it.x, it.y, x1, y1, x2, y2);
            if (d < it.r * 1.15) {
                it.sliced = true; it.sliceT = now;
                if (it.isBomb) { endGame(); return; }
                if (now - lastSliceAt < 650) { combo++; } else { combo = 1; }
                lastSliceAt = now;
                comboBest = Math.max(comboBest, combo);
                const mult = Math.min(combo, 5);
                const gained = 10 * mult;
                score += gained;
                scoreLabel.textContent = score;
                spawnParticles(it.x, it.y, gained, mult);
            }
        }
    }

    function spawnParticles(x, y, gained, mult) {
        particles.push({ x, y, text: '+' + gained + (mult > 1 ? '  x' + mult : ''), life: 700, born: performance.now(), color: mult > 1 ? '#C9A84C' : '#f0e6c8' });
        for (let i = 0; i < 8; i++) {
            const a = Math.random() * Math.PI * 2;
            particles.push({ x, y, vx: Math.cos(a) * 140, vy: Math.sin(a) * 140, life: 500, born: performance.now(), dot: true, color: '#C9A84C' });
        }
    }

    function endGame() {
        running = false;
        finalScoreEl.textContent = score;
        if (score > best) {
            best = score; bestLabel.textContent = best;
            newBestNote.textContent = '🎉 New personal best!';
        } else {
            newBestNote.textContent = 'Best so far: ' + best;
        }
        overOverlay.classList.remove('hidden');
        submitScore(score, comboBest);
    }

    function submitScore(finalScore, cBest) {
        fetch("{{ route('game.score') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ score: finalScore, combo_best: cBest })
        }).catch(() => {});
    }

    let lastT = null;
    function loop(t) {
        if (!lastT) lastT = t;
        const dt = Math.min((t - lastT) / 1000, 0.035);
        lastT = t;
        if (running) {
            elapsed += dt;
            spawnTimer += dt * 1000;
            const curInterval = Math.max(500, spawnInterval - elapsed * 14);
            if (spawnTimer > curInterval) { spawnTimer = 0; spawnItem(); }

            for (const it of items) {
                if (!it.sliced) {
                    it.x += it.vx * dt; it.y += it.vy * dt; it.vy += GRAVITY * dt;
                    it.rot += dt * 1.5;
                }
            }
            const before = items.length;
            items = items.filter(it => {
                if (it.sliced) return performance.now() - it.sliceT < 260;
                if (it.y - it.r > H + 40) {
                    if (!it.isBomb) {
                        lives--;
                        livesLabel.textContent = '●'.repeat(Math.max(lives, 0)) + '○'.repeat(3 - Math.max(lives, 0));
                        if (lives <= 0) { endGame(); }
                    }
                    return false;
                }
                return true;
            });
        }

        ctx.clearRect(0, 0, W, H);

        // trail
        if (trail.length > 1) {
            ctx.save();
            ctx.lineCap = 'round'; ctx.lineJoin = 'round';
            for (let i = 1; i < trail.length; i++) {
                const p0 = trail[i - 1], p1 = trail[i];
                const age = (performance.now() - p1.t) / 180;
                if (age > 1) continue;
                ctx.strokeStyle = `rgba(201,168,76,${1 - age})`;
                ctx.lineWidth = 6 * (1 - age) + 1;
                ctx.beginPath(); ctx.moveTo(p0.x, p0.y); ctx.lineTo(p1.x, p1.y); ctx.stroke();
            }
            ctx.restore();
        }
        trail = trail.filter(p => performance.now() - p.t < 200);

        // items
        for (const it of items) {
            ctx.save();
            ctx.translate(it.x, it.y);
            ctx.rotate(it.rot);
            let scale = 1, alpha = 1;
            if (it.sliced) {
                const p = (performance.now() - it.sliceT) / 260;
                scale = 1 + p * 0.6; alpha = 1 - p;
            }
            ctx.globalAlpha = alpha;
            ctx.font = `${it.r * 2 * scale}px serif`;
            ctx.textAlign = 'center'; ctx.textBaseline = 'middle';
            ctx.fillText(it.emoji, 0, 0);
            ctx.restore();
        }

        // particles
        particles = particles.filter(p => performance.now() - p.born < p.life);
        for (const p of particles) {
            const age = (performance.now() - p.born) / p.life;
            ctx.save();
            ctx.globalAlpha = 1 - age;
            if (p.dot) {
                ctx.fillStyle = p.color;
                ctx.beginPath();
                ctx.arc(p.x + p.vx * age * 0.4, p.y + p.vy * age * 0.4, 3, 0, 7);
                ctx.fill();
            } else {
                ctx.fillStyle = p.color;
                ctx.font = '700 20px Jost, sans-serif';
                ctx.textAlign = 'center';
                ctx.fillText(p.text, p.x, p.y - age * 40);
            }
            ctx.restore();
        }

        requestAnimationFrame(loop);
    }
    requestAnimationFrame(loop);

    // ── pointer input ──────────────────────────────────────────
    let dragging = false, lastPoint = null;
    function toLocal(e) {
        const rect = canvas.getBoundingClientRect();
        const cx = (e.touches ? e.touches[0].clientX : e.clientX) - rect.left;
        const cy = (e.touches ? e.touches[0].clientY : e.clientY) - rect.top;
        return { x: cx, y: cy };
    }
    function down(e) { dragging = true; const p = toLocal(e); lastPoint = p; trail.push({ ...p, t: performance.now() }); }
    function move(e) {
        if (!dragging || !running) return;
        const p = toLocal(e);
        trail.push({ ...p, t: performance.now() });
        if (lastPoint) sliceCheck(lastPoint.x, lastPoint.y, p.x, p.y);
        lastPoint = p;
        e.preventDefault();
    }
    function up() { dragging = false; lastPoint = null; }

    canvas.addEventListener('mousedown', down);
    canvas.addEventListener('mousemove', move);
    window.addEventListener('mouseup', up);
    canvas.addEventListener('touchstart', down, { passive: true });
    canvas.addEventListener('touchmove', move, { passive: false });
    canvas.addEventListener('touchend', up);

    document.getElementById('gsStartBtn').addEventListener('click', () => {
        reset(); startOverlay.classList.add('hidden'); running = true;
    });
    document.getElementById('gsRetryBtn').addEventListener('click', () => {
        reset(); overOverlay.classList.add('hidden'); running = true;
    });
})();
</script>
@endsection
