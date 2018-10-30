<template>
    <div v-if="checkToken" class="cabinet-page" >
        <h1 class="text-center">Custom achivements page</h1>
        <inline-alert></inline-alert>
        <div class="input-group">
            <input v-model="newText" type="text" class="form-control" placeholder="Achievement text...">
            <div class="input-group-append">
                <button @click.prevent="createAchivement()" type="submit" class="btn btn-success">Create</button>
            </div>
        </div>
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
                    <tr v-for="item in customAchievements">
                        <td>
                            {{item.text}}
                        </td>
                        <td>
                            {{item.status}}
                        </td>
                        <td>
                            <span v-if="item.main">MAIN</span>
                            <button
                                v-if="!item.main && item.status == 'ok'"
                                @click.prevent="setMain(item.id)"
                                class="btn btn-warning btn-xs"
                            >
                                set main
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
    <div v-else class="cabinet-page">
        Please login
    </div>
</template>
<script>
import { mapGetters } from 'vuex';

    export default {
        data() {
            return {
                newText: '',
                deletingItem: {
                    name: '',
                    id: 0,
                    openModal: false,
                },
            }
        },
        mounted() {
            if (this.checkToken) {
                this.$store.commit('loadCustomAchivements');
            }
        },
        methods: {
            createAchivement: function() {
                if (this.newText.length > 0) {
                    this.$store.dispatch('createNewAchivementAction', this.newText);
                    this.newText = '';
                }
            },
            confirmDeleteAction: function (item) {
				this.deletingItem.name = item.text;
				this.deletingItem.id = item.id;
				this.deletingItem.openModal = true;
			},
            deleteAction: function() {
                this.deletingItem.openModal = false;
                this.$store.dispatch('deleteCustomAchivementAction', this.deletingItem.id);
            },
            setMain: function(id) {
                this.$store.dispatch('setMainCustomAchivementAction', id);
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