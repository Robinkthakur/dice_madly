@extends('layouts.app')

@section('title', 'Refund & Cancellation Policy - ' . config('app.name', 'Dice Madly'))
@section('meta_description', 'Refund and cancellation policy for Dice Madly subscriptions and virtual dice rolls. Review our terms for Google Play in-app purchases and subscription management.')

@section('content')
<!-- Page Header -->
<div class="policy-page-header">
    <div class="container">
        <span class="policy-badge">Billing & Payments</span>
        <h1 style="margin-bottom: 12px;">Refund & Cancellation Policy</h1>
        <p style="color: var(--text-secondary); max-width: 700px;">
            Effective Date: {{ $lastUpdated }} &bull; Clear and transparent billing terms for subscriptions and virtual goods.
        </p>
    </div>
</div>

<div class="container" style="margin-bottom: 80px;">
    <div class="policy-content" style="max-width: 900px; margin: 0 auto;">

        <div class="policy-highlight-box green">
            <h4>💡 Subscription Management Made Easy</h4>
            <p style="margin: 0; font-size: 0.92rem; color: #065f46;">
                All purchases made on Android devices are processed securely through <strong>Google Play Billing</strong>. You can view, manage, or cancel your active subscriptions at any time directly in your Google Play Store account settings.
            </p>
        </div>

        <section>
            <h2>1. Subscriptions & Auto-Renewal Terms</h2>
            <p>
                <strong>{{ $appName }}</strong> offers premium VIP subscription tiers (e.g., 1-month, 3-month, 6-month plans) granting benefits such as unlimited daily dice rolls, profile spotlight boosts, and advanced preference filters.
            </p>
            <ul>
                <li><strong>Billing Cycle:</strong> Subscriptions are billed at the beginning of each billing cycle upon your explicit confirmation.</li>
                <li><strong>Automatic Renewal:</strong> Unless cancelled at least 24 hours prior to the current billing period's conclusion, subscriptions renew automatically at the standard rate.</li>
            </ul>
        </section>

        <section>
            <h2>2. How to Cancel Your Subscription</h2>
            <p>To prevent auto-renewal, cancel your subscription following these simple steps:</p>
            <ol>
                <li>Open the <strong>Google Play Store</strong> app on your Android device.</li>
                <li>Tap your <strong>Profile Icon</strong> in the top-right corner.</li>
                <li>Select <strong>Payments & subscriptions</strong> &gt; <strong>Subscriptions</strong>.</li>
                <li>Select <strong>{{ $appName }}</strong> and tap <strong>Cancel Subscription</strong>.</li>
            </ol>
            <p>
                <em>Note: Uninstalling the {{ $appName }} mobile app does NOT automatically cancel your active subscription. You must cancel it through the Google Play subscription manager as described above.</em>
            </p>
        </section>

        <section>
            <h2>3. Virtual Goods & Consumable Dice Rolls</h2>
            <p>
                Virtual goods, including one-time dice roll booster packs and spotlight tokens, are classified as <strong>consumable digital items</strong>:
            </p>
            <ul>
                <li>Consumable items are unlocked and made immediately available for gameplay upon successful payment.</li>
                <li>Once consumed or activated within the App, virtual coin and roll purchases are strictly non-refundable and non-exchangeable for fiat currency.</li>
            </ul>
        </section>

        <section>
            <h2>4. Refund Eligibility & Request Process</h2>
            <p>
                Refund eligibility for purchases completed through Google Play is governed primarily by <strong>Google Play's standard refund policies</strong>:
            </p>
            <ul>
                <li><strong>Within 48 Hours:</strong> You may request a direct refund through Google Play by visiting <a href="https://play.google.com/store/account/orderhistory" target="_blank" rel="noopener">Google Play Order History</a> and selecting "Request a refund".</li>
                <li><strong>Technical Glitches / Double Charges:</strong> If you experienced a duplicate billing error or technical delivery failure where purchased benefits were not credited to your account, please contact our billing team at <a href="mailto:{{ $billingEmail }}">{{ $billingEmail }}</a> with your Google Play Order ID (GPA.XXXX-XXXX-XXXX-XXXXX) for rapid manual resolution.</li>
            </ul>
        </section>

        <section>
            <h2>5. Contact Billing Support</h2>
            <div class="glass-panel" style="padding: 24px; margin-top: 16px;">
                <h5 style="color: var(--text-primary); font-size: 1.1rem; margin-bottom: 6px;">{{ $appName }} Billing & Payments Desk</h5>
                <p style="margin: 4px 0; font-size: 0.95rem;"><strong>Email:</strong> <a href="mailto:{{ $billingEmail }}">{{ $billingEmail }}</a></p>
                <p style="margin: 4px 0; font-size: 0.95rem;"><strong>Support Portal:</strong> <a href="{{ route('contact') }}">{{ route('contact') }}</a></p>
                <p style="margin: 4px 0; font-size: 0.95rem;"><strong>Resolution SLA:</strong> Billing tickets are processed within 24 to 48 hours.</p>
            </div>
        </section>

    </div>
</div>
@endsection
