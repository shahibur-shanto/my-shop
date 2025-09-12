<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { Form, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

import HeadingSmall from '@/components/HeadingSmall.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { type BreadcrumbItem } from '@/types';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Password settings',
        href: '/settings/password',
    },
];
defineProps<{
    hasPassword: boolean;
    status:string;
}>();
const passwordInput = ref<HTMLInputElement | null>(null);
const currentPasswordInput = ref<HTMLInputElement | null>(null);
</script>

<template>
    <AppLayout :breadcrumbs="[{ title: hasPassword ? 'Change password' : 'Set password', href: '/settings/password' }]">
        <Head :title="hasPassword ? 'Change password' : 'Set password'" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall
                    :title="hasPassword ? 'Update password' : 'Set password'"
                    description="Ensure your account is using a long, random password to stay secure"
                />
                <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
                    {{ status }}
                </div>

                <Form
                    :method="hasPassword ? 'put' : 'post'"
                    :action="hasPassword ? route('password.update') : route('password.set')"
                    :options="{ preserveScroll: true }"
                    reset-on-success
                    :reset-on-error="['password','password_confirmation','current_password']"
                    class="space-y-6"
                    v-slot="{ errors, processing, recentlySuccessful}"
                >
                    <!-- Current password only if user already has one -->
                    <div v-if="hasPassword" class="grid gap-2">
                        <Label for="current_password">Current password</Label>
                        <Input id="current_password" name="current_password" type="password" autocomplete="current-password" />
                        <InputError :message="errors.current_password" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="password">{{ hasPassword ? 'New password' : 'Set password' }}</Label>
                        <Input id="password" name="password" type="password" autocomplete="new-password" />
                        <InputError :message="errors.password" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="password_confirmation">Confirm password</Label>
                        <Input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" />
                        <InputError :message="errors.password_confirmation" />
                    </div>

                    <div class="flex items-center gap-4">
                        <Button :disabled="processing">
                            {{ hasPassword ? 'Update password' : 'Set password' }}
                        </Button>
<!--                        <p v-show="recentlySuccessful" class="text-sm text-neutral-600">Saved</p>-->
                    </div>
                </Form>
            </div>
        </SettingsLayout>
    </AppLayout>

</template>
