<template>
    <div class="card mx-auto p-3 m-3 text-center" v-if="devices">
        <div class="h5 text-muted" v-if="deviceKnown">You are browsing on a..</div>
        <div class="row justify-content-center">
            <div
                :class="addDeviceClasses(device)"
                class="col-6 col-md-3 card devices-list m-3"
                v-for="device in devices"
            >
                <img class="card-img-top device-picture"
                    :src="`../public/media/${device.image}`"
                    alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ device.type }}
                    </h5>
                    <p class="card-text">{{ device.type }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            devices: [],
            deviceKnown: false,
            detectedType: '',
        }
    },
    methods: {
        getDevices() {
            return new Promise((resolve, reject) => {
                axios.get('/devices')
                    .then((response) => {
                        this.devices = response.data;
                        resolve(response.data);
                    }).catch((error) => {
                        this.error = 'We were not able to list devices!';
                        reject(error.response.data.errors);
                    });
            });
        },
        addDeviceClasses(device) {
            if (!this.deviceKnown) {
                return;
            }

            return device.type === this.detectedType
                ? 'detected-device border-success order-first order-md-1'
                : 'other-devices order-md-1'
        }
    },
    mounted() {
        this.$root.$on('deviceDetected', (data) => {
            this.deviceKnown = true;
            this.detectedType = data.type;
        }
    )},
    created() {
        this.getDevices();
    }
}
</script>

<style lang="css" scoped>
.devices-list {
    align-items: center;
}

.card-img-top {
    width: 50%;
    margin-top:10px;
}

.detected-device {
    border: 1px solid;
}

.other-devices {
    opacity: 0.3;
}
</style>
