@extends('layouts.app')

@section('title', 'Dice Madly - Roll Into True Connection | Dating & Matrimony App')
@section('meta_description', 'Discover verified singles with Dice Madly. Roll the dice to unlock serendipitous high-compatibility matches, 100% selfie-verified profiles, and safe real-time messaging.')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-grid">
            <div class="hero-content">
                <div class="hero-pill">
                    <span class="dot"></span>
                    <span>The Next Generation Dating & Matrimony App</span>
                </div>

                <h1 class="hero-title">
                    Roll Into <span class="gradient-text">True Connection</span>.
                </h1>

                <p class="hero-desc">
                    Skip the endless superficial swiping. Experience the thrill of fate with our unique <strong>Dice Roll matchmaking algorithm</strong>, connecting you with 100% selfie-verified singles based on genuine compatibility, values, and location.
                </p>

                <!-- Store Download Buttons -->
                <div class="store-badges-group" id="download-app">
                    <a href="#download-android" class="store-btn" onclick="openDownloadModal('Google Play Store')">
                        <svg viewBox="0 0 512 512" fill="currentColor">
                            <path fill="#4285F4" d="M48.7 15.1c-4.4 4.8-7 12.3-7 21.6v438.6c0 9.3 2.6 16.8 7 21.6l1.2 1.1 245.4-245.4v-5.8L49.9 14l-1.2 1.1z"/>
                            <path fill="#FBBC04" d="M377.2 334.4l-81.9-81.9v-5.8l81.9-81.9 1.4.8 97.1 55.2c27.7 15.8 27.7 41.5 0 57.3l-97.1 55.2-1.4 1.1z"/>
                            <path fill="#EA4335" d="M378.6 333.3L295.3 250 48.7 496.6c9.1 9.7 24.3 10.9 41.3 1.2l288.6-164.5z"/>
                            <path fill="#34A853" d="M378.6 166.7L90 2.2C73-7.5 57.8-6.3 48.7 3.4L295.3 250l83.3-83.3z"/>
                        </svg>
                        <div class="store-btn-text">
                            <span class="store-btn-sub">GET IT ON</span>
                            <span class="store-btn-title">Google Play</span>
                        </div>
                    </a>

                    <a href="#download-ios" class="store-btn" onclick="openDownloadModal('Apple App Store')">
                        <svg viewBox="0 0 170 170" fill="currentColor">
                            <path d="M150.37 130.25c-2.45 5.66-5.35 10.87-8.71 15.66-4.58 6.53-8.33 11.05-11.22 13.56-4.48 4.12-9.28 6.23-14.42 6.35-3.69 0-8.14-1.05-13.32-3.18-5.19-2.12-9.97-3.17-14.34-3.17-4.58 0-9.49 1.05-14.75 3.17-5.26 2.13-9.5 3.24-12.74 3.35-4.35.13-9.16-1.9-14.42-6.08-3.69-3.08-7.66-7.87-11.9-14.37-6.2-9.5-11.1-20.73-14.7-33.68-3.6-12.95-5.4-24.84-5.4-35.67 0-14.52 3.9-26.47 11.71-35.85 7.8-9.37 17.58-14.16 29.34-14.37 4.13 0 9.02 1.13 14.68 3.38 5.65 2.25 9.27 3.43 10.87 3.52 2.18-.32 6.04-1.63 11.58-3.95 5.54-2.31 10.22-3.32 14.04-3.03 10.88.87 19.8 4.79 26.76 11.76 6.96 6.97 11.1 15.35 12.43 25.13-9.8 5.88-14.6 14.04-14.42 24.48.18 8.05 3.29 14.92 9.32 20.61 6.03 5.69 13.06 9.04 21.09 10.05-2.07 6.1-4.73 12.35-7.98 18.74zM119.22 33.31c0-6.75 2.39-13.01 7.18-18.79 4.79-5.77 10.78-9.58 17.97-11.43 1.09 6.75-.82 13.28-5.72 19.6-4.9 6.32-11.05 10.19-18.45 11.62-.32-.33-.65-.66-.98-1z"/>
                        </svg>
                        <div class="store-btn-text">
                            <span class="store-btn-sub">Download on the</span>
                            <span class="store-btn-title">App Store</span>
                        </div>
                    </a>
                </div>

                <!-- Trust Metrics -->
                <div class="hero-stats-row">
                    <div class="stat-item">
                        <h4>{{ $totalMatches }}</h4>
                        <p>Meaningful Matches</p>
                    </div>
                    <div class="stat-item">
                        <h4>100%</h4>
                        <p>Selfie KYC Verified</p>
                    </div>
                    <div class="stat-item">
                        <h4>{{ $satisfactionRate }}</h4>
                        <p>Safety & Trust Score</p>
                    </div>
                </div>
            </div>

            <!-- Interactive Dice Roller Demo Widget -->
            <div class="hero-widget-col">
                <div class="dice-preview-widget">
                    <div class="widget-header">
                        <div>
                            <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-primary); text-transform: uppercase; letter-spacing: 0.05em;">Live Match Simulator</span>
                            <p style="font-size: 0.78rem; margin: 0; color: var(--text-muted);">Try the Dice Madly matchmaking engine</p>
                        </div>
                        <span class="widget-badge">
                            <span style="width: 6px; height: 6px; border-radius: 50%; background: var(--accent-green);"></span>
                            Algorithm Active
                        </span>
                    </div>

                    <div class="interactive-dice-box">
                        <p style="font-size: 0.9rem; color: var(--text-secondary); text-align: center;">
                            Tap the dice to roll your fate and reveal an instant high-affinity match!
                        </p>

                        <button id="rollDiceBtn" class="dice-3d-button" title="Click to Roll">
                            <span id="diceFace">🎲</span>
                        </button>
                        
                        <span id="rollStatus" style="font-size: 0.82rem; font-weight: 600; color: var(--primary);">Click to Roll (5 Free Daily)</span>
                    </div>

                    <!-- Simulated Match Reveal Card -->
                    <div id="matchCard" class="dice-match-card">
                        <div class="match-profile-header">
                            <div style="width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg, #f43f5e, #8b5cf6); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: #fff; font-weight: bold; border: 2px solid var(--primary);" id="avatarBadge">
                                🌟
                            </div>
                            <div class="match-details">
                                <h5 id="matchName" style="color: var(--text-primary);">
                                    Aanya Sharma, 25 
                                    <span class="match-badge-verified" title="Verified Profile">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="#0284c7">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                        </svg>
                                    </span>
                                </h5>
                                <span id="matchLocation">📍 3.2 km away • Designer & Traveler</span>
                            </div>
                        </div>

                        <div class="match-tags" id="matchInterests">
                            <span class="tag-pill">🎨 Art & Design</span>
                            <span class="tag-pill">☕ Coffee Enthusiast</span>
                            <span class="tag-pill">✈️ Road Trips</span>
                            <span class="tag-pill">🎵 Indie Music</span>
                        </div>

                        <div class="affinity-meter">
                            <span id="affinityScore">🎲 Dice Match Affinity: 96% Compatibility</span>
                            <span style="color: #0284c7; font-size: 0.75rem; font-weight: 700;">KYC PASSED</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Features Section -->
