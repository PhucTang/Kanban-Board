import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import PerfectScrollbar from 'vue3-perfect-scrollbar';
import 'vue3-perfect-scrollbar/dist/vue3-perfect-scrollbar.css';

import Alpine from 'alpinejs';
import TaskCard from './components/TaskCard.vue';
import TaskColumn from './components/TaskColumn.vue';
import KanbanBoard from './components/KanbanBoard.vue';
import GenericModal from './components/modals/GenericModal.vue';

const pinia = createPinia()
const app = createApp({});
app.use(pinia);
app.use(PerfectScrollbar);

app.component('TaskCard', TaskCard);
app.component('TaskColumn', TaskColumn);
app.component('KanbanBoard', KanbanBoard);
app.component('GenericModal', GenericModal);

app.mount("#app");


window.Alpine = Alpine;

Alpine.start();
