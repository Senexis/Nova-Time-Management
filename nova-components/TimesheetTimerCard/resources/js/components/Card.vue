<template>
    <loading-card :loading="initialLoading || loading" class="overflow-hidden" style="height: 100%;">
        <div class="flex flex-col items-center justify-center" v-if="!isValid">
            <svg width="69" height="72" viewBox="0 0 23 24" xmlns="http://www.w3.org/2000/svg" class="spin fill-80 mb-6">
                <path d="M20.12 20.455A12.184 12.184 0 0 1 11.5 24a12.18 12.18 0 0 1-9.333-4.319c4.772 3.933 11.88 3.687 16.36-.738a7.571 7.571 0 0 0 0-10.8c-3.018-2.982-7.912-2.982-10.931 0a3.245 3.245 0 0 0 0 4.628 3.342 3.342 0 0 0 4.685 0 1.114 1.114 0 0 1 1.561 0 1.082 1.082 0 0 1 0 1.543 5.57 5.57 0 0 1-7.808 0 5.408 5.408 0 0 1 0-7.714c3.881-3.834 10.174-3.834 14.055 0a9.734 9.734 0 0 1 .03 13.855zM4.472 5.057a7.571 7.571 0 0 0 0 10.8c3.018 2.982 7.912 2.982 10.931 0a3.245 3.245 0 0 0 0-4.628 3.342 3.342 0 0 0-4.685 0 1.114 1.114 0 0 1-1.561 0 1.082 1.082 0 0 1 0-1.543 5.57 5.57 0 0 1 7.808 0 5.408 5.408 0 0 1 0 7.714c-3.881 3.834-10.174 3.834-14.055 0a9.734 9.734 0 0 1-.015-13.87C5.096 1.35 8.138 0 11.5 0c3.75 0 7.105 1.68 9.333 4.319C16.06.386 8.953.632 4.473 5.057z" fill-rule="evenodd"></path>
            </svg>
            <h1 class="text-4xl text-90 font-light mb-6">We're in a black hole.</h1>
        </div>
        <div class="text-center" v-if="isValid">
            <div class="relative px-8 py-6">
                <svg height="200" width="200">
                    <circle cx="100" cy="100" r="95" stroke="var(--primary)" stroke-width="5" fill="transparent"></circle>
                </svg>
                <h4 class="text-3xl text-lg font-light" style="margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0; height: 1em;">{{ hours }}:{{ minutes }}:{{ seconds }}</h4>
            </div>
            <div class="bg-30 px-8 py-4">
                <button class="btn btn-default btn-primary items-center" type="button" v-if="isRunning" @click="pauseTimer">Pause</button>
                <button class="btn btn-default btn-primary items-center mr-3" type="button" v-if="isPaused" @click="resumeTimer">Resume</button>
                <button class="btn btn-default btn-danger items-center" type="button" v-if="isPaused" @click="stopTimer">Stop</button>
            </div>
        </div>
    </loading-card>
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

        props: [
            "card"
        ],

        methods: {
            initialize() {
                this.getRunningTimer();
            },

            getRunningTimer() {
                Nova.request()
                    .get("/nova-vendor/TimesheetTimerCard/latest-timer")
                    .then(response => {
                        this.runningTimer = response.data;
                        this.timeWorked = response.data.time_worked;

                        if (this.isValid && this.isRunning) {
                            this.startTimer();
                        }

                        this.initialLoading = false;
                        this.loading = false;
                    });
            },

            pauseRunningTimer() {
                this.loading = true;

                Nova.request()
                    .get("/nova-vendor/TimesheetTimerCard/latest-timer/pause")
                    .then(response => {
                        this.runningTimer = response.data;

                        if (this.isValid) {
                            this.timeWorked = response.data.time_worked;
                        }

                        this.loading = false;
                    });
            },

            resumeRunningTimer() {
                this.loading = true;

                Nova.request()
                    .get("/nova-vendor/TimesheetTimerCard/latest-timer/resume")
                    .then(response => {
                        this.runningTimer = response.data;

                        if (this.isValid) {
                        this.timeWorked = response.data.time_worked;
                        }

                        this.loading = false;
                    });
            },

            stopRunningTimer() {
                this.loading = true;

                Nova.request()
                    .get("/nova-vendor/TimesheetTimerCard/latest-timer/stop")
                    .then(response => {
                        this.runningTimer = response.data;

                        if (this.isValid) {
                            this.timeWorked = response.data.time_worked;
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
                return Object.keys(this.runningTimer).length !== 0;
            },

            isRunning() {
                return this.isValid && !this.isEnded && this.runningTimer.paused_at == null;
            },

            isPaused() {
                return this.isValid && !this.isEnded && this.runningTimer.paused_at != null;
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