<section class="features-section" id="features">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Revolutionary Features</span>
            <h2>Engineered For Real Romance, Not Mindless Games.</h2>
            <p>Dice Madly is designed with precision matchmaking mechanics, uncompromising safety, and genuine transparency.</p>
        </div>

        <div class="features-grid">
            <!-- Feature 1 -->
            <div class="glass-panel feature-card">
                <div class="feature-icon-wrapper">
                    🎲
                </div>
                <h4>The Dice Roll Algorithm</h4>
                <p>Break the fatigue of endless swiping. Each roll combines deep interest alignment, lifestyle preferences, and location proximity to present high-affinity potential partners.</p>
            </div>

            <!-- Feature 2 -->
            <div class="glass-panel feature-card green">
                <div class="feature-icon-wrapper">
                    🛡️
                </div>
                <h4>100% Selfie & KYC Verification</h4>
                <p>Zero tolerance for fake profiles, bots, and catfishing. Our mandatory live selfie match and document verification ensure you only interact with authentic individuals.</p>
            </div>

            <!-- Feature 3 -->
            <div class="glass-panel feature-card purple">
                <div class="feature-icon-wrapper">
                    📍
                </div>
                <h4>Hyper-Local Discovery</h4>
                <p>Real-time proximity matching using precise distance filters. Discover amazing singles in your immediate neighborhood, city, or across your favorite destinations.</p>
            </div>

            <!-- Feature 4 -->
            <div class="glass-panel feature-card gold">
                <div class="feature-icon-wrapper">
                    💬
                </div>
                <h4>Real-Time Encrypted Chat</h4>
                <p>Instant messaging powered by real-time web sockets. Send icebreakers, photos, and expressive reactions in end-to-end secured chat rooms with typing indicators.</p>
            </div>

            <!-- Feature 5 -->
            <div class="glass-panel feature-card">
                <div class="feature-icon-wrapper">
                    💍
                </div>
                <h4>Matrimony & Serious Intent</h4>
                <p>Whether you're dating with purpose or looking for a lifelong partner, customize your marital status, cultural background, education, and family goals with deep filters.</p>
            </div>

            <!-- Feature 6 -->
            <div class="glass-panel feature-card purple">
                <div class="feature-icon-wrapper">
                    💎
                </div>
                <h4>Dice Madly VIP & Boosts</h4>
                <p>Unlock unlimited daily dice rolls, see who rolled for you, activate spotlight profile boosts, and enjoy priority matchmaking with flexible subscription plans.</p>
            </div>
        </div>
    </div>
