/**
 * Auth setup — runs ONCE before all tests.
 * Logs in as admin and customer, saves session cookies
 * so subsequent test files can reuse them without re-logging in.
 * This avoids hitting the throttle:5,1 rate limit.
 */
import { test as setup } from '@playwright/test';
import { adminLogin, customerLogin } from './helpers/auth.js';

const ADMIN_AUTH_FILE = 'e2e/.auth/admin.json';
const CUSTOMER_AUTH_FILE = 'e2e/.auth/customer.json';

setup('authenticate as admin', async ({ page }) => {
  await adminLogin(page);
  await page.context().storageState({ path: ADMIN_AUTH_FILE });
});

setup('authenticate as customer', async ({ page }) => {
  await customerLogin(page);
  await page.context().storageState({ path: CUSTOMER_AUTH_FILE });
});
