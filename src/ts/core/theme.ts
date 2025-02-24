/**
 * Core Theme class that implements the Singleton pattern
 * and handles the initialization of all theme components
 */

import { ThemeOptions } from './types';
import MobileMenu from '../components/mobile-menu';
import { logInfo } from '../utils/logger';

export default class Theme {
  private options: ThemeOptions;
  private static instance: Theme | null = null;
  private components: Map<string, any> = new Map();
  
  /**
   * Get the singleton instance of the Theme class
   * @param options Theme initialization options
   * @returns Theme instance
   */
  public static getInstance(options: ThemeOptions): Theme {
    if (!Theme.instance) {
      Theme.instance = new Theme(options);
    }
    return Theme.instance;
  }
  
  /**
   * Private constructor to prevent direct instantiation
   * @param options Theme initialization options
   */
  private constructor(options: ThemeOptions) {
    this.options = options;
    this.init();
  }
  
  /**
   * Initialize the theme and all its components
   */
  private init(): void {
    if (this.options.debug) {
      logInfo(`Atrawi Theme initialized (v${this.options.version})`);
    }
    
    this.registerComponents();
    this.setupEventListeners();
  }
  
  /**
   * Register all theme components
   */
  private registerComponents(): void {
    // Initialize mobile menu
    this.components.set('mobileMenu', new MobileMenu({
      selectors: {
        toggle: '.mobile-menu-toggle',
        menu: '.mobile-menu'
      },
      debug: this.options.debug
    }));
  }
  
  /**
   * Set up global event listeners
   */
  private setupEventListeners(): void {
    // Handle resize events
    window.addEventListener('resize', this.handleResize.bind(this));
    
    // Handle scroll events with debounce
    let scrollTimeout: number | null = null;
    window.addEventListener('scroll', () => {
      if (scrollTimeout) {
        window.clearTimeout(scrollTimeout);
      }
      scrollTimeout = window.setTimeout(() => {
        this.handleScroll();
      }, 100);
    });
  }
  
  /**
   * Handle window resize events
   */
  private handleResize(): void {
    // Notify all components about the resize event
    this.components.forEach(component => {
      if (typeof component.onResize === 'function') {
        component.onResize();
      }
    });
  }
  
  /**
   * Handle window scroll events
   */
  private handleScroll(): void {
    // Notify all components about the scroll event
    this.components.forEach(component => {
      if (typeof component.onScroll === 'function') {
        component.onScroll();
      }
    });
  }
  
  /**
   * Get a specific component by name
   * @param name Component name
   * @returns Component instance or undefined
   */
  public getComponent(name: string): any {
    return this.components.get(name);
  }
}