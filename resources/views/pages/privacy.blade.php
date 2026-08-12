@extends('layouts.app')

@section('title', 'Privacy Policy - ' . config('app.name', 'Dice Madly'))
@section('meta_description', 'Privacy Policy for Dice Madly mobile application. Learn how we collect, protect, and handle your personal information in compliance with Google Play Store policies and global data protection regulations.')

@section('content')
<!-- Page Header -->
<div class="policy-page-header">
    <div class="container">
        <span class="policy-badge">Google Play Store & GDPR Compliant</span>
        <h1 style="margin-bottom: 12px;">Privacy Policy</h1>
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
                <h5 style="color: var(--text-primary); font-size: 0.95rem; margin-bottom: 14px; text-transform: uppercase; letter-spacing: 0.05em;">Contents</h5>
                <ul class="policy-toc">
                    <li><a href="#overview">1. Overview</a></li>
                    <li><a href="#data-collection">2. Data We Collect</a></li>
                    <li><a href="#kyc-photos">3. Photos & KYC Verification</a></li>
                    <li><a href="#location-data">4. Precise Location & Proximity</a></li>
                    <li><a href="#data-usage">5. How We Use Information</a></li>
                    <li><a href="#third-parties">6. Third-Party Services & SDKs</a></li>
                    <li><a href="#data-retention">7. Data Retention & Deletion</a></li>
                    <li><a href="#children">8. Children's Privacy (18+)</a></li>
                    <li><a href="#user-rights">9. Your Privacy Rights</a></li>
                    <li><a href="#security">10. Security Practices</a></li>
                    <li><a href="#contact-dpo">11. Contact & Grievance Officer</a></li>
                </ul>
            </div>
        </aside>

        <!-- Main Document Body -->
        <div class="policy-content">
            <div class="policy-highlight-box green">
                <h4>🔒 Summary of Our Commitment</h4>
                <p style="margin: 0; font-size: 0.92rem; color: #065f46;">
                    At <strong>Dice Madly</strong>, your privacy and trust are our top priority. We do not sell your personal data to advertisers. Sensitive KYC documents are used exclusively for user verification and fraud prevention, and you maintain complete control to delete your account and data at any moment.
                </p>
            </div>

            <!-- Section 1 -->
            <section id="overview">
                <h2>1. Overview & Scope</h2>
                <p>
                    Welcome to <strong>{{ $appName }}</strong> (the "App", "we", "our", or "us"). This Privacy Policy explains how {{ $appName }} collects, uses, stores, shares, and protects your personal information when you use our mobile application (Android and iOS), website, and associated matchmaking services (collectively, the "Services").
                </p>
                <p>
                    By downloading, accessing, or using {{ $appName }}, you acknowledge that you have read and understood this Privacy Policy and agree to our collection, use, and disclosure of your information as described herein.
                </p>
            </section>

            <!-- Section 2 -->
            <section id="data-collection">
                <h2>2. Information We Collect</h2>
                <p>We collect information in three categories to deliver personalized matchmaking and ensure community security:</p>

                <h3>A. Information You Provide Directly</h3>
                <ul>
                    <li><strong>Account & Authentication:</strong> Mobile phone number and/or email address for One-Time Password (OTP) verification, full name, date of birth, gender, and marital status.</li>
                    <li><strong>Profile Details:</strong> Bio ("About Me"), educational background, occupation, lifestyle habits, and selected interest tags (5 to 10 passions).</li>
                    <li><strong>Partner Preferences:</strong> Preferred age ranges, distance radiuses, cultural/religious preferences, and relationship goals.</li>
                    <li><strong>Communications:</strong> Real-time messages, chat transcripts, customer support tickets, and feedback.</li>
                </ul>

                <h3>B. Information Collected Automatically</h3>
                <ul>
                    <li><strong>Device & Network Data:</strong> Device model, operating system version, unique device identifier (UUID), IP address, app build version, and mobile network carrier.</li>
                    <li><strong>App Usage & Telemetry:</strong> In-app navigation events, dice roll counts, swipe interactions, connection requests, active sessions, and crash logs.</li>
                </ul>
            </section>

            <!-- Section 3 -->
            <section id="kyc-photos">
                <h2>3. Profile Photos, Camera Access & KYC Face Verification</h2>
                <p>To preserve authentic dating experiences and enforce our zero-tolerance policy against bots and romance scammers, we collect visual media under explicit consent:</p>
                <ul>
                    <li><strong>Profile Pictures & Galleries:</strong> Photos you select from your device to display on your public profile card.</li>
                    <li><strong>Live Selfie Verification:</strong> A live selfie taken via camera capture to compare against profile photos. This generates a Blue Verified badge upon authentication.</li>
                    <li><strong>KYC Identification Documents (Optional/As Mandated):</strong> Government-issued ID proof uploaded for identity confirmation, used strictly for safety validation.</li>
                </ul>
                <div class="policy-highlight-box gold">
                    <h4>⚠️ Strict Confidentiality of Identity Documents</h4>
                    <p style="margin: 0; font-size: 0.92rem;">
                        Government ID proofs are stored in encrypted, non-public cloud buckets and are <strong>never</strong> displayed to other users or sold to third parties.
                    </p>
                </div>
            </section>

            <!-- Section 4 -->
            <section id="location-data">
                <h2>4. Precise Location & Proximity Matchmaking</h2>
                <p>
                    {{ $appName }} utilizes your device's GPS and network location to calculate distance and recommend nearby matches.
                </p>
                <ul>
                    <li><strong>How We Use Location:</strong> We calculate relative proximity (e.g., "3 km away") using the Haversine formula.</li>
                    <li><strong>Location Masking:</strong> We <strong>never</strong> broadcast your exact coordinates (latitude and longitude) or real-time movement trajectory to other members.</li>
                    <li><strong>Permission Control:</strong> You can adjust or revoke location permissions at any time within your device's operating system settings.</li>
                </ul>
            </section>

            <!-- Section 5 -->
            <section id="data-usage">
                <h2>5. How We Use Your Information</h2>
                <p>We process your data strictly under valid legal bases (contract performance, legitimate interests, legal compliance, and explicit consent) for:</p>
                <ul>
                    <li><strong>Delivering Matchmaking:</strong> Powering the Dice Roll algorithm to generate high-affinity matches based on shared preferences.</li>
                    <li><strong>Account Security & Authentication:</strong> Verifying logins via OTP codes and stopping unauthorized access.</li>
                    <li><strong>Trust & Community Safety:</strong> Identifying prohibited behavior, harassment, fraud, and maintaining a secure dating ecosystem.</li>
                    <li><strong>Push Notifications:</strong> Notifying you in real time of new matches, incoming messages, and daily dice roll resets.</li>
                    <li><strong>Billing & In-App Purchases:</strong> Validating virtual dice purchases and VIP subscriptions via Google Play Billing and payment gateways.</li>
                </ul>
            </section>

            <!-- Section 6 -->
            <section id="third-parties">
                <h2>6. Third-Party Service Providers & SDKs</h2>
                <p>We share limited data with reputable third-party infrastructure providers solely to operate the App:</p>
                <table class="policy-table">
                    <thead>
                        <tr>
                            <th>Service Provider</th>
                            <th>Purpose</th>
                            <th>Data Shared</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Google Play Services</strong></td>
                            <td>App Distribution, Play Billing & In-App Purchases</td>
                            <td>Purchase tokens, device metadata</td>
                        </tr>
                        <tr>
                            <td><strong>Firebase (Google LLC)</strong></td>
                            <td>Push Notifications (FCM) & Crashlytics</td>
                            <td>FCM Device Token, crash diagnostics</td>
                        </tr>
                        <tr>
                            <td><strong>Razorpay / Stripe</strong></td>
                            <td>Secure payment gateway processing</td>
                            <td>Billing order IDs, transaction signatures (no raw card data stored by us)</td>
                        </tr>
                        <tr>
                            <td><strong>AWS (Amazon Web Services)</strong></td>
                            <td>Encrypted cloud database & photo storage</td>
                            <td>Encrypted media and backend records</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <!-- Section 7 -->
            <section id="data-retention">
                <h2>7. Data Retention & Account Deletion (Google Play Compliance)</h2>
                <p>
                    We retain your personal data only for as long as necessary to provide our matchmaking services and fulfill legal compliance requirements.
                </p>
                <div class="policy-highlight-box">
                    <h4>🗑️ User Account & Data Deletion Guarantee</h4>
                    <p style="margin: 0; font-size: 0.92rem; color: #e2e8f0;">
                        In full compliance with Google Play Developer Policies, you have the absolute right to request permanent deletion of your account and all associated data at any time through two methods:
                    </p>
                    <ol style="margin: 10px 0 0 20px; font-size: 0.92rem; color: #334155;">
                        <li><strong>In-App Deletion:</strong> Navigate to <em>Profile &gt; Settings &gt; Delete Account</em>.</li>
                        <li><strong>Web Deletion Portal (No app install required):</strong> Visit our public deletion request portal at <a href="{{ route('delete-account') }}" style="color: var(--primary); font-weight: 600;">{{ route('delete-account') }}</a>.</li>
                    </ol>
                </div>
                <p>
                    <strong>What is deleted:</strong> Your profile, uploaded photos, KYC documents, chat histories, match records, and preferences are unlinked and permanently purged following a 15-to-30-day security hold (retained solely to resolve pending safety reports, fraud investigations, or legal mandates).
                </p>
            </section>

            <!-- Section 8 -->
            <section id="children">
                <h2>8. Children's Privacy (Strict 18+ Policy)</h2>
                <p>
                    {{ $appName }} is strictly restricted to adults aged eighteen (18) years or older. We do not knowingly collect, solicit, or maintain personal information from individuals under 18 years of age.
                </p>
                <p>
                    If we discover that a user under 18 has created an account by misrepresenting their date of birth, we will immediately terminate the account and purge their data from our servers. If you suspect a minor is using the app, please notify us immediately at <a href="mailto:safety@dicemadly.com">safety@dicemadly.com</a>.
                </p>
            </section>

            <!-- Section 9 -->
            <section id="user-rights">
                <h2>9. Your Privacy Rights (GDPR / CCPA / DPDP)</h2>
                <p>Depending on your jurisdiction, you possess the following rights regarding your personal information:</p>
                <ul>
                    <li><strong>Right to Access:</strong> Request a copy of the personal data we hold about you.</li>
                    <li><strong>Right to Rectification:</strong> Update and correct inaccurate or incomplete profile details at any time in the app.</li>
                    <li><strong>Right to Erasure ("Right to Be Forgotten"):</strong> Request full deletion of your profile and data.</li>
                    <li><strong>Right to Restrict / Object:</strong> Object to specific data processing activities or withdraw consent for location/camera access.</li>
                    <li><strong>Right to Data Portability:</strong> Obtain your data in a structured, machine-readable format.</li>
                </ul>
            </section>

            <!-- Section 10 -->
            <section id="security">
                <h2>10. Security Safeguards</h2>
                <p>
                    We employ industry-standard technical and organizational security controls, including TLS/HTTPS 256-bit encryption for all network transmissions, encrypted SQL storage, token-based Sanctum authentication with automatic expiry, and strict access control mechanisms to safeguard user information from unauthorized access, alteration, or disclosure.
                </p>
            </section>

            <!-- Section 11 -->
            <section id="contact-dpo">
                <h2>11. Contact Us & Grievance Redressal Officer</h2>
                <p>
                    For inquiries, data protection requests, or grievance redressal regarding this Privacy Policy, please reach out to our designated Data Protection & Grievance Officer:
                </p>
                <div class="glass-panel" style="padding: 24px; margin-top: 16px;">
                    <h5 style="color: var(--text-primary); font-size: 1.1rem; margin-bottom: 6px;">{{ $appName }} Privacy & Safety Team</h5>
                    <p style="margin: 4px 0; font-size: 0.95rem;"><strong>Email:</strong> <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a></p>
                    <p style="margin: 4px 0; font-size: 0.95rem;"><strong>General Support:</strong> <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a></p>
                    <p style="margin: 4px 0; font-size: 0.95rem;"><strong>Web Contact Form:</strong> <a href="{{ route('contact') }}">Contact Support Portal</a></p>
                    <p style="margin: 4px 0; font-size: 0.95rem;"><strong>Response SLA:</strong> Inquiries are acknowledged within 24 hours and addressed within 15 business days.</p>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
