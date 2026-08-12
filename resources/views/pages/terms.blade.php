@extends('layouts.app')

@section('title', 'Terms of Service - ' . config('app.name', 'Dice Madly'))
@section('meta_description', 'Terms and Conditions for using Dice Madly dating and matrimony application. Review our membership rules, safety guidelines, and subscription terms.')

@section('content')
<!-- Page Header -->
<div class="policy-page-header">
    <div class="container">
        <span class="policy-badge">End User License Agreement</span>
        <h1 style="margin-bottom: 12px;">Terms of Service</h1>
        <p style="color: var(--text-secondary); max-width: 700px;">
            Effective Date: {{ $lastUpdated }} &bull; Last Revised: {{ $lastUpdated }}
        </p>
    </div>
</div>

<div class="container">
    <div class="policy-layout">
        <!-- Sidebar Navigation -->
        <aside class="policy-sidebar">
            <div class="glass-panel" style="padding: 20px;">
                <h5 style="color: var(--text-primary); font-size: 0.95rem; margin-bottom: 14px; text-transform: uppercase; letter-spacing: 0.05em;">Sections</h5>
                <ul class="policy-toc">
                    <li><a href="#acceptance">1. Acceptance of Terms</a></li>
                    <li><a href="#eligibility">2. 18+ Age & Eligibility</a></li>
                    <li><a href="#accounts">3. Account & OTP Auth</a></li>
                    <li><a href="#dice-mechanics">4. Dice Roll Matchmaking</a></li>
                    <li><a href="#conduct">5. Community Code of Conduct</a></li>
                    <li><a href="#subscriptions">6. Subscriptions & Billing</a></li>
                    <li><a href="#safety-disclaimer">7. Real-World Dating Safety</a></li>
                    <li><a href="#content-rights">8. User Content & License</a></li>
                    <li><a href="#termination">9. Account Termination</a></li>
                    <li><a href="#liability">10. Limitation of Liability</a></li>
                    <li><a href="#legal-contact">11. Legal Contact</a></li>
                </ul>
            </div>
        </aside>

        <!-- Main Document Body -->
        <div class="policy-content">
            <!-- Section 1 -->
            <section id="acceptance">
                <h2>1. Acceptance of Terms</h2>
                <p>
                    These Terms of Service ("Terms") constitute a legally binding contract between you ("User", "you", or "your") and <strong>{{ $appName }}</strong> ("Company", "we", "us", or "our"). By creating an account, downloading our mobile app, or accessing any part of our services, you confirm that you accept and agree to be bound by these Terms and our <a href="{{ route('privacy') }}">Privacy Policy</a>.
                </p>
            </section>

            <!-- Section 2 -->
            <section id="eligibility">
                <h2>2. Age Restriction & Eligibility (18+ Only)</h2>
                <div class="policy-highlight-box">
                    <h4>🔞 Mandatory Age Requirement</h4>
                    <p style="margin: 0; font-size: 0.92rem; color: #991b1b;">
                        You must be at least <strong>eighteen (18) years of age</strong> to create an account or use {{ $appName }}. By using the service, you represent and warrant that you possess the full legal right, authority, and capacity to enter into this agreement.
                    </p>
                </div>
                <p>
                    You further warrant that you have never been convicted of any violent crime, sexual offense, felony, or listed on any sex offender registry in any jurisdiction.
                </p>
            </section>

            <!-- Section 3 -->
            <section id="accounts">
                <h2>3. Account Registration & Security</h2>
                <ul>
                    <li><strong>One Account Per Person:</strong> You agree to create only one active account and not to share your account or login credentials with any third party.</li>
                    <li><strong>Accurate Information:</strong> You agree to provide accurate, current, and truthful profile data, including your true identity and genuine photos.</li>
                    <li><strong>OTP Verification:</strong> Account login is validated via One-Time Password (OTP) sent to your registered phone number or email address. You are responsible for all activities occurring under your account.</li>
                </ul>
            </section>

            <!-- Section 4 -->
            <section id="dice-mechanics">
                <h2>4. Dice Roll Matchmaking & Quotas</h2>
                <p>
                    {{ $appName }} provides an algorithm-driven matchmaking service featuring our signature "Dice Roll":
                </p>
                <ul>
                    <li><strong>Daily Quota:</strong> Standard free users are allocated five (5) free daily dice rolls that reset automatically at 00:00 UTC.</li>
                    <li><strong>Fair Use:</strong> Rolls are non-transferable, cannot be exchanged for cash, and must be used in accordance with normal personal matchmaking usage.</li>
                    <li><strong>Matching Outcome:</strong> While our algorithm optimizes for mutual affinity and distance, {{ $appName }} does not guarantee a specific number of matches, responses, or romantic success.</li>
                </ul>
            </section>

            <!-- Section 5 -->
            <section id="conduct">
                <h2>5. Community Code of Conduct & Prohibited Activities</h2>
                <p>To foster a respectful and safe dating and matrimony community, you agree NOT to:</p>
                <ul>
                    <li>Harass, stalk, intimidate, threaten, defame, or abuse any other member.</li>
                    <li>Upload or share sexually explicit, pornographic, violent, hateful, or non-consensual imagery.</li>
                    <li>Impersonate any person or entity, or create fake profiles (catfishing).</li>
                    <li>Use the service for commercial solicitation, advertising, prostitution, or soliciting financial loans/funds.</li>
                    <li>Deploy bots, scrapers, automated scripts, or reverse-engineer {{ $appName }}'s APIs.</li>
                </ul>
                <div class="policy-highlight-box gold">
                    <h4>⚖️ Zero Tolerance Policy</h4>
                    <p style="margin: 0; font-size: 0.92rem;">
                        Violation of community rules results in immediate, permanent ban of the offending user without eligibility for refund.
                    </p>
                </div>
            </section>

            <!-- Section 6 -->
            <section id="subscriptions">
                <h2>6. Subscriptions, Virtual Goods & Billing</h2>
                <p>
                    {{ $appName }} offers optional VIP subscriptions and virtual coin/roll booster packs:
                </p>
                <ul>
                    <li><strong>Google Play Billing:</strong> Android in-app purchases are processed securely through the Google Play Store billing platform and are subject to Google Play's terms and refund policies.</li>
                    <li><strong>Auto-Renewal:</strong> Subscriptions renew automatically unless cancelled at least 24 hours prior to the end of the current billing cycle through your Google Play Store subscription manager.</li>
                    <li><strong>Consumables:</strong> Virtual roll packages are consumable digital items consumed upon gameplay/match exploration and are non-refundable once activated.</li>
                </ul>
            </section>

            <!-- Section 7 -->
            <section id="safety-disclaimer">
                <h2>7. In-Person Meetings & Real-World Safety Disclaimer</h2>
                <p>
                    {{ $appName }} does not conduct background checks on all users beyond selfie face and OTP verification. You are solely responsible for your interactions with other members.
                </p>
                <p>
                    <strong>Safety Tips:</strong> Always meet in well-lit public places for first dates, inform a trusted friend or family member of your whereabouts, never share personal financial details, and arrange your own transportation.
                </p>
            </section>

            <!-- Section 8 -->
            <section id="content-rights">
                <h2>8. User Content & Intellectual Property</h2>
                <p>
                    You retain ownership of the photos, bio text, and messages you submit ("User Content"). By uploading content to {{ $appName }}, you grant us a non-exclusive, royalty-free, worldwide license to host, store, display, and process your content strictly for the purpose of operating and improving the matchmaking services.
                </p>
                <p>
                    All logos, trademarks, visual UI designs, algorithms, software code, and graphics comprising {{ $appName }} are the exclusive intellectual property of the Company.
                </p>
            </section>

            <!-- Section 9 -->
            <section id="termination">
                <h2>9. Account Termination & Deletion</h2>
                <p>
                    You may terminate your account at any time via the in-app settings or via our <a href="{{ route('delete-account') }}">Web Account & Data Deletion Portal</a>.
                </p>
                <p>
                    We reserve the right to suspend, restrict, or permanently terminate your account without notice if you violate these Terms, engage in fraud, or behave harmfully toward our community.
                </p>
            </section>

            <!-- Section 10 -->
            <section id="liability">
                <h2>10. Disclaimers & Limitation of Liability</h2>
                <p>
                    {{ $appName }} IS PROVIDED ON AN "AS IS" AND "AS AVAILABLE" BASIS WITHOUT WARRANTIES OF ANY KIND, EITHER EXPRESS OR IMPLIED. TO THE FULLEST EXTENT PERMITTED BY LAW, WE SHALL NOT BE LIABLE FOR ANY INDIRECT, INCIDENTAL, SPECIAL, CONSEQUENTIAL, OR PUNITIVE DAMAGES ARISING FROM YOUR USE OF THE SERVICES OR INTERACTIONS WITH OTHER USERS.
                </p>
            </section>

            <!-- Section 11 -->
            <section id="legal-contact">
                <h2>11. Contact & Dispute Resolution</h2>
                <p>
                    For legal questions, notices, or formal communication regarding these Terms:
                </p>
                <div class="glass-panel" style="padding: 24px; margin-top: 16px;">
                    <h5 style="color: var(--text-primary); font-size: 1.1rem; margin-bottom: 6px;">{{ $appName }} Legal Operations</h5>
                    <p style="margin: 4px 0; font-size: 0.95rem;"><strong>Email:</strong> <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a></p>
                    <p style="margin: 4px 0; font-size: 0.95rem;"><strong>Customer Support:</strong> <a href="{{ route('contact') }}">{{ route('contact') }}</a></p>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
