<template>
    <div>
        <header class="bg-blue-600 text-white">
            <nav class="flex items-center justify-between p-4 max-w-screen-lg mx-auto">
                <div class="space-x-6">
                    <Link :href="route('home')">Home</Link>
                    <a href="#">About</a>
                </div>
            </nav>
        </header>

        <main class="max-w-screen-lg mx-auto p-4">
            <slot />
        </main>
    </div>
</template>