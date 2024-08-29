<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/Components/ui/card'

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    user_email: '',
    user_pass: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <Card class="mx-auto max-w-sm">
            <CardHeader>
                <CardTitle class="text-2xl">
                Login
                </CardTitle>
                <CardDescription>
                Enter your credential below to login to your account
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit">
                    <div class="grid gap-4">
                    <div>
                        <Label for="email">Email</Label>
                        <Input
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.user_email"
                            required
                            autofocus
                            autocomplete="email"
                            :error="form.errors.user_email"
                        />
                    </div>
                    <div>
                        <Label for="password">Password</Label>
                        <Input
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.user_pass"
                            required
                            autocomplete="current-password"
                            :error="form.errors.user_pass"
                        />
                    </div>
                    <Button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Log in
                    </Button>
                    </div>
                </form>
            </CardContent>
        </Card>

        <!-- <form @submit.prevent="submit">
            <div>
                <Label for="email">Email</Label>

                <Input
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.user_email"
                    required
                    autofocus
                    autocomplete="email"
                    :error="form.errors.user_email"
                />
            </div>

            <div class="mt-4">
                <Label for="password">Password</Label>

                <Input
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.user_pass"
                    required
                    autocomplete="current-password"
                    :error="form.errors.user_pass"
                />
            </div>

            <div class="block mt-4">
                <label class="flex items-center space-x-2">
                    <Checkbox id="remember" v-model:checked="form.remember"></Checkbox>
                    <Label for="remember" class="cursor-pointer">Remember me</Label>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                    Forgot your password?
                </Link>

                <Button class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </Button>
            </div>
        </form> -->
    </GuestLayout>
</template>
