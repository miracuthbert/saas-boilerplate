<template>
        <ul class="pagination">
            <li class="page-item" :class="{ 'disabled': meta.current_page === 1 }">
                <a class="page-link" href="#" @click.prevent="switched(meta.current_page - 1)">
                    <span>
                        <i class="icon-angle-left"></i>
                    </span>
                </a>
            </li>
            <li class="page-item" :class="{ 'disabled': meta.current_page === meta.last_page }">
                <a class="page-link" href="#" @click.prevent="switched(meta.current_page + 1)">
                    <span>
                        <i class="icon-angle-right"></i>
                    </span>
                </a>
            </li>
        </ul>
</template>

<script>
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

                //push page to query string
                this.$router.replace({
                    query: Object.assign({}, this.$route.query, {page})
                })
            },
            pageIsOutOfBounds(page) {
                return page <= 0 || page > this.meta.last_page;
            }
        }
    }
</script>
