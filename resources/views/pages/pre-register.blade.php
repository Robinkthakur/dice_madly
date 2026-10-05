@extends('layouts.app')

@section('title', 'Pre-Register - ' . config('app.name', 'Dice Madly'))
@section('meta_description', 'Dice Madly is launching soon! Pre-register today and be among the first to experience serendipitous dice roll matchmaking.')

@section('content')
@push('styles')
<style>
    .pre-register-layout {
        display: grid;
        grid-template-columns: 1fr 1.15fr;
        gap: 36px;
        align-items: start;
    }
    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }
    .form-grid-phone-age {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 14px;
    }
    .platform-cards-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 10px;
    }
    @media (max-width: 900px) {
        .pre-register-layout {
            grid-template-columns: 1fr;
            gap: 28px;
        }
    }
    @media (max-width: 600px) {
        .form-grid-2, .form-grid-phone-age {
            grid-template-columns: 1fr;
            gap: 0;
        }
        .platform-cards-grid {
            grid-template-columns: 1fr;
            gap: 8px;
        }
    }
</style>
@endpush
<!-- Early Access Hero Header -->
<div class="policy-page-header" style="padding: 60px 0 40px; text-align: center;">
    <div class="container" style="max-width: 800px; margin: 0 auto;">
        <span class="policy-badge" style="background: #fff1f2; border-color: #fecdd3; color: var(--primary); font-weight: 700; margin-bottom: 16px; display: inline-flex; align-items: center; gap: 8px;">
            <span style="width: 8px; height: 8px; border-radius: 50%; background: var(--primary); display: inline-block; animation: pulse 2s infinite;"></span>
            📍 LAUNCHING INITIALLY IN BANGALORE • COMING SOON
        </span>
        <h1 style="font-size: clamp(2.2rem, 4vw, 3.2rem); line-height: 1.15; margin-bottom: 16px;">
            Be First In Line For <span class="gradient-text">True Connection</span>.
        </h1>
        <p style="color: var(--text-secondary); font-size: 1.1rem; line-height: 1.6; max-width: 640px; margin: 0 auto 24px;">
            Dice Madly is currently in active development, launching initially in <strong>Bangalore</strong>. Pre-register your spot today to secure exclusive <strong>Founder Perks</strong> and get notified the moment we go live on the App Store & Google Play.
        </p>

        <!-- Social Proof Stats -->
        <div style="display: inline-flex; align-items: center; gap: 16px; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px); border: 1px solid var(--border-subtle); padding: 10px 24px; border-radius: var(--radius-full); box-shadow: var(--shadow-sm);">
            <div style="display: flex; margin-right: -8px;">
                <span style="display: inline-block; width: 28px; height: 28px; border-radius: 50%; background: #f43f5e; color: #fff; text-align: center; line-height: 28px; font-size: 14px; border: 2px solid #fff;">🎲</span>
                <span style="display: inline-block; width: 28px; height: 28px; border-radius: 50%; background: #8b5cf6; color: #fff; text-align: center; line-height: 28px; font-size: 14px; border: 2px solid #fff; margin-left: -8px;">✨</span>
                <span style="display: inline-block; width: 28px; height: 28px; border-radius: 50%; background: #059669; color: #fff; text-align: center; line-height: 28px; font-size: 14px; border: 2px solid #fff; margin-left: -8px;">🌟</span>
            </div>
            <span style="font-size: 0.92rem; font-weight: 600; color: var(--text-primary);">
                <strong style="color: var(--primary);">{{ $displayCount }}</strong> singles already pre-registered!
            </span>
        </div>
    </div>
</div>

