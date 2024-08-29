<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import Card from '@/Components/Card.vue'
import Pagination from '@/Components/Pagination.vue';
import moment from 'moment';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
                <Card>
                    <template #title>Toddler App Keys</template>
                    <template #content>
                        <Table>
                            <TableHeader class="bg-gray-100">
                                <TableRow>
                                    <TableHead>#</TableHead>
                                    <TableHead class="whitespace-nowrap">Device Name</TableHead>
                                    <TableHead class="whitespace-nowrap">Kit</TableHead>
                                    <TableHead class="whitespace-nowrap text-center">Swap Count</TableHead>
                                    <TableHead class="whitespace-nowrap text-center">Expiry Date</TableHead>
                                    <TableHead class="whitespace-nowrap text-center">Action</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-if="!$page.props.keys.data.length">
                                    <TableCell class="text-center" colspan="10">
                                        <div class="p-3">
                                            No Record Found
                                        </div>
                                    </TableCell>
                                </TableRow> 
                                <TableRow v-for="data, index in $page.props.keys.data">
                                    <TableCell>{{ $page.props.keys.from + index }}</TableCell>
                                    <TableCell class="whitespace-nowrap">{{ data.device_name }}</TableCell>
                                    <TableCell class="whitespace-nowrap">{{ data.kit_ref?.name }}</TableCell>
                                    <TableCell class="whitespace-nowrap text-center">{{ data.swap_count }}</TableCell>
                                    <TableCell class="whitespace-nowrap text-center">{{ moment(data.expiry_date).format('DD MMM YYYY') }}</TableCell>
                                    <TableCell class="whitespace-nowrap text-center">
                                        <Button>Launch</Button>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </template>
                </Card>
                <Pagination :page_data="$page.props.keys"></Pagination>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
