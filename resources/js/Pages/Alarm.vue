<script setup>
import { reactive, watch, ref } from "vue";

const props = defineProps({
    'alarm': {
        type: Object
    }
})

const theAlarm = reactive(props.alarm)
const armTimerDisplay = ref('')
const timerStart = ref(false);

watch(theAlarm, (newValue, oldValue) => {
    //console.log(newValue, oldValue);
    if(theAlarm.status.name === 'arming' && !timerStart.value){
        let timeLeft = theAlarm.arming_duration;
        timerStart.value = true
        const armTimer = setInterval(() => {
            timeLeft -= 1;

            armTimerDisplay.value = `Ready in ${timeLeft}s...`

            if(timeLeft <= 0 || theAlarm.status.name !== 'arming') {
                armTimerDisplay.value = ''
                timerStart.value = false
                clearInterval(armTimer)
            }
        }, 1000)
    }
});

Echo.channel(`alarm-status-changed.${theAlarm.id}`)
    .listen('AlarmStatusChanged', (e) => {
        theAlarm.status.name = e.alarm.status.name
        // console.log(e)
    })

</script>

<template>
    <div class="alarm-div">
        <h3>{{ theAlarm.name }}</h3>
        <div>
            <p>Status - {{ theAlarm.status.name }}</p>
        </div>
        <div v-if="armTimerDisplay">
            {{ armTimerDisplay }}
        </div>
    </div>
</template>
