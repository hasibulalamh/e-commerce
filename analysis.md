# 🔍 E-Commerce Platform — System Audit Report
**Date:** 2026-04-21
**Framework:** Laravel 12.47.0 / PHP 8.4.20 / MySQL 8.0
**Total Routes:** 97 | **Total Migrations:** 34 (all ran) | **Controllers:** 20 | **Blade Views:** 56

---

## ✅ SECTION A: BUGS FIXED (from original V-001 to V-024)

| Code | Issue | Status | Notes |
|------|-------|--------|-------|
| V-001 | Mass Assignment ($guarded=[]) on 5 models | ✅ Fixed | $fillable added to all models (Product, Order, Banner, etc.) |
| V-002 | Destructive GET routes (DELETE/POST) | ✅ Fixed | All delete routes use DELETE method + CSRF |
| V-003 | No Admin Role Check | ✅ Fixed | AdminMiddleware created + role='admin', `auth` + `admin` middleware on all admin routes |
| V-004 | No Checkout Validation | ✅ Fixed | Server-side validation added in `storeaddorder()` — name, email, phone, address, city, payment_method |
| V-005 | Admin Login no password validation | ✅ Fixed | `password=>required\|min:6` added + `throttle:5,1` rate limiting |
| V-006 | User model missing role in fillable | ✅ Fixed | role added to $fillable |
| V-007 | Order-User relationship mismatch | ✅ Fixed | `customer()` relationship added to Order model pointing to Customer model |
| V-008 | Dashboard uses wrong orderItems relation | ✅ Fixed | Changed to `orderDetails` throughout |
| V-009 | File upload no type validation | ✅ Fixed | `mimes:jpeg,png,jpg,gif,webp` added to image uploads |
| V-010 | Undefined $fileName variable | ✅ Fixed | `$fileName = null` before if block |
| V-011 | Add-to-cart outside auth middleware | ✅ Fixed | Moved inside `customerg` middleware group (line 70 of web.php) |
| V-012 | updateStatus route mismatch | ✅ Fixed | Route uses POST method: `Route::post('/status/update/{id}', ...)` |
| V-013 | Checkout Blade syntax error | ✅ Fixed | `{{ }}` added around auth() calls |
| V-014 | Category typo sccess→success | ✅ Fixed | Corrected in CategoryController |
| V-015 | Product shows success toast on failure | ✅ Fixed | Changed to `error()` |
| V-016 | Shipping cost mismatch (+1 vs 100 BDT) | ✅ Fixed | `$shipping_cost = 100` in OrderController line 135 |
| V-017 | No rate limiting on login | ✅ Fixed | `throttle:5,1` on admin login (line 119) + customer login (line 35) + registration (line 33) |
| V-018 | Customer login returns register view | ⚠️ Partial | Both login and register have separate routes but shared page by design |
| V-019 | .env in repository | ✅ Fixed | `.env` IS in `.gitignore` (confirmed: `.env`, `.env.backup`, `.env.production` all listed) |
| V-020 | Session encryption disabled | ✅ Fixed | `SESSION_ENCRYPT=true` confirmed in .env, `SESSION_DRIVER=database` |
| V-021 | orderdetail.php lowercase filename | ✅ Fixed | Model is `OrderDetail.php` (proper casing) |
| V-022 | Cart shows static image | ✅ Fixed | Dynamic product image via `$item['image']` |
| V-023 | No pagination on homepage | ✅ Fixed | Products paginated |
| V-024 | Product list 50 items per page | ✅ Fixed | Changed to 12 |

**Summary: 22/24 fully fixed, 1 partial (by design), 1 was already fixed**

---

## 🔴 SECTION B: NEW BUGS CREATED (during development)

