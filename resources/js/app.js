import { createApp } from 'vue'
import VueAxios from 'vue-axios'
import { Collection, collect } from 'collect.js'

import './bootstrap';
import * as bootstrap from 'bootstrap'
import 'bootstrap-icons/font/bootstrap-icons.css'

import 'vee-validate/dist/vee-validate.js'

import 'bootstrap/dist/css/bootstrap.css'

//helpers
import helpers from './helpers'

import api from './axios.js'

import router from './router.js'
import App from './Layouts/App.vue'

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

//components
import Vrow from './Components/Vrow.vue'
import Vcol from './Components/Vcol.vue'
import Vform from './Components/Vform.vue'
import Vbutton from './Components/Vbutton.vue'
import Vinput from './Components/Vinput.vue'
import Bmodal from './Components/Bmodal.vue'
import Vsnackbar from './Components/Vsnackbar.vue'
import Vselect from './Components/Vselect.vue'  
import Vdialog from './Components/Vdialog.vue'
import Btable from './Components/Btable.vue'
import Vcontainer from './Components/Vcontainer.vue'

import dashboardVue from './Pages/DashboardVue.vue'
import AccountFormVue from './Pages/AccountForm.vue'
import Login from './Pages/Login.vue'
import Menu from './Pages/Menu.vue'
import HomeVue from './Pages/Home.vue'
import ReservationVue from './Pages/Reservation.vue'
import NotFoundVue from './Pages/NotFound.vue'

// Vuetify
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'


const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi',
    },
})

const app = createApp(App)


app.component('Vcol', Vcol)
app.component('Vrow', Vrow)
app.component('Vform', Vform)
app.component('Vbutton', Vbutton)
app.component('Vinput', Vinput)
app.component('Vselect', Vselect)
app.component('Bmodal', Bmodal)
app.component('Vsnackbar', Vsnackbar)
app.component('Vdialog', Vdialog)
app.component('VueDatePicker', VueDatePicker)
app.component('Btable', Btable)
app.component('Vcontainer', Vcontainer)

app.component('Menu', Menu)
app.component('Login', Login)
app.component('AccountForm', AccountFormVue)
app.component('dashboardVue', dashboardVue)
app.component('Home', HomeVue)
app.component('Reservation', ReservationVue)
app.component('NotFound', NotFoundVue)


app
    .use(router)
    .use(vuetify)
    .use(VueAxios, api)

app.config.globalProperties.$helpers = helpers
app.config.globalProperties.$api = api
app.config.globalProperties.$bootstrap = bootstrap
app.config.globalProperties.$isAdmin = window.localStorage.getItem('is_admin')

app.config.globalProperties.collect = collect
app.config.globalProperties.Collection = Collection

app.mount('#app')