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
        <Card class="mx-auto max-w-sm pb-3">
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
                                class="mt-1 block w-full mb-3"
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
    </GuestLayout>
</template>
