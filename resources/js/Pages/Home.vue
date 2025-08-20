<script setup>
import GuestLayout from '../Layouts/GuestLayout.vue';
</script>

<template>
    <GuestLayout>
        <Head title="Home"></Head>
        <div> 
            <h1>{{ $page.props.user }}</h1>
        </div>
    </GuestLayout>
</template>