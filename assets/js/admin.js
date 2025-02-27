/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/ts/core/admin/admin.ts":
/*!************************************!*\
  !*** ./src/ts/core/admin/admin.ts ***!
  \************************************/
/***/ (function(__unused_webpack_module, __unused_webpack_exports, __webpack_require__) {


// File: src/ts/core/admin/admin.ts
var __createBinding = (this && this.__createBinding) || (Object.create ? (function(o, m, k, k2) {
    if (k2 === undefined) k2 = k;
    var desc = Object.getOwnPropertyDescriptor(m, k);
    if (!desc || ("get" in desc ? !m.__esModule : desc.writable || desc.configurable)) {
      desc = { enumerable: true, get: function() { return m[k]; } };
    }
    Object.defineProperty(o, k2, desc);
}) : (function(o, m, k, k2) {
    if (k2 === undefined) k2 = k;
    o[k2] = m[k];
}));
var __setModuleDefault = (this && this.__setModuleDefault) || (Object.create ? (function(o, v) {
    Object.defineProperty(o, "default", { enumerable: true, value: v });
}) : function(o, v) {
    o["default"] = v;
});
var __importStar = (this && this.__importStar) || (function () {
    var ownKeys = function(o) {
        ownKeys = Object.getOwnPropertyNames || function (o) {
            var ar = [];
            for (var k in o) if (Object.prototype.hasOwnProperty.call(o, k)) ar[ar.length] = k;
            return ar;
        };
        return ownKeys(o);
    };
    return function (mod) {
        if (mod && mod.__esModule) return mod;
        var result = {};
        if (mod != null) for (var k = ownKeys(mod), i = 0; i < k.length; i++) if (k[i] !== "default") __createBinding(result, mod, k[i]);
        __setModuleDefault(result, mod);
        return result;
    };
})();
/**
 * Main entry point for Atrawi theme JavaScript
 */
// Import admin functionality if in admin area
if (typeof window !== 'undefined' && window.wp && typeof window.wp.customize === 'undefined') {
    // Check if we're in the WordPress admin (but not in the customizer)
    Promise.resolve().then(() => __importStar(__webpack_require__(/*! ./theme-settings */ "./src/ts/core/admin/theme-settings.ts"))).then(module => {
        // Admin functionality loaded
    }).catch(error => {
        console.error('Error loading admin functionality:', error);
    });
}


/***/ }),

/***/ "./src/ts/core/admin/theme-settings.ts":
/*!*********************************************!*\
  !*** ./src/ts/core/admin/theme-settings.ts ***!
  \*********************************************/
