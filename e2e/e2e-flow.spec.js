import { test, expect } from '@playwright/test';

test.describe('E2E Flow - Basic Shopping Journey', () => {
  test('Search and View Product', async ({ page }) => {
    // 1. Go to homepage
    await page.goto('/');
    
    // Check if the page title or a key element is present
    await expect(page).toHaveTitle(/Shop | eCommers|Laravel|Capital Shop/i);

    // 2. Search for a product
    const searchInput = page.locator('input[name="q"]');
    if (await searchInput.isVisible()) {
      await searchInput.fill('iPhone');
      await searchInput.press('Enter');
      
      // 3. Verify search results
      await expect(page).toHaveURL(/search/);
    }

    // 4. Click on the first product link
    const firstProduct = page.locator('.properties-card a, a[href*="product-details"]').first();
    if (await firstProduct.isVisible()) {
      await firstProduct.click();
      
      // 5. Verify Product Detail Page
      await expect(page.locator('a:has-text("Add to Cart")')).toBeVisible();
    }
  });

  test('Cart Flow', async ({ page }) => {
    await page.goto('/');
    
    // Navigate to cart
    const cartLink = page.locator('a[href*="cart-view"]');
    if (await cartLink.isVisible()) {
        await cartLink.click();
        await expect(page).toHaveURL(/cart/);
        await expect(page.locator('h1, h2, h3')).toContainText(/Cart|Shopping/i);
    }
  });
});
