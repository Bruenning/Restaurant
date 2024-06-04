<template>
    <table class="container table-responsive table table-hover">
        <thead>
            <tr>
                <th v-for="(header, index) in headers" :key="index" :cols="header.cols" scope="col">
                    <b>{{ header.title }}</b>
                </th>
                <th scope="col" class="d-sm-table-cell">
                    <b><v-icon icon="mdi-delete"></v-icon></b>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="items.length > 0" v-for="(item, index) in items" :key="index" >
                <td v-for="(header, index) in headers" :key="index">
                    <slot :item="item" :header="header">
                        <p>{{ item[header.key] }}</p>
                    </slot>
                    
                </td>
                <td v-if="!noDelete">
                    <Vbutton type="button" color="danger" icon @click="this.$emit('delete', item.id)" density="compact" style="margin:0;border:none;">
                        <v-icon size="small" icon="mdi-delete"></v-icon>
                    </Vbutton>
                </td>
            </tr>
            <tr v-if="items.length === 0">  
                <p>Nenhum registro encontrado</p>
            </tr>
        </tbody>
           
    </table>
</template>

<script>
    export default {
        emits: ['delete'],
        props: {
            headers: {
                type: Array,
                required: true,
            },
            items: {
                type: Array,
                required: true,
            },
            noDelete: {
                type: Boolean,
                default: false,
            }
        },
        data() {
            return {
                isCols: {
                    is: false,
                    cols: 0,
                } 
            }
        },  
    }
</script>