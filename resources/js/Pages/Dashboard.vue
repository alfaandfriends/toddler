<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import Card from '@/Components/Card.vue'
import Pagination from '@/Components/Pagination.vue';
import moment from 'moment';
import axios from 'axios';
</script>

<script>
export default {
    methods: {
        checkStatus(key){
            axios.post(route('launch.check_status', key), {
                user_agent: navigator.userAgent
            })
            .then((response)=>{
                console.log(response)
            })
        },
        launch(key) {
            const url = route('launch');

            // Create a temporary form element
            const form = document.createElement('form');
            form.action = url;
            form.method = 'POST';
            form.target = '_blank'; // Open in new tab

            // Add the CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);
            
            // Append the form to the body and submit it
            document.body.appendChild(form);
            form.submit();

            // Remove the form after submission
            document.body.removeChild(form);
        }
    }
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
                <div>


                    <!-- <div v-if="$device.isDesktop">Desktop</div>
                    <div v-else-if="$device.isTablet">Tablet</div>
                    <div v-else>Mobile</div>
                
                    <div v-if="$device.os.android">Android</div>
                    <div v-else-if="$device.isIOS">IOS</div>
                    <div v-else-if="$device.os.windows">Windows</div>
                     <div v-else-if="$device.os.windows_phone">Windows Mobile</div>
                    <div v-else-if="$device.isOSx">MAc</div>
                
                    <span v-if="$device.browser.chrome" >{{$device.browser_name}}</span> -->
                    <div>
                        <!-- Boolean values -->
                        <p>Is Mobile: {{ $device.isMobile }}</p>
                        <p>Is Tablet: {{ $device.isTablet }}</p>
                        <p>Is Desktop: {{ $device.isDesktop }}</p>
                    
                        <!-- Strings -->
                        <p>Model: {{ $device.model }}</p>
                        <p>Brand: {{ $device.brand }}</p>
                        <p>Type: {{ $device.type }}</p>
                        <p>OS Name: {{ $device.os_name }}</p>
                        <p>OS Platform: {{ $device.os_platform }}</p>
                        <p>OS Version: {{ $device.os_version }}</p>
                        <p>Browser Name: {{ $device.browser_name }}</p>
                        <p>Browser Version: {{ $device.browser_version }}</p>
                        <p>Browser Engine: {{ $device.browser_engine }}</p>
                        <p>Browser Engine Version: {{ $device.browser_engine_version }}</p>
                    
                        <!-- Boolean OS checks -->
                        <p>Is Android: {{ $device.isAndroid }}</p>
                        <p>Is Blackberry: {{ $device.isBlackberry }}</p>
                        <p>Is iOS: {{ $device.isIOS }}</p>
                        <p>Is Windows: {{ $device.isWindows }}</p>
                        <p>Is Windows Phone: {{ $device.isWindowsPhone }}</p>
                        <p>Is OSX: {{ $device.isOsx }}</p>
                        <p>Is Linux: {{ $device.isLinux }}</p>
                        <p>Is Chrome OS: {{ $device.isChromeOs }}</p>
                        <p>Is Firefox OS: {{ $device.isFireFoxOS }}</p>
                        <p>Is Gaming Console: {{ $device.GamingConsole }}</p>
                        <p>Is Bot: {{ $device.isBot }}</p>
                    
                        <!-- OS specific booleans -->
                        <p>OS Android: {{ $device.os.android }}</p>
                        <p>OS Blackberry: {{ $device.os.blackberry }}</p>
                        <p>OS iOS: {{ $device.os.ios }}</p>
                        <p>OS Windows: {{ $device.os.windows }}</p>
                        <p>OS Windows Phone: {{ $device.os.windows_phone }}</p>
                        <p>OS Mac: {{ $device.os.mac }}</p>
                        <p>OS Linux: {{ $device.os.linux }}</p>
                        <p>OS Chrome: {{ $device.os.chrome }}</p>
                        <p>OS Firefox: {{ $device.os.firefox }}</p>
                        <p>OS Gaming Console: {{ $device.os.gamingConsole }}</p>
                    
                        <!-- Machine details -->
                        <p>Machine Brand: {{ $device.machine.brand }}</p>
                        <p>Machine Model: {{ $device.machine.model }}</p>
                        <p>Machine OS Name: {{ $device.machine.os_name }}</p>
                        <p>Machine OS Version: {{ $device.machine.os_version }}</p>
                        <p>Machine Type: {{ $device.machine.type }}</p>
                    
                        <!-- Browser specifics -->
                        <p>Browser Chrome: {{ $device.browser.chrome }}</p>
                        <p>Browser Chrome View: {{ $device.browser.chrome_view }}</p>
                        <p>Browser Chrome Mobile: {{ $device.browser.chrome_mobile }}</p>
                        <p>Browser Chrome Mobile iOS: {{ $device.browser.chrome_mobile_ios }}</p>
                        <p>Browser Safari: {{ $device.browser.safari }}</p>
                        <p>Browser Safari Mobile: {{ $device.browser.safari_mobile }}</p>
                        <p>Browser MS Edge: {{ $device.browser.msedge }}</p>
                        <p>Browser IE Mobile: {{ $device.browser.msie_mobile }}</p>
                        <p>Browser IE: {{ $device.browser.msie }}</p>
                    
                        <!-- Additional objects -->
                        <p>Client: {{ $device.client }}</p>
                        <p>Detector: {{ $device.detector }}</p>
                        <p>Bot: {{ $device.bot }}</p>
                        <p>Machine: {{ $device.machine }}</p>
                      </div>
                  </div>
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
                                        <Button @click="checkStatus(data.key)">Launch</Button>
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
