<template>
    <v-btn :color="color" :variant="variant" class="btn" :class="classBtn" :icon="icon" >
        <slot></slot>
    </v-btn>
</template>

<script>
    export default {
        props: {
            color: {
                type: String,
                default: 'primary'
            },
            variant: {
                type: String,
                default: 'outlined'
            },
            classBtn: {
                type: String,
                default: ''
            },
            modal: {
                type: Boolean,
                default: false
            },
            icon: {
                type: Boolean,
                default: false
            }
        }
    }
</script>