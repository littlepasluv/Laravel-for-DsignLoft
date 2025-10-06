<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Client Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">My Briefs</h3>
                        
                        <div v-if="briefs.length === 0" class="text-gray-500 text-center py-8">
                            No briefs yet. Create your first brief to get started!
                        </div>

                        <div v-else class="space-y-4">
                            <div 
                                v-for="brief in briefs" 
                                :key="brief.id"
                                class="border rounded-lg p-4 hover:shadow-md transition-shadow"
                            >
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-semibold text-lg">{{ brief.title }}</h4>
                                        <p class="text-gray-600 text-sm mt-1">{{ brief.description }}</p>
                                        <div class="mt-2 flex items-center space-x-4">
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
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    briefs: Array,
    user: Object
});
</script>
