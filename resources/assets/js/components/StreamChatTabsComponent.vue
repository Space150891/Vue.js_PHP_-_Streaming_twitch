<template>
    <div>
        <ul class="nav nav-pills  flex-column flex-sm-row nav-chat">
            <li class="nav-item" v-for="(chat, index) in chats">
                <a 
                  v-bind:class="[(index == selected) ? 'active' : '', 'flex-sm-fill text-sm-center nav-link']"
                  href="#"
                  :key="index"
                  @click.prevent="setSelected(index)"
                > 
                    Chat {{ index +1 }}
                </a>
            </li>
        </ul>
        <iframe frameborder="1"
            scrolling="true"
            v-bind:src="chats[selected]"
            height="500px"
            width="100%">
        </iframe>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                selected: 0,
                chats: channelsUrl,
            }
        },
        methods: {
            setSelected(index) {
                this.selected = index;
            }
        },
        mounted() {
            console.log('Tabs mounted', this.chats);
        },
    }
</script>
