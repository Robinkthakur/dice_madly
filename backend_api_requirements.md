# Dice Madly - Backend API Requirements Specification

**Version:** 1.0  
**Project:** Dating & Matrimony Mobile App (Flutter)  
**Objective:** Specification for the Backend Team to develop RESTful APIs.

---

## 1. System Overview
Dice Madly is a location-based dating and matrimony application with a unique "Dice Roll" matchmaking mechanic. The backend must handle high-concurrency requests, real-time messaging, and sensitive user data (KYC documents).

---

## 2. Global Standards
- **Base URL:** `https://api.dicemadly.com/api/v1`
- **Protocol:** HTTPS (SSL mandatory)
- **Response Format:** JSON
- **Authentication:** Laravel Sanctum (Bearer Token)
- **Common Header:** `Accept: application/json`
- **Pagination:** Cursor-based pagination for feeds.

---

## 3. Module-wise Feature Requirements

### Module A: Authentication & Security
| Endpoint | Method | Params | Description |
| :--- | :---: | :--- | :--- |
| `/auth/otp/send` | POST | `type`, `value` | Send 6-digit code. Handle rate limiting (60s). |
| `/auth/otp/login` | POST | `value`, `code` | Verify OTP. Return `token`, `user`, and `onboarding_step`. |
| `/auth/logout` | POST | - | Revoke current access token. |
| `/auth/me` | GET | - | Current user profile, status, and subscription details. |
| `/auth/delete-account`| DELETE | - | Soft delete user data (30-day retention). |

### Module B: User Onboarding & KYC
*Note: All onboarding steps must update `onboarding_step` status.*
| Endpoint | Method | Params | Description |
| :--- | :---: | :--- | :--- |
| `/profile/setup` | POST | `first_name`, `email`, `dob`, `gender` | Step 1: Initial Registration. |
| `/profile/bio-dp` | POST | `about_me`, `profile_image` | Step 2: Multipart upload (Image validation). |
| `/profile/id-proof` | POST | `id_type`, `id_document` | Step 3: KYC Document (OCR/Manual Review flag). |
| `/profile/selfie` | POST | `selfie_image` | Step 4: Face verification upload. |
| `/profile/interests` | POST | `interest_ids[]` | Step 5: Finalize. Min 5, Max 10. |
| `/interests/options` | GET | - | Get categorized interests master data. |

### Module C: Discovery & Matchmaking (The "Dice" Core)
| Endpoint | Method | Params | Description |
| :--- | :---: | :--- | :--- |
| `/discover/recommended` | GET | `lat`, `long` | Feed based on preferences & distance. |
| `/discover/dice-roll` | POST | - | **Algorithm:** Fetch 1 unique high-score match. Deduct 1 roll from daily quota. |
| `/discover/filters` | GET | - | Current user search filters (Age, Distance, Religion). |

### Module D: Connections & Matching
| Endpoint | Method | Params | Description |
| :--- | :---: | :--- | :--- |
| `/matches/swipe` | POST | `target_id`, `action` | `like` or `pass`. If mutual, trigger Match. |
| `/matches/list` | GET | `status` | List of `pending`, `accepted`, `declined` requests. |
| `/matches/profile/{id}`| GET | - | Detailed profile view of another user. |
| `/matches/report` | POST | `user_id`, `reason` | Flag user for safety review. |

### Module E: Real-time Chat
| Endpoint | Method | Params | Description |
| :--- | :---: | :--- | :--- |
| `/chats/rooms` | GET | - | List of all active conversations with last message. |
| `/chats/{room_id}/messages`| GET | `page` | Paginated message history. |
| `/chats/send` | POST | `receiver_id`, `text`| Send message. (Trigger Push Notification). |
| `/chats/typing` | POST | `room_id` | Webhook/Socket event for typing status. |

### Module F: Subscriptions & Payments
| Endpoint | Method | Params | Description |
| :--- | :---: | :--- | :--- |
| `/plans` | GET | - | List available premium plans (Prices/Benefits). |
| `/payment/init` | POST | `plan_id` | Generate Payment Gateway Order ID. |
| `/payment/verify` | POST | `payment_id`, `signature`| Verify transaction and upgrade user. |

---

## 4. Key Business Logic (Backend Tasks)
1.  **Dice Roll Quota**: 
    - Free users: 5 rolls/day. Reset at 00:00 UTC.
    - Premium users: Unlimited rolls.
2.  **Distance Calculation**: Use Haversine formula for "nearby" profiles.
3.  **Push Notifications**: 
    - Event: `New Match` → "You have a new match! Start chatting."
    - Event: `New Message` → "{Name} sent you a message."
4.  **Age Restriction**: Prevent registration for users under 18.

---

## 5. Error Code Definitions
- `401`: Token Expired/Invalid.
- `403`: Onboarding Incomplete (Redirect to `onboarding_step`).
- `422`: Validation Error (Email exists, Invalid DOB, etc.).
- `429`: Too many OTP requests.

---
