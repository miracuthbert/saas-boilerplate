<template>
    <div class="card border-bottom-0 border-left-0 border-right-0 border-top my-1">
        <div class="card-body">
            <p class="card-title h4">
                {{ comment.user.name }}

                <template v-if="comment.parent">
                    <small>
                        in reply to {{ comment.parent.user.name }}
                    </small>
                </template>
            </p>

            <div class="my-1 px-1">
                {{ comment.body }}
            </div>

            <ul class="nav my-1">
                <li class="nav-item">
                        <span class="nav-link disabled">
                            {{ comment.formattedCreatedAt }}
                        </span>
                </li>

                <li class="nav-item" v-if="allowed">
                    <a class="nav-link" href="#" data-toggle="collapse"
                       :data-target="'#comment-form-' + comment.id">
                        <i class="icon-action-redo"></i> Reply
                    </a>
                </li>
                <li class="nav-item" v-if="comment.isDeletable">
                    <a class="nav-link" href="#" @click.prevent="deleteComment(comment)">
                        <i class="icon-trash"></i> Delete
                    </a>
                </li>
            </ul>

            <!-- Reply Form -->
            <form class="collapse" action="#" method="post" :id="'comment-form-' + comment.id"
                  @submit.prevent="storeReply(comment.id)" v-if="allowed">

                <div class="form-group" :class="{ 'has-error': errors['body'] }">
                    <label class="control-label">Your reply</label>
                    <textarea class="form-control"
                              :class="{ 'is-invalid': errors['body'] }"
                              id="commentBody"
                              v-model="form.body"
                              placeholder="Your reply here..."></textarea>

                    <div class="invalid-feedback" v-if="errors['body']">
                        <strong>{{ errors['body'][0] }}</strong>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="icon-action-redo"></i> Reply
                    </button>
                </div>
            </form>

            <!-- Replies -->
            <template v-if="comment.children">
                <button type="button"
                        class="btn btn-link"
                        data-toggle="collapse"
                        :data-target="'#replies-wrapper' + comment.id">
                    Replies ({{ comment.children.length }})
                </button>
                <div class="collapse"
                     :id="'replies-wrapper' + comment.id">
                    <comment v-for="comment in comment.children"
                             :comment="comment"
                             :key="comment.id"></comment>
                </div>
            </template>

        </div>
    </div>

</template>

<script>
    import Comment from './Comment'
    import EventBus from '../../../bus'

    export default {
        components: {
            Comment
        },
        props: [
            'comment',
        ],
        name: "comment",
        data() {
            return {
                form: {},
                errors: [],
                endpoint: this.$parent.endpoint,
                allowed: this.$parent.allowed
            }
        },
        methods: {
            storeReply(id) {
                //return if form is empty
                if (!this.form || (!this.form.body || this.form.body.trim() === '')) {
                    this.errors['body'] = [];
                    this.errors.body.unshift("The comment field is required.")

                    return
                }

                axios.post(`${this.endpoint}/${id}/replies`, this.form).then((response) => {
                    this.form = {}
                    this.errors = []

                    EventBus.$emit('reply:add', response.data.data)
                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.creating.errors = error.response.data.errors
                    }
                })
            },
            deleteComment(comment) {
                EventBus.$emit('comment:delete', comment)
            },
            moment(...args) {
                return moment(...args);
            }
        }
    }
</script>

<style scoped>

</style>