import { defineStore } from 'pinia';
import _ from 'lodash';

export const useKanbanStore = defineStore('kanban', {
  state: () => {
    return { 
      hoveredName: 'nothing',
      selectedTask: null,
      phases: [],
      users: [],
      creatingTask: false,
      creatingTaskProps: {
        name: '',
        phase_id: null,
        user_id: null,
      },
      self: null,
    }
  },
  actions: {
    unhoverTask() {
      this.hoveredName = 'nothing'
    },
    selectTask(task) {
      this.selectedTask = _.cloneDeep(task)
    },
    unselectTask(task) {
      this.resetTask()
      this.selectedTask = null
    },
    hasSelectedTask() {
      return this.selectedTask !== null
    },
    resetTask() {
      this.creatingTaskProps = {
        name: '',
        phase_id: null,
        user_id: null,
      }
    }
  },
})