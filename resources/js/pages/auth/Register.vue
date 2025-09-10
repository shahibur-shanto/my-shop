<template>
    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
        <div id="app" class="w-full max-w-md">
            <div class="bg-white p-8 rounded-xl auth-card">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto">
                        <i class="fas fa-user-plus text-white text-2xl"></i>
                    </div>
                    <h2 class="mt-4 text-2xl font-bold text-gray-800">Create New Account</h2>
                </div>

                <form @submit.prevent="handleSignup" class="space-y-5">
                    <!-- Name -->
                    <div>
                        <label for="signup-name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <div class="relative">

                            <input
                                id="signup-name"
                                v-model="form.name"
                                type="text"
                                required
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg transition text-gray-800 placeholder-gray-400"
                                placeholder="Your Name"
                                :class="{'border-red-500': form.errors.name}"
                            >
                        </div>
                        <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="signup-email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                        <div class="relative">

                            <input
                                id="signup-email"
                                v-model="form.email"
                                type="email"
                                required
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg transition text-gray-800 placeholder-gray-400"
                                placeholder="you@example.com"
                                :class="{'border-red-500': form.errors.email}"
                            >
                        </div>
                        <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="signup-password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">

                            <input
                                id="signup-password"
                                v-model="form.password"
                                type="password"
                                required
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg transition text-gray-800 placeholder-gray-400"
                                placeholder="••••••••"
                                :class="{'border-red-500': form.errors.password}"
                            >
                        </div>
                        <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="signup-confirm-password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <div class="relative">

                            <input
                                id="signup-confirm-password"
                                v-model="form.password_confirmation"
                                type="password"
                                required
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg transition text-gray-800 placeholder-gray-400"
                                placeholder="••••••••"
                                :class="{'border-red-500': passwordMismatch}"
                            >
                        </div>
                        <p v-if="passwordMismatch" class="mt-1 text-sm text-red-600">Passwords do not match</p>
                    </div>

                    <!-- Terms -->
                    <div class="flex items-center">
                        <input
                            id="terms"
                            type="checkbox"
                            v-model="termsAccepted"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        >
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            I agree to the <a href="terms.html" class="text-indigo-600 hover:text-indigo-500">Terms</a> and
                            <a href="privacy.html" class="text-indigo-600 hover:text-indigo-500">Privacy Policy</a>
                        </label>
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        class="w-full bg-green-600 text-white py-3 px-4 cursor-pointer rounded-lg transition font-medium"
                        :class="{
              'opacity-50 cursor-not-allowed': !termsAccepted || form.processing || passwordMismatch,
              'hover:bg-green-700': termsAccepted && !form.processing && !passwordMismatch,
              'bg-green-800': form.processing
            }"
                        :disabled="!termsAccepted || form.processing || passwordMismatch"
                    >
            <span v-if="form.processing" class="loading-spinner mr-2">
              <i class="fas fa-spinner fa-spin"></i>
            </span>
                        {{ form.processing ? 'Creating Account...' : 'Create Account' }}
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <Link :href="route('login')" class="text-indigo-600 hover:text-indigo-500 font-medium">Sign in</Link>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm,Link } from '@inertiajs/vue3'

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const termsAccepted = ref(false)

const passwordMismatch = computed(() => {
    return form.password !== form.password_confirmation && form.password_confirmation !== ''
})

const handleSignup = () => {
    if (!termsAccepted.value) {
        alert('You must accept the terms and conditions')
        return
    }

    form.post('/register', {
        onSuccess: () => {
            // redirect handled automatically by Laravel redirect
        }
    })
}
</script>









<!--<template>-->
<!--    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">-->
<!--    <div id="app" class="w-full max-w-md">-->
<!--        <div class="bg-white p-8 rounded-xl auth-card">-->
<!--            <div class="text-center mb-8">-->
<!--                <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto">-->
<!--                    <i class="fas fa-user-plus text-white text-2xl"></i>-->
<!--                </div>-->
<!--                <h2 class="mt-4 text-2xl font-bold text-gray-800">Create New Account</h2>-->
<!--            </div>-->

<!--            <form @submit.prevent="handleSignup" class="space-y-5">-->


