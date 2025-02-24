/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/ts/app.ts":
/*!***********************!*\
  !*** ./src/ts/app.ts ***!
  \***********************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {


/**
 * Main entry point for Atrawi theme JavaScript
 */
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
const theme_1 = __importDefault(__webpack_require__(/*! ./core/theme */ "./src/ts/core/theme.ts"));
const logger_1 = __webpack_require__(/*! ./utils/logger */ "./src/ts/utils/logger.ts");
/**
 * Initialize the theme when the DOM is ready
 */
function initTheme() {
    // Get theme version from meta tag if available
    const versionMeta = document.querySelector('meta[name="theme-version"]');
    const themeVersion = versionMeta ? versionMeta.getAttribute('content') : '1.0.0';
    // Initialize theme singleton
    const theme = theme_1.default.getInstance({
        debug: "development" !== 'production',
        version: themeVersion || '1.0.0'
    });
    // Make theme accessible globally for debugging
    if (true) {
        window.AtrawiTheme = theme;
        (0, logger_1.logInfo)('Theme initialized and available via window.AtrawiTheme');
    }
}
/**
 * Initialize on DOM ready
 */
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initTheme);
}
else {
    initTheme();
}
exports["default"] = initTheme;


/***/ }),

/***/ "./src/ts/components/mobile-menu.ts":
/*!******************************************!*\
  !*** ./src/ts/components/mobile-menu.ts ***!
  \******************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {


/**
 * Mobile Menu Component
 * Handles mobile menu toggle functionality
 */
Object.defineProperty(exports, "__esModule", ({ value: true }));
const logger_1 = __webpack_require__(/*! ../utils/logger */ "./src/ts/utils/logger.ts");
class MobileMenu {
    /**
     * Initialize the mobile menu component
     * @param options Component options
     */
    constructor(options) {
        this.toggle = null;
        this.menu = null;
        this.isOpen = false;
        this.options = options;
        this.init();
    }
    /**
     * Initialize the mobile menu
     */
    init() {
        var _a, _b;
        this.toggle = document.querySelector(((_a = this.options.selectors) === null || _a === void 0 ? void 0 : _a.toggle) || '.mobile-menu-toggle');
        this.menu = document.querySelector(((_b = this.options.selectors) === null || _b === void 0 ? void 0 : _b.menu) || '.mobile-menu');
        if (!this.toggle || !this.menu) {
            if (this.options.debug) {
                (0, logger_1.logError)('Mobile menu elements not found');
            }
            return;
        }
        this.setupEventListeners();
        if (this.options.debug) {
            (0, logger_1.logInfo)('Mobile menu initialized');
        }
    }
    /**
     * Set up event listeners for the mobile menu
     */
    setupEventListeners() {
        if (!this.toggle)
            return;
        // Add click event to toggle button
        this.toggle.addEventListener('click', this.handleToggleClick.bind(this));
        // Close menu when clicking outside
        document.addEventListener('click', (event) => {
            var _a, _b;
            if (!this.isOpen)
                return;
            const target = event.target;
            if (!((_a = this.menu) === null || _a === void 0 ? void 0 : _a.contains(target)) && !((_b = this.toggle) === null || _b === void 0 ? void 0 : _b.contains(target))) {
                this.closeMenu();
            }
        });
        // Close menu on ESC key
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && this.isOpen) {
                this.closeMenu();
            }
        });
    }
    /**
     * Handle mobile menu toggle click
     * @param event Click event
     */
    handleToggleClick(event) {
        event.preventDefault();
        if (this.isOpen) {
            this.closeMenu();
        }
        else {
            this.openMenu();
        }
    }
    /**
     * Open the mobile menu
     */
    openMenu() {
        var _a;
        if (!this.menu)
            return;
        this.menu.classList.remove('hidden');
        this.menu.setAttribute('aria-hidden', 'false');
        (_a = this.toggle) === null || _a === void 0 ? void 0 : _a.setAttribute('aria-expanded', 'true');
        this.isOpen = true;
        // Add animation class
        requestAnimationFrame(() => {
            var _a;
            (_a = this.menu) === null || _a === void 0 ? void 0 : _a.classList.add('menu-open');
        });
        // Prevent body scrolling when menu is open
        document.body.style.overflow = 'hidden';
        if (this.options.debug) {
            (0, logger_1.logInfo)('Mobile menu opened');
        }
    }
    /**
     * Close the mobile menu
     */
    closeMenu() {
        var _a;
        if (!this.menu)
            return;
        this.menu.classList.remove('menu-open');
        (_a = this.toggle) === null || _a === void 0 ? void 0 : _a.setAttribute('aria-expanded', 'false');
        this.isOpen = false;
        // Add a small delay before hiding the menu to allow for animation
        setTimeout(() => {
            var _a, _b;
            (_a = this.menu) === null || _a === void 0 ? void 0 : _a.classList.add('hidden');
            (_b = this.menu) === null || _b === void 0 ? void 0 : _b.setAttribute('aria-hidden', 'true');
            // Restore body scrolling
            document.body.style.overflow = '';
        }, 300);
        if (this.options.debug) {
            (0, logger_1.logInfo)('Mobile menu closed');
        }
    }
    /**
     * Handle window resize event
     */
    onResize() {
        // If window is resized to desktop size, close the mobile menu
        if (window.innerWidth >= 768 && this.isOpen) {
            this.closeMenu();
        }
    }
}
exports["default"] = MobileMenu;