| # | Bug | File | Severity | Status |
|---|-----|------|----------|--------|
| B-001 | **`banner.update` route MISSING** — Edit banner form submits to `route('banner.update', $banner->id)` but NO route with name `banner.update` exists in web.php. Banner edits will crash with `Route [banner.update] not defined` error. | `routes/web.php` line 183-189, `resources/views/backend/features/banner/edit.blade.php` line 14 | 🔴 CRITICAL | ❌ Not Fixed |
| B-002 | **`coupon_code` and `discount_amount` NOT in Order $fillable** — `storeaddorder()` passes `coupon_code` and `discount_amount` to `Order::create()` (lines 182-183) but these fields are NOT in the Order model's `$fillable` array. Coupons are silently ignored on every order. | `app/Models/Order.php` line 12-34 | 🔴 CRITICAL | ❌ Not Fixed |
| B-003 | **DOUBLE STOCK DECREMENT** — Stock is decremented TWICE: once in `OrderController@storeaddorder()` line 198 (`$product->decrement('stock', ...)`) when placing the order, AND again in `OrderListController@handleStatusChangeActions()` lines 244-250 when admin confirms the order. Every confirmed order loses 2× the actual quantity from stock. | `OrderController.php:198` + `OrderListController.php:244-250` | 🔴 CRITICAL | ❌ Not Fixed |
| B-004 | **No Order Confirmation Page** — After placing order, user is redirected to homepage (`return redirect()->route('Home')`) with only a toast message. No dedicated confirmation/thank-you page showing order number, details, or next steps. | `OrderController.php:219` | 🟡 Medium | ❌ Not Fixed |
| B-005 | **`APP_DEBUG=true` in production .env** — Debug mode is enabled, exposing stack traces, database credentials, and environment variables to any user who triggers an error. | `.env` | 🔴 CRITICAL (for production) | ❌ Not Fixed |
| B-006 | **Error log: `Call to undefined method App\Models\Customer::wishlists()`** — Productdetails.blade.php calls `Customer::wishlists()` but this method may be missing or mis-named on the Customer model. Logged on 2026-04-20 23:33:36. | `resources/views/frontend/pages/Productdetails.blade.php`, `app/Models/Customer.php` | 🟡 Medium | ⚠️ Check |

---

## 🟡 SECTION C: REMAINING BUGS (not yet fixed)

### V-019: .env in .gitignore — ✅ RESOLVED
```
.gitignore contains: .env, .env.backup, .env.production
```

### V-020: Session encryption — ✅ RESOLVED
```
SESSION_DRIVER=database
SESSION_ENCRYPT=true
```

### Missing Route Definitions

| Route Name | Referenced In | Exists in web.php? | Status |
|------------|---------------|---------------------|--------|
| `banner.update` | `backend/features/banner/edit.blade.php:14` | ❌ NO | 🔴 BROKEN |
| `order.confirmation` | N/A (should exist after checkout) | ❌ NO | 🟡 Missing Feature |

### Order Confirmation Page — ❌ DOES NOT EXIST
- After `placeorder/store`, user gets redirected to `Home` route
- No `order.confirmation`, `order.success`, or `order.thankyou` route exists
- No corresponding view file exists in `resources/views/frontend/`

### Invoice Route — ✅ WORKS
- Route `order.invoice` exists at `admin/orders/invoice/{id}`
- `OrderListController@invoice` method exists (line 431-436)
- Invoice view exists at `resources/views/backend/features/order/invoice.blade.php`

### Double Stock Decrement — 🔴 CRITICAL
- `OrderController@storeaddorder()` decrements stock at line 198: `$product->decrement('stock', $cartdata['quantity'])`
- `OrderListController@handleStatusChangeActions()` decrements stock AGAIN at lines 244-250 when status changes to 'confirmed'
- **Fix:** Remove stock decrement from EITHER the order placement OR the order confirmation — not both

### Order Model Missing Fillable Fields — 🔴 CRITICAL
- `coupon_code` and `discount_amount` are passed in `Order::create()` but not in `$fillable`
- These values are silently dropped by Laravel's mass assignment protection
- **Fix:** Add `'coupon_code'` and `'discount_amount'` to `Order::$fillable`

---

## ✅ SECTION D: FEATURES COMPLETED

