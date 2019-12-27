<script>
    import algoliaSearch from 'algoliasearch/lite';

    export default {
        props: ['apiKey', 'appId'],
        data() {
            return {
                searchClient: algoliaSearch(this.appId, this.apiKey),
            };
        },
    };
</script>