/***/ }),

/***/ "./src/ts/core/theme.ts":
/*!******************************!*\
  !*** ./src/ts/core/theme.ts ***!
  \******************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {


/**
 * Core Theme class that implements the Singleton pattern
 * and handles the initialization of all theme components
 */
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
const mobile_menu_1 = __importDefault(__webpack_require__(/*! ../components/mobile-menu */ "./src/ts/components/mobile-menu.ts"));
const logger_1 = __webpack_require__(/*! ../utils/logger */ "./src/ts/utils/logger.ts");
class Theme {
    /**
     * Get the singleton instance of the Theme class
     * @param options Theme initialization options
     * @returns Theme instance
     */
    static getInstance(options) {
        if (!Theme.instance) {
            Theme.instance = new Theme(options);
        }
        return Theme.instance;
    }
    /**
     * Private constructor to prevent direct instantiation
     * @param options Theme initialization options
     */
    constructor(options) {
        this.components = new Map();
        this.options = options;
        this.init();
    }
    /**
     * Initialize the theme and all its components
     */
    init() {
        if (this.options.debug) {
            (0, logger_1.logInfo)(`Atrawi Theme initialized (v${this.options.version})`);
        }
        this.registerComponents();
        this.setupEventListeners();
    }
    /**
     * Register all theme components
     */
    registerComponents() {
        // Initialize mobile menu
        this.components.set('mobileMenu', new mobile_menu_1.default({
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
    setupEventListeners() {
        // Handle resize events
        window.addEventListener('resize', this.handleResize.bind(this));
        // Handle scroll events with debounce
        let scrollTimeout = null;
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
    handleResize() {
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
    handleScroll() {
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
    getComponent(name) {
        return this.components.get(name);
    }
}
Theme.instance = null;
exports["default"] = Theme;


/***/ }),

/***/ "./src/ts/utils/logger.ts":
/*!********************************!*\
  !*** ./src/ts/utils/logger.ts ***!
  \********************************/
/***/ ((__unused_webpack_module, exports) => {


/**
 * Logger utility for consistent logging throughout the theme
 */
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.logInfo = logInfo;
exports.logWarning = logWarning;
exports.logError = logError;
exports.logDebug = logDebug;
const THEME_PREFIX = '[Atrawi]';
/**
 * Log an informational message
 * @param message Message to log
 * @param data Optional data to log
 */
function logInfo(message, data) {
    console.log(`${THEME_PREFIX} ${message}`, data || '');
}
/**
 * Log a warning message
 * @param message Warning message to log
 * @param data Optional data to log
 */
function logWarning(message, data) {
    console.warn(`${THEME_PREFIX} ${message}`, data || '');
}
/**
 * Log an error message
 * @param message Error message to log
 * @param data Optional data to log
 */
function logError(message, data) {
    console.error(`${THEME_PREFIX} ${message}`, data || '');
}
/**
 * Log a message only when in development mode
 * @param message Message to log
 * @param data Optional data to log
 */
function logDebug(message, data) {
    if (true) {
        console.log(`${THEME_PREFIX} [DEBUG] ${message}`, data || '');
    }
}


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module is referenced by other modules so it can't be inlined
/******/ 	var __webpack_exports__ = __webpack_require__("./src/ts/app.ts");
/******/ 	
/******/ })()
;
//# sourceMappingURL=app.js.map