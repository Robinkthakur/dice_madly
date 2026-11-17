@extends('layouts.app')

@section('title', 'Safety Standards & Child Safety Policy - ' . config('app.name', 'Dice Madly'))
@section('meta_description', 'Official Safety Standards, Child Sexual Exploitation and Abuse (CSAE) prevention policy, and user safety pledge for Dice Madly in full compliance with Google Play Developer policies.')

@section('content')
<!-- Page Header -->
<div class="policy-page-header">
    <div class="container">
        <span class="policy-badge" style="background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8;">
            🛡️ Google Play Policy & Child Safety Standards (CSAE Compliant)
        </span>
        <h1 style="margin-bottom: 12px;">Safety Standards & Child Protection Policy</h1>
        <p style="color: var(--text-secondary); max-width: 780px;">
            Effective Date: {{ $lastUpdated }} &bull; Dice Madly is dedicated to cultivating an authentic, respectful, and safe community with zero tolerance for child sexual abuse material, exploitation, or abuse.
        </p>
    </div>
</div>

<div class="container" style="margin-bottom: 80px;">
    <div class="policy-layout">
        <!-- Sidebar Navigation -->
        <aside class="policy-sidebar">
            <div class="glass-panel" style="padding: 20px;">
                <h5 style="color: var(--text-primary); font-size: 0.92rem; margin-bottom: 14px; text-transform: uppercase; letter-spacing: 0.05em;">Table of Contents</h5>
                <ul class="policy-toc">
                    <li><a href="#zero-tolerance">1. Zero-Tolerance Statement</a></li>
                    <li><a href="#age-restriction">2. Strict 18+ Age Restriction</a></li>
                    <li><a href="#prohibited-content">3. Prohibited Content & Behaviors</a></li>
                    <li><a href="#prevention-detection">4. Prevention & Detection Measures</a></li>
                    <li><a href="#in-app-reporting">5. In-App Reporting Guide</a></li>
                    <li><a href="#external-reporting">6. External & Emergency Contacts</a></li>
                    <li><a href="#law-enforcement">7. Mandatory NCMEC & Legal Escalation</a></li>
                    <li><a href="#enforcement-sanctions">8. Account Sanctions & Penalties</a></li>
                    <li><a href="#general-safety">9. General User & Meeting Safety</a></li>
                    <li><a href="#grievance-contact">10. Grievance & Safety Officer</a></li>
                </ul>
            </div>
        </aside>

        <!-- Main Document Body -->
        <div class="policy-content">
            <!-- Critical Compliance Callout Box -->
            <div class="policy-highlight-box" style="background: #fef2f2; border-left: 4px solid #ef4444;">
                <h4 style="color: #991b1b; display: flex; align-items: center; gap: 8px;">
                    <span>🚨</span> Zero Tolerance for Child Sexual Exploitation and Abuse (CSAE)
                </h4>
                <p style="margin: 0; font-size: 0.94rem; color: #7f1d1d; line-height: 1.6;">
                    <strong>{{ $appName }}</strong> maintains an absolute, uncompromising <strong>zero-tolerance policy</strong> against Child Sexual Exploitation and Abuse (CSAE) and Child Sexual Abuse Material (CSAM). Any attempt to produce, upload, transmit, solicit, or facilitate material depicting or exploiting minors will result in immediate permanent banning, account termination, preservation of digital forensics, and reporting to the <strong>National Center for Missing & Exploited Children (NCMEC)</strong> and competent criminal law enforcement agencies worldwide.
                </p>
            </div>

            <!-- Section 1 -->
            <section id="zero-tolerance">
                <h2>1. Commitment & Zero-Tolerance Policy</h2>
                <p>
                    {{ $appName }} ("we", "us", or "our") operates a dating, matchmaking, and social connection platform. We are deeply committed to maintaining a safe digital environment for all users and safeguarding vulnerable populations. In accordance with <strong>Google Play Developer Program Policies</strong>, international human rights accords, and applicable statutory laws, we enforce strict prohibitions against any form of child sexual exploitation and abuse.
                </p>
                <p>
                    This Safety Standards document applies to all users, interactions, and content across all {{ $appName }} platforms, including our Android application, iOS application, and web services.
                </p>
            </section>

            <!-- Section 2 -->
            <section id="age-restriction">
                <h2>2. Strict Age Requirement: Adults Only (18+)</h2>
                <div class="policy-highlight-box gold">
                    <h4 style="color: #92400e;">🔞 Strict 18+ Platform Restriction</h4>
                    <p style="margin: 0; font-size: 0.92rem; color: #78350f;">
                        {{ $appName }} is exclusively intended and permitted for consenting adults aged <strong>18 years or older</strong>. Minors under the age of 18 are categorically prohibited from downloading, registering, accessing, or utilizing the platform.
                    </p>
                </div>
                <p>To enforce our age policy, we implement the following safety safeguards:</p>
                <ul>
                    <li><strong>Mandatory Date of Birth Verification:</strong> During initial onboarding, users must provide their verifiable date of birth. Any applicant under 18 is prevented from registration.</li>
                    <li><strong>Live Selfie Verification:</strong> Users complete a live selfie verification with liveness and facial geometry checks to prevent minors from using adult photos or masquerading as adults.</li>
                    <li><strong>Optional Government KYC:</strong> We offer government-issued identity verification to confirm legal adult status.</li>
                    <li><strong>Immediate Account Purging:</strong> If we discover or receive notice that an account is operated by or represents someone under 18, that account is terminated instantly and all associated data is permanently erased (subject only to evidentiary retention for law enforcement if abuse is indicated).</li>
                </ul>
            </section>

            <!-- Section 3 -->
            <section id="prohibited-content">
                <h2>3. Prohibited Content and Conduct</h2>
                <p>
                    We strictly prohibit the creation, upload, storage, sharing, discussion, or transmission of any of the following on or through {{ $appName }}:
                </p>
                <ul>
                    <li><strong>Child Sexual Abuse Material (CSAM):</strong> Any visual, photographic, digital, video, audio, or illustrated depiction of a minor engaged in sexually explicit or suggestive conduct.</li>
                    <li><strong>Child Sexual Exploitation and Abuse (CSAE):</strong> Any solicitation, enticement, trafficking, sextortion, or grooming directed at or involving minors.</li>
                    <li><strong>Child Grooming & Pedophilic Predation:</strong> Any behavior aimed at establishing an emotional connection with a minor to lower inhibitions or facilitate exploitation.</li>
                    <li><strong>Non-Consensual Sexual Imagery (NCII):</strong> Dissemination or threat of dissemination of intimate photographs without explicit mutual adult consent.</li>
                    <li><strong>Commercial Sex & Escorting:</strong> Solicitation or promotion of commercial sex, prostitution, sugar dating, or human trafficking.</li>
                    <li><strong>Depictions of Violence & Harassment:</strong> Hate speech, threats of physical violence, stalking, cyberbullying, doxxing, or coercion.</li>
                </ul>
            </section>

            <!-- Section 4 -->
            <section id="prevention-detection">
                <h2>4. Proactive Detection, Moderation & Safety Technologies</h2>
                <p>
                    {{ $appName }} employs a comprehensive multi-layered safety defense system combining automated algorithms and human oversight:
                </p>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin: 20px 0;">
                    <div style="background: #f8fafc; border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 18px;">
                        <h4 style="font-size: 1rem; margin-bottom: 6px; color: var(--primary);">🤖 Automated Media Filtering</h4>
                        <p style="font-size: 0.88rem; color: var(--text-secondary); margin: 0;">
                            Computer vision and perceptual hashing scan media uploads in real time to intercept sexually explicit media, underage imagery, and known CSAM digital hashes before they reach our public pool.
                        </p>
                    </div>

                    <div style="background: #f8fafc; border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 18px;">
                        <h4 style="font-size: 1rem; margin-bottom: 6px; color: var(--accent-green);">💬 Text & Keyword Heuristics</h4>
                        <p style="font-size: 0.88rem; color: var(--text-secondary); margin: 0;">
                            Chat and bio scanning algorithms inspect messages for predatory patterns, grooming triggers, underage references, and solicitation attempts to auto-flag or block offending accounts.
                        </p>
                    </div>

                    <div style="background: #f8fafc; border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 18px;">
                        <h4 style="font-size: 1rem; margin-bottom: 6px; color: #2563eb;">👥 24/7 Human Trust & Safety</h4>
                        <p style="font-size: 0.88rem; color: var(--text-secondary); margin: 0;">
                            A dedicated team of trained safety specialists reviews flagged profiles, user reports, and media around the clock with immediate escalation workflows for critical safety threats.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Section 5 -->
            <section id="in-app-reporting">
                <h2>5. How to Report Violations in the App (Step-by-Step)</h2>
                <p>
                    We provide prominent, user-accessible reporting mechanisms at every touchpoint within the mobile application. If you encounter any suspicious activity, minor profile, harassment, or exploitative content, please report it immediately:
                </p>

                <div class="glass-panel" style="padding: 24px; margin: 20px 0; border: 1px solid #bfdbfe; background: #f0f7ff;">
                    <h4 style="color: #1e40af; margin-bottom: 12px;">📱 In-App Reporting Steps (Android & iOS):</h4>
                    <ol style="margin-bottom: 0; padding-left: 20px; line-height: 1.8;">
                        <li><strong>Open Profile or Chat:</strong> Navigate to the user's profile card or the open chat room.</li>
                        <li><strong>Tap Options:</strong> Tap the <strong>three vertical dots (⋮)</strong> located at the top-right corner of the screen.</li>
                        <li><strong>Select Report:</strong> Tap <strong>"Report User"</strong> from the menu dropdown.</li>
                        <li><strong>Choose Category:</strong> Select the relevant reason, such as:
                            <ul>
                                <li><em>"Child Safety / Exploitation / Underage"</em></li>
                                <li><em>"Inappropriate or Explicit Media"</em></li>
                                <li><em>"Harassment, Abuse, or Threats"</em></li>
                                <li><em>"Fake Profile / Impersonation"</em></li>
                            </ul>
                        </li>
                        <li><strong>Provide Details:</strong> Add optional context or screenshots to expedite our investigation, then tap <strong>Submit</strong>.</li>
                        <li><strong>Instant Block:</strong> You will immediately be prompted to <strong>Block</strong> the user, instantly cutting off all messages and hiding profiles mutually.</li>
                    </ol>
                </div>
                <p style="font-size: 0.92rem; color: var(--text-secondary);">
                    <em>All user reports are handled confidentially. The reported account will not be told who filed the report.</em>
                </p>
            </section>

            <!-- Section 6 -->
            <section id="external-reporting">
                <h2>6. Dedicated External Safety Reporting Channels</h2>
                <p>
                    In addition to in-app tools, our safety team operates direct external reporting hotlines monitored 24 hours a day, 7 days a week:
                </p>
                <ul>
                    <li>
                        <strong>Dedicated Child Safety & CSAM Hotline:</strong> 
                        <a href="mailto:{{ $childSafetyEmail }}" style="font-weight: 700; color: #dc2626;">{{ $childSafetyEmail }}</a>
                        <br><span style="font-size: 0.88rem; color: var(--text-muted);">Priority tier: All emails to this address bypass normal queues and are reviewed within 1 to 4 hours.</span>
                    </li>
                    <li style="margin-top: 10px;">
                        <strong>General Trust & Safety Desk:</strong> 
                        <a href="mailto:{{ $safetyEmail }}" style="font-weight: 700;">{{ $safetyEmail }}</a>
                        <br><span style="font-size: 0.88rem; color: var(--text-muted);">For harassment, account impersonation, or safety inquiries.</span>
                    </li>
                    <li style="margin-top: 10px;">
                        <strong>Web Helpdesk Portal:</strong> 
                        <a href="{{ route('contact') }}">Dice Madly Helpdesk</a> (Select category: <em>"Safety & Abuse Report"</em>).
                    </li>
                </ul>
            </section>

            <!-- Section 7 -->
            <section id="law-enforcement">
                <h2>7. Mandatory Reporting to Law Enforcement & NCMEC</h2>
                <p>
                    {{ $appName }} complies fully with United States federal law (including 18 U.S.C. § 2258A) and international child safety standards. We do not negotiate, warn, or tolerate violations involving minors:
                </p>
                <div class="policy-highlight-box green">
                    <h4>🌐 Coordinated Law Enforcement Escalation</h4>
                    <ul>
                        <li>
                            <strong>NCMEC CyberTipline:</strong> When child sexual abuse material (CSAM) or child sexual exploitation and abuse (CSAE) is detected or reported, we immediately transmit a comprehensive electronic report to the <strong>National Center for Missing & Exploited Children (NCMEC)</strong> via the CyberTipline (<a href="{{ $cyberTiplineUrl }}" target="_blank" rel="noopener noreferrer">{{ $cyberTiplineUrl }}</a>).
                        </li>
                        <li>
                            <strong>Evidence Preservation:</strong> Offending accounts, associated IP addresses, device identifiers, communication logs, and uploaded files are preserved in a secure, tamper-proof evidentiary vault to assist criminal investigations.
                        </li>
                        <li>
                            <strong>National Cybercrime Authorities:</strong> We proactively cooperate with national and local law enforcement bodies, including the <strong>Cyber Crime Division / Indian Cyber Crime Reporting Portal</strong> (<a href="{{ $cyberCrimeGovUrl }}" target="_blank" rel="noopener noreferrer">{{ $cyberCrimeGovUrl }}</a>), INTERPOL, and regional cyber crime cells.
                        </li>
                    </ul>
                </div>
            </section>

            <!-- Section 8 -->
            <section id="enforcement-sanctions">
                <h2>8. Enforcement Actions and Account Sanctions</h2>
                <p>
                    Users found in breach of our Safety Standards will be subject to rapid disciplinary actions depending on the severity of the offense:
                </p>
                <table class="policy-table">
                    <thead>
                        <tr>
                            <th>Violation Level</th>
                            <th>Offense Types</th>
                            <th>Enforcement Action Taken</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-weight: 700; color: #b91c1c;">Critical / Zero-Tolerance</td>
                            <td>CSAM, CSAE, underage accounts, grooming, human trafficking, terror threats</td>
                            <td><strong>Permanent platform ban</strong>, hardware/device blacklisting, phone/email ban, evidence lock, immediate report to NCMEC & law enforcement.</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700; color: #c2410c;">Severe</td>
                            <td>Unsolicited explicit media, extortion (NCII), severe harassment, financial fraud/scams</td>
                            <td>Immediate account termination, deletion from discovery pool, forfeiture of subscription benefits, legal notification if applicable.</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700; color: #4338ca;">Moderate</td>
                            <td>Catfishing, impersonation, offensive language, spamming external links</td>
                            <td>Formal warning, mandatory re-verification, temporary suspension, or permanent ban upon repeated infractions.</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <!-- Section 9 -->
            <section id="general-safety">
                <h2>9. Real-World Safe Dating & Meeting Checklist</h2>
                <p>
                    While our moderation team works around the clock online, personal safety offline requires situational awareness. Please review these essential real-world dating guidelines:
                </p>
                <ul>
                    <li><strong>Public Meeting Locations:</strong> Always schedule first dates in populated, well-lit public venues (coffee shops, public restaurants, museums). Never meet in private residences, hotel rooms, or secluded areas.</li>
                    <li><strong>Arrange Independent Travel:</strong> Control your own transportation to and from the venue. Avoid letting your date pick you up or drop you off at your home address on initial meetings.</li>
                    <li><strong>Share Your Itinerary:</strong> Always inform a trusted friend or family member of where you are going, who you are meeting, and when you anticipate returning.</li>
                    <li><strong>Never Send Money:</strong> Never send wire transfers, UPI payments, cryptocurrency, gift cards, or financial assistance to someone you met online, regardless of their claimed emergency.</li>
                    <li><strong>Stay in Control:</strong> Keep your drink and personal belongings in sight at all times. If you feel uncomfortable at any point, ask staff for help or end the date immediately.</li>
                </ul>
            </section>

            <!-- Section 10 -->
            <section id="grievance-contact">
                <h2>10. Grievance Redressal & Designated Safety Officer</h2>
                <p>
                    For regulatory inquiries, compliance certifications, or formal safety disputes, contact our designated Safety & Grievance Redressal Officer:
                </p>
                <div class="glass-panel" style="padding: 24px; border-color: #cbd5e1; background: #f8fafc;">
                    <div style="font-size: 0.95rem; line-height: 1.8;">
                        <p><strong>Officer:</strong> Grievance & Child Protection Officer</p>
                        <p><strong>Platform:</strong> {{ $appName }} (A Product of Dice Madly Operations)</p>
                        <p><strong>Direct Child Safety Desk:</strong> <a href="mailto:{{ $childSafetyEmail }}">{{ $childSafetyEmail }}</a></p>
                        <p><strong>Trust & Safety Desk:</strong> <a href="mailto:{{ $safetyEmail }}">{{ $safetyEmail }}</a></p>
                        <p><strong>Grievance Escalation:</strong> <a href="mailto:{{ $grievanceEmail }}">{{ $grievanceEmail }}</a></p>
                        <p><strong>General Inquiries:</strong> <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a></p>
                        <p style="margin-top: 10px; font-size: 0.88rem; color: var(--text-muted);">
                            <em>Acknowledgment is dispatched within 24 hours. Formal safety and CSAE complaints receive immediate emergency escalation.</em>
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
