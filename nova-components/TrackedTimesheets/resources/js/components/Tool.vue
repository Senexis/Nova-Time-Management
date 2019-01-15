<template>
  <loading-view :loading="initialLoading">
    <h1 class="mb-6 text-90 font-normal text-2xl">Log Details</h1>
    <loading-card
      :loading="loading"
      class="card overflow-hidden"
    >
      <div v-if="isValid">
        <div class="px-8 py-6">{{ hours }}:{{ minutes }}:{{ seconds }}</div>
        <div class="bg-30 flex px-8 py-4">
          <button
            class="btn btn-default btn-primary inline-flex items-center relative ml-auto mr-auto"
            type="button"
            v-if="isRunning"
            @click="pauseTimer"
          >Pause</button>
          <button
            class="btn btn-default btn-primary inline-flex items-center relative ml-auto mr-3"
            type="button"
            v-if="isPaused"
            @click="resumeTimer"
          >Resume</button>
          <button
            class="btn btn-default btn-primary inline-flex items-center relative mr-auto"
            type="button"
            v-if="isPaused"
            @click="stopTimer"
          >Stop</button>
        </div>
      </div>
    </loading-card>
  </loading-view>
</template>

<script>
export default {
  data: () => ({
    initialLoading: true,
    loading: false,
    runningTimer: {},
    timer: null,
    timeWorked: 0
  }),

  methods: {
    initialize() {
      this.getRunningTimer();
    },

    getRunningTimer() {
      Nova.request()
        .get("/nova-vendor/tracked-timesheets/latest-timer")
        .then(response => {
          this.runningTimer = response.data;

          if (this.isValid) {
            this.timeWorked = response.data.time_worked;

            if (this.isRunning) {
              this.startTimer();
            }
          } else {
            // TODO: Move to create new.
          }

          this.initialLoading = false;
          this.loading = false;
        });
    },

    pauseRunningTimer() {
      this.loading = true;

      Nova.request()
        .get("/nova-vendor/tracked-timesheets/latest-timer/pause")
        .then(response => {
          this.runningTimer = response.data;

          if (this.isValid) {
            this.timeWorked = response.data.time_worked;
          } else {
            // TODO: Move to create new.
          }

          this.loading = false;
        });
    },

    resumeRunningTimer() {
      this.loading = true;

      Nova.request()
        .get("/nova-vendor/tracked-timesheets/latest-timer/resume")
        .then(response => {
          this.runningTimer = response.data;

          if (this.isValid) {
            this.timeWorked = response.data.time_worked;
          } else {
            // TODO: Move to create new.
          }

          this.loading = false;
        });
    },

    stopRunningTimer() {
      this.loading = true;

      Nova.request()
        .get("/nova-vendor/tracked-timesheets/latest-timer/stop")
        .then(response => {
          this.runningTimer = response.data;

          if (this.isValid) {
            this.timeWorked = response.data.time_worked;
          } else {
            // TODO: Move to create new.
          }

          this.loading = false;
        });
    },

    startTimer() {
      this.timer = setInterval(() => this.updateTimer(), 1000);
    },

    updateTimer() {
      this.timeWorked++;
    },

    pauseTimer() {
      this.pauseRunningTimer();

      clearInterval(this.timer);
      this.timer = null;
    },

    resumeTimer() {
      this.resumeRunningTimer();
      this.startTimer();
    },

    stopTimer() {
      this.stopRunningTimer();

      clearInterval(this.timer);
      this.timer = null;
    },

    padTime(time) {
      return (time < 10 ? "0" : "") + time;
    }
  },

  computed: {
    timeWorked() {
      return this.timeWorked;
    },

    hours() {
      return Math.floor(this.timeWorked / 3600);
    },

    minutes() {
      return this.padTime(Math.floor(this.timeWorked / 60) % 60);
    },

    seconds() {
      return this.padTime(this.timeWorked % 60);
    },

    isValid() {
      return this.runningTimer != "{}";
    },

    isRunning() {
      return (
        this.isValid && !this.isEnded && this.runningTimer.paused_at == null
      );
    },

    isPaused() {
      return (
        this.isValid && !this.isEnded && this.runningTimer.paused_at != null
      );
    },

    isEnded() {
      return this.isValid && this.runningTimer.ended_at != null;
    }
  },

  created() {
    this.initialize();
  }
};
</script>
