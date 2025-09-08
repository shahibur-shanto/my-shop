<script setup>
import { reactive, ref } from 'vue'
import { Link } from '@inertiajs/vue3';
import axios from 'axios'

const loading = ref(false)
const providers = [
    { name: "google", label: "Continue with Google", color: "bg-white border hover:bg-gray-50", textColor: "text-gray-700", icon: "https://www.svgrepo.com/show/355037/google.svg" },
    { name: "facebook", label: "Continue with Facebook", color: "bg-[#1877F2] hover:bg-[#166FE5]", textColor: "text-white", icon: "https://www.svgrepo.com/show/452196/facebook-1.svg" },
    { name: "github", label: "Continue with GitHub", color: "bg-[#24292F] hover:bg-[#1F2429]", textColor: "text-white", icon: "https://www.svgrepo.com/show/512317/github-142.svg" }
];



const form = reactive({
    email: '',
    password: '',
    name:'',
    remember: false,
})

const login = async () => {
    try {
        loading.value = true
        await axios.post('/login', form)
        window.location.href = '/' // redirect after success
    } catch (error) {
        alert('Invalid credentials. Please try again.')
    } finally {
        loading.value = false
    }
}


</script>

<template>
    <div class="flex min-h-screen items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
            <!-- Title -->
            <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Sign In</h2>

            <!-- Social Login -->
            <div class="flex flex-col space-y-3 mb-6">

                <a
                    v-for="provider in providers"
                    :key="provider.name"
                    :href="`/auth/${provider.name}/redirect`"
                    class="flex items-center justify-center w-full py-2 px-4 rounded-lg shadow transition mb-2"
                    :class="provider.color"
                >
      <span class="inline-flex items-center justify-center w-6 h-6 rounded bg-white mr-2">
        <img :src="provider.icon" :alt="provider.name" class="w-4 h-4" />
      </span>
                    <span :class="provider.textColor + ' font-medium'">
        {{ provider.label }}
      </span>
                </a>
                <!-- Google -->
<!--                <a-->
<!--                    :href="`/auth/facebook/redirect`"-->
<!--                    class="flex items-center justify-center w-full py-2 px-4 rounded-lg shadow transition bg-white border hover:bg-gray-50"-->
<!--                >-->
<!--          <span class="inline-flex items-center justify-center w-6 h-6 rounded bg-white mr-2">-->
<!--            <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google" class="w-4 h-4" />-->
<!--          </span>-->
<!--                    <span class="text-gray-700 font-medium">Continue with Google</span>-->
<!--                </a>-->

<!--                &lt;!&ndash; Facebook &ndash;&gt;-->
<!--                <a-->
<!--                    :href="`/auth/facebook/redirect`"-->
<!--                    class="flex items-center justify-center w-full py-2 px-4 rounded-lg shadow transition bg-[#1877F2] hover:bg-[#166FE5]"-->
<!--                >-->
<!--                    &lt;!&ndash; Put the icon on a white chip so it stays visible without CSS filters &ndash;&gt;-->
<!--                    <span class="inline-flex items-center justify-center w-6 h-6 rounded bg-white mr-2">-->
<!--            <img src="https://www.svgrepo.com/show/452196/facebook-1.svg" alt="Facebook" class="w-4 h-4" />-->
<!--          </span>-->
<!--                    <span class="text-white font-medium">Continue with Facebook</span>-->
<!--                </a>-->

<!--                &lt;!&ndash; GitHub &ndash;&gt;-->
<!--                <a-->
<!--                    :href="`/auth/github/redirect`"-->
<!--                    class="flex items-center justify-center w-full py-2 px-4 rounded-lg shadow transition bg-[#24292F] hover:bg-[#1F2429]"-->
<!--                >-->
<!--          <span class="inline-flex items-center justify-center w-6 h-6 rounded bg-white mr-2">-->
<!--            <img src="https://www.svgrepo.com/show/512317/github-142.svg" alt="GitHub" class="w-4 h-4" />-->
<!--          </span>-->
<!--                    <span class="text-white font-medium">Continue with GitHub</span>-->
<!--                </a>-->
            </div>

            <!-- Divider -->
            <div class="flex items-center my-6">
                <div class="flex-grow h-px bg-gray-300"></div>
                <span class="mx-3 text-gray-500 text-sm">OR</span>
                <div class="flex-grow h-px bg-gray-300"></div>
            </div>

            <!-- Email Login -->
            <form @submit.prevent="login">
                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="email">Email</label>
                    <input
                        v-model="form.email"
                        id="email"
                        type="email"
                        required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="you@example.com"
                    />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="password">Password</label>
                    <input
                        v-model="form.password"
                        id="password"
                        type="password"
                        required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="••••••••"
                    />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" v-model="form.remember" class="mr-2 rounded border-gray-300" />
                        Remember me
                    </label>
                    <a href="#" class="text-sm text-blue-600 hover:underline">Forgot password?</a>
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition"
                    :disabled="loading"
                >
                    <span v-if="loading">Signing in...</span>
                    <span v-else>Sign In</span>
                </button>
            </form>

            <p class="text-center text-sm text-gray-600 mt-6">
                Don’t have an account?
                <Link :href="route('register')" class="text-blue-600 hover:underline">Sign up</Link>
            </p>
        </div>
    </div>
