<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { Badge } from "@/components/ui/badge"
import { ScrollArea } from "@/components/ui/scroll-area"
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table"
import { Product, Tags } from '@/types'
import { show } from '@/routes/product'

defineProps({
    products: Array<Product>,
    tags: Array<Tags>
})
</script>

<template>
    <Head title="Products" />
    <div class="flex flex-col items-center gap-4 my-10">
        <h1 class="text-3xl font-medium ">Products</h1>
        <div class="flex flex-row  justify-self-center">
            <Table>
                <TableCaption>A list of current products.</TableCaption>
                <TableHeader>
                    <TableHead>SKU</TableHead>
                    <TableHead>Description</TableHead>
                    <TableHead>Size</TableHead>
                    <TableHead>Tags</TableHead>
                </TableHeader>
                <TableBody>
                    <Link
                        v-for="product in products"
                        :key="product.sku"
                        :href="show(product.sku)"
                        :as="TableRow"
                        class="cursor-pointer"
                    >
                        <TableCell class="font-bold">{{ product.sku }}</TableCell>
                        <TableCell class="text-wrap">{{ product.description }}</TableCell>
                        <TableCell>{{ product.size }}</TableCell>
                        <TableCell class="flex gap-2 overflow-hidden">
                            <Badge v-for="tag in product.tags" :key="`${product.sku}-${tag.title}`">
                                {{ tag.title }}
                            </Badge>
                        </TableCell>
                    </Link>
                </TableBody>
            </Table>
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
