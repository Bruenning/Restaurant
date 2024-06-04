<template>
    <Bmodal @close="close()" id="login" :title="title" :show="showModal" icon="login">
        <Vform>
            <Vrow>
                <Vcol>
                    <Vinput v-model="login.email" type="text" name="email" icon="email" label="Email" :rules="emailRules"/>
                </Vcol>
            </Vrow>
            <Vrow>
                <Vcol>
                    <Vinput v-model="login.password" type="password" name="password" icon="form-textbox-password" label="Password" :rules="passwordRules"/>
                </Vcol>
            </Vrow> 
        </Vform>

        <template v-slot:footer>
            <Vbutton @click="onSubmit" color="primary">Entrar</Vbutton>
            <Vbutton @click="createAccont" color="primary">Registrar-se</Vbutton>
        </template>
    </Bmodal>

    <Vsnackbar v-model="snackbar" :message="snackbarMessage" :color="snackbarColor" :timeout="snackbarTimeout" />

</template>

<script>
    export default {
    emits: ["close", "snack", "createAccount"],
    props: {
        title: {
            type: String,
            default: ""
        },
        show: {
            type: Boolean,
            default: false
        },
    },
    data() {
        return {
            login: {
                email: null,
                password: null
            },

            snackbar: false,
            snackbarMessage: "",
            snackbarColor: "",
            snackbarTimeout: 3000,
            
            showModal: false,
        };
    },
    mounted() {
        this.reload();
    },
    watch: {
        "show": function () {
            this.showModal = this.show;
        },
    },
    computed: {
        emailRules() {
            return [
                v => !!v || "E-mail é obrigatório",
                v => /.+@.+\..+/.test(v) || "E-mail deve ser válido",
            ];
        },
        passwordRules() {
            return [
                v => !!v || "Senha é obrigatória",
            ];
        },
    },
    methods: {
        onSubmit(e) {
            let valid = this.$helpers.validateForm(this.login, { email: this.emailRules, password: this.passwordRules });

            if (valid != true) {
                this.snackbarMessage = valid;
                this.snackbarColor = "error";
                this.snackbar = true;
                return;
            }

            let login = {
                ...this.login,
            };

            console.log(login);

            this.$api.post("user/login", login).then(res => {

                localStorage.setItem("token", res.data.token);
                localStorage.setItem("user_id", res.data.user_id)

                if (res.data.is_admin === 1)
                    localStorage.setItem("is_admin", res.data.is_admin)

                this.$emit('snack', {message: "Login efetuado com sucesso!", color: 'success'})
                this.reload(true);

            }).catch(err => {
                this.$emit('snack', {message: err, color: 'error'})
            });
        },

        createAccont() {
            this.$emit("createAccount")

            this.showModal = false;
            this.close();

        },
        
        reload(reload = false) {
            if (localStorage.getItem("token")) {
                this.$router.push({ name: "Home" });
                this.close();
            }
            if (reload) {
                window.location.reload();
            }
        },
        close() {
            this.login = {
                email: null,
                password: null
            };

            this.$emit("close");
        },
    },
}
</script>