@extends('layouts.app')

@section('title', 'Rent Boyfriend or Girlfriend & Companion Partner Registration - ' . config('app.name', 'Dice Madly'))
@section('meta_description', 'Looking to rent a friendly boyfriend or girlfriend companion for dinners, events, or social outings? Or register as a rental partner to earn with verified safety.')

@push('styles')
<style>
    /* Rent Companion Custom Styling */
    .rent-hero-section {
        position: relative;
        padding: 50px 0 80px;
        overflow: hidden;
    }

    .rent-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 16px;
        border-radius: var(--radius-full);
        background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%);
        border: 1px solid #fecdd3;
        color: var(--primary);
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        margin-bottom: 16px;
        box-shadow: 0 2px 10px rgba(225, 29, 72, 0.1);
    }

    .rent-header-title {
        font-family: var(--font-heading);
        font-size: clamp(2rem, 4vw, 3.2rem);
        font-weight: 900;
        line-height: 1.15;
        letter-spacing: -0.03em;
        color: var(--text-primary);
        margin-bottom: 14px;
    }

    .rent-header-title span.gradient-text {
        background: linear-gradient(135deg, #e11d48 0%, #be123c 60%, #7c3aed 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .rent-header-subtitle {
        font-size: 1.12rem;
        color: var(--text-secondary);
        max-width: 680px;
        margin: 0 auto 36px;
        line-height: 1.6;
    }

    /* 3-Column Layout: Left Boy Card, Center Form, Right Girl Card */
    .companion-grid {
        display: grid;
        grid-template-columns: 310px 1fr 310px;
        gap: 28px;
        align-items: start;
    }

    @media (max-width: 1200px) {
        .companion-grid {
            grid-template-columns: 270px 1fr 270px;
            gap: 20px;
        }
    }

    @media (max-width: 991px) {
        .companion-grid {
            grid-template-columns: 1fr;
            max-width: 680px;
            margin: 0 auto;
        }

        .side-companion-card {
            display: none;
        }

        .mobile-companion-showcase {
            display: grid !important;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 24px;
        }
    }

    @media (min-width: 992px) {
        .mobile-companion-showcase {
            display: none !important;
        }
    }

    /* Side Companion Showcase Cards */
    .side-companion-card {
        background: #ffffff;
        border-radius: var(--radius-xl);
        border: 1px solid var(--border-subtle);
        box-shadow: var(--shadow-elevated);
        overflow: hidden;
        transition: var(--transition-smooth);
        position: sticky;
        top: 90px;
    }

    .side-companion-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 35px -8px rgba(0, 0, 0, 0.12);
    }

    .side-companion-card.active-highlight {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.2), 0 20px 35px -8px rgba(225, 29, 72, 0.25);
    }

    .companion-img-wrapper {
        position: relative;
        width: 100%;
        height: 380px;
        overflow: hidden;
        background: #f1f5f9;
    }

    .companion-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center top;
        transition: transform 0.5s ease;
    }

    .side-companion-card:hover .companion-img-wrapper img {
        transform: scale(1.04);
    }

    .img-gradient-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.05) 0%, rgba(0, 0, 0, 0.3) 60%, rgba(15, 23, 42, 0.9) 100%);
    }

    .img-floating-badge {
        position: absolute;
        top: 14px;
        padding: 5px 12px;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 0.03em;
        backdrop-filter: blur(8px);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-boy {
        left: 14px;
        background: rgba(30, 58, 138, 0.85);
        color: #ffffff;
        border: 1px solid rgba(147, 197, 253, 0.4);
    }

    .badge-girl {
        right: 14px;
        background: rgba(190, 18, 60, 0.85);
        color: #ffffff;
        border: 1px solid rgba(254, 205, 211, 0.4);
    }

    .img-info-overlay {
        position: absolute;
        bottom: 16px;
        left: 16px;
        right: 16px;
        color: #ffffff;
    }

    .img-info-overlay h4 {
        font-size: 1.25rem;
        font-weight: 800;
        margin-bottom: 2px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }

    .img-info-overlay p {
        font-size: 0.82rem;
        color: #e2e8f0;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .companion-card-body {
        padding: 20px;
    }

    .feature-tag-list {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 16px;
    }

    .feature-tag {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 4px 9px;
        border-radius: var(--radius-full);
        background: #f1f5f9;
        color: var(--text-secondary);
        border: 1px solid var(--border-subtle);
    }

    .companion-quote {
        font-size: 0.85rem;
        font-style: italic;
        color: var(--text-secondary);
        background: #f8fafc;
        border-left: 3px solid var(--primary);
        padding: 10px 12px;
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        margin-bottom: 14px;
        line-height: 1.5;
    }

    .btn-select-target {
        width: 100%;
        padding: 9px 14px;
        border-radius: var(--radius-md);
        font-size: 0.84rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: var(--transition-smooth);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-select-boy {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .btn-select-boy:hover {
        background: #1d4ed8;
        color: #ffffff;
    }

    .btn-select-girl {
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
    }

    .btn-select-girl:hover {
        background: #e11d48;
        color: #ffffff;
    }

    /* Main Form Container */
    .rent-form-card {
        background: #ffffff;
        border-radius: var(--radius-xl);
        border: 1px solid var(--border-subtle);
        box-shadow: 0 20px 45px -12px rgba(0, 0, 0, 0.08);
        padding: 32px 36px;
        position: relative;
    }

    @media (max-width: 640px) {
        .rent-form-card {
            padding: 24px 18px;
        }
    }

    /* Role/Mode Switcher Tabs */
    .mode-tab-nav {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        background: #f1f5f9;
        padding: 6px;
        border-radius: var(--radius-lg);
        margin-bottom: 28px;
    }

    .mode-tab-btn {
        padding: 12px 16px;
        border-radius: var(--radius-md);
        border: none;
        font-family: var(--font-heading);
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-secondary);
        background: transparent;
        cursor: pointer;
        transition: var(--transition-smooth);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .mode-tab-btn.active {
        background: #ffffff;
        color: var(--primary);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    /* Rent Boyfriend / Girlfriend Visual Toggle */
    .rent-target-toggle-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 22px;
    }

    .target-choice-card {
        border: 2px solid var(--border-subtle);
        border-radius: var(--radius-md);
        padding: 14px 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: var(--transition-smooth);
        background: #fafaf9;
    }

    .target-choice-card:hover {
        border-color: #cbd5e1;
        background: #ffffff;
    }

    .target-choice-card.selected {
        border-color: var(--primary);
        background: #fff1f2;
    }

    .target-choice-card input[type="radio"] {
        display: none;
    }

    .target-icon {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        background: #ffffff;
        box-shadow: var(--shadow-sm);
        flex-shrink: 0;
    }

    .target-text h5 {
        font-size: 0.95rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 2px;
    }

    .target-text p {
        font-size: 0.74rem;
        color: var(--text-muted);
        line-height: 1.3;
    }

    /* Form Fields */
    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 6px;
    }

    .form-group label .required-dot {
        color: var(--primary);
        margin-left: 2px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-subtle);
        background: #ffffff;
        font-family: var(--font-body);
        font-size: 0.92rem;
        color: var(--text-primary);
        transition: var(--transition-smooth);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.12);
    }

    .form-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    @media (max-width: 600px) {
        .form-row-2 {
            grid-template-columns: 1fr;
        }
    }

    /* Success Alert */
    .success-receipt-card {
        background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 100%);
        border: 2px solid #a7f3d0;
        border-radius: var(--radius-lg);
        padding: 24px;
        margin-bottom: 24px;
        position: relative;
    }

    .receipt-code {
        font-family: monospace;
        font-size: 1.15rem;
        font-weight: 800;
        background: #ffffff;
        color: #059669;
        padding: 4px 12px;
        border-radius: var(--radius-sm);
        border: 1px dashed #6ee7b7;
        display: inline-block;
        margin: 6px 0;
    }

    /* Guarantees Badge Row */
    .guarantees-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid var(--border-subtle);
    }

    @media (max-width: 600px) {
        .guarantees-row {
            grid-template-columns: 1fr;
        }
    }

    .guarantee-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.78rem;
        color: var(--text-secondary);
        font-weight: 600;
    }

    .guarantee-icon {
        width: 24px;
        height: 24px;
        border-radius: var(--radius-full);
        background: #fff1f2;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        flex-shrink: 0;
    }
