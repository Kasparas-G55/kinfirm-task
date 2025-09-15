<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { Badge } from "@/components/ui/badge"
import { ScrollArea } from "@/components/ui/scroll-area"
import { Product, Tags } from '@/types'
import DataTable from '@/components/ui/data-table/data-table.vue'
import { columns } from '@/components/ui/data-table/columns'

defineProps({
    products: {
        type: Array<Product>,
            default: () => [],
    },
    tags: Array<Tags>
})

</script>

<template>
    <Head title="Products" />
    <div class="flex flex-col items-center gap-4 my-10">
        <h1 class="text-3xl font-medium ">Products</h1>
        <div class="flex flex-row  justify-self-center">
            <DataTable class="w-4xl" :columns="columns" :data="products" />
            <div class="p-4 w-3xs">
                <h2 class="text-xl font-medium mb-4">Tags</h2>
                <ScrollArea class="h-72  rounded-md">
                    <div class="flex justify-center flex-col">
                        <div class="mb-2" v-for="tag in tags" :key="tag.title">
                            <Badge class="text-sm min-w-36">
                                <span>{{ tag.title }}</span>
                                <span class="text-current/50">({{ tag.count }})</span>
                            </Badge>
                        </div>
                    </div>
                </ScrollArea>
            </div>
        </div>
    </div>
</template>
