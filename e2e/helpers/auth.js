/**
 * Shared authentication helpers for E2E tests.
 * 
 * Centralizes login logic so all spec files use consistent
 * selectors, credentials, and wait strategies.
 */

// ── Constants ────────────────────────────────────────────────
export const BASE_URL = 'http://127.0.0.1:8000';

// Customer (must match the E2E bypass list in CustomerController.php)
export const CUSTOMER_EMAIL = 'himelhasib06@gmail.com';
export const CUSTOMER_PASS  = '12345678';

// Admin (from UserTableSeeder)
export const ADMIN_EMAIL = 'hasib@gmail.com';
export const ADMIN_PASS  = '123456';

// ── Customer Login ───────────────────────────────────────────
/**
 * Log in as the test customer.
 * Uses the E2E bypass in CustomerController (local env only)
 * so OTP/2FA is skipped automatically.
 *
 * @param {import('@playwright/test').Page} page
 */
export async function customerLogin(page) {
  await page.goto(`${BASE_URL}/customer/login`);

  // The login form has id="login", fields are name="login" and name="password"
  await page.fill('#login input[name="login"]', CUSTOMER_EMAIL);
  await page.fill('#login input[name="password"]', CUSTOMER_PASS);
  await page.click('#login button[type="submit"]');

  // Wait for redirect to homepage after successful login
  await page.waitForURL(`${BASE_URL}/`, { timeout: 15000 });
}

// ── Admin Login ──────────────────────────────────────────────
/**
 * Log in as the admin user.
 * Admin login form uses name="email" and name="password",
 * and redirects to /admin on success.
 *
 * @param {import('@playwright/test').Page} page
 */
export async function adminLogin(page) {
  await page.goto(`${BASE_URL}/login`);

  await page.fill('input[name="email"]', ADMIN_EMAIL);
  await page.fill('input[name="password"]', ADMIN_PASS);
  await page.click('button[type="submit"]');

  // Admin dashboard lives at /admin
  await page.waitForURL(`${BASE_URL}/admin`, { timeout: 15000 });
}
