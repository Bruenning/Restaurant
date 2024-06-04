<!-- modal de craição de conta de usuário usando o componentes de Vmodal -->
<template>
    <Bmodal @close="close()" id="accountForm" title="Registrar-se" icon="account-plus" :show="show">
        <Vform >
            <Vrow>
                <Vcol>
                    <Vinput v-model="form.name" label="Nome" :rules="rules.name"></Vinput>
                </Vcol>
                <Vcol>
                    <Vinput v-model="form.email" label="E-mail" icon="email" :rules="rules.email"></Vinput>
                </Vcol>
                <Vcol>
                    <Vinput v-model="form.password" label="Senha" icon="form-textbox-password" :rules="rules.password" type="password"></Vinput>
                </Vcol>
                <Vcol>
                    <Vinput v-model="form.password_confirmation" label="Confirmação de senha" icon="form-textbox-password" :rules="rules.password_confirmation" type="password"></Vinput>
                </Vcol>
            </Vrow>

        </Vform>
        <template v-slot:footer>
            <Vbutton color="primary" @click="create">Criar</Vbutton>
        </template>
    </Bmodal>

</template>

<script>
export default {
    emits: ["close", "snack"],
    props: {
        show: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            form: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
            },

            snackbar: false,
            snackbarMessage: '',
            snackbarColor: '',
            snackbarTimeout: 3000,

            rules: {
                name: [
                    v => !!v || 'Nome é obrigatório',
                    v => !!v && this.collect(v).count() <= 255 || 'Nome deve ter no máximo 255 caracteres',
                ],
                email: [
                    v => !!v || 'E-mail é obrigatório',
                    v => /.+@.+\..+/.test(v) || 'E-mail deve ser válido',
                ],
                password: [
                    v => !!v || 'Senha é obrigatória',
                    v => v != this.form.email || 'Senha não pode ser igual ao e-mail',
                    v => v != this.form.name || 'Senha não pode ser igual ao nome',
                    v => /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$*&@#])[0-9a-zA-Z$*&@#]{8,}$/.test(v) || 'Senha deve conter pelo menos uma letra maiúscula, uma letra minúscula, um número e um caractere especial',
                ],
                password_confirmation: [
                    v => !!v || 'Confirmação de senha é obrigatória',
                    v => v == this.form.password || 'Confirmação de senha deve ser igual a senha',
                ],
            },
            showModal: false,
        }
    },
    methods: {
        create() {
            let valid = this.$helpers.validateForm(this.form, this.rules)

            if (valid != true) {
                this.snackbarMessage = valid
                this.snackbarColor = 'error'
                this.snackbar = true
                return
            }

            let form = {
                ...this.form,
                password: this.$helpers.hash(this.form.password),
                password_confirmation: this.$helpers.hash(this.form.password_confirmation),
            }

            this.$api.post('user/store', form)
                .then(response => {
                    this.$emit('snack', {message: 'Conta criada com sucesso', color: 'success'})

                    this.close()
                })
                .catch(error => {
                    this.$emit('snack', {message: error, color: 'error'})
                })
        },
        close() {
            this.form = {
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
            }

            this.$emit('close')
        },
    },
}
</script>
