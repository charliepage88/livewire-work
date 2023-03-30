import './bootstrap';
import './parts/tasks_dashboard';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();


import Sortable from 'sortablejs';


window.Sortable = Sortable;
