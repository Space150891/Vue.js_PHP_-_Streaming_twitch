<template>
  <div v-if="opened" v-bind:style="styleBack">
    <div v-bind:style="styleDiv">
      <h5 class="text-center">
        <span v-if="AlertType=='warning'" v-bind:style="alertWarning">
            WARNING
        </span>
        <span v-else-if="AlertType=='notify'">
            Notify
        </span>
        <span v-else-if="AlertType=='success'">
            Success
        </span>
        <span v-else>
            Alert
        </span>
      </h5>
      <p v-if="message.length > 0" v-bind:style="styleMessage">{{ message }}</p>
      <p v-if="messages" v-for="mes in messages" v-bind:style="styleMessage" :key="mes">{{ mes }}</p>
      <div class="text-center">
        <button v-on:click="$emit('close-alert-modal')"  class="btn btn-primary btn-xs">OK</button>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
        opened: {
            type: Boolean,
            default: false,
            required: false
        },
        AlertType: {
            type: String,
            default: 'notify',
            required: false
        },
        message: {
            type: String,
            default: '',
            required: false,
        },
        messages: {
            type: Array,
            default: [],
            required: false,
        },
    },
    data() {
      return {
        styleBack : {
          position: "fixed",
          width: "100%",
          height: "100%",
          background : "rgba(0,0,0, .5)",
          top: "0",
          left: "0",
        },
        styleDiv : {
          position: "fixed",
          top: "50%",
          left: "50%",
          marginLeft: "-150px",
          width: "300px",
          border: "1px 777 solid",
          background : "#fff",
          borderRadius: "5px",
          padding: "10px",
        },
        alertWarning : {
          color: "#f00",
        },
        styleMessage : {
          padding: "0",
          margin: "0",
        },
      }
    },
  }
</script>