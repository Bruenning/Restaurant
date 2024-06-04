<template>
    <Vcontainer class="dashboard">
        <Vrow>
            <Vcol :cols="12">
                <div class="d-flex justify-content-between">
                    <h1>Reservas</h1>
                    <Vbutton v-if="!$isAdmin" @click="CreateReservation" color="primary">Nova reserva</Vbutton>
                </div>
            </Vcol>
            <Vcol>
                <Btable :headers="headers" :items="items" @delete="onDelete">
                </Btable>
            </Vcol>
        </Vrow>
    </Vcontainer>

    <Reservation :show="showReservation" @close="close()" @snack="ShowSnackbar"></Reservation>

    <Vsnackbar v-model="snackbar" :message="snackbarMessage" :color="snackbarColor" :timeout="snackbarTimeout" />

    <Vdialog title="Confirmação" message="<div class'text-align-center'>Tem certeza que deseja excluir este item?</div>" @cancel="cancelDialog()" @confirm="deleteConfirm = true" v-model="dialog" />

</template>

<script>
import Vrow from '@/Components/Vrow.vue'
export default {
	components: { Vrow },
    data() {
        return {
            headers: [
                {title: 'Reservado por', key: 'user', cols: null},
                {title: 'Data', key: 'date', cols: null},
                {title: 'Horário', key: 'time', cols: null},
            ],
            items: [],
            showReservation: false,

            snackbar: false,
            snackbarMessage: "",
            snackbarColor: "",
            snackbarTimeout: 3000,

            deleteConfirm: false,
            idDelete: null,

            dialog: false,

        }
    },
    mounted() {
        this.reload()
    },

    watch: {
        'deleteConfirm': function () {
            if (this.idDelete != null && this.deleteConfirm) {
                this.$api.del(`reservations/delete/${this.idDelete}`).then(response => {
                    this.snackbar = true
                    this.snackbarMessage ='Reserva excluída com sucesso!'
                    this.snackbarColor = 'success'

                    this.deleteConfirm = false
                    this.idDelete = null
                    this.dialog = false

                    this.reload()
                }).catch(error => {
                    console.log(error, 'error')
                    this.snackbar = true
                    this.snackbarMessage = error.response?.data.message || error
                    this.snackbarColor = 'error'
                })
            }
        }
    },
    methods: {
        reload() {
            this.items = []
            this.$api.get(`user/show/${window.localStorage.getItem('user_id')}`).then(response => {
                if (this.$isAdmin == 1) {
                    this.$api.get('reservations/index').then(r => {
                        r.data.data.forEach(element => {
                            this.items.push({
                                id: element.id,
                                user: element.user.name,
                                date: this.$helpers.getDate(element.dateReservation),
                                time: this.$helpers.getTime(element.timeReservation),
                            })
                        });
                    })
                    return
                }

                this.$api.get(`reservations/user/${response.data.data.id}`).then(r => {
                    r.data.data.forEach(element => {
                        console.log(element)
                        this.items.push({
                            id: element.id,
                            user: element.user.name,
                            date: this.$helpers.getDate(element.dateReservation),
                            time: this.$helpers.getTime(element.timeReservation),
                        })
                    });
                })
            })
        },
        edit(id) {
            this.$router.push({ name: 'user.edit', params: { id: id } })
        },

        CreateReservation() {
            this.showReservation = true
        },

        close() {
            this.showReservation = false
            this.reload()
        },

        ShowSnackbar(e) {
            this.snackbar = true
            this.snackbarMessage = e.message
            this.snackbarColor = e.color
        },
        cancelDialog() {
            this.dialog = false
        },

        onDelete(id) {

            this.idDelete = id

            this.dialog = true

        }
    },
}
</script>
