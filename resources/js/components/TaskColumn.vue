<template>
<div class="w-[300px] bg-sky-950 rounded-lg shadow-lg">
    <div class="p-4">
        <div class="flex items-center justify-between">
            <div class="header flex items-center mb-3">
                <h2 class="text-lg text-zinc-100 font-black">{{ kanban.phases[props.phase_id].name }}</h2>
                <div class="rounded-full w-[20px] h-[20px] flex items-center justify-center text-white bg-gray-400 p-[3px] ml-[8px] text-[12px]">
                    {{ kanban.phases[props.phase_id].task_count }}
                </div>
            </div>
            <div class="flex">
                <CheckCircleIcon 
                    class="h-6 w-6 hover:cursor-pointer"
                    :class="kanban.phases[props.phase_id].is_completion? ' text-green-400' : 'text-white'"
                    aria-hidden="true" 
                    @click="completionPhase()"
                />
                <PlusIcon 
                    @click="createTask()" 
                    class="mb-3 h-6 w-6 ml-3 text-white hover:cursor-pointer" 
                    aria-hidden="true" 
                />
            </div>
            
        </div>
        <template v-if="kanban.phases[props.phase_id].tasks.length > 0">
            <task-card 
                v-for="(task, index) in kanban.phases[props.phase_id].tasks" 
                :key="index"
                :task="task"
            />
        </template>
        
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
import { useKanbanStore } from '../stores/kanban'
import { PlusIcon, CheckCircleIcon } from '@heroicons/vue/20/solid'

const kanban = useKanbanStore()

const props = defineProps({
    phase_id: {
        type: Number,
        required: true
    },
})


const completionPhase = async () => {
    kanban.phases[props.phase_id].is_completion = !kanban.phases[props.phase_id].is_completion
    const params =  {
        name: kanban.phases[props.phase_id].name,
        is_completion: kanban.phases[props.phase_id].is_completion
    }
    await axios.put('/api/phases/' + props.phase_id, params);
}

const createTask = function () {
    kanban.creatingTask = true;
    kanban.creatingTaskProps.phase_id = props.phase_id;
}

</script>