<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import { Badge } from "@/components/ui/badge"
import { ScrollArea } from "@/components/ui/scroll-area"
import { Product, Tags } from '@/types'
import DataTable from '@/components/ui/data-table/data-table.vue'
import { columns } from '@/components/ui/data-table/columns'
import { logout } from '@/routes'
import { LogOut } from 'lucide-vue-next'

defineProps({
    products: {
        type: Array<Product>,
            default: () => [],
    },
    tags: Array<Tags>
})

const handleLogout = () => {
    router.flushAll();
};

</script>

<template>
    <Head title="Products" />
    <Link class="hover:underline relative top-4 left-4 text-current/80" :href="logout()" @click="handleLogout" as="button">
        <span class="flex items-center">
            <LogOut class="mr-2 h-4 w-4" />
            Log out
        </span>
    </Link>
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
