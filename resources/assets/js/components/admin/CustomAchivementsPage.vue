<template>
<div class="container">
  <admin-menu page="/custom-achivements"></admin-menu>
    <div v-if="checkToken">
        <h1 class="text-center">Custom achivements page</h1>
        <div v-if="customAchievementsLoaded">
            <table v-if="customAchievements.length > 0" class="table">
                <thead>
                    <tr>
                        <th>Text</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in customAchievements" :key="item.id">
                        <td>
                            {{item.text}}
                        </td>
                        <td>
                            {{item.status}}
                        </td>
                        <td>
                            <button
                                v-if="item.status !='ok'"
                                @click.prevent="setOk(item.id)"
                                class="btn btn-success btn-xs"
                            >
                                confirm
                            </button>
                            <button
                                v-if="item.status !='block'"
                                @click.prevent="setBlock(item.id)"
                                class="btn btn-warning btn-xs"
                            >
                                block
                            </button>
                            <button @click.prevent="confirmDeleteAction(item)" class="btn btn-danger btn-xs">
                                delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <modal-delete 
			v-bind:name="deletingItem.name"
			v-bind:opened="deletingItem.openModal"
			v-on:close-delete-modal="deletingItem.openModal=false"
			v-on:confirm-delete="deleteAction"
        ></modal-delete>
        <div v-if="!customAchievementsLoaded" class="v-loading">
        </div>
    </div>
    <div v-else>
        Please login
    </div>
</div>
</template>
<script>
import { mapGetters } from 'vuex';

    export default {
        data() {
            return {
                deletingItem: {
                    name: '',
                    id: 0,
                    openModal: false,
                },
            }
        },
        mounted() {
            if (this.checkToken) {
                this.$store.commit('loadAllCustomAchivements');
            }
        },
        methods: {
            confirmDeleteAction: function (item) {
				this.deletingItem.name = item.text;
				this.deletingItem.id = item.id;
				this.deletingItem.openModal = true;
			},
            deleteAction: function() {
                this.deletingItem.openModal = false;
                this.$store.dispatch('deleteCustomAchivementAction', this.deletingItem.id);
            },
            setOk: function(id) {
                this.$store.dispatch('setOkCustomAchivementAction', id);
            },
            setBlock: function(id) {
                this.$store.dispatch('setBlockCustomAchivementAction', id);
            },
        },
        computed: {
             ...mapGetters([
				'checkToken',
				'alerts',
                'customAchievements',
                'customAchievementsLoaded',
			]),
        },
    }
</script>