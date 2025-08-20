import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue'
import { createInertiaApp, Link, Head } from '@inertiajs/vue3'

createInertiaApp({
  title: (title) => `My App | ${title}`,
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .component('Link', Link)
      .component('Head', Head)
      .mount(el)
  },
  progress: {
    // delay: 250,
    color: '#4B0082',
    includeCSS: true,
    showSpinner: true,
  },
})
