import { Product } from '@/types';
import { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';
import Badge from '../badge/Badge.vue';
import { Link } from '@inertiajs/vue3';
import { show } from '@/routes/product';

export const columns: ColumnDef<Product>[] = [
    {
        accessorKey: 'sku',
        header: () => h('div', { class: 'text-right' }, 'SKU'),
        cell: ({ row }) => h('div', { class: 'text-right font-bold' }, row.getValue('sku'))
    },
    {
        accessorKey: 'description',
        header: () => h('div', { class: 'text-right' }, 'Description'),
        cell: ({ row }) => h('div', row.getValue('description'))
    },
    {
        accessorKey: 'size',
        header: () => h('div', { class: 'text-right' }, 'Size'),
        cell: ({ row }) => h('div', { class: 'text-center' }, row.getValue('size'))
    },
    {
        accessorKey: 'tags',
        header: () => h('div', { class: 'text-left'  }, 'Tags'),
        cell: ({ row }) => {
            const tag = row.getValue<Product['tags']>('tags').at(0);

            if (!tag)
                return;

            return h(Badge, { class: 'text-right font-medium' }, () => tag.title)
        }
    },
    {
        accessorKey: 'link',
        header: () => h('div'),
        cell: ({ row }) => {
            const sku = row.getValue<string>('sku');
            return h(Link, { href: show(sku), class: 'hover:underline text-right font-medium text-current/50' }, () => 'View')
        }
    },
]
