@extends('layouts.app')

@section('title', 'Community Guidelines & Safety Pledge - ' . config('app.name', 'Dice Madly'))
@section('meta_description', 'Dice Madly community guidelines, safe dating tips, and user safety pledge. Learn how we maintain a safe, authentic, and respectful matchmaking platform.')

@section('content')
<!-- Page Header -->
<div class="policy-page-header">
    <div class="container">
        <span class="policy-badge" style="background: #ecfdf5; border-color: #a7f3d0; color: var(--accent-green);">
            Trust & Community Safety
        </span>
        <h1 style="margin-bottom: 12px;">Community Guidelines</h1>
        <p style="color: var(--text-secondary); max-width: 700px;">
            Effective Date: {{ $lastUpdated }} &bull; Creating a respectful, authentic, and joyful dating community.
        </p>
    </div>
</div>

<div class="container">
    <div class="policy-layout">
        <!-- Sidebar Navigation -->
        <aside class="policy-sidebar">
            <div class="glass-panel" style="padding: 20px;">
                <h5 style="color: var(--text-primary); font-size: 0.95rem; margin-bottom: 14px; text-transform: uppercase; letter-spacing: 0.05em;">Guidelines</h5>
                <ul class="policy-toc">
                    <li><a href="#core-principles">1. Core Principles</a></li>
                    <li><a href="#authenticity">2. Authenticity & Verification</a></li>
                    <li><a href="#harassment">3. Harassment & Hate Speech</a></li>
                    <li><a href="#sexual-content">4. Nudity & Explicit Content</a></li>
                    <li><a href="#financial-scams">5. Scams & Commercial Use</a></li>
                    <li><a href="#safe-dating-tips">6. Real-World Dating Safety</a></li>
                    <li><a href="#reporting">7. Reporting & Enforcement</a></li>
                </ul>
            </div>
        </aside>

        <!-- Main Document Body -->
        <div class="policy-content">
            <div class="policy-highlight-box green">
                <h4>🤝 Our Community Standard</h4>
                <p style="margin: 0; font-size: 0.92rem; color: #065f46;">
                    <strong>{{ $appName }}</strong> is built to make finding love and meaningful relationships fun, honest, and safe. Every member is expected to treat others with dignity, kindness, and respect.
                </p>
            </div>

            <!-- Section 1 -->
            <section id="core-principles">
                <h2>1. Core Community Principles</h2>
                <ul>
                    <li><strong>Mutual Respect:</strong> Treat every match with the same courtesy and empathy you expect in return.</li>
                    <li><strong>Consent Matters:</strong> Always respect personal boundaries. No means no.</li>
                    <li><strong>Kindness:</strong> Ghosting, mocking, or abusive language have no place on our platform.</li>
                </ul>
            </section>

            <!-- Section 2 -->
            <section id="authenticity">
                <h2>2. Authenticity & Real Profiles</h2>
                <ul>
                    <li><strong>Be Yourself:</strong> Use only your genuine photos, actual age, and honest biographical information.</li>
                    <li><strong>No Impersonation:</strong> Catfishing, using photos of celebrities or other people, or creating accounts for others is strictly prohibited.</li>
                    <li><strong>Verified Badge:</strong> Complete your live selfie verification to show others that your profile is 100% verified.</li>
                </ul>
            </section>

            <!-- Section 3 -->
            <section id="harassment">
                <h2>3. Harassment, Bullying & Hate Speech</h2>
                <p>We maintain a zero-tolerance policy against any form of abusive behavior:</p>
                <ul>
                    <li>Do not use abusive, threatening, racist, sexist, homophobic, or derogatory language.</li>
                    <li>Do not stalk, repeatedly contact users who have expressed disinterest, or distribute anyone's private personal information (doxxing).</li>
                </ul>
            </section>

            <!-- Section 4 -->
            <section id="sexual-content">
                <h2>4. Nudity & Sexually Explicit Material</h2>
                <ul>
                    <li><strong>No Explicit Media:</strong> Uploading or transmitting sexually explicit photos, nudity, pornographic images, or unsolicited sexually suggestive content is forbidden.</li>
                    <li><strong>No Commercial Sex:</strong> The promotion or solicitation of commercial sexual services, sugar dating, prostitution, or escort services will result in an immediate and permanent ban.</li>
                </ul>
            </section>

            <!-- Section 5 -->
            <section id="financial-scams">
                <h2>5. Scams, Solicitations & Fraud</h2>
                <ul>
                    <li><strong>Never Send Money:</strong> Never send money, wire transfers, crypto, or financial aid to someone you met online.</li>
                    <li><strong>No Commercial Selling:</strong> Do not use {{ $appName }} to sell goods, promote affiliate links, advertise external services, or recruit members for business ventures.</li>
                </ul>
            </section>

            <!-- Section 6 -->
            <section id="safe-dating-tips">
                <h2>6. Real-World Safe Dating Checklist</h2>
                <div class="policy-highlight-box gold">
                    <h4>🌟 Top Safety Tips Before Meeting in Person</h4>
                    <ul style="margin: 8px 0 0 20px; font-size: 0.92rem; color: #92400e;">
                        <li><strong>Stay in Public:</strong> Meet in busy, well-lit public venues (cafés, restaurants, parks) for initial dates.</li>
                        <li><strong>Tell a Friend:</strong> Share your date location and plans with a close friend or family member.</li>
                        <li><strong>Own Transportation:</strong> Control your own ride to and from the date; never agree to be picked up from your residence on a first date.</li>
                        <li><strong>Protect Private Data:</strong> Do not share your home address, workplace details, or financial passwords.</li>
                    </ul>
                </div>
            </section>

            <!-- Section 7 -->
            <section id="reporting">
                <h2>7. How to Report Violations & Enforcement</h2>
                <p>
                    If you encounter a profile or message that violates our guidelines:
                </p>
                <ol>
                    <li>Tap the <strong>three dots (⋮)</strong> at the top right of the user's profile or chat screen.</li>
                    <li>Select <strong>Report User</strong>, pick the relevant reason (e.g., Harassment, Fake Profile, Inappropriate Photo), and add optional details.</li>
                    <li>Tap <strong>Block</strong> to immediately cut off all communication.</li>
                </ol>
                <p>
                    Our 24/7 moderation team investigates every report. Violators will face account suspension, shadow-bans, or permanent expulsion. You can also report incidents directly to <a href="mailto:{{ $safetyEmail }}">{{ $safetyEmail }}</a>.
                </p>
            </section>
        </div>
    </div>
</div>
@endsection
