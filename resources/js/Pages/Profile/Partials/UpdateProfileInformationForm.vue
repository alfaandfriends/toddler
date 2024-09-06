<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
</script>

<script>
import DeleteConfirmation from '@/Components/DeleteConfirmation.vue';

export default {
    components: {
        DeleteConfirmation
    },
    data() {
        return {
            form: {
                name: this.$page.props.school?.name || '',
                code: this.$page.props.school?.code || '',
                email: this.$page.props.school?.email || '',
            },
            confirmation: {
                is_open: false,
                id: '',
                route_name: 'profile.update',
                params: '',
                method: 'patch',
                title: 'Warning',
                description: 'Changing your email will log you out to ensure account security. Are you sure?'
            },
        }
    },
    methods: {

        handleSaveClick() {
            if ((this.form.email && this.form.email !== this.$page.props.auth.user.user_email) && (this.form.email && this.isEmailValid(this.form.email))) {
                this.confirmation.params = this.form;
                this.confirmation.is_open = true;
            } else {
                this.$inertia.patch(this.route('profile.update'), this.form);
            }
        },

        isEmailValid(email) {
            // Basic email format validation
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailPattern.test(email);
        }
    }
}
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">School Information</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your school information and email address.
            </p>
        </header>

        <div class="mt-6 space-y-6">
            <div>
                <Label for="name">School Name</Label>
                <Input id="name" type="text" v-model="form.name" required autofocus autocomplete="name"></Input>

                <InputError class="mt-2" :message="$page.props.errors.name" />
            </div>

            <div>
                <Label for="code">School Code</Label>
                <Input id="code" type="text" v-model="form.code" required autofocus autocomplete="code" disabled></Input>

                <InputError class="mt-2" :message="$page.props.errors.code" />
            </div>

            <div>
                <Label for="email">School Email</Label>
                <Input id="email" type="email" v-model="form.email" required autofocus autocomplete="email"></Input>

                <InputError class="mt-2" :message="$page.props.errors.email" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing" @click="handleSaveClick">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                </Transition>
            </div>
        </div>
    </section>
    <DeleteConfirmation :open="confirmation.is_open" @close="confirmation.is_open = false" :routeName="confirmation.route_name" :id="confirmation.id" :method="confirmation.method" :params="confirmation.params">
        <template #title><span class="text-red-500">{{ confirmation.title }}</span></template>
        <template #description>{{ confirmation.description }}</template>
    </DeleteConfirmation>
</template>
