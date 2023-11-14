<template>
<div class="w-[300px] bg-sky-950 rounded-lg shadow-lg">
    <div class="p-4">
        <div class="flex items-center justify-between">
            <div class="header flex items-center mb-3">
                <h2 class="text-lg text-zinc-100 font-black">{{ currentKanban.name }}</h2>
                <div class="rounded-full w-[20px] h-[20px] flex items-center justify-center text-white bg-gray-400 p-[3px] ml-[8px] text-[12px]">
                    {{ currentKanban.task_count }}
                </div>
            </div>
            <div class="flex">
                <CheckCircleIcon 
                    class="h-6 w-6 hover:cursor-pointer"
                    :class="currentKanban.is_completion? ' text-green-400' : 'text-white'"
                    aria-hidden="true" 
                    @click="completionPhase()"
                />
                <XMarkIcon 
                    @click="removePhase()" 
                    class="mb-3 h-6 w-6 ml-3 text-red-500 hover:cursor-pointer" 
                    aria-hidden="true" 
                />
            </div>
            
        </div>
        
        <perfect-scrollbar :options="{suppressScrollX: true}">
            <div class="h-[500px]">
                <VueDraggableNext 
                    :list="currentKanban.tasks" 
                    @change="checkMove" 
                    group="task"
                    @end="onEnd"
                >
                    <task-card 
                        v-for="(task, index) in currentKanban.tasks" 
                        :key="index"
                        :task="task"
                    />
                </VueDraggableNext>
            </div>
        </perfect-scrollbar>
       
        
        <!-- A card to create a new task -->
        <div class="w-full flex items-center justify-between bg-white text-gray-900 hover:cursor-pointer shadow-md rounded-lg p-3 relative"
            @click="createTask()">
            <span>Create a new task</span>
            <PlusIcon class="h-6 w-6" aria-hidden="true" />
        </div>

    </div>
</div>
</template>

<script setup>
// get the props
import { useKanbanStore } from '../stores/kanban';
import { PlusIcon, CheckCircleIcon, XMarkIcon } from '@heroicons/vue/20/solid';
import { VueDraggableNext } from 'vue-draggable-next'
import { computed } from "vue";

const kanban = useKanbanStore()

const props = defineProps({
    phase_id: {
        type: Number,
        required: true
    },
})

const currentKanban = computed(() => {
    return kanban.phases.filter((item) => item.id == props.phase_id)[0]
})


const completionPhase = async () => {
    try {
        const params =  {
            name: currentKanban.name,
            is_completion: !currentKanban.value.is_completion,
        }
        await axios.put('/api/phases/' + props.phase_id, params);
        kanban.setCompletion(props.phase_id, !currentKanban.value.is_completion);
    } catch (error) {
        console.log(error)
    }
}

const createTask = function () {
    kanban.creatingTask = true;
    kanban.creatingTaskProps.phase_id = props.phase_id;
}

const removePhase = async () => {
    try {
        await axios.delete('/api/phases/' + props.phase_id);
        kanban.phases = kanban.phases.filter((item) => item.id != props.phase_id)
    } catch (error) {
        console.log(error)
    }
}

const checkMove = async (event) => {
    if (event.hasOwnProperty("added")) {
        const task_id = event.added.element.id
        const task = currentKanban.value.tasks.filter(item => item.id == task_id)
        const params = {
            old_phase_id: task.phase_id,
            phase_id: props.phase_id
        }
        try {   
            const { data } = await axios.put('/api/tasks/' + event.added.element.id, params);
        } catch (e) {
            console.log(e)
        }
    }
    currentKanban.value.task_count = currentKanban.value.tasks.length;
}

</script>