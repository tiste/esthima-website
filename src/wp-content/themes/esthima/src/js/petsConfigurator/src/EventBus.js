import { reactive } from 'vue';

const EventBus = reactive({
  events: {},
  currentDataReturn: null,
  emit(event, data) {
    const promises = [];
    if (this.events[event]) {
      for (const callback of this.events[event]) {
        const result = callback(data);
        if (result instanceof Promise) {
          promises.push(result);
        } else {
          promises.push(Promise.resolve(result));
        }
      }
    }
    return Promise.all(promises);
  },
  on(event, callback) {
    if (!this.events[event]) {
      this.events[event] = [];
    }
    this.events[event].push(callback);
    this.currentDataReturn = null;
  },
  off(event, callback) {
    if (this.events[event]) {
      const index = this.events[event].indexOf(callback);
      if (index > -1) {
        this.events[event].splice(index, 1);
      }
    }
    this.currentDataReturn = null;
  }
});

export default EventBus;
