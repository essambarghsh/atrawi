/**
 * DOM utility functions
 */

/**
 * Get all elements matching a selector within a container
 * @param selector CSS selector
 * @param container Parent container (defaults to document)
 * @returns Array of matching elements
 */
export function getElements(selector: string, container: Document | HTMLElement = document): HTMLElement[] {
    return Array.from(container.querySelectorAll(selector)) as HTMLElement[];
  }
  
  /**
   * Get the first element matching a selector within a container
   * @param selector CSS selector
   * @param container Parent container (defaults to document)
   * @returns Matching element or null
   */
  export function getElement(selector: string, container: Document | HTMLElement = document): HTMLElement | null {
    return container.querySelector(selector) as HTMLElement | null;
  }
  
  /**
   * Add event listener to multiple elements
   * @param elements Array of elements or CSS selector
   * @param event Event name
   * @param callback Event handler
   * @param options Event listener options
   */
  export function addEventListeners(
    elements: HTMLElement[] | string,
    event: string,
    callback: EventListenerOrEventListenerObject,
    options?: AddEventListenerOptions
  ): void {
    // If elements is a string, treat it as a selector
    const elementsArray = typeof elements === 'string' 
      ? getElements(elements) 
      : elements;
    
    elementsArray.forEach(element => {
      element.addEventListener(event, callback, options);
    });
  }
  
  /**
   * Remove event listener from multiple elements
   * @param elements Array of elements or CSS selector
   * @param event Event name
   * @param callback Event handler
   * @param options Event listener options
   */
  export function removeEventListeners(
    elements: HTMLElement[] | string,
    event: string,
    callback: EventListenerOrEventListenerObject,
    options?: EventListenerOptions
  ): void {
    // If elements is a string, treat it as a selector
    const elementsArray = typeof elements === 'string' 
      ? getElements(elements) 
      : elements;
    
    elementsArray.forEach(element => {
      element.removeEventListener(event, callback, options);
    });
  }
  
  /**
   * Create an HTML element with attributes and content
   * @param tag HTML tag name
   * @param attributes Element attributes
   * @param content Inner HTML or text content
   * @returns Created HTML element
   */
  export function createElement<T extends HTMLElement>(
    tag: string,
    attributes: { [key: string]: string } = {},
    content?: string
  ): T {
    const element = document.createElement(tag) as T;
    
    // Set attributes
    Object.entries(attributes).forEach(([key, value]) => {
      element.setAttribute(key, value);
    });
    
    // Set content if provided
    if (content !== undefined) {
      element.innerHTML = content;
    }
    
    return element;
  }
  
  /**
   * Toggle a class on an element
   * @param element Element to toggle class on
   * @param className Class name to toggle
   * @param force Force add or remove
   * @returns Whether the class is now present
   */
  export function toggleClass(element: HTMLElement, className: string, force?: boolean): boolean {
    if (force !== undefined) {
      if (force) {
        element.classList.add(className);
      } else {
        element.classList.remove(className);
      }
      return force;
    } else {
      return element.classList.toggle(className);
    }
  }
  
  /**
   * Check if an element has a class
   * @param element Element to check
   * @param className Class to check for
   * @returns True if element has class
   */
  export function hasClass(element: HTMLElement, className: string): boolean {
    return element.classList.contains(className);
  }
  
  /**
   * Get the closest parent element matching a selector
   * @param element Starting element
   * @param selector CSS selector
   * @returns Matching parent or null
   */
  export function getClosest(element: HTMLElement, selector: string): HTMLElement | null {
    // Element.closest() polyfill for older browsers
    if (typeof element.closest === 'function') {
      return element.closest(selector);
    }
    
    let el: HTMLElement | null = element;
    while (el) {
      if (el.matches(selector)) {
        return el;
      }
      el = el.parentElement;
    }
    
    return null;
  }