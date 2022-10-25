export default {
    data(){
        return {
            isOpen: false,
        };
    },
    methods: {
        toggle() {
            if (this.isOpen) {
                this.close();
            } else {
                this.open();
            }
        },
        open() {
            this.isOpen = true

            this.$emit('open');
        },
        close() {
            this.isOpen = false;

            this.$emit('close');
        },
    }
}
