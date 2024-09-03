<template>
    <Head title="Manage Schools" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Manage Schools</h2>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
                <Card>
                    <template #title>School Information</template>
                    <template #content>
                        <div class="grid grid-cols-1 2xl:grid-cols-2 gap-4">
                            <div class="">
                                <Label>Name</Label>
                                <Input disabled v-model="$page.props.info.name"></Input>
                            </div>
                            <div class="">
                                <Label>Email</Label>
                                <Input disabled v-model="$page.props.info.email"></Input>
                            </div>
                        </div>
                    </template>
                </Card>
                <Card>
                    <template #title>Toddler App Keys</template>
                    <template #content>
                        <div class="grid grid-cols-1 2xl:grid-cols-3 gap-4 mb-1">
                            <!-- <ComboBox class="w-full" :items="$page.props.options.categories" placeholder="Category" searchPlaceholder="Search category..." selectPlaceholder="Category" @select="search" v-model="params.category_id"></ComboBox> -->
                            <!-- <div class="flex justify-end space-x-2">
                                <Button class="space-x-2">
                                    <MixerHorizontalIcon class="h-5 w-5"/>
                                    <span class="hidden sm:block">Category</span> 
                                </Button>
                                <Button class="space-x-2">
                                    <PlusCircledIcon class="h-5 w-5"/>
                                    <span class="hidden sm:block">Key Activation</span> 
                                </Button>
                            </div> -->
                        </div>
                        <Table>
                            <TableHeader class="bg-gray-100">
                                <TableRow>
                                    <TableHead class="whitespace-nowrap pl-10">Kit</TableHead>
                                    <TableHead class="whitespace-nowrap">Expiry Date</TableHead>
                                    <TableHead class="whitespace-nowrap text-center">Swap Count</TableHead>
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
                                    <TableCell class="whitespace-nowrap pl-10">{{ data.kit_ref?.name }}</TableCell>
                                    <TableCell class="whitespace-nowrap">{{ moment(data.expiry_date).format('DD MMM YYYY') }}</TableCell>
                                    <TableCell class="whitespace-nowrap text-center">{{ data.swap_count }}</TableCell>
                                    <TableCell class="whitespace-nowrap text-center space-x-2">
                                        <Button variant="outline" @click="ResetKeySwapCount(data.id)">Reset Swap Count</Button>
                                        <Button variant="destructive" @click="deleteKey(data.id)">Delete</Button>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </template>
                </Card>
                <Card>
                    <template #content>
                        <div class="flex justify-between">
                            <div class="flex space-x-2">
                                <Button variant="outline" class="space-x-2" @click="resetPassword">
                                    <ReloadIcon class="h-4 w-4"></ReloadIcon>
                                    <span>Reset Password</span>
                                </Button>
                                <Button variant="destructive" @click="deleteSchool">
                                    <TrashIcon class="h-4 w-4"></TrashIcon>
                                    <span>Delete School</span>
                                </Button>
                            </div>
                        </div>
                    </template>
                </Card>
                <Card>
                    <template #content>
                        <div class="flex justify-end">
                            <Button variant="outline" class="space-x-1" @click="$inertia.get(route('schools'))">
                                <ResetIcon class="h-4 w-4"></ResetIcon>
                                <span>Back</span> 
                            </Button>
                        </div>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
    <DeleteConfirmation :open="confirmation.is_open" @close="confirmation.is_open = false" :routeName="confirmation.route_name" :id="confirmation.id" :method="confirmation.method">
        <template #title>{{ confirmation.title }}</template>
        <template #description>{{ confirmation.description }}</template>
    </DeleteConfirmation>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import Card from '@/Components/Card.vue'
import Pagination from '@/Components/Pagination.vue';
import moment from 'moment';
import { debounce } from 'vue-debounce'
import { ReloadIcon, TrashIcon, ResetIcon } from '@radix-icons/vue';
import DeleteConfirmation from '@/Components/DeleteConfirmation.vue';
</script>

<script>
export default {
    components: {
        DeleteConfirmation
    },
    data() {
        return {
            params: {
                search: this.$page.props.filters?.search || '',
                category_id: this.$page.props.filters?.category_id || '',
            },
            confirmation: {
                is_open: false,
                id: '',
                route_name: '',
                method: '',
                title: '',
                description: ''
            },
        }
    },
    methods: {
        search(){
            this.$inertia.get(this.route('schools'), this.params, { replace: true, preserveState: true});
        },
        deleteKey(key_id){
            this.confirmation.route_name    =   'keys.destroy'
            this.confirmation.method        =   'delete'
            this.confirmation.id            =   key_id
            this.confirmation.is_open       =   true
            this.confirmation.title         =   'Delete key'
            this.confirmation.description   =   'Are you sure want to delete this key?'
        },
        ResetKeySwapCount(key_id){
            this.confirmation.route_name    =   'keys.reset'
            this.confirmation.method        =   'post'
            this.confirmation.id            =   key_id
            this.confirmation.is_open       =   true
            this.confirmation.title         =   "Reset Key's Swap count"
            this.confirmation.description   =   "Are you sure want to reset this key's swap count?"
        },
        deleteSchool(){
            this.confirmation.route_name    =   'schools.destroy'
            this.confirmation.method        =   'delete'
            this.confirmation.id            =   this.$page.props.info.id
            this.confirmation.is_open       =   true
            this.confirmation.title         =   'Delete School'
            this.confirmation.description   =   'Are you sure want to delete this school? All information will be deleted and this action is irreversible.'
        },
        resetPassword(){
            this.confirmation.route_name    =   'schools.reset_password'
            this.confirmation.method        =   'post'
            this.confirmation.id            =   this.$page.props.info.id
            this.confirmation.is_open       =   true
            this.confirmation.title         =   'Reset Password'
            this.confirmation.description   =   "Are you sure want to reset password? New password will be sent to owner's email."
        },
    }
}
</script>
