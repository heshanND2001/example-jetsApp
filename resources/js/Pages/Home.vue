<script setup></script>

<template>
    <Head :title="` | ${$page.component}`" />
    <h1>{{ $page.component.user }}</h1>
    <Head title=" | Home" />
    <h1>Home Page</h1>

    <Link class="mt-[600px] block" href="/" preserve-scroll>Refresh</Link>
</template>

<!-- <template>
    <Layout>
        <h1>Hello</h1>
    </Layout>
</template> -->