</section>

<!-- App Interface Showcase Section (Real Screenshots) -->
<section class="showcase-section" id="app-preview">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Visual Experience</span>
            <h2>Designed for Seamless, Serendipitous Dating</h2>
            <p>Take a tour inside the Dice Madly mobile interface. Elegant, intuitive, and built from the ground up for authentic connections.</p>
        </div>

        <div class="screenshots-grid">
            <!-- Screen 1 -->
            <div class="phone-mockup-card">
                <div class="phone-screen-container">
                    <img src="{{ asset('images/app/dice-madly1.jpg') }}" alt="Dice Madly Splash Screen - Roll to find your match" loading="lazy">
                </div>
                <div class="phone-caption">
                    <h5>Welcome & Discovery</h5>
                    <span>Brand Experience</span>
                </div>
            </div>

            <!-- Screen 2 -->
            <div class="phone-mockup-card">
                <div class="phone-screen-container">
                    <img src="{{ asset('images/app/dice-madly2.jpg') }}" alt="Dice Roll Mystery Profile Matchmaking" loading="lazy">
                </div>
                <div class="phone-caption">
                    <h5>Roll & Reveal</h5>
                    <span>Mystery Match Engine</span>
                </div>
            </div>

            <!-- Screen 3 -->
            <div class="phone-mockup-card">
                <div class="phone-screen-container">
                    <img src="{{ asset('images/app/dice-madly3.jpg') }}" alt="Real-time Chat Screen" loading="lazy">
                </div>
                <div class="phone-caption">
                    <h5>Instant Messaging</h5>
                    <span>Encrypted Real-Time Chat</span>
                </div>
            </div>

            <!-- Screen 4 -->
            <div class="phone-mockup-card">
                <div class="phone-screen-container">
                    <img src="{{ asset('images/app/dice-madly4.jpg') }}" alt="Matches and Affinity Score" loading="lazy">
                </div>
                <div class="phone-caption">
                    <h5>Compatibility Matches</h5>
                    <span>Pending & Accepted Feeds</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="how-it-works-section" id="how-it-works">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Simple & Fun</span>
            <h2>How Dice Madly Works</h2>
            <p>From setup to meaningful dates in three effortless steps.</p>
        </div>

        <div class="steps-grid">
            <div class="glass-panel step-card">
                <div class="step-number">1</div>
                <h4>Set Up & Face Verify</h4>
                <p>Sign in via seamless OTP, choose your top 5 to 10 passions, upload your best photos, and complete our quick live selfie verification to earn your Blue Verified Badge.</p>
            </div>

            <div class="glass-panel step-card">
                <div class="step-number">2</div>
                <h4>Roll The Dice of Fate</h4>
                <p>Tap the Dice button to let our matchmaking algorithm search for singles with matching affinity, mutual interests, and proximity within your defined radius.</p>
            </div>

            <div class="glass-panel step-card">
                <div class="step-number">3</div>
                <h4>Connect & Spark Chemistry</h4>
                <p>When you match, start chatting instantly with fun icebreakers. Plan real-world coffee dates or video calls knowing your safety is always protected.</p>
            </div>
        </div>
    </div>
