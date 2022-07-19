<script>
export default {
    props: {
        msg: String,
        type: String
    },
    data() {
        return ({
            alertBoxClass: {
                'alert-box': true,
                'warning': false,
                'danger': false,
                'success': false,
            }
        });
    },
    watch: {
        type() {
            for (var alertBoxClassKey in this.alertBoxClass) {
                this.alertBoxClass[alertBoxClassKey] = alertBoxClassKey === 'alert-box'? true : false;
            }
            this.alertBoxClass[this.type] = true;            
        }
    },
    mounted() {
        this.alertBoxClass[this.type] = true;
    }
}
</script>

<template>
    <div :class="alertBoxClass" v-if="msg">
        {{ msg }}
    </div>
</template>

<style lang="scss" scoped>
.alert-box {
    @apply px-6;
    @apply py-4;
    @apply mb-4;
    @apply rounded-lg;
    @apply border;
    @apply font-medium;
    @apply bg-slate-200;
    @apply border-slate-400;
    @apply text-slate-600;
}
.warning {
    @apply bg-yellow-200;
    @apply border-yellow-400;
    @apply text-yellow-600;
}
.danger {
    @apply bg-red-200;
    @apply border-red-400;
    @apply text-red-600;
}
.success {
    @apply bg-green-200;
    @apply border-green-400;
    @apply text-green-600;
}
</style>