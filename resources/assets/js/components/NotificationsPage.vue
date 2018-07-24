<template>
    <div v-if="checkToken" class="cabinet-page" >
        <h1 class="text-center">Notifications</h1>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Message</th>
                    <th>Date / Time</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="notification in notifications">
                    <td>
                        {{notification.message}}
                    </td>
                    <td>
                        {{notification.created_at}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div v-else class="cabinet-page">
        Please login
    </div>
</template>
<script>
    export default {
        data() {
            return {
                
            }
        },
        mounted() {
            this.$store.commit('loadNotifications');
        },
        methods: {
           
        },
        computed: {
            checkToken: function () {
              return this.$store.getters.checkToken;
            },
            notifications: function () {
                return this.$store.getters.notifications.reverse();
            },
        },
    }
</script>