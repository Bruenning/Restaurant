<template>
    <div class="navbar navbar-expand-lg bg-kight">
        <div class="container-fluid">
            <RouterLink class="navbar-brand" :to="home">Home</RouterLink>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item" :key="key" v-for="(item, key) in getRoutes">
                        <RouterLink class="nav-link" :to="item.link"><b>{{ item.name }}</b></RouterLink>
                    </li>
                </ul>
            </div>

            <Vbutton v-if="btnLogin" class="navbar-brand" type="button" color="primary" @click="showModal = true" >
                Login
            </Vbutton>
            <Vbutton v-else class="navbar-brand" type="button" color="primary" @click="logout()" >
                Logout
            </Vbutton>
        </div>
    </div>
    <Login title="<b>Login</b>" :show="showModal" @close="onClose()" @snack="showSnackbar" @createAccount="createAccount"/>

    <AccountForm :show="showAccount" @close="closeAccount" @snack="showSnackbar" />

    <Vsnackbar v-model="snackbar" :message="snackbarMessage" :color="snackbarColor" :timeout="snackbarTimeout" />

    <Vdialog title="Confirmação" message="<div class'text-align-center'>Deslogar</div>" @cancel="cancelDialog()" @confirm="logout(true)" v-model="dialog" />

</template>

<script>
    export default {
        data() {
            return {
                show: false,
                btnLogin: false,

                showModal: false,
                showAccount: false,

                alert: false,
                alertMessage: '',
                alertColor: '',
                alertTimeout: 3000,
                dialog: false,

                snackbar: false,
                snackbarMessage: '',
                snackbarColor: '',
                snackbarTimeout: 3000,
            }
        },
        mounted() {
            this.reload()
        },
        computed:{
            getRoutes() {
                let rotas = []
                this.$router.options.routes.forEach(element => {
                    if (!element.name) return

                    if (!localStorage.getItem('token')) {
                        if (element.meta.isLogged.includes(false)) {
                            rotas.push({name: element.meta.usedName, link: element.path})
                            return
                        }
                        return
                    }

                    if (localStorage.getItem('token')) {
                        if (element.meta.isLogged.includes(true)) {
                            rotas.push({name: element.meta.usedName, link: element.path})
                            return
                        }
                        return
                    }
                    
                })

                return rotas
            },
            home(){
                return localStorage.getItem('token') ? "/a/": '/'
            }

            
        },
        methods: {
            onClose() {
                this.showModal = false;
            },
            reload() {
                if (!localStorage.getItem('token')) {
                    this.$router.push({name: 'Home'})
                }

                if (localStorage.getItem('token')) {
                    this.btnLogin = false
                    this.$router.push({name: 'Dashboard'})
                } else {
                    this.btnLogin = true
                }

            },
            cancelDialog() {
                this.dialog = false
            },

            logout(confirm) {
                if (confirm) {
                    localStorage.removeItem('token')
                    localStorage.removeItem('user_id')
                    localStorage.removeItem('is_admin')
                    
                    this.dialog = false

                    this.reload()

                    return
                }

                this.dialog = true
            },

            createAccount() {
                this.showAccount = true
            },

            closeAccount() {
                this.showAccount = false
            },

            showSnackbar(e) {
                this.snackbar = true
                this.snackbarMessage = e.message
                this.snackbarColor = e.color
            }
        }
    }
</script>