</section>

<!-- Safety & Trust Pledge Section -->
<section class="safety-pledge-section" id="safety">
    <div class="container">
        <div class="safety-pledge-card">
            <div>
                <span class="section-tag" style="color: var(--accent-green);">Google Play & Store Compliant Safety</span>
                <h3 style="color: var(--text-primary); margin-bottom: 16px;">Your Safety, Privacy & Peace of Mind Are Paramount.</h3>
                <p>We believe online dating should feel safe, respectful, and empowering. Dice Madly enforces strict community safety guidelines and real-time moderation.</p>

                <ul class="safety-check-list">
                    <li class="safety-check-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span><strong>Zero tolerance</strong> for harassment, unsolicited explicit content, or fake accounts.</span>
                    </li>
                    <li class="safety-check-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span><strong>One-tap reporting & instant block</strong> directly from any profile or chat screen.</span>
                    </li>
                    <li class="safety-check-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span><strong>Discreet location protection</strong> — exact GPS coordinates are never revealed to other users.</span>
                    </li>
                    <li class="safety-check-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span><strong>Full data rights</strong> — simple in-app and web account/data deletion at any time.</span>
                    </li>
                </ul>
            </div>

            <div style="background: #ffffff; border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 32px; text-align: center; box-shadow: var(--shadow-sm);">
                <div style="font-size: 3.2rem; margin-bottom: 12px;">🛡️</div>
                <h4 style="color: var(--text-primary); margin-bottom: 8px;">100% Genuine Humans</h4>
                <p style="font-size: 0.92rem; margin-bottom: 20px;">Every profile goes through automated and human moderation checks before entering the active discovery pool.</p>
                <a href="{{ route('community-guidelines') }}" class="btn btn-secondary btn-sm" style="width: 100%;">Read Community Guidelines</a>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Success Stories</span>
            <h2>Loved by Singles Everywhere</h2>
            <p>Real stories from people who found sparks, love, and life partners on Dice Madly.</p>
        </div>

        <div class="testimonials-grid">
            <div class="glass-panel testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-text">"I was tired of swiping for hours. With Dice Madly, the dice roll actually matched me with Rohan on my 3rd roll because we both love hiking and live 2 km apart. We're engaged now!"</p>
                <div class="testimonial-user">
                    <div class="testimonial-avatar">P</div>
                    <div>
                        <h5 style="font-size: 1rem; color: var(--text-primary);">Pooja & Rohan</h5>
                        <span style="font-size: 0.82rem; color: var(--text-muted);">Together for 1.5 years • Verified Couple</span>
                    </div>
                </div>
            </div>

            <div class="glass-panel testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-text">"The selfie verification makes such a massive difference. You know the person on the other end is real. The chat is super fast and icebreakers made starting conversations effortless."</p>
                <div class="testimonial-user">
                    <div class="testimonial-avatar">A</div>
                    <div>
                        <h5 style="font-size: 1rem; color: var(--text-primary);">Arjun Mehta</h5>
                        <span style="font-size: 0.82rem; color: var(--text-muted);">Dating actively in Mumbai</span>
                    </div>
                </div>
            </div>

            <div class="glass-panel testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-text">"Dice Madly combines the excitement of fate with serious relationship filters. You get quality matches rather than hundreds of meaningless pings. Highly recommend!"</p>
                <div class="testimonial-user">
                    <div class="testimonial-avatar">S</div>
                    <div>
                        <h5 style="font-size: 1rem; color: var(--text-primary);">Sneha K.</h5>
                        <span style="font-size: 0.82rem; color: var(--text-muted);">Found her partner in Bangalore</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section" id="faq">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Got Questions?</span>
            <h2>Frequently Asked Questions</h2>
            <p>Everything you need to know about Dice Madly, safety, rolls, and subscriptions.</p>
        </div>

        <div class="faq-list">
            <div class="faq-item active">
                <button class="faq-question">
                    <span>How does the Dice Roll matchmaking feature work?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    The Dice Roll is our signature matchmaking mechanic. When you tap to roll, our algorithm scans active profiles within your chosen location radius and calculates a compatibility score based on mutual interests, lifestyle choices, and relationship intentions. Free members receive 5 lucky rolls daily, while VIP members get unlimited rolls.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>Is profile verification mandatory on Dice Madly?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    Yes! To ensure a trustworthy and safe environment, every user is required to complete phone/email OTP verification and an instant selfie face-check. This guarantees that all active members are real people and prevents catfishing or bot accounts.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>Is Dice Madly free to use?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    Dice Madly is free to download and use. Free accounts include 5 daily dice rolls, profile creation, discovery feeds, mutual matching, and messaging with mutual connections. We also offer affordable VIP plans and dice booster packs for unlimited rolls and premium discovery filters.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>How do I delete my account or personal data?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    You have complete control over your data. You can delete your account at any time directly in the mobile app via <strong>Settings &gt; Delete Account</strong>, or via our web portal at <a href="{{ route('delete-account') }}">dicemadly.com/delete-account</a> without needing the app installed.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>What should I do if someone violates community rules?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    You can report or block any user at any moment by tapping the three dots (⋮) on their profile or chat screen. Our 24/7 safety moderation team investigates reported accounts immediately and permanently bans offenders.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Final CTA Banner -->
