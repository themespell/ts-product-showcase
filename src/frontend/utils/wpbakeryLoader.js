export function wpbakeryLoader(initializeReact) {
    const showcaseSelector = '.ts-product-showcase';
    const initializedAttribute = 'data-tsproduct-initialized';

    const isWPBakeryEditor = () => {
        if (window.vc_iframe) {
            return true;
        }

        if (typeof window.vc !== 'undefined') {
            return true;
        }

        return document.body.classList.contains('vc_editor');
    };

    if (!isWPBakeryEditor()) {
        return;
    }

    const initializeElement = (element) => {
        if (!element.hasAttribute(initializedAttribute)) {
            element.setAttribute(initializedAttribute, 'true');
            initializeReact(element);
        }
    };

    const initializeAllShowcases = () => {
        const showcaseElements = document.querySelectorAll(showcaseSelector);
        showcaseElements.forEach(initializeElement);
    };

    setTimeout(() => {
        initializeAllShowcases();
    }, 500);

    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node) => {
                if (node.nodeType !== Node.ELEMENT_NODE) {
                    return;
                }

                if (node.matches?.(showcaseSelector)) {
                    initializeElement(node);
                }

                const newShowcaseElements = node.querySelectorAll?.(showcaseSelector) || [];
                newShowcaseElements.forEach(initializeElement);
            });
        });
    });

    observer.observe(document.body, { childList: true, subtree: true });

    if (window.vc && window.vc.events) {
        window.vc.events.on('shortcodes:add', function () {
            setTimeout(() => {
                initializeAllShowcases();
            }, 300);
        });

        window.vc.events.on('shortcodes:update', function () {
            setTimeout(() => {
                initializeAllShowcases();
            }, 300);
        });

        window.vc.events.on('app.render', function () {
            setTimeout(() => {
                initializeAllShowcases();
            }, 500);
        });
    }

    if (window.vc_iframe) {
        window.vc_iframe.on('ready', function () {
            setTimeout(() => {
                initializeAllShowcases();
            }, 500);
        });
    }

    jQuery(document).on('vc-reload', function () {
        setTimeout(() => {
            initializeAllShowcases();
        }, 300);
    });
}
