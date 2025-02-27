// File: src/ts/types/wordpress.d.ts

interface WPCustomize {
    [key: string]: any;
}

interface WordPress {
    customize: WPCustomize;
    [key: string]: any;
}

interface Window {
    wp: WordPress;
}