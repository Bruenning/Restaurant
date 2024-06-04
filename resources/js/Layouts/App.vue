<template>
    <v-app>
        <Menu />
        <router-view></router-view>
        <v-footer class="d-flex flex-column" >
            <div class="bg-teal d-flex w-100 align-center px-4">
                <strong>Minhas Redes socias</strong>

                <v-spacer></v-spacer>

                <Vbutton v-for="icon in icons" :key="icon.icon" :style="`border-color:${icon.color}`"  icon :href="url[icon.name]" target="_blank" small class="mx-2">
                    <v-icon size="small" :style="`color:${icon.color}`" :icon="icon.icon"></v-icon>
                </Vbutton>
            </div>

            <div class="px-4 py-2 text-center w-100">
                &copy;{{ new Date().getFullYear() }} — <strong>Guilherme Henrique Bruenning</strong>
            </div>

        </v-footer>
    </v-app>
</template>

<script>
    export default {
        data() {
            return {
                icons: [
                    {name: 'facebook', icon: 'mdi-facebook', color: 'blue'},
                    {name: 'instagram', icon: 'mdi-instagram', color: 'pink'},
                    {name: 'linkedin', icon: 'mdi-linkedin', color: 'blue'},
                    {name: 'github', icon: 'mdi-github', color: 'black'},
                ],
                url: {
                    'facebook': 'https://www.facebook.com/guilherme.bruenning',
                    'instagram': 'https://www.instagram.com/guilhermehbruenning/',
                    'linkedin': 'https://www.linkedin.com/in/guilherme-henrique-bruenning-2b1b3b1b0/',
                    'github': 'https://github.com/bruenning',
                }
            }
        },
    }
</script>