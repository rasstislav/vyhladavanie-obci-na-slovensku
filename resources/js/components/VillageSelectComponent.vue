<template>
    <v-select :options="options" :filterable="false" label="title" placeholder="Zadajte názov" @search="onFetchOptions" @input="onSelectedOption">
        <template #selected-option-container="{ option }">
            <span class="vs__selected" v-bind:class="{ 'text-danger': error }">
                {{ option.title }} ({{ option.region.title }})
            </span>
        </template>
        <template #option="option">
            {{ option.title }} ({{ option.region.title }})
        </template>
        <template #no-options>
            <span v-if="error" class="text-danger">{{ error }}</span>
            <span v-else-if="search">Ľutujeme, ale vyhľadávanému výrazu nezodpovedajú žiadne obce.</span>
            <span v-else>Začnite vyhľadávanie podľa názvu obce alebo mena starostu ...</span>
        </template>
    </v-select>
</template>

<script>
    import vSelect from 'vue-select';
    import axios from 'axios';
    import debounce from 'vue-debounce/src/debounce';

    const CancelToken = axios.CancelToken;
    let source = null;

    const fetchOptions = debounce((vm, search, loading) => {
        let $this = vm;

        if (source) {
            source.cancel();
        }

        if (! search) {
            return;
        }

        source = CancelToken.source();

        axios.get(`/obec?q=${search}`, {
                cancelToken: source.token
            })
            .then(response => {
                $this.options = response.data;
            })
            .catch(error => {
                if (! axios.isCancel(error)) {
                    $this.error = error.response.data.message || error.message;
                }
            })
            .finally(() => {
                loading(false);
            });
    }, 350);

    export default {
        components: {
            vSelect,
        },
        data() {
            return {
                options: [],
                search: null,
                error: false,
            }
        },
        methods: {
            onFetchOptions (search, loading) {
                this.search = search;
                this.error = false;

                if (search) {
                    loading(true);
                } else {
                    this.options = [];

                    loading(false);
                }

                fetchOptions(this, search, loading);
            },
            onSelectedOption(value) {
                this.error = false;

                if (! value) {
                    return;
                }

                axios.get(`/obec/${value.id}`)
                    .then(response => {
                        window.location.href = response.data.link;
                    })
                    .catch(error => {
                        this.error = error.response.data.message || error.message;
                    });
            },
        }
    }
</script>
