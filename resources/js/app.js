import './bootstrap';
import './parts/tasks_dashboard';

// Livewire 3+ bundles Alpine. Import its instance so we register plugins once
// and let Livewire.start() boot Alpine — avoids a second Alpine instance.
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import focus from '@alpinejs/focus';

Alpine.plugin(focus);
window.Alpine = Alpine;

Livewire.start();


import Sortable from 'sortablejs';


window.Sortable = Sortable;
