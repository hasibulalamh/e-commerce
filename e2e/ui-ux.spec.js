import { test } from '@playwright/test';
import { playAudit } from 'playwright-lighthouse';

test.describe('UI/UX Lighthouse Audit', () => {
  test('Audit Homepage', async ({ page }) => {
    // Navigate to homepage and wait for network to be idle
    await page.goto('/', { waitUntil: 'networkidle' });
    
    await playAudit({
      page: page,
      port: 9222,
      thresholds: {
        performance: 20,
        accessibility: 70,
        'best-practices': 70,
        seo: 70,
      },
      reports: {
        formats: {
          html: true,
        },
        name: `lighthouse-homepage`,
        directory: 'playwright-report/lighthouse',
      },
    });
  });

  test('Audit Product Listing', async ({ page }) => {
    // Navigate to a product listing page and wait for network to be idle
    await page.goto('/product/list', { waitUntil: 'networkidle' }); 
    
    await playAudit({
      page: page,
      port: 9222,
      thresholds: {
        performance: 20,
        accessibility: 70,
        'best-practices': 70,
        seo: 70,
      },
      reports: {
        formats: {
          html: true,
        },
        name: `lighthouse-products`,
        directory: 'playwright-report/lighthouse',
      },
    });
  });
});