<!--                <div>-->
<!--                    <label for="signup-name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>-->
<!--                    <div class="relative">-->
<!--                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">-->
<!--                            <i class="fas fa-user text-gray-400"></i>-->
<!--                        </div>-->
<!--                        <input-->
<!--                            id="signup-name"-->
<!--                            v-model="form.name"-->
<!--                            type="text"-->
<!--                            required-->
<!--                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg transition"-->
<!--                            placeholder="Your Name"-->
<!--                            :class="{'border-red-500': errors.name}"-->
<!--                        >-->
<!--                    </div>-->
<!--                    <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name[0] }}</p>-->
<!--                </div>-->

<!--                <div>-->
<!--                    <label for="signup-email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>-->
<!--                    <div class="relative">-->
<!--                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">-->
<!--                            <i class="fas fa-envelope text-gray-400"></i>-->
<!--                        </div>-->
<!--                        <input-->
<!--                            id="signup-email"-->
<!--                            v-model="form.email"-->
<!--                            type="email"-->
<!--                            required-->
<!--                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg transition"-->
<!--                            placeholder="you@example.com"-->
<!--                            :class="{'border-red-500': errors.email}"-->
<!--                        >-->
<!--                    </div>-->
<!--                    <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email[0] }}</p>-->
<!--                </div>-->

<!--                <div>-->
<!--                    <label for="signup-password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>-->
<!--                    <div class="relative">-->
<!--                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">-->
<!--                            <i class="fas fa-lock text-gray-400"></i>-->
<!--                        </div>-->
<!--                        <input-->
<!--                            id="signup-password"-->
<!--                            v-model="form.password"-->
<!--                            type="password"-->
<!--                            required-->
<!--                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg transition"-->
<!--                            placeholder="••••••••"-->
<!--                            :class="{'border-red-500': errors.password}"-->
<!--                        >-->
<!--                    </div>-->
<!--                    <p v-if="errors.password" class="mt-1 text-sm text-red-600">{{ errors.password[0] }}</p>-->
<!--                </div>-->

<!--                <div>-->
<!--                    <label for="signup-confirm-password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>-->
<!--                    <div class="relative">-->
<!--                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">-->
<!--                            <i class="fas fa-lock text-gray-400"></i>-->
<!--                        </div>-->
<!--                        <input-->
<!--                            id="signup-confirm-password"-->
<!--                            v-model="form.password_confirmation"-->
<!--                            type="password"-->
<!--                            required-->
<!--                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg transition"-->
<!--                            placeholder="••••••••"-->
<!--                            :class="{'border-red-500': passwordMismatch}"-->
<!--                        >-->
<!--                    </div>-->
<!--                    <p v-if="passwordMismatch" class="mt-1 text-sm text-red-600">Passwords do not match</p>-->
<!--                </div>-->

<!--                <div class="flex items-center">-->
<!--                    <input-->
<!--                        id="terms"-->
<!--                        type="checkbox"-->
<!--                        v-model="termsAccepted"-->
<!--                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"-->
<!--                    >-->
<!--                    <label for="terms" class="ml-2 block text-sm text-gray-700">-->
<!--                        I agree to the <a href="terms.html" class="text-indigo-600 hover:text-indigo-500">Terms</a> and <a href="privacy.html" class="text-indigo-600 hover:text-indigo-500">Privacy Policy</a>-->
<!--                    </label>-->
<!--                </div>-->

<!--                <button-->
<!--                    type="submit"-->
<!--                    class="w-full bg-green-600 text-white py-3 px-4 cursor-pointer rounded-lg hover:bg-green-700 transition font-medium"-->
<!--                    :class="{-->
<!--                            'opacity-50 cursor-not-allowed': !termsAccepted || loading || passwordMismatch,-->
<!--                            'hover:bg-green-700': termsAccepted && !loading && !passwordMismatch,-->
<!--                            'bg-green-800': loading-->
<!--                        }"-->
<!--                    :disabled="!termsAccepted || loading || passwordMismatch"-->
<!--                >-->
<!--                    <span v-if="loading" class="loading-spinner mr-2">-->
<!--                            <i class="fas fa-spinner fa-spin"></i>-->
<!--                        </span>-->
<!--                    {{ loading ? 'Creating Account...' : 'Create Account' }}-->
<!--                </button>-->
<!--            </form>-->

