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
import AlertDialog from '@/Components/AlertDialog.vue';
</script>

<script>
export default {
    components: {
        DeleteConfirmation, AlertDialog
    },
    data() {
        return {
            device_name: '',
            confirmation: {
                is_open: false,
                use_inertia: false,
                id: '',
                route_name: 'launch.check_device',
                method: 'post',
                params: {'confirm': true},
                title: '',
                subtitle: '',
                description: ''
            },
            alert_dialog: {
                is_open: false,
                title: '',
                subtitle: '',
                description: ''
            }
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
            
            axios.post(route('launch.check_device', [app_key, app_token]))
            .then((response)=>{
                const data = response.data
                if(data.launch){
                    this.launch()
                }
                if(data.first_device){
                    this.confirmation.id            =   [app_key, app_token]
                    this.confirmation.is_open       =   true
                    this.confirmation.title         =   'Device Name'
                    this.confirmation.subtitle      =   ''
                    this.confirmation.description   =   ''
                }
                if(data.new_device){
                    this.confirmation.id            =   [app_key, app_token]
                    this.confirmation.is_open       =   true
                    this.confirmation.title         =   'New Device Detected'
                    this.confirmation.subtitle      =   'Active device: ' + data.active_device_name
                    this.confirmation.description   =   'You are trying to launch on a new device, are you sure?'
                }
                if(data.last_swap){
                    this.confirmation.id            =   [app_key, app_token]
                    this.confirmation.is_open       =   true
                    this.confirmation.title         =   'New Device Detected'
                    this.confirmation.subtitle      =   'Active device: ' + data.active_device_name
                    this.confirmation.description   =   'You are about to reach maximum swap count for this key, if you need to reset the device limit please contact us.'
                }
                if(data.device_limit_reached){
                    this.alert_dialog.is_open       =   true
                    this.alert_dialog.title         =   'Device Limit Reached'
                    this.alert_dialog.subtitle      =   ''
                    this.alert_dialog.description   =   'Sorry, your have reached device limit. If you wish to reset the device limit, please contact us.'
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
            form.appendChild(this.createHiddenInput('device_name', this.device_name));

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
        },
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
                                        <Button @click="checkStatus(data.key, data.school_ref.code, data.kit_id)">Launch</Button>
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
        <template #subtitle>{{ confirmation.subtitle }}</template>
        <template #description>{{ confirmation.description }}</template>
        <template #content>
            <Input type="text" maxlength="30" class="text-slate-900" v-model="device_name" placeholder="New Device Name"></Input>
        </template>
    </DeleteConfirmation>
    <AlertDialog :open="alert_dialog.is_open" @close="alert_dialog.is_open = false">
        <template #title>{{ alert_dialog.title }}</template>
        <template #description>{{ alert_dialog.description }}</template>
    </AlertDialog>
</template>
