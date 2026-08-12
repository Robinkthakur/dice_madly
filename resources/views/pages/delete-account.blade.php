@extends('layouts.app')

@section('title', 'Account & Data Deletion Portal - ' . config('app.name', 'Dice Madly'))
@section('meta_description', 'Official Google Play compliant Account and Data Deletion portal for Dice Madly. Submit a request to delete your account, photos, chat history, and personal information.')

@section('content')
<!-- Page Header -->
<div class="policy-page-header">
    <div class="container">
        <span class="policy-badge" style="background: #fee2e2; border-color: #fca5a5; color: #dc2626;">
            Google Play Data Safety Compliance
        </span>
        <h1 style="margin-bottom: 12px;">Account & Data Deletion Portal</h1>
        <p style="color: var(--text-secondary); max-width: 700px;">
            We respect your privacy and data sovereignty. Learn how to delete your account or submit a direct web deletion request below without needing the mobile app installed.
        </p>
    </div>
</div>

<div class="container" style="margin-bottom: 80px;">
    <div style="max-width: 860px; margin: 0 auto;">

        <!-- Success notification if form submitted -->
        @if(session('success_request'))
            <div class="alert-success">
                <div style="display: flex; align-items: flex-start; gap: 14px;">
                    <div style="font-size: 1.6rem; line-height: 1;">✅</div>
                    <div>
                        <h4>Account Deletion Request Submitted</h4>
                        <p style="margin: 4px 0 8px; font-size: 0.95rem; color: #065f46;">
                            {{ session('success_request')['message'] }}
                        </p>
                        <p style="margin: 0; font-size: 0.85rem; color: #047857;">
                            <strong>Tracking Reference ID:</strong> <span style="font-family: monospace; background: #d1fae5; padding: 2px 8px; border-radius: 4px;">{{ session('success_request')['reference'] }}</span> &bull; 
                            <strong>Target Account:</strong> {{ session('success_request')['identifier'] }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Deletion Overview Cards -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 36px;">
            <div class="glass-panel" style="padding: 28px;">
                <div style="font-size: 2rem; margin-bottom: 12px;">📱</div>
                <h4 style="margin-bottom: 8px;">Method 1: Inside the Mobile App</h4>
                <p style="font-size: 0.92rem; color: var(--text-secondary); margin-bottom: 14px;">
                    If you currently have the {{ $appName }} app installed on your smartphone:
                </p>
                <ol style="margin-left: 20px; font-size: 0.9rem; color: var(--text-secondary); line-height: 1.8;">
                    <li>Open <strong>{{ $appName }}</strong> and log in.</li>
                    <li>Tap on your <strong>Profile</strong> tab (bottom right).</li>
                    <li>Open <strong>Settings (⚙️)</strong> &gt; <strong>Account Settings</strong>.</li>
                    <li>Tap <strong>Delete Account</strong> and confirm your choice.</li>
                </ol>
            </div>

            <div class="glass-panel" style="padding: 28px; border-color: rgba(225, 29, 72, 0.35);">
                <div style="font-size: 2rem; margin-bottom: 12px;">🌐</div>
                <h4 style="margin-bottom: 8px;">Method 2: Web Deletion Request</h4>
                <p style="font-size: 0.92rem; color: var(--text-secondary); margin-bottom: 14px;">
                    If you uninstalled the app or cannot access your device, submit the form below.
                </p>
                <ul style="margin-left: 20px; font-size: 0.9rem; color: var(--text-secondary); line-height: 1.8;">
                    <li>Requires your registered email or phone number.</li>
                    <li>Instantly terminates active session tokens.</li>
                    <li>Queues user data for permanent deletion.</li>
                    <li>Generates an official reference tracking ticket.</li>
                </ul>
            </div>
        </div>

        <!-- Web Deletion Request Form -->
        <div class="glass-panel" style="padding: 36px; margin-bottom: 40px;">
            <h3 style="margin-bottom: 8px;">Submit Web Data Deletion Request</h3>
            <p style="font-size: 0.95rem; margin-bottom: 24px; color: var(--text-secondary);">
                Please fill in your registered credentials to initiate the deletion workflow.
            </p>

            <form action="{{ route('delete-account.submit') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="identifier_type">Account Verification Type *</label>
                    <select name="identifier_type" id="identifier_type" class="form-select" required>
                        <option value="phone" {{ old('identifier_type') == 'phone' ? 'selected' : '' }}>Registered Mobile Phone Number</option>
                        <option value="email" {{ old('identifier_type') == 'email' ? 'selected' : '' }}>Registered Email Address</option>
                    </select>
                    @error('identifier_type')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="identifier">Registered Phone Number / Email Address *</label>
                    <input type="text" name="identifier" id="identifier" class="form-input" placeholder="+1 555-0199 or user@example.com" value="{{ old('identifier') }}" required>
                    @error('identifier')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="reason">Reason for Leaving (Optional)</label>
                    <textarea name="reason" id="reason" rows="3" class="form-textarea" placeholder="Help us improve: Found someone, taking a break, or other feedback...">{{ old('reason') }}</textarea>
                    @error('reason')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom: 28px;">
                    <label class="form-checkbox-label">
                        <input type="checkbox" name="confirm_checkbox" id="confirm_checkbox" value="1" required {{ old('confirm_checkbox') ? 'checked' : '' }}>
                        <span>
                            I understand that submitting this request will permanently delete my profile, photos, chat transcripts, match history, and remaining dice rolls. This action cannot be reversed after the 15-day recovery window.
                        </span>
                    </label>
                    @error('confirm_checkbox')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; background: linear-gradient(135deg, #ef4444, #be123c);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                    Confirm & Submit Account Deletion Request
                </button>
            </form>
        </div>

        <!-- Data Transparency & Retention Details -->
        <div class="glass-panel" style="padding: 36px;">
            <h4 style="margin-bottom: 16px;">Detailed Data Deletion & Retention Policy</h4>
            
            <table class="policy-table">
                <thead>
                    <tr>
                        <th>Data Category</th>
                        <th>Status Upon Deletion Request</th>
                        <th>Retention Period</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Public Profile, Photos & Bio</strong></td>
                        <td>Hidden immediately from discovery and search</td>
                        <td>Permanently purged within 15 to 30 days</td>
                    </tr>
                    <tr>
                        <td><strong>Chat Transcripts & Media</strong></td>
                        <td>Session severed, conversation unlinked</td>
                        <td>Permanently purged within 30 days</td>
                    </tr>
                    <tr>
                        <td><strong>Matches, Likes & Daily Rolls</strong></td>
                        <td>Revoked immediately</td>
                        <td>Permanently deleted</td>
                    </tr>
                    <tr>
                        <td><strong>KYC / Live Selfie Proof</strong></td>
                        <td>Unlinked from active user pool</td>
                        <td>Purged after verification check cycle</td>
                    </tr>
                    <tr>
                        <td><strong>Financial / In-App Billing Records</strong></td>
                        <td>Retained for legal/tax accounting only</td>
                        <td>As mandated by applicable tax/payment laws</td>
                    </tr>
                </tbody>
            </table>

            <div class="policy-highlight-box gold" style="margin-top: 24px;">
                <h4>Need Assistance?</h4>
                <p style="margin: 0; font-size: 0.92rem; color: #92400e;">
                    If you have questions about your data rights or encounter any issues deleting your account, contact our Data Protection Team at <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a>.
                </p>
            </div>
        </div>

    </div>
</div>
@endsection
