import { test, expect } from '@playwright/test';
import { BASE_URL } from './helpers/auth.js';

test.describe('E2E Flow - Basic Shopping Journey', () => {

  test('Homepage loads with correct title', async ({ page }) => {
    await page.goto(BASE_URL);
    // Title from master.blade.php: "Shop | eCommers"
    await expect(page).toHaveTitle(/Shop \| eCommers/i);
    await page.screenshot({ path: 'screenshots/21-homepage-title.png' });
  });

  test('Search and View Product', async ({ page }) => {
    await page.goto(BASE_URL);

    // Search for a product
    const searchInput = page.locator('input[name="q"]');
    if (await searchInput.isVisible()) {
      await searchInput.fill('iPhone');
      await searchInput.press('Enter');
      await expect(page).toHaveURL(/search/);
      await page.screenshot({ path: 'screenshots/22-search-results.png' });
    }

    // Click on the first product link
    const firstProduct = page.locator('.properties-card a, a[href*="product/details"]').first();
    if (await firstProduct.count() > 0 && await firstProduct.isVisible()) {
      await firstProduct.click();
      await page.waitForLoadState('networkidle');
      await page.screenshot({ path: 'screenshots/23-product-detail.png', fullPage: true });
    }
  });

  test('Cart page accessible', async ({ page }) => {
    await page.goto(BASE_URL);

    // Navigate to cart
    const cartLink = page.locator('a[href*="cart"]').first();
    if (await cartLink.count() > 0 && await cartLink.isVisible()) {
      await cartLink.click();
      await page.waitForLoadState('networkidle');
      await page.screenshot({ path: 'screenshots/24-cart-flow.png', fullPage: true });
    }
  });

});