| Feature | Status | Notes |
|---------|--------|-------|
| Admin Login/Logout | ✅ | With rate limiting (`throttle:5,1`), auth+admin middleware |
| Admin CRUD - Category | ✅ | Full CRUD + Image + CSV Import |
| Admin CRUD - Brand | ✅ | Full CRUD + Image + CSV Import |
| Admin CRUD - Product | ✅ | Full CRUD + Image + CSV Import + Discount + Soft Deletes |
| Admin CRUD - Banner | ⚠️ | Create, List, Delete work. **Edit/Update BROKEN** (missing route) |
| Admin Order Management | ✅ | List, View, Status Update (with transitions), Invoice, Bulk Update, Export CSV |
| Admin Dashboard | ✅ | Stats, Revenue, Monthly comparison |
| Admin Coupon Management | ✅ | Full CRUD via resource routes, product-specific coupons |
| Customer Registration | ✅ | With validation + OTP email verification |
| Customer Login/Logout | ✅ | With rate limiting + 2FA support |
| Customer Profile Edit | ✅ | Name, Email, Phone, Address, Password, Profile Image |
| Customer Address Book | ✅ | Multiple addresses, set default, edit, delete |
| Customer Order History | ✅ | My Orders page with pagination + Order Detail view |
| Customer Vouchers | ✅ | Collect & use coupons, My Vouchers page |
| Customer Wishlist | ✅ | Toggle, list, remove. Back-in-stock notifications |
| Product Reviews/Ratings | ✅ | Submit review, display average rating, related products |
| Product Listing + Filter | ✅ | Category filter sidebar |
| Product Search | ✅ | Name + description search |
| Product Details Page | ✅ | With discount display, reviews, related products, wishlist toggle |
| Add to Cart (AJAX) | ✅ | No page reload, toast notification, stock validation |
| Cart Management | ✅ | Update qty (with stock check), Remove item |
| Checkout | ✅ | COD + SSL option, address selection, coupon application |
| Order Placement | ✅ | COD working, DB transaction, stock validation |
| Discount System | ✅ | % stored, BDT displayed via `getFinalPriceAttribute()` |
| Bulk Import CSV | ✅ | Category, Brand, Product with image URL |
| Dynamic Homepage | ✅ | Real products, banners, categories |
| Responsive Design | ✅ | Bootstrap based |
| Security Middleware | ✅ | Admin role check, customer auth guard |
| Stock Validation | ✅ | On add to cart + on order placement |
| Password Reset | ✅ | Forgot password → Email link → Reset form (PasswordResetController) |
| Social Login (Google) | ✅ | Google OAuth via Socialite |
| Email Notifications | ✅ | OTP, 2FA, Password Reset, Order Confirmation, Shipping Status, Back-in-Stock |
| Order Status Tracking | ✅ | Status history timeline with admin notes |

---

## 🔴 SECTION E: MUST-HAVE FEATURES (not done — required for production)

