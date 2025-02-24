/**
 * Core type definitions for Atrawi Theme
 */

export interface ThemeOptions {
    debug: boolean;
    version: string;
  }
  
  export interface ComponentOptions {
    selectors?: {
      [key: string]: string;
    };
    debug?: boolean;
  }
  
  export interface EventHandlers {
    [key: string]: (event: Event) => void;
  }