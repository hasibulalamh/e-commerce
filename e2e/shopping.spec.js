import { test, expect } from '@playwright/test';
import { BASE_URL } from './helpers/auth.js';

// ── Public pages (no auth needed) ───────────────────────────
test.describe('Shopping - Public Pages', () => {

  test('Homepage loads', async ({ page }) => {
    await page.goto(BASE_URL);
    await expect(page).toHaveTitle(/Shop \| eCommers/i);
    await page.screenshot({ path: 'screenshots/13-homepage.png', fullPage: true });
  });

  test('Product list page', async ({ page }) => {
    await page.goto(`${BASE_URL}/product/list`);
    await expect(page).toHaveURL(/product\/list/);
    await page.screenshot({ path: 'screenshots/14-products.png', fullPage: true });
  });

  test('Search works', async ({ page }) => {
    await page.goto(BASE_URL);
    const searchInput = page.locator('input[name="q"]');
    if (await searchInput.isVisible()) {
      await searchInput.fill('Samsung');
      await searchInput.press('Enter');
      await expect(page).toHaveURL(/search/);
    }
    await page.screenshot({ path: 'screenshots/15-search.png', fullPage: true });
  });

  test('Brand page loads', async ({ page }) => {
    await page.goto(`${BASE_URL}/Brand`);
    await expect(page).toHaveURL(/Brand/);
    await page.screenshot({ path: 'screenshots/16-brands.png', fullPage: true });
  });

});

// ── Authenticated pages (reuse session from auth.setup.js) ──
test.describe('Shopping - Authenticated Flow', () => {
  test.use({ storageState: 'e2e/.auth/customer.json' });

  test('Cart page loads', async ({ page }) => {
    await page.goto(`${BASE_URL}/cart/view`);
    await expect(page).toHaveURL(/cart\/view/);
    await page.screenshot({ path: 'screenshots/17-cart.png', fullPage: true });
  });

  test('Add to cart via AJAX', async ({ page }) => {
    await page.goto(`${BASE_URL}/product/list`);
    const cartBtn = page.locator('.ajax-cart-btn').first();
    if (await cartBtn.count() > 0) {
      await cartBtn.click();
      // Wait for AJAX success indicator
      await page.waitForTimeout(2500);
    }
    await page.screenshot({ path: 'screenshots/18-add-to-cart.png' });
  });

  test('Checkout page loads', async ({ page }) => {
    await page.goto(`${BASE_URL}/cart/checkout`);
    await page.screenshot({ path: 'screenshots/19-checkout.png', fullPage: true });
  });

  test('Complete order flow', async ({ page }) => {
    // Add a product to cart dynamically
    await page.goto(`${BASE_URL}/product/list`);
    const addBtn = page.locator('.ajax-cart-btn').first();
    if (await addBtn.count() > 0) {
      const cartUrl = await addBtn.getAttribute('href') || await addBtn.getAttribute('data-url');
      if (cartUrl) {
        await page.goto(cartUrl.startsWith('http') ? cartUrl : `${BASE_URL}${cartUrl}`);
        await page.waitForTimeout(1000);
      }
    }

    // Go to checkout
    await page.goto(`${BASE_URL}/cart/checkout`);

    // Fill checkout form
    const numberField = page.locator('input[name="number"]');
    if (await numberField.isVisible()) await numberField.fill('01700000000');

    const addressField = page.locator('input[name="address"]');
    if (await addressField.isVisible()) await addressField.fill('Dhaka Road');

    const cityField = page.locator('input[name="city"]');
    if (await cityField.isVisible()) await cityField.fill('Dhaka');

    // Select payment method
    const cashRadio = page.locator('input[value="CASH"]');
    if (await cashRadio.isVisible()) await cashRadio.click();

    // Submit order
    const submitBtn = page.locator('.btn-place-order');
    if (await submitBtn.isVisible()) {
      await submitBtn.click();
      await page.waitForTimeout(3000);
    }

    await page.screenshot({ path: 'screenshots/20-order-done.png', fullPage: true });
  });

});
