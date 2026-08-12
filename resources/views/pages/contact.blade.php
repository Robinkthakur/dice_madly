@extends('layouts.app')

@section('title', 'Contact Us & Grievance Redressal - ' . config('app.name', 'Dice Madly'))
@section('meta_description', 'Contact the Dice Madly support team, report safety issues, or reach our designated Grievance Officer.')

@section('content')
<!-- Page Header -->
<div class="policy-page-header">
    <div class="container">
        <span class="policy-badge" style="background: #eff6ff; border-color: #bfdbfe; color: #2563eb;">
            24/7 Support Desk & Grievance Redressal
        </span>
        <h1 style="margin-bottom: 12px;">Get In Touch With Us</h1>
        <p style="color: var(--text-secondary); max-width: 700px;">
            Have questions, feedback, or need safety assistance? We're here to help you 24/7.
        </p>
    </div>
</div>

<div class="container" style="margin-bottom: 80px;">
    <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 40px;">
        
        <!-- Left: Contact Details & Grievance Desk -->
        <div>
            <!-- Contact Card -->
            <div class="glass-panel" style="padding: 32px; margin-bottom: 24px;">
                <h4 style="margin-bottom: 16px;">Direct Support Channels</h4>
                
                <div style="display: flex; flex-direction: column; gap: 18px;">
                    <div style="display: flex; align-items: flex-start; gap: 14px;">
                        <div style="font-size: 1.4rem;">📧</div>
                        <div>
                            <strong style="color: var(--text-primary); font-size: 0.95rem;">General Inquiries & Support</strong>
                            <p style="margin: 2px 0; font-size: 0.9rem;"><a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a></p>
                            <span style="font-size: 0.8rem; color: var(--text-muted);">Avg. response time: 24 hours</span>
                        </div>
                    </div>

                    <div style="display: flex; align-items: flex-start; gap: 14px;">
                        <div style="font-size: 1.4rem;">🛡️</div>
                        <div>
                            <strong style="color: var(--text-primary); font-size: 0.95rem;">Safety & Abuse Hotline</strong>
                            <p style="margin: 2px 0; font-size: 0.9rem;"><a href="mailto:safety@dicemadly.com">safety@dicemadly.com</a></p>
                            <span style="font-size: 0.8rem; color: var(--text-muted);">Immediate triage priority</span>
                        </div>
                    </div>

                    <div style="display: flex; align-items: flex-start; gap: 14px;">
                        <div style="font-size: 1.4rem;">💳</div>
                        <div>
                            <strong style="color: var(--text-primary); font-size: 0.95rem;">Billing & Subscription Support</strong>
                            <p style="margin: 2px 0; font-size: 0.9rem;"><a href="mailto:billing@dicemadly.com">billing@dicemadly.com</a></p>
                            <span style="font-size: 0.8rem; color: var(--text-muted);">Provide Google Play Order ID</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grievance Redressal Officer Info (Google Play & Legal Requirement) -->
            <div class="glass-panel" style="padding: 32px; border-color: #ddd6fe;">
                <span class="section-tag" style="color: var(--accent-purple); font-size: 0.78rem;">Legal Compliance</span>
                <h4 style="margin-bottom: 12px;">Grievance Redressal Officer</h4>
                <p style="font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 14px;">
                    In accordance with applicable Information Technology and digital consumer protection rules, the contact details of the Grievance Officer are provided below:
                </p>
                <div style="font-size: 0.9rem; line-height: 1.8; color: var(--text-secondary);">
                    <p><strong>Designation:</strong> Grievance Officer, {{ $appName }} Operations</p>
                    <p><strong>Email:</strong> <a href="mailto:{{ $grievanceEmail }}">{{ $grievanceEmail }}</a></p>
                    <p><strong>Acknowledgment:</strong> Within 24 hours</p>
                    <p><strong>Disposal of Grievance:</strong> Within 15 business days</p>
                </div>
            </div>
        </div>

        <!-- Right: Interactive Contact Form -->
        <div>
            <div class="glass-panel" style="padding: 36px;">
                <!-- Success Message -->
                @if(session('contact_success'))
                    <div class="alert-success">
                        <h4>Message Sent Successfully!</h4>
                        <p style="margin: 4px 0 8px; font-size: 0.95rem; color: #065f46;">
                            {{ session('contact_success')['message'] }}
                        </p>
                        <p style="margin: 0; font-size: 0.85rem; color: #047857;">
                            <strong>Your Support Ticket Reference:</strong> 
                            <span style="font-family: monospace; background: #d1fae5; padding: 2px 8px; border-radius: 4px;">{{ session('contact_success')['ticket'] }}</span>
                        </p>
                    </div>
                @endif

                <h3 style="margin-bottom: 8px;">Send Us A Message</h3>
                <p style="font-size: 0.95rem; margin-bottom: 24px; color: var(--text-secondary);">
                    Fill in your details below and our team will get back to you promptly.
                </p>

                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label class="form-label" for="name">Your Name *</label>
                            <input type="text" name="name" id="name" class="form-input" placeholder="e.g. Alex Johnson" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">Email Address *</label>
                            <input type="email" name="email" id="email" class="form-input" placeholder="alex@example.com" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="category">Inquiry Category *</label>
                        <select name="category" id="category" class="form-select" required>
                            <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>General Inquiry / Feedback</option>
                            <option value="safety" {{ old('category') == 'safety' ? 'selected' : '' }}>Safety & Abuse Report</option>
                            <option value="billing" {{ old('category') == 'billing' ? 'selected' : '' }}>Billing & Subscription Issue</option>
                            <option value="privacy" {{ old('category') == 'privacy' ? 'selected' : '' }}>Privacy & Data Rights</option>
                            <option value="bug" {{ old('category') == 'bug' ? 'selected' : '' }}>Technical Bug Report</option>
                        </select>
                        @error('category')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="subject">Subject *</label>
                        <input type="text" name="subject" id="subject" class="form-input" placeholder="Brief summary of your inquiry" value="{{ old('subject') }}" required>
                        @error('subject')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="message">Message *</label>
                        <textarea name="message" id="message" rows="5" class="form-textarea" placeholder="Please describe how we can assist you with as much detail as possible..." required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                        Send Inquiry
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
