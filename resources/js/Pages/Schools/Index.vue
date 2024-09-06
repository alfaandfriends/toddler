<template>
    <Head title="Manage Schools" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Manage Schools</h2>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
                <Card>
                    <template #title>Edit School Details and Manage Key Activation</template>
                    <template #content>
                        <div class="grid grid-cols-1 2xl:grid-cols-3 gap-4 mb-1">
                            <div class="relative w-full items-center">
                                <Input type="text" placeholder="Search..." class="pl-10" v-debounce:800ms="search" v-model="params.search"/>
                                <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
                                    <MagnifyingGlassIcon class="size-6 text-muted-foreground" />
                                </span>
                            </div>
                            <ComboBox class="w-full" :items="$page.props.options.categories" placeholder="Category" searchPlaceholder="Search category..." selectPlaceholder="Category" @select="search" v-model="params.category_id"></ComboBox>
                            <div class="flex justify-end space-x-2">
                                <Button class="space-x-2" @click="showManageCategory">
                                    <MixerHorizontalIcon class="h-5 w-5"/>
                                    <span class="hidden sm:block">Category</span> 
                                </Button>
                                <Button class="space-x-2" @click="showkeyActivation">
                                    <PlusCircledIcon class="h-5 w-5"/>
                                    <span class="hidden sm:block">Key Activation</span> 
                                </Button>
                            </div>
                        </div>
                        <Table>
                            <TableHeader class="bg-gray-100">
                                <TableRow>
                                    <TableHead>#</TableHead>
                                    <TableHead>School Name</TableHead>
                                    <TableHead>School Code</TableHead>
                                    <TableHead>Category</TableHead>
                                    <TableHead class="text-center">Action</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-if="!$page.props.schools.data.length">
                                    <TableCell class="text-center" colspan="10">
                                        <div class="p-3">
                                            No Record Found
                                        </div>
                                    </TableCell>
                                </TableRow> 
                                <TableRow v-for="data, index in $page.props.schools.data">
                                    <TableCell class="whitespace-nowrap">{{ $page.props.schools.from + index }}</TableCell>
                                    <TableCell class="whitespace-nowrap">{{ data.name }}</TableCell>
                                    <TableCell class="whitespace-nowrap">{{ data.code }}</TableCell>
                                    <TableCell class="whitespace-nowrap">{{ data.category_ref?.name }}</TableCell>
                                    <TableCell class="text-center">
                                        <Button variant="secondary" @click="edit(data.id)">Edit</Button>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </template>
                </Card>
                <Pagination :page_data="$page.props.schools" :params="params"></Pagination>
            </div>
        </div>
    </AuthenticatedLayout>
    <DialogModal v-model:open="show.manage_category">
        <template #title>Manage Category</template>
        <template #content>
            <div class="grid grid-cols-1 gap-4 py-1">
                <div class="">
                    <Label>Category</Label>
                    <ComboBox class="w-full" :items="$page.props.options.categories" placeholder="Category" searchPlaceholder="Search category..." selectPlaceholder="Category" v-model="manage_category_form.id" @select="manage_category_form.name = $page.props.options.categories.find(item => item.id == manage_category_form.id)?.name"></ComboBox>
                </div>
                <div class="">
                    <Label>Label</Label>
                    <Input type="text" v-model="manage_category_form.name" :error="!manage_category_form.name"/>
                </div>
            </div>
        </template>
        <template #footer>
            <Button variant="outline" @click="show.manage_category = false">Cancel</Button>
            <Button @click="updateCategory">Save</Button>
        </template>
    </DialogModal>
    <DialogModal v-model:open="show.key_activation">
        <template #title>Key Activation</template>
        <template #content>
            <div class="grid grid-cols-1 gap-4 py-1">
                <div class="">
                    <Label>School Code</Label>
                    <div class="relative w-full items-center">
                        <Input type="text" v-debounce:800ms="searchCode" v-model="key_activation_form.code" :error="!key_activation_form.code"/>
                        <svg aria-hidden="true" v-if="searching_code" class="absolute end-0 inset-y-1 p-1 w-7 h-7 text-gray-200 animate-spin dark:text-gray-600 fill-slate-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                    </div>
                </div>
                <div class="">
                    <Label>School Name</Label>
                    <Input type="text" v-model="key_activation_form.name" :disabled="disable_input" :error="!key_activation_form.name"/>
                </div>
                <div class="">
                    <Label>School Email</Label>
                    <div class="relative w-full items-center">
                        <Input type="text" v-model="key_activation_form.email" :disabled="disable_input" :error="!key_activation_form.email ? !key_activation_form.email : email_exist_text" v-debounce:800ms="checkEmail"/>
                        <svg aria-hidden="true" v-if="checking_email" class="absolute end-0 inset-y-1 p-1 w-7 h-7 text-gray-200 animate-spin dark:text-gray-600 fill-slate-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                    </div>
                </div>
                <div class="">
                    <Label>Category</Label>
                    <ComboBox class="w-full" :items="$page.props.options.categories" labelProp="name" valueProperty="id" searchPlaceholder="Search category..." :selectPlaceholder="$page.props.options.categories.find(item => item.id == key_activation_form.category)?.name" v-model="key_activation_form.category" :disabled="disable_input" :error="!key_activation_form.category"></ComboBox>
                </div>
                <div class="" v-if="!searching_code">
                    <Label>Kit</Label>
                    <div class="flex space-x-6">
                        <template v-for="kit, index in key_activation_form.kits">
                            <div class="flex items-center space-x-2">
                                <Checkbox :id="'kit_'+kit.id" @update:checked="checkKit(kit)"></Checkbox>
                                <Label class="cursor-pointer" :for="'kit_'+kit.id">{{ kit.name }}</Label>
                            </div>
                        </template>
                    </div>
                    <p class="mt-0.5 text-[0.8rem] font-medium text-destructive" v-if="!key_activation_form.kits.find(item=>item.checked == true)">
                      At least 1 kit is required.
                    </p>
                </div>
                <div class="p-4 text-sm text-red-700 rounded-lg bg-red-50" role="alert" v-if="kit_1_exists || kit_2_exists">
                    <span class="font-medium">Warning: </span> 
                    This school already have an active keys for 
                    <span v-html="kit_1_exists && kit_2_exists ? '<b>Kit 1</b> and <b>Kit 2</b>' : kit_1_exists && !kit_2_exists ? '<b>Kit 1</b>' : '<b>Kit 2</b>'"></span>. 
                    This will replace the keys.
                </div>
                <hr class="mt-3">
            </div>
        </template>
        <template #footer>
            <!-- <div class="flex flex-col space-y-2 md:flex-row md:space-x-2"> -->
                <Button variant="outline" @click="show.key_activation = false">Cancel</Button>
                <Button @click="saveKeyActivation()">Save</Button>
            <!-- </div> -->
        </template>
    </DialogModal>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import Card from '@/Components/Card.vue'
