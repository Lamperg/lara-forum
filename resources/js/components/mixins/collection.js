export default {
    data() {
        return {
            items: [],
        };
    },
    methods: {
        /**
         * Adds items to the collection
         *
         * @param item
         */
        add(item) {
            this.items.push(item);
            this.$emit('added');
        },

        /**
         * Removes item from the collection
         *
         * @param index
         */
        remove(index) {
            this.items.splice(index, 1);
            this.$emit('removed');
        },
    },
};
