<template>
  <div v-bind:style="styleDiv">
    <h4> Upload {{ title }} </h4>
    <p v-if="fileName"> {{ fileName.name }} </p>
    <input type="file" v-on:change="$emit('upload-file', $event.target.files[0])" ref="fileBut" style="display: none;">
    <button v-on:click="handleUploadClick" class="btn btn-primary btn-xs">Load</button>
  </div>
</template>

<script>
  export default {
    props: {
        title: {
            type: String,
            required: true,
        },
        fileName: {
            required: false
        },
    },
    data() {
      return {
        file: false,
        styleDiv : {
          display: "inline-block",
          margin: "5px",
          width: "300px",
          height: "200px",
          border: "1px 999 solid",
          background : "#fff",
          borderRadius: "5px",
          padding: "10px",
        },
      }
    },
    methods: {
        handleUploadClick: function () {
            this.$refs.fileBut.click();
        },
    }
  }
</script>