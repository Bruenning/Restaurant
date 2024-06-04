<template>
    <div class="modal fade" tabindex="-1" aria-hidden="true" :id="id">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div v-if="!noHeader" class="modal-header">
            <div>
                <v-icon :icon="`mdi-${icon}`" style="padding-right:15px;"></v-icon>
                <span class="modal-title" v-html="title"></span>
            </div>
            <button type="button" class="close" @click="close()">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <slot></slot>
          </div>
          <div v-if="!noFooter" class="modal-footer">
            <slot name="footer">
                <Vbutton v-if="!noSave" type="button" color="primary" @click="this.$emit('confirm');">Save changes</Vbutton>
            </slot>

            <Vbutton v-if="!noClose" type="button" color="danger" @click="close()">Close</Vbutton>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
    export default {
        emits: ['close', 'confirm'],
        props: {
            confirmText: {
                type: String,
                default: 'Confirm',
            },
            cancelText: {
                type: String,
                default: 'Cancel',
            },
            title: {
                type: String,
                default: 'Título'
            },
            noHeader: {
                type: Boolean,
                default: false
            },
            noFooter: {
                type: Boolean,
                default: false
            },
            noSave: {
                type: Boolean,
                default: false
            },
            noClose: {
                type: Boolean,
                default: false
            },
            id: {
                type: String,
                default: 'modal'
            },
            show: {
                type: Boolean,
                default: false
            },
            icon: {
                type: String,
                default: 'information'
            }
        },
        data() {
            return {
                modal: null
            }
        },
        mounted() {
            this.modal = new this.$bootstrap.Modal(document.getElementById(this.id), {
                keyboard: false,
                backdrop: 'static'

            })
        },
        watch: {
            'show'(val) {
                if (val) 
                    this.modal.show()
                else
                    this.modal.hide()
            }
        },
        
        methods: {
            close() {
                this.modal.hide()
                this.$emit('close')
            }
        }
    }
</script>