<section class="cta-section">
    <div class="container">
        <div class="cta-banner">
            <span class="hero-pill" style="margin-bottom: 16px;">
                <span class="dot"></span> Join Over 100,000+ Verified Singles
            </span>
            <h2>Ready to Let Fate Find Your Match?</h2>
            <p>Download Dice Madly today on Android and iOS. Your next great romance is just a dice roll away.</p>
            
            <div class="store-badges-group" style="justify-content: center;">
                <a href="#download-android" class="store-btn" onclick="openDownloadModal('Google Play Store')">
                    <svg viewBox="0 0 512 512" fill="currentColor" width="28" height="28">
                        <path fill="#4285F4" d="M48.7 15.1c-4.4 4.8-7 12.3-7 21.6v438.6c0 9.3 2.6 16.8 7 21.6l1.2 1.1 245.4-245.4v-5.8L49.9 14l-1.2 1.1z"/>
                        <path fill="#FBBC04" d="M377.2 334.4l-81.9-81.9v-5.8l81.9-81.9 1.4.8 97.1 55.2c27.7 15.8 27.7 41.5 0 57.3l-97.1 55.2-1.4 1.1z"/>
                        <path fill="#EA4335" d="M378.6 333.3L295.3 250 48.7 496.6c9.1 9.7 24.3 10.9 41.3 1.2l288.6-164.5z"/>
                        <path fill="#34A853" d="M378.6 166.7L90 2.2C73-7.5 57.8-6.3 48.7 3.4L295.3 250l83.3-83.3z"/>
                    </svg>
                    <div class="store-btn-text">
                        <span class="store-btn-sub">GET IT ON</span>
                        <span class="store-btn-title">Google Play</span>
                    </div>
                </a>

                <a href="#download-ios" class="store-btn" onclick="openDownloadModal('Apple App Store')">
                    <svg viewBox="0 0 170 170" fill="currentColor" width="28" height="28">
                        <path d="M150.37 130.25c-2.45 5.66-5.35 10.87-8.71 15.66-4.58 6.53-8.33 11.05-11.22 13.56-4.48 4.12-9.28 6.23-14.42 6.35-3.69 0-8.14-1.05-13.32-3.18-5.19-2.12-9.97-3.17-14.34-3.17-4.58 0-9.49 1.05-14.75 3.17-5.26 2.13-9.5 3.24-12.74 3.35-4.35.13-9.16-1.9-14.42-6.08-3.69-3.08-7.66-7.87-11.9-14.37-6.2-9.5-11.1-20.73-14.7-33.68-3.6-12.95-5.4-24.84-5.4-35.67 0-14.52 3.9-26.47 11.71-35.85 7.8-9.37 17.58-14.16 29.34-14.37 4.13 0 9.02 1.13 14.68 3.38 5.65 2.25 9.27 3.43 10.87 3.52 2.18-.32 6.04-1.63 11.58-3.95 5.54-2.31 10.22-3.32 14.04-3.03 10.88.87 19.8 4.79 26.76 11.76 6.96 6.97 11.1 15.35 12.43 25.13-9.8 5.88-14.6 14.04-14.42 24.48.18 8.05 3.29 14.92 9.32 20.61 6.03 5.69 13.06 9.04 21.09 10.05-2.07 6.1-4.73 12.35-7.98 18.74zM119.22 33.31c0-6.75 2.39-13.01 7.18-18.79 4.79-5.77 10.78-9.58 17.97-11.43 1.09 6.75-.82 13.28-5.72 19.6-4.9 6.32-11.05 10.19-18.45 11.62-.32-.33-.65-.66-.98-1z"/>
                    </svg>
                    <div class="store-btn-text">
                        <span class="store-btn-sub">Download on the</span>
                        <span class="store-btn-title">App Store</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Download Modal Dialog -->
