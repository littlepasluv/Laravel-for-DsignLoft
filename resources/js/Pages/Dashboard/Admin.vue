<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Admin Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-500">Total Briefs</div>
                            <div class="mt-2 text-3xl font-semibold text-gray-900">{{ stats.total_briefs }}</div>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-500">Total Users</div>
                            <div class="mt-2 text-3xl font-semibold text-gray-900">{{ stats.total_users }}</div>
                            <div class="mt-2 text-sm text-gray-500">
                                {{ stats.clients }} clients, {{ stats.designers }} designers
                            </div>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-500">Brief Status</div>
                            <div class="mt-2 space-y-1">
                                <div class="text-sm">
                                    <span class="font-medium">Pending:</span> {{ stats.pending_briefs }}
                                </div>
                                <div class="text-sm">
                                    <span class="font-medium">In Progress:</span> {{ stats.in_progress_briefs }}
                                </div>
                                <div class="text-sm">
                                    <span class="font-medium">Completed:</span> {{ stats.completed_briefs }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- All Briefs -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">All Briefs</h3>
                        
                        <div v-if="briefs.length === 0" class="text-gray-500 text-center py-8">
                            No briefs yet.
                        </div>

                        <div v-else class="space-y-4">
                            <div 
                                v-for="brief in briefs" 
                                :key="brief.id"
                                class="border rounded-lg p-4"
                            >
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-semibold text-lg">{{ brief.title }}</h4>
                                        <p class="text-gray-600 text-sm mt-1">{{ brief.description }}</p>
                                        <div class="mt-2 flex items-center space-x-4">
                                            <span class="text-sm text-gray-500">
                                                Client: {{ brief.creator.name }}
                                            </span>
                                            <span class="text-sm text-gray-500">
                                                Package: {{ brief.package.name }}
                                            </span>
                                            <span 
                                                class="px-2 py-1 text-xs rounded-full"
                                                :class="{
                                                    'bg-yellow-100 text-yellow-800': brief.status === 'pending',
                                                    'bg-blue-100 text-blue-800': brief.status === 'in_progress',
                                                    'bg-purple-100 text-purple-800': brief.status === 'review',
                                                    'bg-green-100 text-green-800': brief.status === 'completed',
                                                    'bg-red-100 text-red-800': brief.status === 'cancelled'
                                                }"
                                            >
                                                {{ brief.status }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ new Date(brief.created_at).toLocaleDateString() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- All Users -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">All Users</h3>
                        
                        <div v-if="users.length === 0" class="text-gray-500 text-center py-8">
                            No users yet.
                        </div>

                        <div v-else class="space-y-4">
                            <div 
                                v-for="user in users" 
                                :key="user.id"
                                class="border rounded-lg p-4"
                            >
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-semibold">{{ user.name }}</h4>
                                        <p class="text-gray-600 text-sm mt-1">{{ user.email }}</p>
                                        <span 
                                            class="mt-2 inline-block px-2 py-1 text-xs rounded-full"
                                            :class="{
                                                'bg-blue-100 text-blue-800': user.role === 'client',
                                                'bg-purple-100 text-purple-800': user.role === 'designer',
                                                'bg-red-100 text-red-800': user.role === 'admin'
                                            }"
                                        >
                                            {{ user.role }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    briefs: Array,
    users: Array,
    stats: Object,
    user: Object
});
</script>