<!--            <div class="mt-6 text-center">-->
<!--                <p class="text-sm text-gray-600">-->
<!--                    Already have an account?-->
<!--                    <a href="login.html" class="text-indigo-600 hover:text-indigo-500 font-medium">Sign in</a>-->
<!--                </p>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    </div>-->
<!--</template>-->

<!--<script setup>-->
<!--import { useForm } from '@inertiajs/vue3'-->

<!--const form = useForm({-->
<!--    name: '',-->
<!--    email: '',-->
<!--    password: '',-->
<!--    password_confirmation: '',-->
<!--})-->

<!--const handleSignup = () => {-->
<!--    form.post('/register', {-->
<!--        onSuccess: () => {-->
<!--            // automatically redirected by backend to dashboard-->
<!--        },-->
<!--        onError: (errors) => {-->
<!--            console.log(errors)-->
<!--        },-->
<!--    })-->
<!--}-->

<!--// export default {-->
<!--//-->
<!--//-->
<!--//-->
<!--//     data() {-->
<!--//         return {-->
<!--//             loading: false,-->
<!--//             termsAccepted: false,-->
<!--//             successMessage: '',-->
<!--//             errorMessage: '',-->
<!--//             errors: {},-->
<!--//             form: {-->
<!--//                 name: '',-->
<!--//                 email: '',-->
<!--//                 password: '',-->
<!--//                 password_confirmation: '',-->
<!--//             }-->
<!--//         }-->
<!--//     },-->
<!--//     computed: {-->
<!--//         passwordMismatch() {-->
<!--//             return this.form.password !== this.form.password_confirmation && this.form.password_confirmation !== '';-->
<!--//         }-->
<!--//     },-->
<!--//     methods: {-->
<!--//         async handleSignup() {-->
<!--//             // Reset messages-->
<!--//             this.successMessage = '';-->
<!--//             this.errorMessage = '';-->
<!--//             this.errors = {};-->
<!--//-->
<!--//             // Validate passwords match-->
<!--//             if (this.form.password !== this.form.password_confirmation) {-->
<!--//                 this.errorMessage = 'Passwords do not match';-->
<!--//                 return;-->
<!--//             }-->
<!--//-->
<!--//             // Validate terms accepted-->
<!--//             if (!this.termsAccepted) {-->
<!--//                 this.errorMessage = 'You must accept the terms and conditions';-->
<!--//                 return;-->
<!--//             }-->
<!--//-->
<!--//             this.loading = true;-->
<!--//-->
<!--//             try {-->
<!--//                 // Send registration request to Laravel API-->
<!--//                 const response = await fetch('/register', {-->
<!--//                     method: 'POST',-->
<!--//                     headers: {-->
<!--//                         'Content-Type': 'application/json',-->
<!--//                         'Accept': 'application/json',-->
<!--//                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')-->
<!--//                     },-->
<!--//                     body: JSON.stringify(this.form)-->
<!--//                 });-->
<!--//-->
<!--//                 const data = await response.json();-->
<!--//-->
<!--//                 if (response.ok) {-->
<!--//                     // Registration successful-->
<!--//                     this.successMessage = data.message || 'Account created successfully!';-->
<!--//                     // Reset form-->
<!--//                     this.form = {-->
<!--//                         name: '',-->
<!--//                         email: '',-->
<!--//                         password: '',-->
<!--//                         password_confirmation: ''-->
<!--//                     };-->
<!--//                     this.termsAccepted = false;-->
<!--//-->
<!--//                     // Optional: Redirect to login after successful registration-->
<!--//                     // setTimeout(() => {-->
<!--//                     //     window.location.href = '/login';-->
<!--//                     // }, 2000);-->
<!--//                 } else {-->
<!--//                     // Handle validation errors-->
<!--//                     if (data.errors) {-->
<!--//                         this.errors = data.errors;-->
<!--//                     } else {-->
<!--//                         this.errorMessage = data.message || 'An error occurred during registration';-->
<!--//                     }-->
<!--//                 }-->
<!--//             } catch (error) {-->
<!--//                 console.error('Registration error:', error);-->
<!--//                 this.errorMessage = 'Network error. Please try again.';-->
<!--//             } finally {-->
<!--//                 this.loading = false;-->
<!--//             }-->
<!--//         }-->
<!--//     }-->
<!--// }-->
<!--</script>-->