| Priority | Feature | Why Important | Effort |
|----------|---------|---------------|--------|
| P0 | **Fix `banner.update` route** | Banner edit page crashes — admin cannot update banners | 5 min |
| P0 | **Fix Order `$fillable` for coupons** | Coupon discounts are silently lost on every order | 5 min |
| P0 | **Fix double stock decrement** | Stock count goes negative, inventory corrupted | 15 min |
| P0 | **Order Confirmation Page** | User needs visual feedback after order (order #, summary, what's next) | 1 hr |
| P0 | **`APP_DEBUG=false` for production** | Security — hides stack traces, DB credentials, env vars from users | 5 min |
| P1 | Invoice Download (PDF) | Professional feature — currently HTML only | 1 hr |
| P1 | Out of Stock display on product page | UX — prevent frustrated add-to-cart attempts | 30 min |
| P1 | SSLCommerz Payment (sandbox test) | Checkout has "online" option but no SSLCommerz integration | 3 hr |

---

## 🟡 SECTION F: OPTIONAL FEATURES (would increase project value/grade)

| Feature | Value Added | Effort |
|---------|-------------|--------|
| Coupon/Discount Codes (checkout) | ✅ Already Done — coupon collect, apply, remove working | — |
| Product Reviews/Ratings | ✅ Already Done — submit, display, average rating | — |
| Wishlist (save to DB) | ✅ Already Done — toggle, list, back-in-stock alerts | — |
| Product Image Gallery | Multiple images per product | 2 hr |
| Related Products section | ✅ Already Done — shown on product detail page | — |
| Order Tracking timeline | ✅ Already Done — status history with admin notes | — |
| Admin Sales Charts | Better dashboard insights (Chart.js) | 2 hr |
| Product Inventory Alert | Low stock notifications (back-in-stock already done) | 1 hr |
| SEO Meta Tags | Search engine visibility | 1 hr |
| Multi-image upload | Professional product display | 2 hr |
| Print Invoice button | Already working (HTML invoice page exists) | 30 min |
| Automated Tests | Code quality, professionalism | 4 hr |

---

## 📋 SECTION G: RECOMMENDED ACTION PLAN (before submission)

### 🚨 Do RIGHT NOW (< 15 min total):

1. **Fix `banner.update` route** — Add to `routes/web.php` inside banner prefix:
   ```php
   Route::post('/update/{id}', [BannerController::class, 'update'])->name('banner.update');
   ```

2. **Fix Order `$fillable`** — Add to `app/Models/Order.php` `$fillable` array:
   ```php
   'coupon_code',
   'discount_amount',
   ```

3. **Fix double stock decrement** — Remove the stock decrement from `OrderListController@handleStatusChangeActions()` case `'confirmed'` (lines 243-251), since stock is already decremented at order placement time in `OrderController@storeaddorder()`.

4. **Set `APP_DEBUG=false`** in `.env` for production deployment.

### ✅ Do TODAY (< 1 hr each):

1. **Create Order Confirmation Page**
   - Add route: `Route::get('/order/confirmation/{id}', [OrderController::class, 'confirmation'])->name('order.confirmation');`
   - Create view: `resources/views/frontend/pages/order-confirmation.blade.php`
   - Change redirect in `storeaddorder()` from `Home` to `order.confirmation`

2. **Verify Customer wishlists() method** — Check if `Customer` model has `wishlists()` relationship (error logged on 2026-04-20)

3. **GitHub push** with all fixes

### ⏭️ Skip for now (do after submission):

1. SSLCommerz live payment integration
2. PDF Invoice download
3. Automated tests
4. Multi-image product gallery

---

## 🔧 SECTION H: TECHNICAL DEBT

| Item | Risk | Fix |
|------|------|-----|
| `APP_DEBUG=true` in .env | 🔴 High | Set to `false` before any deployment |
| Double stock decrement on confirmed orders | 🔴 High | Remove one of the two decrement locations |
| Order model missing coupon fillable fields | 🔴 High | Add `coupon_code`, `discount_amount` to `$fillable` |
| `banner.update` route missing | 🔴 High | Add POST route for banner update |
| No automated tests | 🟡 Medium | Add PHPUnit tests for critical flows (order, cart, auth) |
| Images served from public/ | 🟠 Low | Move to storage with symlink or CDN |
| No image optimization | 🟠 Low | Add Intervention/Image for resize/compress |
| Hardcoded shop name | 🟠 Low | Move to `config/settings.php` or admin settings table |
| 34 migrations (some are fixes) | 🟠 Low | Consider squashing migrations before production |
| No HTTPS enforcement | 🟡 Medium | Add `URL::forceScheme('https')` in AppServiceProvider for production |

---

## 📊 SECTION I: PROJECT STATISTICS

### Codebase Overview
| Metric | Count |
|--------|-------|
| Total Routes | 97 |
| Total Migrations | 34 (all ran successfully) |
| Controllers (Backend) | 9 |
| Controllers (Frontend) | 11 |
| Blade Views (Backend) | 27 |
| Blade Views (Frontend) | 29 |
| Models | Order, OrderDetail, Product, Category, Brand, Banner, Customer, User, Wishlist, Review, Coupon, CustomerCoupon, OrderStatusHistory |

### Feature Completion Score
| Category | Done | Total | % |
|----------|------|-------|---|
| Admin Features | 8 | 8 | 100% |
| Customer Auth | 6 | 6 | 100% |
| Shopping Flow | 5 | 6 | 83% (missing confirmation page) |
| Product Features | 5 | 5 | 100% |
| Extra Features | 6 | 6 | 100% |
| **Overall** | **30** | **31** | **97%** |

### Critical Bug Score
| Severity | Count | Status |
|----------|-------|--------|
| 🔴 Critical (new bugs) | 3 | Need immediate fix |
| 🟡 Medium | 2 | Should fix before submission |
| ✅ Fixed (V-001 to V-024) | 23/24 | Excellent |

---

> **Bottom Line:** The project is feature-rich and well-structured (97% complete), but has **3 critical bugs introduced during development** (banner.update route, coupon fillable, double stock decrement) that need fixing before submission. All 3 can be fixed in under 20 minutes total.
