/**
 * Mobile Menu Component
 * Handles mobile menu toggle functionality
 */

import { ComponentOptions } from '../core/types';
import { logInfo, logError } from '../utils/logger';

export default class MobileMenu {
  private toggle: HTMLElement | null = null;
  private menu: HTMLElement | null = null;
  private isOpen: boolean = false;
  private options: ComponentOptions;
  
  /**
   * Initialize the mobile menu component
   * @param options Component options
   */
  constructor(options: ComponentOptions) {
    this.options = options;
    this.init();
  }
  
  /**
   * Initialize the mobile menu
   */
  private init(): void {
    this.toggle = document.querySelector(this.options.selectors?.toggle || '.mobile-menu-toggle');
    this.menu = document.querySelector(this.options.selectors?.menu || '.mobile-menu');
    
    if (!this.toggle || !this.menu) {
      if (this.options.debug) {
        logError('Mobile menu elements not found');
      }
      return;
    }
    
    this.setupEventListeners();
    if (this.options.debug) {
      logInfo('Mobile menu initialized');
    }
  }
  
  /**
   * Set up event listeners for the mobile menu
   */
  private setupEventListeners(): void {
    if (!this.toggle) return;
    
    // Add click event to toggle button
    this.toggle.addEventListener('click', this.handleToggleClick.bind(this));
    
    // Close menu when clicking outside
    document.addEventListener('click', (event: Event) => {
      if (!this.isOpen) return;
      
      const target = event.target as HTMLElement;
      if (!this.menu?.contains(target) && !this.toggle?.contains(target)) {
        this.closeMenu();
      }
    });
    
    // Close menu on ESC key
    document.addEventListener('keydown', (event: KeyboardEvent) => {
      if (event.key === 'Escape' && this.isOpen) {
        this.closeMenu();
      }
    });
  }
  
  /**
   * Handle mobile menu toggle click
   * @param event Click event
   */
  private handleToggleClick(event: Event): void {
    event.preventDefault();
    
    if (this.isOpen) {
      this.closeMenu();
    } else {
      this.openMenu();
    }
  }
  
  /**
   * Open the mobile menu
   */
  public openMenu(): void {
    if (!this.menu) return;
    
    this.menu.classList.remove('hidden');
    this.menu.setAttribute('aria-hidden', 'false');
    this.toggle?.setAttribute('aria-expanded', 'true');
    this.isOpen = true;
    
    // Add animation class
    requestAnimationFrame(() => {
      this.menu?.classList.add('menu-open');
    });
    
    // Prevent body scrolling when menu is open
    document.body.style.overflow = 'hidden';
    
    if (this.options.debug) {
      logInfo('Mobile menu opened');
    }
  }
  
  /**
   * Close the mobile menu
   */
  public closeMenu(): void {
    if (!this.menu) return;
    
    this.menu.classList.remove('menu-open');
    this.toggle?.setAttribute('aria-expanded', 'false');
    this.isOpen = false;
    
    // Add a small delay before hiding the menu to allow for animation
    setTimeout(() => {
      this.menu?.classList.add('hidden');
      this.menu?.setAttribute('aria-hidden', 'true');
      
      // Restore body scrolling
      document.body.style.overflow = '';
    }, 300);
    
    if (this.options.debug) {
      logInfo('Mobile menu closed');
    }
  }
  
  /**
   * Handle window resize event
   */
  public onResize(): void {
    // If window is resized to desktop size, close the mobile menu
    if (window.innerWidth >= 768 && this.isOpen) {
      this.closeMenu();
    }
  }
}