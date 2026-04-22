// @ts-check
import { defineConfig, devices } from '@playwright/test';

export default defineConfig({
  testDir: './e2e',

  /* Run tests sequentially — login state matters */
  fullyParallel: false,
  workers: 1,

  /* CI-specific settings */
  forbidOnly: !!process.env.CI,
  retries: process.env.CI ? 2 : 0,

  /* Reporter: HTML report with screenshots */
  reporter: 'html',

  /* Shared settings for all tests */
  use: {
    baseURL: 'http://127.0.0.1:8000',
    trace: 'on-first-retry',
    screenshot: 'only-on-failure',
    video: 'on-first-retry',
  },

  projects: [
    /* Setup project: logs in once and saves session cookies */
    {
      name: 'setup',
      testMatch: /auth\.setup\.js$/,
      use: {
        ...devices['Desktop Chrome'],
      },
    },

    /* Main test project: depends on setup for auth state */
    {
      name: 'chromium',
      use: {
        ...devices['Desktop Chrome'],
        launchOptions: {
          args: ['--remote-debugging-port=9222'],
        },
      },
      dependencies: ['setup'],
      testIgnore: /\.setup\.js$/,
    },

    // Uncomment to test on additional browsers:
    // {
    //   name: 'firefox',
    //   use: { ...devices['Desktop Firefox'] },
    //   dependencies: ['setup'],
    //   testIgnore: /\.setup\.js$/,
    // },
    // {
    //   name: 'webkit',
    //   use: { ...devices['Desktop Safari'] },
    //   dependencies: ['setup'],
    //   testIgnore: /\.setup\.js$/,
    // },
  ],

  /* Auto-start the Laravel dev server */
  webServer: {
    command: 'php artisan serve --port=8000',
    url: 'http://127.0.0.1:8000',
    reuseExistingServer: !process.env.CI,
    stdout: 'pipe',
    stderr: 'pipe',
    timeout: 30000,
  },
});
