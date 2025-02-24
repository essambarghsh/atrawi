interface ThemeOptions {
    debug: boolean;
    version: string;
}

class AtrawiTheme {
    private options: ThemeOptions;

    constructor(options: ThemeOptions) {
        this.options = options;
        this.init();
    }

    private init(): void {
        if (this.options.debug) {
            console.log(`Atrawi Theme initialized (v${this.options.version})`);
        }

        this.setupEventListeners();
    }

    private setupEventListeners(): void {
        document.addEventListener('DOMContentLoaded', () => {
            this.handleMobileMenu();
        });
    }

    private handleMobileMenu(): void {
        const menuToggle = document.querySelector('.mobile-menu-toggle');
        const mobileMenu = document.querySelector('.mobile-menu');

        if (menuToggle && mobileMenu) {
            menuToggle.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    }
}

// Initialize the theme
const atrawi = new AtrawiTheme({
    debug: true,
    version: '1.0.0'
});

export default atrawi;