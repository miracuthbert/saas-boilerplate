<template>
        <ul class="pagination">
            <li class="page-item" :class="{ 'disabled': meta.current_page === 1 }">
                <a class="page-link" href="#" @click.prevent="switched(meta.current_page - 1)">
                    <span>
                        &laquo;
                    </span>
                </a>
            </li>
            <li class="page-item" :class="{ 'active': meta.current_page === x }" v-for="x in meta.last_page">
                <a class="page-link" href="#" @click.prevent="switched(x)">{{ x }}</a>
            </li>
            <li class="page-item" :class="{ 'disabled': meta.current_page === meta.last_page }">
                <a class="page-link" href="#" @click.prevent="switched(meta.current_page + 1)">
                    <span>
                        &raquo;
                    </span>
                </a>
            </li>
        </ul>
</template>

<script>
    import EventBus from '../../../bus'

    export default {
        props: [
            'meta'
        ],
        mounted() {
        },
        methods: {
            switched(page) {
                if (this.pageIsOutOfBounds(page)) {
                    return;
                }

                this.$emit('pagination:switched', page)

                EventBus.$emit('pagination:switched', page)
            },
            pageIsOutOfBounds(page) {
                return page <= 0 || page > this.meta.last_page;
            }
        }
    }
</script>
