/**
 * Main entry point for Atrawi theme JavaScript
 */

import Theme from './core/theme';
import { logInfo } from './utils/logger';

/**
 * Initialize the theme when the DOM is ready
 */
function initTheme(): void {
  // Get theme version from meta tag if available
  const versionMeta = document.querySelector('meta[name="theme-version"]');
  const themeVersion = versionMeta ? versionMeta.getAttribute('content') : '1.0.0';
  
  // Initialize theme singleton
  const theme = Theme.getInstance({
    debug: process.env.NODE_ENV !== 'production',
    version: themeVersion || '1.0.0'
  });
  
  // Make theme accessible globally for debugging
  if (process.env.NODE_ENV !== 'production') {
    (window as any).AtrawiTheme = theme;
    logInfo('Theme initialized and available via window.AtrawiTheme');
  }
}

/**
 * Initialize on DOM ready
 */
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initTheme);
} else {
  initTheme();
}

export default initTheme;