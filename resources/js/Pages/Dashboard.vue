<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import Card from '@/Components/Card.vue'
import Pagination from '@/Components/Pagination.vue';
import moment from 'moment';
import axios from 'axios';
import { v4 as uuidv4 } from 'uuid';
import DeleteConfirmation from '@/Components/DeleteConfirmation.vue';
</script>

<script>
export default {
    components: {
        DeleteConfirmation
    },
    data() {
        return {
            confirmation: {
                is_open: false,
                use_inertia: false,
                id: '',
                route_name: '',
                method: '',
                params: '',
                title: '',
                description: ''
            },
        }
    },
    methods: {
        checkStatus(app_key, school_code, kit_id){
            localStorage.setItem('app-key', app_key);
            localStorage.setItem('app-school-code', school_code);
            localStorage.setItem('app-kit-id', kit_id);

            var app_token       = localStorage.getItem('app-token');
            
            if(!app_token){
                app_token = uuidv4();
                localStorage.setItem('app-token', app_token);
            }
            
            axios.post(route('launch.check_status', app_key), {
                platform: this.$device.os_name,
                browser: this.$device.browser_name,
                app_token : app_token
            })
            .then((response)=>{
                if(response.data == 100){
                    this.confirmation.route_name    =   'launch.check_status'
                    this.confirmation.method        =   'post'
                    this.confirmation.id            =   app_key
                    this.confirmation.is_open       =   true
                    this.confirmation.params        =   {'proceed': true}
                    this.confirmation.title         =   'Last Device Swap'
                    this.confirmation.description   =   'This is your last device swap, if you need too reset the device limit please contact support.'
                }
                if(response.data == 200){
                    this.launch()
                }
            })
        },
        launch() {
            const url = route('launch');

            // Create a temporary form element
            const form = document.createElement('form');
            form.action = url;
            form.method = 'POST';

            // Add the CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);

            // Add the localStorage items to the form
            form.appendChild(this.createHiddenInput('app_key', localStorage.getItem('app-key')));
            form.appendChild(this.createHiddenInput('app_token', localStorage.getItem('app-token')));

            // Append the form to the body and submit it
            document.body.appendChild(form);
            form.submit();

            // Remove the form after submission
            document.body.removeChild(form);
        },
        createHiddenInput(name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            return input;
        }
    },
}
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
                                        <Button @click="checkStatus(data.key, data.school_ref.code, data.kit_id)" v-if="data.swap_count != 3">Launch</Button>
                                        <div class="text-red-500 py-2" v-if="data.swap_count == 3">Device Limit Reached</div>
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
    <DeleteConfirmation :useInertia="confirmation.use_inertia" @success="launch()" :open="confirmation.is_open" @close="confirmation.is_open = false" :routeName="confirmation.route_name" :id="confirmation.id" :method="confirmation.method" :params="confirmation.params">
        <template #title>{{ confirmation.title }}</template>
        <template #description>{{ confirmation.description }}</template>
    </DeleteConfirmation>
</template>
