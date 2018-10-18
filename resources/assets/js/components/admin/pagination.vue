<template>
<nav>
  <ul class="pagination">
    <li class="page-item">
        <a
          v-if="page > 1"
          @click.prevent="$emit('load-page', page - 1)"
          class="page-link"
          href="#"
        >
            Previous
        </a>
    </li>
    <li v-if="page <= 1" class="page-item disabled">
        <span class="page-link">Previous</span>
    </li>
    <li
      v-for="pagg in paggData" v-bind:key="pagg"
      v-bind:class="(pagg == page) ? 'page-item active': 'page-item'"
    >
        <a
          v-if="pagg != page"
          @click.prevent="$emit('load-page', pagg)"
          class="page-link"
          href="#"
        >
            {{pagg}}
        </a>
        <span v-if="pagg == page" class="page-link">
            {{pagg}}
        </span>
    </li>
    <li v-if="page < pages" class="page-item">
        <a
          @click.prevent="$emit('load-page', page + 1)"
          class="page-link"
          href="#"
        >
            Next
        </a>
        
    </li>
    <li  v-if="page >= pages" class="page-item disabled">
        <span class="page-link">Next</span>
    </li>
  </ul>
</nav>
</template>
<script>
  export default {
    props: ['page', 'pages', 'buttons'],
    methods: {
		
    },
    computed: {
        paggData: function() {
            let list = [];
            const totalButtons = parseInt(this.buttons > this.pages ? this.pages : this.buttons);
            const middle = Math.ceil(totalButtons / 2) - 1;
            if (this.page <= middle) {
                for (let i = 1; i <= totalButtons; i++) {
                    list.push(i);
                }
                return list;
            }
            if (this.page >= this.pages - middle) {
                for (let i = this.pages; i > this.pages - totalButtons; i--) {
                    list.push(i);
                }
                return list.reverse();
            }
            for (let i = this.page - middle; i < this.page - middle + totalButtons; i++) {
                list.push(i);
            }
            return list;
        }
    }
  }
</script>