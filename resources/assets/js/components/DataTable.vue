<template>
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <strong class="mr-auto">{{ response.table }}</strong>

                <a href="#" class="pull-right ml-auto" v-if="response.allow.creation"
                   @click.prevent="creating.active = !creating.active">
                    {{ creating.active ? 'Cancel' : 'Add new record' }}
                </a>
            </div>

            <!-- Create Form -->
            <div class="card card-body my-3" v-if="creating.active">
                <h5 class="card-title">New record</h5>

                <form action="#" @submit.prevent="store">
                    <div class="form-group row" :class="{ 'has-error': creating.errors[row.value] }"
                         v-for="row in response.createable">
                        <label :for="row.value" class="control-label col-md-4">
                            {{ response.custom_columns[row.value] || row.value }}
                        </label>

                        <div class="col-md-6">

                            <!-- Text Input -->
                            <template v-if="row.type == 'text'">
                                <input type="text" class="form-control"
                                       :class="{ 'is-invalid': creating.errors[row.value] }"
                                       v-model="creating.form[row.value]">
                            </template>

                            <!-- Textarea -->
                            <template v-else-if="row.type == 'textarea'">
                                <textarea class="form-control" :class="{ 'is-invalid': creating.errors[row.value] }"
                                          v-model="creating.form[row.value]"></textarea>
                            </template>

                            <!-- Select -->
                            <template v-else-if="row.type == 'select'">
                                <select class="form-control custom-select"
                                        :class="{ 'is-invalid': creating.errors[row.value] }"
                                        v-model="creating.form[row.value]">

                                    <template v-for="option in row.options">
                                        <template v-if="option.children.length">
                                            <optgroup :label="option.name">
                                                <option :value="child.value" v-for="child in option.children"
                                                        :disabled="String(child.usable).toLowerCase()!='true'">
                                                    {{ child.name }}
                                                </option>
                                            </optgroup>
                                        </template>

                                        <template v-else>
                                            <option :value="option.value"
                                                    :disabled="String(option.usable).toLowerCase()!='true'">
                                                {{ option.name }}
                                            </option>
                                        </template>
                                    </template>
                                </select>
                            </template>

                            <div class="invalid-feedback" v-if="creating.errors[row.value]">
                                <strong>{{ creating.errors[row.value][0] }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Backend Search -->
            <form action="#" @submit.prevent="getRecords">
                <fieldset>
                    <label for="dataTableSearch" class="control-label">Search</label>
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <select class="form-control custom-select" v-model="search.column">
                                <option :value="column" v-for="column in response.displayable">
                                    {{ column }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <select class="form-control custom-select" v-model="search.operator">
                                <option value="equals">=</option>
                                <option value="contains">contains</option>
                                <option value="starts_with">starts with</option>
                                <option value="ends_with">ends with</option>
                                <option value="greater_than">greater than</option>
                                <option value="greater_equal_to">greater than or equal to</option>
                                <option value="less_than">less than</option>
                                <option value="less_equal_to">less than or equal to</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <div class="input-group">
                                <input type="text" class="form-control" id="dataTableSearch" v-model="search.value">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>

            <!-- Quick Search -->
            <div class="form-group row">
                <div class="col-sm-10">
                    <label for="filter" class="control-label">
                        Quick search current results
                    </label>
                    <input type="text" class="form-control" id="filter" v-model="quickSearchQuery">
                </div>
                <div class="col-sm-2">
                    <label for="limit" class="control-label">Per page</label>
                    <select class="form-control custom-select" id="limit" v-model="limit" @change="getRecords">
                        <option value="15">15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="">All</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card-body">
            <p class="card-text my-2" v-if="!response.data.length">No records found.</p>

            <div class="clearfix" v-if="selected.length">
                <div class="btn-group">
                    <a href="#" class="btn btn-outline-primary dropdown-toggle" role="button" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        With selected <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item" @click.prevent="destroy(selected)">Delete</a>
                    </div>
                </div>
            </div>

            <p class="card-text" v-else>Select records to access more options</p>
        </div>

        <!-- Table -->
        <table class="table table-responsive-sm table-hover table-outline mb-0" v-if="response.data.length">
            <thead class="thead-light">
            <tr>
                <th v-if="canSelectItems">
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" @change="toggleSelectAll"
                               :checked="filteredRecords.length === selected.length">
                        <span class="custom-control-label"></span>
                    </label>
                </th>
                <th v-for="column in response.displayable">
                    <span class="sortable"
                          @click="sortBy(column)">{{ response.custom_columns[column] || column }}</span>

                    <div class="arrow" v-if="sort.key === column"
                         :class="{ 'arrow--asc': sort.order === 'asc', 'arrow--desc': sort.order === 'desc' }"></div>
                </th>
                <th v-for="column in response.appendable">
                    <span></span>
                </th>
                <th v-if="response.allow.updating">&nbsp;</th>
                <th v-if="response.allow.deletion">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="record in filteredRecords">
                <td v-if="canSelectItems">
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" v-model="selected" :value="record.id">
                        <span class="custom-control-label"></span>
                    </label>
                </td>
                <td v-for="columnValue, column in record">
                    <template v-if="editing.id === record.id && isColumnUpdatable(column)">
                        <div class="form-group" :class="{ 'has-error': editing.errors[column] }">
                            <input type="text" class="form-control" :class="{ 'is-invalid': editing.errors[column] }"
                                   v-model="editing.form[column]">

                            <div class="invalid-feedback" v-if="editing.errors[column]">
                                <strong>{{ editing.errors[column][0] }}</strong>
                            </div>
                        </div>
                    </template>

                    <template v-else>
                        {{ columnValue }}
                    </template>
                </td>
                <td v-if="response.allow.updating">
                    <a href="#" @click.prevent="edit(record)" v-if="editing.id !== record.id">
                        Quick edit
                    </a>

                    <template v-if="editing.id === record.id">
                        <a href="#" @click.prevent="update">Save</a>
                        <a href="#" @click.prevent="editing.id = null">Cancel</a>
                    </template>
                </td>
                <td v-if="response.allow.deletion">
                    <a href="#" @click.prevent="destroy(record.id)">Delete</a>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="card-body" v-if="response.data.length">
            Pagination currently not available
        </div>
    </div>
</template>

<script>
    import queryString from 'query-string'

    export default {
        props: [
            'endpoint'
        ],
        data() {
            return {
                response: {
                    table: null,
                    displayable: [],
                    appendable: [],
                    updateable: [],
                    createable: [],
                    custom_columns: [],
                    data: [],
                    meta: [],
                    allow: {},
                },
                sort: {
                    key: 'id',
                    order: 'asc'
                },
                limit: 15,
                quickSearchQuery: '',
                editing: {
                    id: null,
                    form: {},
                    errors: []
                },
                search: {
                    value: '',
                    operator: 'equals',
                    column: 'id'
                },
                creating: {
                    active: false,
                    form: {},
                    errors: []
                },
                selected: []
            }
        },
        computed: {
            filteredRecords() {
                let data = this.response.data

                data = data.filter((row) => {
                    return Object.keys(row).some((key) => {
                        return String(row[key]).toLowerCase().indexOf(this.quickSearchQuery.toLowerCase()) > -1
                    })
                })

                if (this.sort.key) {
                    data = _.orderBy(data, (i) => {
                        let value = i[this.sort.key]

                        if (!isNaN(parseFloat(value))) {
                            return parseFloat(value)
                        }

                        return String(i[this.sort.key]).toLowerCase()
                    }, this.sort.order)
                }

                return data
            },
            canSelectItems() {
                return this.filteredRecords.length <= 500
            }
        },
        methods: {
            getRecords() {
                return axios.get(`${this.endpoint}?${this.getQueryParameters()}`).then((response) => {
                    this.response = response.data
                })
            },
            getQueryParameters() {
                return queryString.stringify({
                    limit: this.limit,
                    ...this.search
                })
            },
            sortBy(column) {
                this.sort.key = column
                this.sort.order = this.sort.order == 'asc' ? 'desc' : 'asc'
            },
            edit(record) {
                this.editing.errors = []
                this.editing.id = record.id
                this.editing.form = _.pick(record, this.response.updateable)
            },
            update() {
                axios.put(`${this.endpoint}/${this.editing.id}`, this.editing.form).then(() => {
                    this.getRecords().then(() => {
                        this.editing.id = null
                        this.editing.form = {}
                    })
                }).catch((error) => {
                    this.editing.errors = error.response.data.errors
                })
            },
            store() {
                axios.post(`${this.endpoint}`, this.creating.form).then(() => {
                    this.getRecords().then(() => {
                        this.creating.active = false
                        this.creating.form = {}
                        this.creating.errors = []
                    })
                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.creating.errors = error.response.data.errors
                    }
                })
            },
            destroy(record) {
                if (!window.confirm(`Are you sure you want to delete this?`)) {
                    return
                }

                axios.delete(`${this.endpoint}/${record}`).then(() => {
                    this.selected = []
                    this.getRecords()
                }).catch((error) => {
                    //
                })
            },
            isColumnUpdatable(column) {
                return this.response.updateable.includes(column)
            },
            toggleSelectAll() {
                if (this.selected.length > 0) {
                    this.selected = []
                    return
                }

                this.selected = _.map(this.filteredRecords, 'id')
            }
        },
        mounted() {
            this.getRecords()
        }
    }
</script>