</template>

















<!--<script setup lang="ts">-->
<!--import InputError from '@/components/InputError.vue';-->
<!--import TextLink from '@/components/TextLink.vue';-->
<!--import { Button } from '@/components/ui/button';-->
<!--import { Checkbox } from '@/components/ui/checkbox';-->
<!--import { Input } from '@/components/ui/input';-->
<!--import { Label } from '@/components/ui/label';-->
<!--import AuthBase from '@/layouts/AuthLayout.vue';-->
<!--import { Form, Head } from '@inertiajs/vue3';-->
<!--import { LoaderCircle } from 'lucide-vue-next';-->

<!--defineProps<{-->
<!--    status?: string;-->
<!--    canResetPassword: boolean;-->
<!--}>();-->
<!--</script>-->

<!--<template>-->
<!--    <AuthBase title="Log in to your account" description="Enter your email and password below to log in">-->
<!--        <Head title="Log in" />-->

<!--        <div v-if="status" class="mb-4 text-sm font-medium text-center text-green-600">-->
<!--            {{ status }}-->
<!--        </div>-->

<!--        <Form method="post" :action="route('login')" :reset-on-success="['password']" v-slot="{ errors, processing }" class="flex flex-col gap-6">-->
<!--            <div class="grid gap-6">-->
<!--                <div class="grid gap-2">-->
<!--                    <Label for="email">Email address</Label>-->
<!--                    <Input-->
<!--                        id="email"-->
<!--                        type="email"-->
<!--                        name="email"-->
<!--                        required-->
<!--                        autofocus-->
<!--                        :tabindex="1"-->
<!--                        autocomplete="email"-->
<!--                        placeholder="email@example.com"-->
<!--                    />-->
<!--                    <InputError :message="errors.email" />-->
<!--                </div>-->

<!--                <div class="grid gap-2">-->
<!--                    <div class="flex items-center justify-between">-->
<!--                        <Label for="password">Password</Label>-->
<!--                        <TextLink v-if="canResetPassword" :href="route('password.request')" class="text-sm" :tabindex="5">-->
<!--                            Forgot password?-->
<!--                        </TextLink>-->
<!--                    </div>-->
<!--                    <Input-->
<!--                        id="password"-->
<!--                        type="password"-->
<!--                        name="password"-->
<!--                        required-->
<!--                        :tabindex="2"-->
<!--                        autocomplete="current-password"-->
<!--                        placeholder="Password"-->
<!--                    />-->
<!--                    <InputError :message="errors.password" />-->
<!--                </div>-->

<!--                <div class="flex items-center justify-between">-->
<!--                    <Label for="remember" class="flex items-center space-x-3">-->
<!--                        <Checkbox id="remember" name="remember" :tabindex="3" />-->
<!--                        <span>Remember me</span>-->
<!--                    </Label>-->
<!--                </div>-->

<!--                <Button type="submit" class="w-full mt-4" :tabindex="4" :disabled="processing">-->
<!--                    <LoaderCircle v-if="processing" class="w-4 h-4 animate-spin" />-->
<!--                    Log in-->
<!--                </Button>-->
<!--            </div>-->

<!--            <div class="text-sm text-center text-muted-foreground">-->
<!--                Don't have an account?-->
<!--                <TextLink :href="route('register')" :tabindex="5">Sign up</TextLink>-->
<!--            </div>-->
<!--        </Form>-->
<!--    </AuthBase>-->
<!--</template>-->
