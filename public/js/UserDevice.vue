<template>
    <div>
        <div class="btn btn-primary" @click="detectDevice()">
            Detect my device
        </div>
        <div class="p-3 mb-2" v-if="userDevice">
            <span class="text-success" role="success">{{ userDevice.type }}</span>
            <br/>
            <span class="text-success" role="success">{{ userDevice.os }}</span>
            <br/>
            <span class="text-success" role="success">{{ userDevice.browser }}</span>
        </div>
        <div class="p-3 mb-2" v-if="error">
            <span class="text-danger" role="alert">{{ error }}</span>
        </div>
    </div>
</template>

<script>
export default {
    emits: ['deviceDetected'],

    data() {
        return {
            userDevice: null,
            error: null
        }
    },

    methods: {
        detectDevice() {
            this.error = null;

            return axios.get('/detect')
            .then((response) => {
                this.userDevice = response.data;

                this.emitter.emit("device-detected", response.data);
            }).catch((error) => {
                this.error = 'We were not able to detect your device! please try again!';
            });
        }
    },
}
</script>
