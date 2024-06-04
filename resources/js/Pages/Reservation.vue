<template>
    <Bmodal @close="close()" id="Reservation" title="Reserve seu horário" :show="show" icon="store-clock-outline">
        <Vform>
            <Vrow>
                <Vcol :cols="12">
                    <VueDatePicker v-model="form.date" format="dd/MM/yyyy" placeholder="Selecione uma data  " :enable-time-picker="false" :allowed-dates="allowedDates" auto-apply position="left" ></VueDatePicker>
                </Vcol>
                <Vcol :cols="12" >
                    <Vselect v-model="form.hours" :items="getHours" :label="label" :rules="rules" ></Vselect>
                </Vcol>
            </Vrow>
        </Vform>

        <template v-slot:footer>
            <Vbutton color="primary" @click="save()">Reservar</Vbutton>
        </template>
    </Bmodal>
</template>

<script>

export default {
    emits: ["close", "snack"],
    data() {
        return {
            form: {
                date:  null,
                hours: null,
            },

            show: false,

            timeBase: [
                {id: 1800, name: '18:00'},
                {id: 1830, name: '18:30'},
                {id: 1900, name: '19:00'},
                {id: 1930, name: '19:30'},
                {id: 2000, name: '20:00'},
                {id: 2030, name: '20:30'},
                {id: 2100, name: '21:00'},
                {id: 2130, name: '21:30'},
                {id: 2200, name: '22:00'},
                {id: 2230, name: '22:30'},
                {id: 2300, name: '23:00'},
                {id: 2330, name: '23:30'},
            ],

            label: 'Select Item',
            rules: [
                value => !!value || 'Item is required',
            ],
        }
    },
    computed:{
        allowedDates () {
            let date = new Date()
            let dates = []

            date.setDate(date.getDate())

            while (date.getDate() <= 30) {
                if (date.getDay() != 1)
                    dates.push(date.toISOString().substr(0, 10))

                date.setDate(date.getDate() + 1)
                
            }
           
            return dates
        },
        getHours() {
            let dateNow = new Date().toLocaleTimeString();
            
            let items = []

            this.timeBase.forEach(element => {
                let date = new Date()
                date.setHours(element.name.substr(0, 2), element.name.substr(3, 2), 0, 0);
                
                if (date.toLocaleTimeString() >= dateNow)
                    items.push(element)

            });
            
            return items
        },
    },
    methods: {
        close(reload = false) {
            this.form = {
                date:  null,
                hours: null,
            }
            this.show = false
            this.$emit('close')

            if (reload)
                window.location.reload()
        },
        save() {
            let time = new Date()
            let date = new Date(this.form.date)
            date.setHours(date.getHours() - 3)
            let hoursSting = this.timeBase.find(element => element.id == this.form.hours).name
            time.setHours(hoursSting.substr(0, 2), hoursSting.substr(3, 2), 0, 0);
            
            this.$api.post('reservations/store', {
                dateReservation: date.toISOString().substr(0, 10),
                timeReservation: time.toLocaleTimeString(),
                user_id: window.localStorage.getItem('user_id'),
            }).then(response => {
                this.$emit('snack', {message: 'Reserva criada', color: 'success'})
                this.close(true)

            }).catch(error => {
                this.$emit('snack', {message: error, color: 'error'})
            })
        },
    },
}
</script>
