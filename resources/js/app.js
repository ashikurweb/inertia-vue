import './bootstrap';
import '../css/app.css';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import { createApp, h } from 'vue'
import { createInertiaApp, Link, Head } from '@inertiajs/vue3'
import { Icon } from "@iconify/vue";
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

createInertiaApp({
  title: (title) => `My App | ${title}`,
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue, Ziggy)
      .component('Icon', Icon)
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
