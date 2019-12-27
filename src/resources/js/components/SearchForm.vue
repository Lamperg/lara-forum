<template>
    <ais-instant-search :search-client="searchClient" index-name="threads">
        <ais-search-box/>

        <ais-refinement-list attribute="channel.name"/>

        <ais-hits>
            <div slot="item" slot-scope="{ item }">
                <a :href="item.path">
                    <ais-highlight attribute="title" :hit="item"/>
                </a>
            </div>
        </ais-hits>
    </ais-instant-search>
</template>

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

<style>
    body {
        font-family: sans-serif;
        padding: 1em;
    }
</style>
