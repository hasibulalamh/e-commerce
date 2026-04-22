import { test, expect } from '@playwright/test';
import { customerLogin, BASE_URL } from './helpers/auth.js';

test.describe('Customer Account Journey', () => {

  test('Customer login page loads', async ({ page }) => {
    await page.goto(`${BASE_URL}/customer/login`);
    await expect(page.locator('#login input[name="login"]')).toBeVisible();
    await expect(page.locator('#login input[name="password"]')).toBeVisible();
    await page.screenshot({ path: 'screenshots/09-customer-login.png' });
  });

  test('Customer valid login (E2E Bypass)', async ({ page }) => {
    await customerLogin(page);
    await expect(page).toHaveURL(BASE_URL + '/');
    await page.screenshot({ path: 'screenshots/10-customer-home.png' });
  });

});

// ── Authenticated tests (reuse session from auth.setup.js) ──
test.describe('Customer Protected Pages', () => {
  test.use({ storageState: 'e2e/.auth/customer.json' });

  test('My Orders page access', async ({ page }) => {
    await page.goto(`${BASE_URL}/customer/orders`);
    await expect(page).toHaveURL(/customer\/orders/);
    await page.screenshot({ path: 'screenshots/11-my-orders.png', fullPage: true });
  });

  test('Profile page access', async ({ page }) => {
    await page.goto(`${BASE_URL}/customer/profile`);
    await expect(page).toHaveURL(/customer\/profile/);
    await page.screenshot({ path: 'screenshots/12-profile.png', fullPage: true });
  });

});
