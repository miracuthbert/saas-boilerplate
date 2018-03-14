<template>
    <div>
        <div class="form-group" :class="{ 'has-error': errors['name'] }">
            <label for="tag" class="control-label">Search or add new tag</label>
            <div class="input-group">
                <input type="text"
                       class="form-control"
                       :class="{ 'is-invalid': errors['name'] }"
                       id="tag"
                       v-model="form.name"
                       @keydown.enter.prevent="processForm">
                <div class="input-group-btn" v-if="!filteredRecords.length">
                    <button type="button"
                            class="btn btn-primary"
                            @click.prevent="store">Add tag
                    </button>
                </div>
            </div>

            <div class="invalid-feedback" v-if="errors['name']">
                <strong>{{ errors['name'][0] }}</strong>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-3" v-for="tag in filteredRecords">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox"
                           name="tags[]"
                           class="custom-control-input"
                           :id="tag.slug"
                           v-model="selected" :value="tag.id">
                    <label class="custom-control-label" :for="tag.slug">{{ tag.name }}</label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'endpoint',
            'taggables',
            'allowed'
        ],
        name: "TagsIndex",
        data() {
            return {
                tags: [],
                selected: [],
                form: {
                    name: ''
                },
                errors: []
            }
        },
        mounted() {
            this.getTags()
        },
        computed: {
            filteredRecords() {
                let data = this.tags

                data = data.filter((row) => {
                    return Object.keys(row).some((key) => {
                        return String(row[key]).toLowerCase().indexOf(this.form.name.toLowerCase()) > -1
                    })
                })

                return data
            }
        },
        methods: {
            getTags() {
                axios.get(this.endpoint).then((response) => {
                    this.tags = response.data.data
                    this.setTaggables()
                })
            },
            setTaggables() {
                this.selected = this.taggables
            },
            processForm() {
                if (!this.filteredRecords.length) {
                    this.errors['name'] = [];
                    this.errors.name.unshift('No matching tag found. You can add this as a new tag.')
                }

                return
            },
            store() {
                axios.post(this.endpoint, this.form).then((response) => {
                    this.form.name = ''
                    this.errors = []

                    var data = response.data.data
                    this.selected.unshift(data.id)
                    this.tags.unshift(data)
                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }
                })

            },
            toggleSelectAll() {
                if (this.selected.length > 0) {
                    this.selected = []
                    return
                }

                this.selected = _.map(this.filteredRecords, 'id')
            }
        }
    }
</script>

<style scoped>

</style>