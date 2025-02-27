// File: src/ts/core/admin/theme-settings.ts

/**
 * Theme Settings TypeScript
 */

interface AtrawiSettingsData {
    [key: string]: {
        [key: string]: string | string[] | boolean | number;
    };
}

class ThemeSettings {
    private tabs: NodeListOf<Element> | null;
    private forms: NodeListOf<HTMLFormElement> | null;
    private saveButton: HTMLElement | null;
    private saveStatus: HTMLElement | null;
    private saveStatusText: HTMLElement | null;
    private saveStatusIcon: HTMLElement | null;
    private spinner: HTMLElement | null;
    private hasChanges: boolean = false;
    
    constructor() {
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
    private init(): void {
        this.setupTabNavigation();
        this.setupFormHandling();
        this.setupSaveButton();
    }
    
    /**
     * Setup tab navigation.
     */
    private setupTabNavigation(): void {
        if (!this.tabs || this.tabs.length === 0) {
            return;
        }
        
        this.tabs.forEach((tab: Element) => {
            tab.addEventListener('click', (e: Event) => {
                e.preventDefault();
                
                // Check for unsaved changes
                if (this.hasChanges) {
                    if (!confirm('You have unsaved changes. Are you sure you want to leave this tab?')) {
                        return;
                    }
                }
                
                // Get the URL from the tab link
                const url = (tab as HTMLAnchorElement).href;
                
                // Navigate to the URL
                window.location.href = url;
            });
        });
    }
    
    /**
     * Setup form handling.
     */
    private setupFormHandling(): void {
        if (!this.forms || this.forms.length === 0) {
            return;
        }
        
        // Prevent default form submission
        this.forms.forEach((form: HTMLFormElement) => {
            form.addEventListener('submit', (e: Event) => {
                e.preventDefault();
            });
            
            // Track changes to form fields
            form.querySelectorAll('input, select, textarea').forEach((field: Element) => {
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
    private setupSaveButton(): void {
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
    private saveSettings(): void {
        if (!this.forms || this.forms.length === 0) {
            return;
        }
        
        // Show saving status
        this.updateSaveStatus('saving');
        
        // Collect all form data
        const settingsData: AtrawiSettingsData = {};
        
        this.forms.forEach((form: HTMLFormElement) => {
            const formData = new FormData(form);
            const optionGroup = form.getAttribute('data-option-group') || 'atrawi_settings';
            
            if (!settingsData[optionGroup]) {
                settingsData[optionGroup] = {};
            }
            
            for (const [key, value] of formData.entries()) {
                settingsData[optionGroup][key as string] = value as string;
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
            } else {
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
    private updateSaveStatus(status: string, message?: string): void {
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
        } else {
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

// Add TypeScript interfaces for WordPress admin globals
declare global {
    interface Window {
        atrawiAdmin: {
            ajaxUrl: string;
            nonce: string;
        };
    }
}

export default ThemeSettings;