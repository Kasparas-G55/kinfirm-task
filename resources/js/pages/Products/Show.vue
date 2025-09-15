<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { Product } from '@/types';
import { PropType } from 'vue';
import { index, show } from '@/routes/product';
import { TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import Table from '@/components/ui/table/Table.vue';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/components/ui/carousel';
import { Card, CardContent } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';

const props = defineProps({
    product: Object as PropType<Product>,
    related: Array<Product>
})

console.log(props.related)
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
                    <p>
                        <span class="font-bold pr-2">Tags:</span>
                        <Badge v-for="tag in product?.tags" :key="tag.title">
                            {{ tag.title }}
                        </Badge>
                    </p>
                </div>
            </div>
            <Table class="rounded-md">
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
            <div class="flex flex-col items-center">
                <h2 class="text-xl font-medium mt-10 my-4">Related Products</h2>
                <Carousel class="relative w-full max-w-xs">
                    <CarouselContent>
                        <Link
                            v-for="product in related"
                            :key="product.sku"
                            :href="show(product.sku)"
                            class="basis-1/2"
                            :as="CarouselItem"
                        >
                            <Card class="hover:bg-current/5 h-56">
                                <CardContent class="flex flex-col text-nowrap items-center p-4">
                                    <img class="rounded-md w-full h-full" :src="product?.photo" :alt="product?.description">
                                    <h3 class="text-xl font-medium">{{ product?.sku }}</h3>
                                </CardContent>
                            </Card>
                        </Link>
                    </CarouselContent>
                    <CarouselPrevious />
                    <CarouselNext />
                </Carousel>
            </div>
        </div>
    </div>
</template>
