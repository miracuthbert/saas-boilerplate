<template>
    <div class="card card-body border-0">
        <h4 class="card-title">
            <i class="icon-bubbles"></i>
            Comments <span class="text-muted" v-if="meta.total">{{ meta.total }}</span>
        </h4>

        <a id="commentsWrapper"></a>
        <form action="#" @submit.prevent="store" v-if="allowed">
            <div class="form-group" :class="{ 'has-error': errors['body'] }">
                <label for="commentBody" class="control-label">
                    Post a public comment
                </label>
                <textarea class="form-control"
                          :class="{ 'is-invalid': errors['body'] }"
                          id="commentBody"
                          v-model="form.body"
                          placeholder="Share here...">
                </textarea>

                <div class="invalid-feedback" v-if="errors['body']">
                    <strong>{{ errors['body'][0] }}</strong>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Post comment</button>
            </div>
        </form>

        <p v-else>
            <a :href="login">Login</a> or <a :href="register">Sign Up</a> to post comments.
        </p>

        <div class="mt-1">
            <template v-if="comments.length">
                <comment
                        v-for="comment in comments"
                        :comment="comment"
                        :key="comment.id"
                        :endpoint="endpoint"></comment>
                <pagination :meta="meta"></pagination>
            </template>
            <template v-else>
                No comments posted yet.
            </template>
        </div>
    </div>
</template>

<script>
    import Comment from './partials/Comment'
    import Pagination from './partials/SimplePagination.vue'
    import EventBus from "../../bus";

    export default {
        components: {
            Comment,
            Pagination
        },
        props: [
            'endpoint',
            'login',
            'register',
            'allowed'
        ],
        name: "CommentIndex",
        data() {
            return {
                comments: [],
                meta: {},
                form: {},
                errors: [],
                currentPage: 1
            }
        },
        mounted() {
            this.getComments()

            EventBus.$on('comment:delete', (comment) => {
                this.deleteComment(comment)
            }).$on('pagination:switched', (page) => {
                this.currentPage = page
                this.getComments(page)
                this.$scrollTo('#commentsWrapper')
            }).$on('reply:add', (reply) => {
                this.addReply(reply)
            })
        },
        methods: {
            getComments(page = this.currentPage) {
                axios.get(this.endpoint, {
                    params: {
                        page
                    }
                }).then((response) => {
                    this.comments = response.data.data
                    this.meta = response.data.meta
                })
            },
            store() {

                //return if form is empty
                if (!this.form || (!this.form.body || this.form.body.trim() === '')) {
                    this.errors['body'] = [];
                    this.errors.body.unshift("The comment field is required.")

                    return
                }

                axios.post(this.endpoint, this.form).then((response) => {
                    this.form = {}
                    this.errors = []

                    if (this.currentPage !== 1) {
                        this.getComments(1)

                        return
                    }
                    this.comments.unshift(response.data.data)
                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }
                })
            },
            addReply(reply, comments = this.comments) {

                if (!reply) {
                    return
                }

                var comment = this.filtered(reply.parent_id, comments)

                if (comment && (comment.id == reply.parent_id)) {
                    this.appendReply(comment, reply)
                    return
                } else if (comment.children) {
                    this.addReply(reply, comment.children)
                }
            },
            appendReply(comment, reply) {
                if (!_.has(comment, 'children')) {
                    comment['children'] = [];

                    comment['children'][0] = reply

                    return
                }

                comment.children.unshift(reply)
            },
            deleteComment(comment) {
                axios.delete(`${this.endpoint}/${comment.id}`).then((response) => {
                    this.removeComment(comment)
                }).catch((error) => {
                })
            },
            removeComment(deleted, comments = this.comments) {

                if (!deleted) {
                    return
                }

                var comment = this.filtered(deleted.id, comments)

                if (comment && (comment.id == deleted.id)) {
                    _.remove(comments, function (comment, key) {
                        return comment.id == deleted.id;
                    })
                } else if (comment.children) {
                    this.removeComment(deleted, comment.children)
                }
            },
            filtered(id, comments) {
                return _.head(this.filterTree(id, comments));
            },
            filterTree(filter, list) {
                return _.filter(list, (item) => {
                    if (_.includes(_.toLower(item.id), _.toLower(filter))) {
                        return true
                    } else if (item.children) {
                        item.children = this.filterTree(filter, item.children);

                        return !_.isEmpty(item.children)
                    }
                })
            },
            moment(...args) {
                return moment(...args);
            }
        }
    }
</script>

<style scoped>

</style>