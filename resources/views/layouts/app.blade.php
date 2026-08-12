<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">

    <title>@yield('title', config('app.name', 'Dice Madly') . ' - Roll Into True Connection')</title>
    <meta name="description" content="@yield('meta_description', 'Dice Madly is a modern dating and matrimony app where fate meets genuine connections. Verified profiles, location discovery, and unique dice roll matchmaking.')">
    
    <!-- Open Graph / Meta -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', config('app.name', 'Dice Madly') . ' - Roll Into True Connection')">
    <meta property="og:description" content="@yield('meta_description', 'Dice Madly is a modern dating and matrimony app where fate meets genuine connections.')">
    <meta property="og:image" content="{{ asset('logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Site CSS -->
    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v={{ time() }}">

    @stack('styles')
</head>
<body>
    <!-- Background atmospheric soft glows -->
    <div class="bg-ambient-grid"></div>
    <div class="bg-ambient-pattern"></div>

    <!-- Header / Navbar -->
    <header class="site-header">
        <div class="container">
            <div class="nav-container">
                <a href="{{ route('home') }}" class="brand-logo">
                    @if(file_exists(public_path('logo.png')))
                        <img src="{{ asset('logo.png') }}" alt="Dice Madly" style="height: 38px;">
                    @else
                        <div class="dice-icon-badge">🎲</div>
                    @endif
                </a>

                <ul class="nav-links">
                    <li><a href="{{ route('home') }}#features" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Features</a></li>
                    <li><a href="{{ route('home') }}#how-it-works" class="nav-link">How It Works</a></li>
                    <li><a href="{{ route('home') }}#safety" class="nav-link">Safety Pledge</a></li>
                    <li><a href="{{ route('home') }}#faq" class="nav-link">FAQ</a></li>
                    <li><a href="{{ route('privacy') }}" class="nav-link {{ request()->routeIs('privacy') ? 'active' : '' }}">Privacy</a></li>
                    <li><a href="{{ route('terms') }}" class="nav-link {{ request()->routeIs('terms') ? 'active' : '' }}">Terms</a></li>
                </ul>

                <div class="nav-actions">
                    <a href="{{ route('home') }}#download-app" class="btn btn-primary btn-sm">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                        Get App
                    </a>

                    <button class="mobile-toggle" id="mobileMenuBtn" aria-label="Toggle Navigation">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer -->
        <div id="mobileDrawer" style="display: none; background: #ffffff; border-bottom: 1px solid var(--border-subtle); padding: 20px 24px; box-shadow: var(--shadow-elevated);">
            <div style="display: flex; flex-direction: column; gap: 14px;">
                <a href="{{ route('home') }}" style="color: var(--text-primary); font-weight: 700; padding: 6px 0;">Home</a>
                <a href="{{ route('home') }}#features" style="color: var(--text-secondary); padding: 6px 0;">Features</a>
                <a href="{{ route('home') }}#how-it-works" style="color: var(--text-secondary); padding: 6px 0;">How It Works</a>
                <a href="{{ route('home') }}#safety" style="color: var(--text-secondary); padding: 6px 0;">Safety & KYC</a>
                <a href="{{ route('home') }}#faq" style="color: var(--text-secondary); padding: 6px 0;">FAQ</a>
                <div style="height: 1px; background: var(--border-subtle); margin: 6px 0;"></div>
                <a href="{{ route('privacy') }}" style="color: var(--text-secondary); padding: 6px 0;">Privacy Policy</a>
                <a href="{{ route('terms') }}" style="color: var(--text-secondary); padding: 6px 0;">Terms of Service</a>
                <a href="{{ route('delete-account') }}" style="color: #dc2626; padding: 6px 0; font-weight: 600;">Account & Data Deletion</a>
                <a href="{{ route('contact') }}" style="color: var(--text-secondary); padding: 6px 0;">Contact Support</a>
                <a href="{{ route('home') }}#download-app" class="btn btn-primary" style="margin-top: 10px; width: 100%;">Download Dice Madly</a>
            </div>
        </div>
    </header>

    <!-- Main Content Yield -->
    <main>
        @yield('content')
    </main>

    <!-- Global Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="{{ route('home') }}" class="brand-logo" style="margin-bottom: 16px;">
                        @if(file_exists(public_path('logo.png')))
                            <img src="{{ asset('logo.png') }}" alt="Dice Madly" style="height: 38px;">
                        @else
                            <div class="dice-icon-badge">🎲</div>
                        @endif
                        <span>DICE <span>MADLY</span></span>
                    </a>
                    <p>Where fate meets genuine connection. Experience the thrill of serendipitous matchmaking, verified profiles, and safe dating & matrimony.</p>
                    <div style="display: flex; gap: 12px; margin-top: 20px;">
                        <span style="font-size: 0.78rem; padding: 4px 10px; border-radius: var(--radius-full); background: #fff1f2; border: 1px solid #fecdd3; color: var(--primary); font-weight: 600;">🔞 18+ Adults Only</span>
                        <span style="font-size: 0.78rem; padding: 4px 10px; border-radius: var(--radius-full); background: #ecfdf5; border: 1px solid #a7f3d0; color: var(--accent-green); font-weight: 600;">🔒 SSL Encrypted</span>
                    </div>
                </div>

                <div class="footer-column">
                    <h5>Discover</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}#features">Dice Matchmaking</a></li>
                        <li><a href="{{ route('home') }}#how-it-works">How It Works</a></li>
                        <li><a href="{{ route('home') }}#safety">Safety & KYC Verification</a></li>
                        <li><a href="{{ route('home') }}#faq">Frequently Asked Questions</a></li>
                        <li><a href="{{ route('home') }}#download-app">Download Mobile App</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h5>Policies & Legal</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}">Terms of Service</a></li>
                        <li><a href="{{ route('delete-account') }}">Account & Data Deletion</a></li>
                        <li><a href="{{ route('community-guidelines') }}">Community Guidelines</a></li>
                        <li><a href="{{ route('refund-policy') }}">Refund Policy</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h5>Support & Contact</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('contact') }}">Help & Support Desk</a></li>
                        <li><a href="{{ route('contact') }}">Grievance Officer</a></li>
                        <li><a href="mailto:support@dicemadly.com">support@dicemadly.com</a></li>
                        <li><a href="mailto:privacy@dicemadly.com">privacy@dicemadly.com</a></li>
                        <li><a href="{{ route('delete-account') }}" style="color: #dc2626; font-weight: 600;">Request Account Deletion</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <div>
                    &copy; {{ date('Y') }} {{ config('app.name', 'Dice Madly') }}. All rights reserved. Built for meaningful dating and matrimony.
                </div>
                <div style="display: flex; gap: 20px;">
                    <a href="{{ route('privacy') }}" style="color: var(--text-muted); font-size: 0.85rem;">Privacy</a>
                    <a href="{{ route('terms') }}" style="color: var(--text-muted); font-size: 0.85rem;">Terms</a>
                    <a href="{{ route('delete-account') }}" style="color: var(--text-muted); font-size: 0.85rem;">Data Safety</a>
                    <a href="{{ route('contact') }}" style="color: var(--text-muted); font-size: 0.85rem;">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Global Scripts -->
    <script>
        // Mobile Navigation Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileDrawer = document.getElementById('mobileDrawer');
        if (mobileMenuBtn && mobileDrawer) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileDrawer.style.display = mobileDrawer.style.display === 'none' ? 'block' : 'none';
            });
        }

        // Accordion helper
        document.addEventListener('DOMContentLoaded', () => {
            const faqQuestions = document.querySelectorAll('.faq-question');
            faqQuestions.forEach(btn => {
                btn.addEventListener('click', () => {
                    const item = btn.parentElement;
                    const isActive = item.classList.contains('active');
                    
                    // Close other items
                    document.querySelectorAll('.faq-item').forEach(other => other.classList.remove('active'));
                    
                    if (!isActive) {
                        item.classList.add('active');
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
