import { test, expect } from '@playwright/test';
import { BASE_URL, ADMIN_EMAIL } from './helpers/auth.js';

// ── Unauthenticated tests (no stored state needed) ──────────
test.describe('Admin Authentication', () => {

  test('Admin login page loads', async ({ page }) => {
    await page.goto(`${BASE_URL}/login`);
    await expect(page.locator('input[name="email"]')).toBeVisible();
    await expect(page.locator('input[name="password"]')).toBeVisible();
    await page.screenshot({ path: 'screenshots/01-admin-login.png' });
  });

  test('Admin wrong password rejected', async ({ page }) => {
    await page.goto(`${BASE_URL}/login`);
    await page.fill('input[name="email"]', ADMIN_EMAIL);
    await page.fill('input[name="password"]', 'wrongpass');
    await page.click('button[type="submit"]');
    // Wait for redirect back to login
    await page.waitForURL(url => url.pathname.includes('/login'));
    await expect(page).toHaveURL(/login/);
    await page.screenshot({ path: 'screenshots/03-admin-login-fail.png' });
  });

});

// ── Authenticated tests (reuse session from auth.setup.js) ──
test.describe('Admin Panel Pages', () => {
  test.use({ storageState: 'e2e/.auth/admin.json' });

  test('Admin dashboard loads', async ({ page }) => {
    await page.goto(`${BASE_URL}/admin`);
    await expect(page).toHaveURL(/admin/);
    await page.screenshot({ path: 'screenshots/02-admin-dashboard.png', fullPage: true });
  });

  test('Category list loads', async ({ page }) => {
    await page.goto(`${BASE_URL}/admin/categories`);
    await expect(page).toHaveURL(/admin\/categories/);
    await page.screenshot({ path: 'screenshots/04-category-list.png', fullPage: true });
  });

  test('Product list loads', async ({ page }) => {
    await page.goto(`${BASE_URL}/admin/products`);
    await expect(page).toHaveURL(/admin\/products/);
    await page.screenshot({ path: 'screenshots/05-product-list.png', fullPage: true });
  });

  test('Order list loads', async ({ page }) => {
    await page.goto(`${BASE_URL}/admin/orders`);
    await expect(page).toHaveURL(/admin\/orders/);
    await page.screenshot({ path: 'screenshots/06-order-list.png', fullPage: true });
  });

  test('Brand list loads', async ({ page }) => {
    await page.goto(`${BASE_URL}/admin/brands`);
    await expect(page).toHaveURL(/admin\/brands/);
    await page.screenshot({ path: 'screenshots/07-brand-list.png', fullPage: true });
  });

  test('Invoice page loads', async ({ page }) => {
    await page.goto(`${BASE_URL}/admin/orders/invoice/1`);
    await page.screenshot({ path: 'screenshots/08-invoice.png', fullPage: true });
  });

});
