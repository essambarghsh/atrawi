/**
 * Logger utility for consistent logging throughout the theme
 */

const THEME_PREFIX = '[Atrawi]';

/**
 * Log an informational message
 * @param message Message to log
 * @param data Optional data to log
 */
export function logInfo(message: string, data?: any): void {
  console.log(`${THEME_PREFIX} ${message}`, data || '');
}

/**
 * Log a warning message
 * @param message Warning message to log
 * @param data Optional data to log
 */
export function logWarning(message: string, data?: any): void {
  console.warn(`${THEME_PREFIX} ${message}`, data || '');
}

/**
 * Log an error message
 * @param message Error message to log
 * @param data Optional data to log
 */
export function logError(message: string, data?: any): void {
  console.error(`${THEME_PREFIX} ${message}`, data || '');
}

/**
 * Log a message only when in development mode
 * @param message Message to log
 * @param data Optional data to log
 */
export function logDebug(message: string, data?: any): void {
  if (process.env.NODE_ENV !== 'production') {
    console.log(`${THEME_PREFIX} [DEBUG] ${message}`, data || '');
  }
}