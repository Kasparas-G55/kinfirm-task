<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { Product } from '@/types';
import { PropType } from 'vue';
import { index } from '@/routes/product';
import { TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import Table from '@/components/ui/table/Table.vue';

defineProps({
    product: Object as PropType<Product>
})
</script>

<template>
    <Head :title="`Product - ${product?.sku}`" />
    <Link class="relative top-4 left-4 text-current/75" :href="index()">Back to Products</Link>
    <div class="flex flex-col items-center my-10">
        <h1 class="text-3xl mb-6 font-medium">{{ product?.sku }}</h1>
        <div class="flex flex-col gap-4">
            <div class="flex gap-4">
                <div class="max-w-3xs max-h-64 aspect-fit">
                    <img class="object-cover rounded-md w-full h-full" :src="product?.photo" :alt="product?.description">
                </div>
                <div class="flex flex-col">
                    <p class="text-current/75">{{ product?.description }}</p>
                    <p><span class="font-bold">Size:</span> {{ product?.size }}</p>
                </div>
            </div>
            <Table class="rounded-md">
                <TableCaption>A list of the products stocks.</TableCaption>
                <TableHeader>
                    <TableHead>City</TableHead>
                    <TableHead>Stock</TableHead>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="stock in product?.stocks" :key="stock.city">
                        <TableCell>{{ stock.city }}</TableCell>
                        <TableCell>{{ stock.stock }}</TableCell>
                    </TableRow>
                    <TableRow v-if="!product?.stocks?.length">
                        <TableCell class="text-center font-medium text-base" colspan="2">No stock available.</TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </div>
</template>
