<template>
    <div class="relative" v-click-outside="close">
        <button v-if="!searchable" @click.prevent="toggle" type="button" class="bg-white relative w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" aria-haspopup="listbox-genre" aria-expanded="true" aria-labelledby="listbox-genre-label">
              <span class="block truncate">
                {{ title }}
              </span>
            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                <!-- Heroicon name: solid/selector -->
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </span>
        </button>

        <div v-if="searchable">
            <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center z-10">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" v-if="!isSearching && !searchValue">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <a href="javascript:void(0)" @click.prevent="clearSearchValue" class="cursor-pointer text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4" v-if="!isSearching && searchValue">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                    <div class="animate-spin inline-block w-6 h-6 border-[3px] border-current border-t-transparent text-blue-600 rounded-full" role="status" aria-label="loading" v-if="isSearching">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

                <input type="text" @focus.prevent="open" @input.prevent="search" v-model="searchValue" class="bg-white relative w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" :placeholder="title">

            </div>
        </div>

        <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <ul class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm" tabindex="-1" role="listbox-genre" aria-labelledby="listbox-genre-label" aria-activedescendant="listbox-genre-option-3" v-if="isOpened">

                <li v-if="items && items.length" v-for="item in items" :key="item.id" @click.prevent="select(item)" class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9 hover:text-white hover:bg-indigo-600" id="listbox-genre-option-0" role="option">
                    <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                    <span class="truncate" :class="selectedId === item.id ? 'font-semibold' : 'font-normal'">
                      {{ item.title }}
                    </span>

                    <span v-if="item.badge" class="ml-1.5 rounded py-0.5 px-1.5 bg-gray-200 text-xs font-semibold text-gray-700 tabular-nums">{{item.badge}}</span>

                    <span class="text-indigo-600 absolute inset-y-0 right-0 flex items-center pr-4" v-if="selectedId === item.id">
                      <!-- Heroicon name: solid/check -->
                      <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                      </svg>
                    </span>
                </li>
            </ul>
        </transition>
    </div>
</template>

<script>
import DropdownMixin from '@js/mixins/dropdown';

export default {
    name: "Dropdown",
    mixins: [DropdownMixin],
    props: {
        label: {
            type: String,
            default: "Select"
        },
        options: {
            type: Array,
            default: () => []
        },
        value: {
            type: Object,
            default: () => {}
        },
        defaultTitle: {
            type: String,
            default: ""
        },
        searchable: {
            type: Boolean,
            default: false
        },
        loading: {
            type: Boolean,
            default: false
        },
        clearSearchOnClose: {
            type: Boolean,
            default: true
        }
    },
    data(){
        return {
            selected: this.value,
            items: [],
            isSearching: false,
            searchValue: ''
        }
    },

    methods: {
        close() {
            this.isOpen = false;

            this.$emit('close');

            if (this.clearSearchOnClose) {
                this.searchValue = '';
            }
        },
        select(item){
            this.selected = item?.id === this.selected?.id ? null : item;
            this.isOpen = false

            if (this.searchable) {
                this.searchValue = this.selected?.title;
            }

            this.$emit('input', this.selected);
        },
        search() {
            this.$emit('search', this.searchValue);
        },
        clearSearchValue() {
            this.searchValue = '';
            this.selected = null;

            this.$emit('clear');
            this.$emit('input', null);
        }
    },

    created() {
        window.addEventListener('click', (e) => {
            if (!this.$el.contains(e.target)){
                this.isOpen = false;
            }
        });
    },

    computed: {
        title() {
            return this.selected ? this.selected.title : this.defaultTitle;
        },
        selectedId() {
            return this.selected?.id || 0;
        },
        isOpened() {
            if (this.searchable) {
                return this.isOpen && this.items?.length;
            } else {
                return this.isOpen;
            }
        }
    },

    watch: {
        options(newOptions) {
            this.items = newOptions;
        },
        loading(isLoading) {
            this.isSearching = isLoading;
        }
    }
}
</script>

<style scoped>

</style>
