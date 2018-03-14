<template>
        <ul class="pagination justify-content-end">
            <li class="page-item" :class="{ 'disabled': meta.current_page === 1 }">
                <a class="page-link" href="#" @click.prevent="switched(meta.current_page - 1)">
                    <span>
                        <i class="icon-arrow-left"></i> Prev.
                    </span>
                </a>
            </li>
            <li class="page-item" :class="{ 'disabled': meta.current_page === meta.last_page }">
                <a class="page-link" href="#" @click.prevent="switched(meta.current_page + 1)">
                    <span>
                        <i class="icon-arrow-right"></i> Next
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
