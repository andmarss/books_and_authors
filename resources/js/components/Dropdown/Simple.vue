<template>
    <div class="relative inline-block text-left" v-click-outside="close">
        <div>
            <a @click.prevent="toggle" href="javascript:void(0)" type="button" class="inline-flex justify-center w-full px-4 py-2 bg-white text-sm font-medium text-gray-700 focus:outline-none" id="menu-button" aria-expanded="true" aria-haspopup="true">
                <slot name="user"></slot>
                <!-- Heroicon name: solid/chevron-down -->
                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" v-if="isOpen">
                <div class="py-1" role="none">
                    <slot name="dropdown"></slot>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import DropdownMixin from '@js/mixins/dropdown';
import GlobalMixin from '@js/mixins/global';

export default {
    name: "Simple",
    mixins: [DropdownMixin, GlobalMixin],

}
</script>

<style scoped>

</style>