<div id="downloadModal" style="display: none; position: fixed; inset: 0; z-index: 999; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(8px); align-items: center; justify-content: center; padding: 20px;">
    <div class="glass-panel" style="max-width: 460px; width: 100%; padding: 36px; text-align: center; position: relative; background: #ffffff; box-shadow: var(--shadow-elevated);">
        <button onclick="closeDownloadModal()" style="position: absolute; top: 16px; right: 16px; background: transparent; border: none; color: var(--text-muted); font-size: 1.5rem; cursor: pointer;">&times;</button>
        <div style="font-size: 3rem; margin-bottom: 12px;">📱</div>
        <h3 id="modalStoreTitle" style="color: var(--text-primary); margin-bottom: 12px;">Get Dice Madly</h3>
        <p style="font-size: 0.95rem; margin-bottom: 24px; color: var(--text-secondary);">
            Dice Madly is currently rolling out on the official app stores. Scan the QR code with your smartphone or download the APK directly for early access.
        </p>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <a href="https://play.google.com/store/apps" target="_blank" class="btn btn-primary" style="width: 100%;">
                Open in Store
            </a>
            <button onclick="closeDownloadModal()" class="btn btn-secondary" style="width: 100%;">Close</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Simulated profiles database for interactive widget
    const simulatedProfiles = [
        {
            name: "Aanya Sharma, 25",
            avatar: "👩‍🎨",
            color: "linear-gradient(135deg, #f43f5e, #8b5cf6)",
            location: "📍 3.2 km away • Designer & Traveler",
            interests: ["🎨 Art & Design", "☕ Coffee Enthusiast", "✈️ Road Trips", "🎵 Indie Music"],
            score: "96% Compatibility"
        },
        {
            name: "Kabir Malhotra, 27",
            avatar: "👨‍💻",
            color: "linear-gradient(135deg, #3b82f6, #06b6d4)",
            location: "📍 1.8 km away • Software Architect & Musician",
            interests: ["💻 Tech & AI", "🎸 Acoustic Guitar", "📚 Sci-Fi Novels", "🍕 Foodie"],
            score: "98% Compatibility"
        },
        {
            name: "Riya Sen, 24",
            avatar: "🧘‍♀️",
            color: "linear-gradient(135deg, #10b981, #059669)",
            location: "📍 4.5 km away • Yoga Instructor & Wellness",
            interests: ["🧘 Mindful Living", "🌱 Organic Cooking", "🐶 Dog Lover", "⛺ Camping"],
            score: "94% Compatibility"
        },
        {
            name: "Dev Dixit, 28",
            avatar: "🏃‍♂️",
            color: "linear-gradient(135deg, #f59e0b, #d97706)",
            location: "📍 2.1 km away • Entrepreneur & Marathoner",
            interests: ["🏃 Marathon Running", "📈 Startups", "🎬 Cinema", "☕ Pour-over Coffee"],
            score: "95% Compatibility"
        },
        {
            name: "Tara Nair, 26",
            avatar: "📸",
            color: "linear-gradient(135deg, #ec4899, #be123c)",
            location: "📍 5.0 km away • Photographer & Architect",
            interests: ["📸 Street Photography", "🏛️ Architecture", "🍣 Japanese Cuisine", "🚲 Cycling"],
            score: "97% Compatibility"
        }
    ];

    const diceFaces = ['⚀', '⚁', '⚂', '⚃', '⚄', '⚅'];
    let currentProfileIdx = 0;

    const rollDiceBtn = document.getElementById('rollDiceBtn');
    const diceFace = document.getElementById('diceFace');
    const rollStatus = document.getElementById('rollStatus');
    const matchCard = document.getElementById('matchCard');
    const matchName = document.getElementById('matchName');
    const matchLocation = document.getElementById('matchLocation');
    const matchInterests = document.getElementById('matchInterests');
    const affinityScore = document.getElementById('affinityScore');
    const avatarBadge = document.getElementById('avatarBadge');

    if (rollDiceBtn) {
        rollDiceBtn.addEventListener('click', () => {
            // Animate rolling
            rollDiceBtn.classList.add('dice-rolling');
            rollStatus.innerText = "Rolling fate algorithm...";
            matchCard.style.opacity = "0.5";
            matchCard.style.transform = "scale(0.98)";

            // Rapid dice face change
            let count = 0;
            const interval = setInterval(() => {
                diceFace.innerText = diceFaces[Math.floor(Math.random() * diceFaces.length)];
                count++;
                if (count > 6) clearInterval(interval);
            }, 100);

            setTimeout(() => {
                rollDiceBtn.classList.remove('dice-rolling');
                
                // Next random profile
                currentProfileIdx = (currentProfileIdx + 1) % simulatedProfiles.length;
                const p = simulatedProfiles[currentProfileIdx];

                matchName.innerHTML = `${p.name} <span class="match-badge-verified"><svg width="18" height="18" viewBox="0 0 24 24" fill="#0284c7"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg></span>`;
                matchLocation.innerText = p.location;
                avatarBadge.innerText = p.avatar;
                avatarBadge.style.background = p.color;
                affinityScore.innerText = `🎲 Dice Match Affinity: ${p.score}`;
                
                matchInterests.innerHTML = p.interests.map(tag => `<span class="tag-pill">${tag}</span>`).join('');
                
                matchCard.style.opacity = "1";
                matchCard.style.transform = "scale(1)";
                rollStatus.innerText = "Match Discovered! Tap to roll again.";
            }, 800);
        });
    }

    // Modal controls
    function openDownloadModal(storeName) {
        document.getElementById('modalStoreTitle').innerText = 'Get Dice Madly on ' + storeName;
        document.getElementById('downloadModal').style.display = 'flex';
    }

    function closeDownloadModal() {
        document.getElementById('downloadModal').style.display = 'none';
    }
</script>
@endpush
