<template>
    <div v-if="checkToken" class="custom-donate" >
        <h1 class="text-center">Customize Donate Page</h1>
        <input v-model="currentStreamer.donate_text" type="text" class="form-control" placeholder="Welcome text...">
        <input v-model="currentStreamer.paypal" type="text" class="form-control" placeholder="PayPal...">
        <button @click.prevent="save()" class="btn btn-success">save</button>
        <button v-on:click="handleUploadBackClick" class="btn btn-warning">change background image</button>
        <button v-on:click="handleUploadFrontClick" class="btn btn-warning">change header image</button>
        <input type="file" ref="fileBack" v-on:change="uploadBackFile($event.target.files[0])" style="display:none">
        <input type="file" ref="fileFront" v-on:change="uploadFrontFile($event.target.files[0])" style="display:none">
        <h2>Preview</h2>
        <div class="preview">
            <img v-if="currentStreamer.donate_back" v-bind:src="'storage/' + currentStreamer.donate_back">
            <div class="header">
                <img v-if="currentStreamer.donate_front" v-bind:src="'storage/' + currentStreamer.donate_front">
                <img v-bind:src="currentStreamer.avatar" alt="avatar" class="avatar">
                <span>{{ currentStreamer.donate_text }}</span>
            </div>
            <div class="form">
                <h3>Donate Form</h3>
                <h5>donate to PayPal account: <strong>{{ currentStreamer.paypal }}</strong></h5>
            </div>
        </div>
    </div>
    <div v-else class="custom-donate">
        Please login
    </div>
</template>
<script>
import { mapGetters} from 'vuex';

    export default {
        data() {
            return {
                text: '',
            }
        },
        mounted() {
            this.$store.dispatch('getCurrentStreamer');
        },
        methods: {
            handleUploadBackClick: function () {
                this.$refs.fileBack.click();
            },
            handleUploadFrontClick: function () {
                this.$refs.fileFront.click();
            },
            uploadBackFile: function (imageFile) {
                const data = {
                    type: 'back',
                    file: imageFile
                }
                this.$store.dispatch('uploadDonationImage', data);
            },
            uploadFrontFile: function (imageFile) {
                const data = {
                    type: 'front',
                    file: imageFile
                }
                this.$store.dispatch('uploadDonationImage', data);
            },
            save() {
                const data = {
                    'donate_text' : this.currentStreamer.donate_text,
                    'paypal'      : this.currentStreamer.paypal,
                }
                this.$store.dispatch('saveCurrentStreamer', data);
            },
        },
         computed: {
            ...mapGetters([
				'checkToken',
                'currentStreamer'
			]),
        },
    }
</script>