<div class="container" style="max-width: 1080px; margin: 0 auto 90px;">
    <div class="pre-register-layout">
        
        <!-- Left: Founder Perks & What to Expect -->
        <div>
            <!-- Perks Card -->
            <div class="glass-panel" style="padding: 32px; margin-bottom: 24px; border-color: rgba(225, 29, 72, 0.2);">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 18px;">
                    <span style="font-size: 1.6rem;">🎁</span>
                    <div>
                        <h3 style="margin: 0; font-size: 1.3rem;">Early Bird Founder Rewards</h3>
                        <p style="margin: 0; font-size: 0.85rem; color: var(--text-muted);">Free for all users who pre-register before launch</p>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 18px; margin-top: 20px;">
                    <div style="display: flex; gap: 14px; align-items: flex-start;">
                        <div style="width: 36px; height: 36px; border-radius: 10px; background: #ecfdf5; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; color: var(--accent-green); font-weight: bold;">
                            🎲
                        </div>
                        <div>
                            <strong style="color: var(--text-primary); font-size: 0.95rem; display: block;">10 Free Daily Dice Rolls</strong>
                            <span style="font-size: 0.85rem; color: var(--text-secondary);">Double the regular free daily rolls for 6 months after official release.</span>
                        </div>
                    </div>

                    <div style="display: flex; gap: 14px; align-items: flex-start;">
                        <div style="width: 36px; height: 36px; border-radius: 10px; background: #eff6ff; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; color: #2563eb; font-weight: bold;">
                            🛡️
                        </div>
                        <div>
                            <strong style="color: var(--text-primary); font-size: 0.95rem; display: block;">Priority KYC Badge & Queue</strong>
                            <span style="font-size: 0.85rem; color: var(--text-secondary);">Get verified first with an exclusive "Founding Member" profile badge.</span>
                        </div>
                    </div>

                    <div style="display: flex; gap: 14px; align-items: flex-start;">
                        <div style="width: 36px; height: 36px; border-radius: 10px; background: #faf5ff; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; color: var(--accent-purple); font-weight: bold;">
                            🔔
                        </div>
                        <div>
                            <strong style="color: var(--text-primary); font-size: 0.95rem; display: block;">Launch Day Direct Access Link</strong>
                            <span style="font-size: 0.85rem; color: var(--text-secondary);">Receive an instant SMS / email download invite as soon as the app goes live.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trust & Privacy Panel -->
            <div class="glass-panel" style="padding: 24px 28px;">
                <h4 style="font-size: 1rem; margin-bottom: 12px; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                    <span>🔒</span> Zero Spam & Privacy Commitment
                </h4>
                <p style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.6; margin: 0;">
                    Your data is never shared or sold. We will only reach out to inform you of the official application launch, beta invitations, and to credit your early-bird founder rewards.
                </p>
            </div>
        </div>

        <!-- Right: Pre-Registration Form / Success Screen -->
        <div>
            <div class="glass-panel" style="padding: 36px; box-shadow: var(--shadow-elevated); position: relative;">
                
                <!-- If already pre-registered info banner -->
                @if(session('info_notice'))
                    <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: var(--radius-md); padding: 20px; margin-bottom: 24px;">
                        <div style="display: flex; gap: 12px; align-items: flex-start;">
                            <span style="font-size: 1.5rem;">ℹ️</span>
                            <div>
                                <h4 style="margin: 0 0 4px; color: #1e40af; font-size: 1.05rem;">You're Already Pre-Registered!</h4>
                                <p style="margin: 0; font-size: 0.9rem; color: #1e3a8a; line-height: 1.5;">
                                    {{ session('info_notice')['message'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Success Card -->
                @if(session('pre_register_success'))
                    <div style="background: #ecfdf5; border: 1.5px solid #a7f3d0; border-radius: var(--radius-lg); padding: 28px; text-align: center; margin-bottom: 24px; animation: fadeIn 0.4s ease;">
                        <div style="font-size: 3rem; margin-bottom: 12px;">🎉</div>
                        <h3 style="color: #065f46; font-size: 1.4rem; margin-bottom: 8px;">Spot Confirmed!</h3>
                        <p style="color: #047857; font-size: 0.95rem; margin-bottom: 16px; line-height: 1.5;">
                            {{ session('pre_register_success')['message'] }}
                        </p>

                        <div style="background: #ffffff; border: 1px dashed #059669; border-radius: var(--radius-md); padding: 16px; margin: 18px 0; display: inline-block; width: 100%;">
                            <span style="font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); display: block; margin-bottom: 4px;">Your Founder Access Ticket</span>
                            <span style="font-family: monospace; font-size: 1.4rem; font-weight: 800; color: var(--primary); letter-spacing: 0.1em;">
                                {{ session('pre_register_success')['ticket'] }}
                            </span>
                        </div>

                        <p style="font-size: 0.85rem; color: #065f46; margin: 0;">
                            A confirmation note has been scheduled for <strong>{{ session('pre_register_success')['email'] }}</strong>. Keep your ticket code safe for official launch updates!
                        </p>
                    </div>
                @endif

                <div style="margin-bottom: 22px;">
                    <span class="section-tag" style="margin-bottom: 6px;">Pre-Register</span>
                    <h2 style="font-size: 1.6rem; margin-bottom: 8px;">Claim Your Founder Spot</h2>
                    <p style="font-size: 0.9rem; color: var(--text-secondary); margin: 0;">
                        Takes under 30 seconds. No credit card required.
                    </p>
                </div>

                @if ($errors->any())
                    <div style="background: #fff1f2; border: 1px solid #fecdd3; border-radius: var(--radius-md); padding: 14px 18px; margin-bottom: 22px;">
                        <strong style="color: #9f1239; font-size: 0.9rem; display: block; margin-bottom: 6px;">Please review the following:</strong>
                        <ul style="margin: 0; padding-left: 20px; color: #be123c; font-size: 0.85rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pre-register.submit') }}" method="POST" id="preRegisterForm">
                    @csrf

                    <!-- Full Name -->
                    <div class="form-group">
                        <label class="form-label" for="name">
                            Full Name <span style="color: var(--primary);">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               class="form-input @error('name') is-invalid @enderror" 
                               placeholder="e.g. Aanya Sharma" 
                               value="{{ old('name') }}" 
                               required>
                        @error('name')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="form-group">
                        <label class="form-label" for="email">
                            Email Address <span style="color: var(--primary);">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="form-input @error('email') is-invalid @enderror" 
                               placeholder="you@example.com" 
                               value="{{ old('email') }}" 
                               required>
                        <span style="font-size: 0.78rem; color: var(--text-muted); margin-top: 4px; display: block;">
                            We will send your launch key to this address.
                        </span>
                        @error('email')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone Number & Age (2-col) -->
                    <div class="form-grid-phone-age">
                        <div class="form-group">
                            <label class="form-label" for="phone">Phone Number (Optional)</label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   class="form-input @error('phone') is-invalid @enderror" 
                                   placeholder="+91 98765 43210" 
                                   value="{{ old('phone') }}">
                            @error('phone')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="age">Age (18+)</label>
                            <input type="number" 
                                   id="age" 
                                   name="age" 
                                   min="18" 
                                   max="99" 
                                   class="form-input @error('age') is-invalid @enderror" 
                                   placeholder="e.g. 24" 
                                   value="{{ old('age') }}">
                            @error('age')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Gender & Interested In (2-col) -->
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="gender">Gender</label>
                            <select id="gender" name="gender" class="form-select @error('gender') is-invalid @enderror">
                                <option value="">Select Gender</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other / Non-binary</option>
                            </select>
                            @error('gender')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="interested_in">Looking For</label>
                            <select id="interested_in" name="interested_in" class="form-select @error('interested_in') is-invalid @enderror">
                                <option value="both" {{ old('interested_in') == 'both' || !old('interested_in') ? 'selected' : '' }}>Both Dating & Matrimony</option>
                                <option value="dating" {{ old('interested_in') == 'dating' ? 'selected' : '' }}>Dating & Romance</option>
                                <option value="matrimony" {{ old('interested_in') == 'matrimony' ? 'selected' : '' }}>Serious Matrimony</option>
                            </select>
                            @error('interested_in')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- City / Location -->
                    <div class="form-group">
                        <label class="form-label" for="city">City / Region (Optional)</label>
                        <input type="text" 
                               id="city" 
                               name="city" 
                               class="form-input @error('city') is-invalid @enderror" 
                               placeholder="e.g. Bangalore / Bengaluru (Initial Launch City), Delhi, Mumbai..." 
                               value="{{ old('city') }}">
                        <div style="font-size: 0.76rem; color: var(--primary); margin-top: 5px; font-weight: 600;">
                            📍 Priority early access onboarding for Bangalore / Bengaluru residents!
                        </div>
                        @error('city')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Preferred Platform (Visual Cards) -->
                    <div class="form-group">
                        <label class="form-label" style="margin-bottom: 8px;">
                            Your Smartphone Platform <span style="color: var(--primary);">*</span>
                        </label>
                        <div class="platform-cards-grid">
                            <label style="cursor: pointer; border: 1.5px solid var(--border-subtle); border-radius: var(--radius-md); padding: 12px 10px; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 6px; transition: var(--transition-smooth); background: #ffffff;" class="platform-option">
                                <input type="radio" name="preferred_platform" value="android" {{ old('preferred_platform', 'android') == 'android' ? 'checked' : '' }} style="display: none;">
                                <span style="font-size: 1.4rem;">🤖</span>
                                <span style="font-size: 0.82rem; font-weight: 700; color: var(--text-primary);">Android</span>
                                <span style="font-size: 0.72rem; color: var(--text-muted);">Google Play</span>
                            </label>

                            <label style="cursor: pointer; border: 1.5px solid var(--border-subtle); border-radius: var(--radius-md); padding: 12px 10px; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 6px; transition: var(--transition-smooth); background: #ffffff;" class="platform-option">
                                <input type="radio" name="preferred_platform" value="ios" {{ old('preferred_platform') == 'ios' ? 'checked' : '' }} style="display: none;">
                                <span style="font-size: 1.4rem;">🍎</span>
                                <span style="font-size: 0.82rem; font-weight: 700; color: var(--text-primary);">iPhone</span>
                                <span style="font-size: 0.72rem; color: var(--text-muted);">iOS App Store</span>
                            </label>

                            <label style="cursor: pointer; border: 1.5px solid var(--border-subtle); border-radius: var(--radius-md); padding: 12px 10px; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 6px; transition: var(--transition-smooth); background: #ffffff;" class="platform-option">
                                <input type="radio" name="preferred_platform" value="both" {{ old('preferred_platform') == 'both' ? 'checked' : '' }} style="display: none;">
                                <span style="font-size: 1.4rem;">📱</span>
                                <span style="font-size: 0.82rem; font-weight: 700; color: var(--text-primary);">Both</span>
                                <span style="font-size: 0.72rem; color: var(--text-muted);">Multiple Devices</span>
                            </label>
                        </div>
                        @error('preferred_platform')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Terms Agreement Checkbox -->
                    <div style="margin: 20px 0 24px;">
                        <label class="form-checkbox-label">
                            <input type="checkbox" name="agree_terms" value="1" {{ old('agree_terms') ? 'checked' : '' }} required>
                            <span style="font-size: 0.84rem; color: var(--text-secondary); line-height: 1.5;">
                                I agree to receive early access updates, launch notifications, and founder bonus perks from Dice Madly. I understand that my details will remain confidential under the <a href="{{ route('privacy') }}" target="_blank" style="color: var(--primary); text-decoration: underline;">Privacy Policy</a>.
                            </span>
                        </label>
                        @error('agree_terms')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 1rem; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <span>🎲 Pre-Register</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    // Platform selector styling
    document.addEventListener('DOMContentLoaded', () => {
        const platformLabels = document.querySelectorAll('.platform-option');
        
        function updatePlatformStyles() {
            platformLabels.forEach(label => {
                const radio = label.querySelector('input[type="radio"]');
                if (radio && radio.checked) {
                    label.style.borderColor = 'var(--primary)';
                    label.style.backgroundColor = '#fff1f2';
                    label.style.boxShadow = '0 0 0 1px var(--primary)';
                } else {
                    label.style.borderColor = 'var(--border-subtle)';
                    label.style.backgroundColor = '#ffffff';
                    label.style.boxShadow = 'none';
                }
            });
        }

        platformLabels.forEach(label => {
            label.addEventListener('click', () => {
                const radio = label.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                    updatePlatformStyles();
                }
            });
        });

        updatePlatformStyles();
    });
</script>
@endpush
