<!-- resources/js/components/auth/Register.vue -->
<template>
    <div id="app" class="w-full max-w-md">
        <div class="mb-6">
            <a href="index.html" class="flex items-center text-indigo-600 hover:text-indigo-800 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Home
            </a>
        </div>

        <div class="bg-white p-8 rounded-xl auth-card">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto">
                    <i class="fas fa-user-plus text-white text-2xl"></i>
                </div>
                <h2 class="mt-4 text-2xl font-bold text-gray-800">Create Account</h2>
                <p class="mt-2 text-gray-600">Join us to get started</p>
            </div>

            <form @submit.prevent="handleSignup" class="space-y-5">
                <div>
                    <label for="signup-name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input
                            id="signup-name"
                            v-model="name"
                            type="text"
                            required
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            placeholder="John Doe"
                        >
                    </div>
                </div>

                <div>
                    <label for="signup-email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input
                            id="signup-email"
                            v-model="email"
                            type="email"
                            required
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            placeholder="you@example.com"
                        >
                    </div>
                </div>

                <div>
                    <label for="signup-password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input
                            id="signup-password"
                            v-model="password"
                            type="password"
                            required
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            placeholder="••••••••"
                        >
                    </div>
                </div>

                <div>
                    <label for="signup-confirm-password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input
                            id="signup-confirm-password"
                            v-model="confirmPassword"
                            type="password"
                            required
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            placeholder="••••••••"
                        >
                    </div>
                </div>

                <div class="flex items-center">
                    <input
                        id="terms"
                        type="checkbox"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                    >
                    <label for="terms" class="ml-2 block text-sm text-gray-700">
                        I agree to the <a href="terms.html" class="text-indigo-600 hover:text-indigo-500">Terms</a> and <a href="privacy.html" class="text-indigo-600 hover:text-indigo-500">Privacy Policy</a>
                    </label>
                </div>

                <button
                    type="submit"
                    class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition font-medium"
                >
                    Create Account
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <a href="login.html" class="text-indigo-600 hover:text-indigo-500 font-medium">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                phone: '',
                address: '',
                city: '',
                state: '',
                country: '',
                postal_code: ''
            }
        }
    },
    methods: {
        async register() {
            this.loading = true;

            try {
                const response = await axios.post('/register', this.form);

                this.$toast.success('Registration successful! Please login.');
                this.$router.push('/login');
            } catch (error) {
                if (error.response?.data?.errors) {
                    const errors = error.response.data.errors;
                    Object.keys(errors).forEach(key => {
                        this.$toast.error(errors[key][0]);
                    });
                } else {
                    this.$toast.error('Registration failed. Please try again.');
                }
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