</style>
@endpush

@section('content')
<div class="rent-hero-section">
    <div class="container">
        
        <!-- Header Introduction -->
        <div style="text-align: center; max-width: 780px; margin: 0 auto 36px;">
            <div class="rent-badge">
                <span>🚀 Official Companion & Partner Survey • Launching Initially in Bangalore</span>
            </div>
            <h1 class="rent-header-title">
                Rent a <span class="gradient-text">Boyfriend</span> or <span class="gradient-text">Girlfriend</span>
            </h1>
            <p class="rent-header-subtitle">
                Looking for a charming date for an event, dinner, cafe outing, or friendly conversation? Or register as a verified companion partner in <strong>Bangalore</strong> to provide safe, respectful rental services.
            </p>
        </div>

        <!-- Mobile Companion Preview Cards (shown on small screens) -->
        <div class="mobile-companion-showcase">
            <div style="background: #ffffff; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); overflow: hidden; box-shadow: var(--shadow-sm);">
                <div style="height: 180px; position: relative;">
                    <img src="{{ asset('images/rent/boy_companion.jpg') }}" alt="Boyfriend Companion" style="width: 100%; height: 100%; object-fit: cover;">
                    <div class="img-floating-badge badge-boy">👨 Boyfriend</div>
                </div>
                <div style="padding: 10px; text-align: center;">
                    <strong style="font-size: 0.85rem; color: var(--text-primary); display: block;">Chivalrous & Attentive</strong>
                    <span style="font-size: 0.72rem; color: var(--text-muted);">Dinner • Events • Movies</span>
                </div>
            </div>

            <div style="background: #ffffff; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); overflow: hidden; box-shadow: var(--shadow-sm);">
                <div style="height: 180px; position: relative;">
                    <img src="{{ asset('images/rent/girl_companion.jpg') }}" alt="Girlfriend Companion" style="width: 100%; height: 100%; object-fit: cover;">
                    <div class="img-floating-badge badge-girl">👩 Girlfriend</div>
                </div>
                <div style="padding: 10px; text-align: center;">
                    <strong style="font-size: 0.85rem; color: var(--text-primary); display: block;">Charming & Sweet</strong>
                    <span style="font-size: 0.72rem; color: var(--text-muted);">Cafe • Plus-One • Chats</span>
                </div>
            </div>
        </div>

        <!-- Main 3-Column Layout: Left Boy Card | Center Form | Right Girl Card -->
        <div class="companion-grid">
            
            <!-- LEFT COLUMN: Boy Companion Card -->
            <div class="side-companion-card" id="boyCompanionCard">
                <div class="companion-img-wrapper">
                    <img src="{{ asset('images/rent/boy_companion.jpg') }}" alt="Boyfriend Companion Service">
                    <div class="img-gradient-overlay"></div>
                    <div class="img-floating-badge badge-boy">
                        <span>🛡️ Verified Companion</span>
                    </div>
                    <div class="img-info-overlay">
                        <h4>Boyfriend Companion</h4>
                        <p>
                            <span>⭐ 4.95 Rating</span>
                            <span>•</span>
                            <span>100% Chivalrous</span>
                        </p>
                    </div>
                </div>
                <div class="companion-card-body">
                    <div class="feature-tag-list">
                        <span class="feature-tag">🎩 Well Groomed</span>
                        <span class="feature-tag">🥂 Dinner Dates</span>
                        <span class="feature-tag">🎭 Family Events</span>
                        <span class="feature-tag">🎧 Attentive Listener</span>
                        <span class="feature-tag">💼 Plus-One</span>
                    </div>
                    <div class="companion-quote">
                        "Make any family function, friends meetup, or dinner date relaxing and memorable with an educated, polite gentleman."
                    </div>
                    <button type="button" class="btn-select-target btn-select-boy" onclick="selectRentTarget('boyfriend')">
                        <span>Select Boyfriend Companion 👨</span>
                    </button>
                </div>
            </div>

            <!-- CENTER COLUMN: Interactive Survey & Registration Form -->
            <div class="rent-form-card">
                
                @if(session('rental_success'))
                    <div class="success-receipt-card">
                        <div style="display: flex; align-items: flex-start; gap: 14px;">
                            <div style="font-size: 2rem;">🎉</div>
                            <div style="flex: 1;">
                                <h3 style="color: #065f46; font-size: 1.25rem; font-weight: 800; margin-bottom: 4px;">
                                    Registration Successful!
                                </h3>
                                <p style="color: #047857; font-size: 0.92rem; margin-bottom: 8px;">
                                    {{ session('rental_success.message') }}
                                </p>
                                <div>
                                    <span style="font-size: 0.8rem; color: #065f46; font-weight: 600;">Your Reference Code:</span>
                                    <div class="receipt-code">{{ session('rental_success.reference_no') }}</div>
                                </div>
                                <p style="font-size: 0.82rem; color: #047857; margin-top: 6px;">
                                    🔒 All information is kept strictly confidential under Dice Madly's Privacy & Safety Charter.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div style="background: #fef2f2; border: 1px solid #fecdd3; border-radius: var(--radius-md); padding: 14px 18px; margin-bottom: 22px;">
                        <div style="color: #991b1b; font-weight: 700; font-size: 0.9rem; margin-bottom: 6px;">
                            Please correct the errors below:
                        </div>
                        <ul style="color: #b91c1c; font-size: 0.85rem; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Mode Switcher Tabs: Rent Companion VS Register as Partner -->
                <div class="mode-tab-nav">
                    <button type="button" class="mode-tab-btn {{ old('type', $defaultType) === 'client' ? 'active' : '' }}" id="tabClientBtn" onclick="setFormMode('client')">
                        <span>❤️ Looking to Rent</span>
                    </button>
                    <button type="button" class="mode-tab-btn {{ old('type', $defaultType) === 'partner' ? 'active' : '' }}" id="tabPartnerBtn" onclick="setFormMode('partner')">
                        <span>💼 Register as Partner</span>
                    </button>
                </div>

                <form action="{{ route('rent-companion.submit') }}" method="POST" id="companionRentalForm">
                    @csrf
                    
                    <!-- Hidden Mode Field (client or partner) -->
                    <input type="hidden" name="type" id="inputFormType" value="{{ old('type', $defaultType) }}">

                    <!-- Visual Rent Toggle: Boyfriend or Girlfriend (for both modes) -->
                    <div class="form-group">
                        <label id="targetSectionLabel">
                            <span id="labelPrefix">I want to rent a</span>
                            <span class="required-dot">*</span>
                        </label>
                        <div class="rent-target-toggle-grid">
                            
                            <!-- Option 1: Boyfriend -->
                            <label class="target-choice-card {{ old('rent_target', $defaultTarget) === 'boyfriend' ? 'selected' : '' }}" id="choiceCardBoyfriend">
                                <input type="radio" name="rent_target" value="boyfriend" {{ old('rent_target', $defaultTarget) === 'boyfriend' ? 'checked' : '' }} onchange="onTargetRadioChange('boyfriend')">
                                <div class="target-icon">👨</div>
                                <div class="target-text">
                                    <h5 id="titleBoyfriend">Boyfriend</h5>
                                    <p id="descBoyfriend">Polite gentleman, dinner & outings</p>
                                </div>
                            </label>

                            <!-- Option 2: Girlfriend -->
                            <label class="target-choice-card {{ old('rent_target', $defaultTarget) === 'girlfriend' ? 'selected' : '' }}" id="choiceCardGirlfriend">
                                <input type="radio" name="rent_target" value="girlfriend" {{ old('rent_target', $defaultTarget) === 'girlfriend' ? 'checked' : '' }} onchange="onTargetRadioChange('girlfriend')">
                                <div class="target-icon">👩</div>
                                <div class="target-text">
                                    <h5 id="titleGirlfriend">Girlfriend</h5>
                                    <p id="descGirlfriend">Sweet companion, cafes & events</p>
                                </div>
                            </label>

                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="form-row-2">
                        <div class="form-group">
                            <label for="inputName">Full Name <span class="required-dot">*</span></label>
                            <input type="text" name="name" id="inputName" class="form-control" placeholder="e.g. Alex Johnson" value="{{ old('name') }}" required maxlength="100">
                        </div>

                        <div class="form-group">
                            <label for="inputEmail">Email Address <span class="required-dot">*</span></label>
                            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="e.g. alex@example.com" value="{{ old('email') }}" required maxlength="150">
                        </div>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label for="inputPhone">Mobile / WhatsApp Number <span class="required-dot">*</span></label>
                            <input type="tel" name="phone" id="inputPhone" class="form-control" placeholder="e.g. +91 98765 43210" value="{{ old('phone') }}" required maxlength="25">
                        </div>

                        <div class="form-group">
                            <label for="selectGender">Your Gender <span class="required-dot">*</span></label>
                            <select name="gender" id="selectGender" class="form-control" required>
                                <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select your gender</option>
                                <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other / Non-binary</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label for="inputAge">Your Age (18+) <span class="required-dot">*</span></label>
                            <input type="number" name="age" id="inputAge" class="form-control" placeholder="e.g. 24" value="{{ old('age') }}" min="18" max="99">
                        </div>

                        <div class="form-group">
                            <label for="inputCity">City / Location</label>
                            <input type="text" name="city" id="inputCity" class="form-control" placeholder="e.g. Bangalore / Bengaluru (Initial Launch City)" value="{{ old('city') }}" maxlength="100">
                        </div>
                    </div>

                    <!-- Client-Specific Fields -->
                    <div id="clientSpecificFields" style="{{ old('type', $defaultType) === 'partner' ? 'display: none;' : '' }}">
                        <div class="form-row-2">
                            <div class="form-group">
                                <label for="inputDuration">Preferred Occasion / Duration</label>
                                <input type="text" name="duration_hours" id="inputDuration" class="form-control" placeholder="e.g. 2-3 Hours Dinner, Evening Wedding" value="{{ old('duration_hours') }}">
                            </div>

                            <div class="form-group">
                                <label for="inputBudget">Expected Budget Range</label>
                                <input type="text" name="budget_or_rate" id="inputBudget" class="form-control" placeholder="e.g. ₹1,500 - ₹3,000 / hour" value="{{ old('budget_or_rate') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputRemarks">Special Remarks / Preferred Personality Traits</label>
                            <textarea name="remarks" id="inputRemarks" class="form-control" rows="3" placeholder="Tell us what kind of vibe, conversation topics, dress code, or occasion you have in mind...">{{ old('remarks') }}</textarea>
                        </div>
                    </div>

                    <!-- Partner-Specific Fields (for Partner Registration) -->
                    <div id="partnerSpecificFields" style="{{ old('type', $defaultType) === 'partner' ? '' : 'display: none;' }}">
                        <div class="form-row-2">
                            <div class="form-group">
                                <label for="inputPartnerRate">Expected Hourly Compensation</label>
                                <input type="text" name="budget_or_rate" id="inputPartnerRate" class="form-control" placeholder="e.g. ₹1,500/hr, Negotiable" value="{{ old('budget_or_rate') }}">
                            </div>

                            <div class="form-group">
                                <label for="inputPartnerDuration">Available Timings / Days</label>
                                <input type="text" name="duration_hours" id="inputPartnerDuration" class="form-control" placeholder="e.g. Weekends, Weekday Evenings" value="{{ old('duration_hours') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputHobbies">Hobbies, Languages & Interests</label>
                            <input type="text" name="hobbies_interests" id="inputHobbies" class="form-control" placeholder="e.g. English & Hindi, Travel, Coffee, Music, Fine Dining" value="{{ old('hobbies_interests') }}">
                        </div>

                        <div class="form-group">
                            <label for="inputExperience">About You / Companion Profile Bio</label>
                            <textarea name="partner_experience" id="inputExperience" class="form-control" rows="3" placeholder="Briefly describe your personality, communication style, hobbies, and why you would be a wonderful rental companion...">{{ old('partner_experience') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="inputPartnerRemarks">Additional Remarks / Boundaries</label>
                            <textarea name="remarks" id="inputPartnerRemarks" class="form-control" rows="2" placeholder="Any special preferences, safety boundaries, or areas of the city you prefer...">{{ old('remarks') }}</textarea>
                        </div>
                    </div>

                    <!-- Safety & Consent Checkbox -->
                    <div class="form-group" style="margin-top: 10px;">
                        <label style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer; font-size: 0.84rem; color: var(--text-secondary); font-weight: 500;">
                            <input type="checkbox" name="agree_guidelines" value="1" {{ old('agree_guidelines') ? 'checked' : '' }} required style="margin-top: 3px; accent-color: var(--primary);">
                            <span>
                                I confirm I am 18+ years old and agree to Dice Madly's <strong>Safe Companion Guidelines</strong>, respectful conduct pledge, and strict zero-tolerance harassment policy.
                            </span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary" id="btnSubmitForm" style="width: 100%; padding: 14px; font-size: 1.05rem; font-weight: 800; border-radius: var(--radius-md); margin-top: 8px; box-shadow: var(--shadow-glow);">
                        <span id="btnSubmitText">
                            {{ old('type', $defaultType) === 'partner' ? 'Submit Partner Application ✨' : 'Submit Rental Request 🚀' }}
                        </span>
                    </button>

                    <!-- Trust & Guarantee Indicators -->
                    <div class="guarantees-row">
                        <div class="guarantee-item">
                            <div class="guarantee-icon">🛡️</div>
                            <span>100% Verified Profiles</span>
                        </div>
                        <div class="guarantee-item">
                            <div class="guarantee-icon">🔒</div>
                            <span>Strict Privacy & Confidential</span>
                        </div>
                        <div class="guarantee-item">
                            <div class="guarantee-icon">🤝</div>
                            <span>Respectful & Safe Only</span>
                        </div>
                    </div>

                </form>
            </div>

            <!-- RIGHT COLUMN: Girl Companion Card -->
            <div class="side-companion-card" id="girlCompanionCard">
                <div class="companion-img-wrapper">
                    <img src="{{ asset('images/rent/girl_companion.jpg') }}" alt="Girlfriend Companion Service">
                    <div class="img-gradient-overlay"></div>
                    <div class="img-floating-badge badge-girl">
                        <span>🛡️ Verified Companion</span>
                    </div>
                    <div class="img-info-overlay">
                        <h4>Girlfriend Companion</h4>
                        <p>
                            <span>⭐ 4.98 Rating</span>
                            <span>•</span>
                            <span>Charming & Sweet</span>
                        </p>
                    </div>
                </div>
                <div class="companion-card-body">
                    <div class="feature-tag-list">
                        <span class="feature-tag">☕ Cafe Dates</span>
                        <span class="feature-tag">🎬 Movie Nights</span>
                        <span class="feature-tag">✨ Social Events</span>
                        <span class="feature-tag">💬 Meaningful Chats</span>
                        <span class="feature-tag">📸 Great Pictures</span>
                    </div>
                    <div class="companion-quote">
                        "Enjoy heartwarming company, vibrant laughter, and wonderful vibes for weekend strolls, fancy dinners, and celebrations."
                    </div>
                    <button type="button" class="btn-select-target btn-select-girl" onclick="selectRentTarget('girlfriend')">
                        <span>Select Girlfriend Companion 👩</span>
                    </button>
                </div>
            </div>

        </div>

        <!-- FAQ & Guidelines Section -->
        <div style="margin-top: 70px; background: #ffffff; border-radius: var(--radius-xl); border: 1px solid var(--border-subtle); padding: 40px; box-shadow: var(--shadow-sm);">
            <div style="text-align: center; max-width: 600px; margin: 0 auto 30px;">
                <h3 style="font-family: var(--font-heading); font-size: 1.6rem; font-weight: 800; color: var(--text-primary);">
                    Frequently Asked Questions
                </h3>
                <p style="color: var(--text-secondary); font-size: 0.92rem;">
                    Everything you need to know about our companion rental survey and partner onboarding.
                </p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
                <div style="padding: 16px; background: #f8fafc; border-radius: var(--radius-md); border: 1px solid var(--border-subtle);">
                    <h5 style="font-weight: 800; color: var(--text-primary); margin-bottom: 6px;">How does the rental companion service work?</h5>
                    <p style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.5;">
                        Clients looking for a companion for dinner, movies, weddings, or friendly conversations submit their preferences. Our concierge matches you with a verified, background-checked companion.
                    </p>
                </div>

                <div style="padding: 16px; background: #f8fafc; border-radius: var(--radius-md); border: 1px solid var(--border-subtle);">
                    <h5 style="font-weight: 800; color: var(--text-primary); margin-bottom: 6px;">Is this safe and respectful?</h5>
                    <p style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.5;">
                        Yes, absolutely! Dice Madly strictly enforces a platonic, safe, public-venues-only companionship code. All partners undergo KYC verification and ID checks.
                    </p>
                </div>

                <div style="padding: 16px; background: #f8fafc; border-radius: var(--radius-md); border: 1px solid var(--border-subtle);">
                    <h5 style="font-weight: 800; color: var(--text-primary); margin-bottom: 6px;">How can I earn as a rental partner?</h5>
                    <p style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.5;">
                        Switch to the "Register as Partner" tab, submit your application with your hobbies and availability. Once verified, you can accept companion bookings and earn on your schedule.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Tab Mode Toggle: Client (Looking to Rent) vs Partner (Register as Partner)
    function setFormMode(mode) {
        const inputType = document.getElementById('inputFormType');
        const tabClientBtn = document.getElementById('tabClientBtn');
        const tabPartnerBtn = document.getElementById('tabPartnerBtn');
        const clientFields = document.getElementById('clientSpecificFields');
        const partnerFields = document.getElementById('partnerSpecificFields');
        const labelPrefix = document.getElementById('labelPrefix');
        const titleBoyfriend = document.getElementById('titleBoyfriend');
        const titleGirlfriend = document.getElementById('titleGirlfriend');
        const descBoyfriend = document.getElementById('descBoyfriend');
        const descGirlfriend = document.getElementById('descGirlfriend');
        const btnSubmitText = document.getElementById('btnSubmitText');

        inputType.value = mode;

        if (mode === 'partner') {
            tabClientBtn.classList.remove('active');
            tabPartnerBtn.classList.add('active');
            clientFields.style.display = 'none';
            partnerFields.style.display = 'block';

            labelPrefix.textContent = 'I want to register as a';
            titleBoyfriend.textContent = 'Boyfriend Companion';
            titleGirlfriend.textContent = 'Girlfriend Companion';
            descBoyfriend.textContent = 'Provide chivalrous companionship & earn';
            descGirlfriend.textContent = 'Provide sweet, warm companionship & earn';
            btnSubmitText.textContent = 'Submit Partner Application ✨';
        } else {
            tabPartnerBtn.classList.remove('active');
            tabClientBtn.classList.add('active');
            partnerFields.style.display = 'none';
            clientFields.style.display = 'block';

            labelPrefix.textContent = 'I want to rent a';
            titleBoyfriend.textContent = 'Boyfriend';
            titleGirlfriend.textContent = 'Girlfriend';
            descBoyfriend.textContent = 'Polite gentleman, dinner & outings';
            descGirlfriend.textContent = 'Sweet companion, cafes & events';
            btnSubmitText.textContent = 'Submit Rental Request 🚀';
        }
    }

    // Toggle Selection for Boyfriend vs Girlfriend
    function selectRentTarget(target) {
        const radio = document.querySelector(`input[name="rent_target"][value="${target}"]`);
        if (radio) {
            radio.checked = true;
            onTargetRadioChange(target);
        }
    }

    function onTargetRadioChange(target) {
        const cardBf = document.getElementById('choiceCardBoyfriend');
        const cardGf = document.getElementById('choiceCardGirlfriend');
        const boySide = document.getElementById('boyCompanionCard');
        const girlSide = document.getElementById('girlCompanionCard');

        if (target === 'boyfriend') {
            cardBf.classList.add('selected');
            cardGf.classList.remove('selected');
            if (boySide) boySide.classList.add('active-highlight');
            if (girlSide) girlSide.classList.remove('active-highlight');
        } else {
            cardGf.classList.add('selected');
            cardBf.classList.remove('selected');
            if (girlSide) girlSide.classList.add('active-highlight');
            if (boySide) boySide.classList.remove('active-highlight');
        }
    }

    // Initialize highlight on load
    document.addEventListener('DOMContentLoaded', () => {
        const checked = document.querySelector('input[name="rent_target"]:checked');
        if (checked) {
            onTargetRadioChange(checked.value);
        }
    });
</script>
@endsection
