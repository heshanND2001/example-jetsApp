<script setup>
</script>

<template>

    <!-- <div>
        <header class="bg-indigo-500 text-white">
            <nav class="flex items-center justify-between p-4 max-w-screen-lg mx-auto"> -->

                <!-- <h1>{{ $page.props.auth.user }}</h1> -->

                <!-- <div class="space-x-6">
                    <Link href="/">Home</Link>
                    <Link href="/about">About</Link>
                    <Link href="/task" class="nav-link">Task</Link>
                </div>
            </nav>
        </header>

        <main class="p-4">
            <slot/>
        </main>
    </div> -->

<div>
    <header class="bg-indigo-500 text-white">
        <nav class="flex items-center justify-between p-4 max-w-screen-lg mx-auto">
            <div class="space-x-3 g-2">
                <Link :href="route('home')">Home</Link>
                <Link :href="route('about')">About</Link>
                <Link :href="route('task')">Task</Link>
            </div>

            <!-- <div class="space-x-6">

            </div>

            <div class="space-x-6">

            </div> -->
        </nav>
    </header>

    <main class="p-4">
        <slot/>
    </main>
</div>

</template>
