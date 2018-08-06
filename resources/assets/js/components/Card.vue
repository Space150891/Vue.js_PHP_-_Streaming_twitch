<template>
  <div v-bind:style="mainStyle">
    <img
        v-bind:src="imagesUrl + hero"
        v-bind:style="heroImageStyle"
        alt="hero"
    >
    <img
        v-bind:src="imagesUrl + frame"
        v-bind:style="frameImageStyle"
        alt="frame"
    >
    <p v-bind:style="achivementStyle">
        {{achivement}}
    </p>
  </div>
</template>

<script>
var config = require('./config/config.json');

export default {
    props: {
        frame: {
            type: String,
            required: true
        },
        hero: {
            type: String,
            required: true
        },
        achivement: {
            type: String,
            required: true,
        },
    },
    mounted() {
        console.log(this.imagesUrl);
    },
    data() {
      return {
            imagesUrl : (config.baseUrl + '/storage/'),
            mainStyle: {
                width: "217px",
                height: "312px",
                border: "none",
                borderRadius: "5px",
                position: "relative",
            },
            frameImageStyle: {
                width: "217px",
                height: "312px",
                border: "none",
                borderRadius: "5px",
                position: "absolute",
                top: "0",
                left: "0",
            },
            heroImageStyle: {
                width: "132px",
                height: "170px",
                borderRadius: "50%",
                position: "absolute",
                top: "20px",
                left: "40px",
            },
            achivementStyle: {
                position: "absolute",
                top: "205px",
                width: "217px",
                margin: "0",
                padding: "0 40px",
                color: "#fff",
            }
        }
    },
}
</script>