import Pagination from '@/Components/Pagination.vue';
import moment from 'moment';
import { debounce } from 'vue-debounce'
import { MagnifyingGlassIcon, PlusCircledIcon, MixerHorizontalIcon } from '@radix-icons/vue';
import DialogModal from '@/Components/DialogModal.vue';
import axios from 'axios';
import Label from '@/Components/ui/label/Label.vue';
import { Alert, AlertDescription, AlertTitle } from '@/Components/ui/alert'
</script>

<script>
export default {
    data() {
        return {
            params: {
                search: this.$page.props.filters.search ? this.$page.props.filters.search : '',
                category_id: this.$page.props.filters.category_id ? this.$page.props.filters.category_id : '',
            },
            show: {
                manage_category: false,
                key_activation: false
            },
            manage_category_form: {
                id: '',
                name: ''
            },
            searching_code: false,
            checking_email: false,
            email_exists: '',
            email_exist_text: '',
            kit_1_exists: false,
            kit_2_exists: false,
            disable_input: false,
            key_activation_form: {
                id: '',
                code: '',
                name: '',
                email: '',
                category: '',
                kits: []
            }
        }
    },
    methods: {
        search(){
            this.$inertia.get(this.route('schools'), this.params, { replace: true, preserveState: true});
        },
        edit(school_id){
            this.$inertia.get(route('schools.edit'), {'school_id': school_id})
        },
        updateCategory(){
            if(this.manage_category_form.id && this.manage_category_form.name){
                this.$inertia.post(route('categories.update'), this.manage_category_form, {preserveState: false})
            }
        },
        searchCode(){
            this.key_activation_form.id = ''
            this.key_activation_form.name = ''
            this.key_activation_form.email = ''
            this.key_activation_form.category = ''

            if(this.key_activation_form.code){
                this.searching_code = true
                this.disable_input = false
                axios.get(route('schools.info', this.key_activation_form.code))
                .then((response)=>{
                    const data = response.data
                    if(data){
                        this.key_activation_form.id = data.id
                        this.key_activation_form.code = data.code
                        this.key_activation_form.name = data.name
                        this.key_activation_form.email = data.email
                        this.key_activation_form.category = data.category_id
                        this.disable_input = true
                    }
                    this.searching_code = false
                })
            }
            this.initiateKits()
        },
        checkEmail(){
            this.email_exist_text = ''
            this.email_exists = false
            if(this.key_activation_form.email){
                this.checking_email = true
                axios.get(route('schools.check_email', this.key_activation_form.email))
                .then((response)=>{
                    this.email_exists = response.data
                    if(this.email_exists && !this.key_activation_form.id){
                        this.email_exist_text = 'Email exists, please use another email.'
                    }
                    this.checking_email = false
                })
            }
        },
        checkKit(kit){
            this[`kit_${kit.id}_exists`] = false
            kit.checked = !kit.checked
            if(kit.checked == true){
                axios.get(route('schools.check_kit', [this.key_activation_form.id, kit.id]))
                .then((response)=>{
                    if(response.data){
                        this[`kit_${kit.id}_exists`] = response.data
                    }
                })
            }
            return kit.checked
        },
        showManageCategory(){
            this.show.manage_category = true
        },
        showkeyActivation(){
            this.show.key_activation = true
        },
        saveKeyActivation(){
            if(
                !this.searching_code && 
                !this.checking_email && 
                !this.email_exists && 
                this.key_activation_form.code && 
                this.key_activation_form.name && 
                this.key_activation_form.email && 
                this.key_activation_form.category && 
                this.key_activation_form.kits.find(item => item.checked == true)
            ){
                this.$inertia.post(route('schools.store'), this.key_activation_form, {preserveState: false})
            }
        },
        initiateKits(){
            this.key_activation_form.kits = []
            this.$page.props.options.kits.map((item)=>{
                this.key_activation_form.kits.push({
                    id: item.id,
                    name: item.name,
                    checked: false,
                })
            })
            this.kit_1_exists = false
            this.kit_2_exists = false
        }
    },
    mounted(){
        this.initiateKits()
    }
}
</script>
