<script setup>
import { reactive } from "vue";

const props = defineProps({
    'alarm': {
        type: Object
    }
})

const theAlarm = reactive(props.alarm)

Echo.channel(`alarm-status-changed.${theAlarm.id}`)
    .listen('AlarmStatusChanged', (e) => {
        theAlarm.status.name = e.alarm.status.name
        console.log(e)
    })

</script>

<template>
    <div class="alarm-div">
        <h3>{{ theAlarm.name }}</h3>
        <div>
            <p>Status - {{ theAlarm.status.name }}</p>
        </div>
    </div>
</template>