/***/ ((__unused_webpack_module, exports) => {


// File: src/ts/core/admin/theme-settings.ts
Object.defineProperty(exports, "__esModule", ({ value: true }));
class ThemeSettings {
    constructor() {
        this.hasChanges = false;
        this.tabs = document.querySelectorAll('.atrawi-tab');
        this.forms = document.querySelectorAll('.atrawi-settings-form form');
        this.saveButton = document.querySelector('.atrawi-save-settings');
        this.saveStatus = document.querySelector('.atrawi-save-status');
        this.saveStatusText = document.querySelector('.atrawi-save-status-text');
        this.saveStatusIcon = document.querySelector('.atrawi-save-status-icon');
        this.spinner = document.querySelector('.atrawi-spinner');
        this.init();
    }
    /**
     * Initialize the theme settings.
     */
    init() {
        this.setupTabNavigation();
        this.setupFormHandling();
        this.setupSaveButton();
    }
    /**
     * Setup tab navigation.
     */
    setupTabNavigation() {
        if (!this.tabs || this.tabs.length === 0) {
            return;
        }
        this.tabs.forEach((tab) => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                // Check for unsaved changes
                if (this.hasChanges) {
                    if (!confirm('You have unsaved changes. Are you sure you want to leave this tab?')) {
                        return;
                    }
                }
                // Get the URL from the tab link
                const url = tab.href;
                // Navigate to the URL
                window.location.href = url;
            });
        });
    }
    /**
     * Setup form handling.
     */
    setupFormHandling() {
        if (!this.forms || this.forms.length === 0) {
            return;
        }
        // Prevent default form submission
        this.forms.forEach((form) => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
            });
            // Track changes to form fields
            form.querySelectorAll('input, select, textarea').forEach((field) => {
                field.addEventListener('change', () => {
                    this.hasChanges = true;
                    this.updateSaveStatus('unsaved');
                });
            });
        });
    }
    /**
     * Setup save button.
     */
    setupSaveButton() {
        if (!this.saveButton) {
            return;
        }
        this.saveButton.addEventListener('click', () => {
            this.saveSettings();
        });
    }
    /**
     * Save settings via AJAX.
     */
    saveSettings() {
        if (!this.forms || this.forms.length === 0) {
            return;
        }
        // Show saving status
        this.updateSaveStatus('saving');
        // Collect all form data
        const settingsData = {};
        this.forms.forEach((form) => {
            const formData = new FormData(form);
            const optionGroup = form.getAttribute('data-option-group') || 'atrawi_settings';
            if (!settingsData[optionGroup]) {
                settingsData[optionGroup] = {};
            }
            for (const [key, value] of formData.entries()) {
                settingsData[optionGroup][key] = value;
            }
        });
        // Get current section
        const urlParams = new URLSearchParams(window.location.search);
        const currentSection = urlParams.get('section') || '';
        // Send AJAX request
        fetch(window.atrawiAdmin.ajaxUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'atrawi_save_settings',
                nonce: window.atrawiAdmin.nonce,
                settings: JSON.stringify(settingsData),
                section: currentSection
            })
        })
            .then(response => response.json())
            .then(response => {
            if (response.success) {
                this.updateSaveStatus('saved');
                this.hasChanges = false;
                // Reset status after a delay
                setTimeout(() => {
                    if (!this.hasChanges) {
                        this.updateSaveStatus('');
                    }
                }, 3000);
            }
            else {
                this.updateSaveStatus('error', response.data.message || 'Error saving settings.');
            }
        })
            .catch(error => {
            console.error('Error saving settings:', error);
            this.updateSaveStatus('error', 'Error saving settings.');
        });
    }
    /**
     * Update save status.
     *
     * @param status Status: 'saving', 'saved', 'error', 'unsaved', or empty for default.
     * @param message Optional status message.
     */
    updateSaveStatus(status, message) {
        if (!this.saveStatus || !this.saveStatusText || !this.saveStatusIcon || !this.spinner) {
            return;
        }
        // Remove all status classes
        this.saveStatus.classList.remove('saving', 'saved', 'error', 'unsaved');
        // Add appropriate class and message
        if (status) {
            this.saveStatus.classList.add(status);
            switch (status) {
                case 'saving':
                    this.saveStatusText.textContent = 'Saving changes...';
                    this.spinner.classList.add('is-active');
                    break;
                case 'saved':
                    this.saveStatusText.textContent = message || 'Changes saved successfully!';
                    this.spinner.classList.remove('is-active');
                    break;
                case 'error':
                    this.saveStatusText.textContent = message || 'Error saving changes.';
                    this.spinner.classList.remove('is-active');
                    break;
                case 'unsaved':
                    this.saveStatusText.textContent = 'You have unsaved changes.';
                    this.spinner.classList.remove('is-active');
                    break;
            }
        }
        else {
            // Default state (no message)
            this.saveStatusText.textContent = '';
            this.spinner.classList.remove('is-active');
        }
    }
}
// Initialize the theme settings when the DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new ThemeSettings();
});
exports["default"] = ThemeSettings;


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
/******/ 	var __webpack_exports__ = __webpack_require__("./src/ts/core/admin/admin.ts");
/******/ 	
/******/ })()
;
//# sourceMappingURL=admin.js.map