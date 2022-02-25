require('./bootstrap');

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'

// import naive ui components
import { naiveUiSetup } from './naiveui'
// some nav components
import { Link, Head } from '@inertiajs/inertia-vue3'
// default layout
import Layout from './Shared/Layout'
import { NMessageProvider } from 'naive-ui';

InertiaProgress.init();

createInertiaApp({
    // title resolution
    title: (title) => title.length > 1 ? `Crawler - ${title}` : 'Crawler',
    // resolve page by name
    resolve: async (name) => {
        let page = (await import(`./Pages/${name}`)).default
        
        // only and only if layout is undefined 
        // do we inject the default layout
        if (typeof page.layout === 'undefined') {
            page.layout = Layout
        }

        return page
    },
    // setup
    setup({ el, app, props, plugin }) {
        createApp({ render: () => 
            // we wrap our inertia root in NMessageProvider
            h(
                NMessageProvider,
                [
                    h(app, props)
                ]
            )
            // h(app, props) 
        })
        // register components
            .component('Link', Link)
            .component('Head', Head)
        // register plugins
            .use(plugin)
            .use(naiveUiSetup)
            .mount(el);
    }
});
