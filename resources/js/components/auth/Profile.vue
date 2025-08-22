<!-- resources/js/components/auth/Profile.vue -->
<template>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Profile</div>

                    <div class="card-body">
                        <form @submit.prevent="updateProfile">
                            <!-- Basic Information -->
                            <h5 class="mb-3">Basic Information</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="name" v-model="form.name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" v-model="form.email" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <h5 class="mb-3 mt-4">Contact Information</h5>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" v-model="form.phone">
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" v-model="form.address" rows="2"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" class="form-control" id="city" v-model="form.city">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="state" class="form-label">State</label>
                                        <input type="text" class="form-control" id="state" v-model="form.state">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="postal_code" class="form-label">Postal Code</label>
                                        <input type="text" class="form-control" id="postal_code" v-model="form.postal_code">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control" id="country" v-model="form.country">
                            </div>

                            <!-- Additional Information -->
                            <h5 class="mb-3 mt-4">Additional Information</h5>

                            <div class="mb-3">
                                <label for="bio" class="form-label">Bio</label>
                                <textarea class="form-control" id="bio" v-model="form.bio" rows="3" placeholder="Tell us about yourself..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" v-model="form.date_of_birth">
                            </div>

                            <!-- Avatar Upload -->
                            <div class="mb-3">
                                <label class="form-label">Profile Picture</label>
                                <div class="d-flex align-items-center">
                                    <img v-if="form.avatar" :src="form.avatar" alt="Avatar" class="rounded-circle me-3" width="64" height="64">
                                    <input type="file" class="form-control" @change="handleAvatarUpload" accept="image/*">
                                </div>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary" :disabled="loading">
                                    <span v-if="loading" class="spinner-border spinner-border-sm"></span>
                                    Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
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
                phone: '',
                address: '',
                city: '',
                state: '',
                country: '',
                postal_code: '',
                bio: '',
                date_of_birth: '',
                avatar: ''
            }
        }
    },
    mounted() {
        this.fetchProfile();
    },
    methods: {
        async fetchProfile() {
            try {
                const response = await axios.get('/api/profile');
                const { user, profile } = response.data;

                this.form = {
                    name: user.name,
                    email: user.email,
                    phone: profile.phone || '',
                    address: profile.address || '',
                    city: profile.city || '',
                    state: profile.state || '',
                    country: profile.country || '',
                    postal_code: profile.postal_code || '',
                    bio: profile.bio || '',
                    date_of_birth: profile.date_of_birth || '',
                    avatar: profile.avatar ? `/storage/${profile.avatar}` : ''
                };
            } catch (error) {
                console.error('Error fetching profile:', error);
            }
        },
        async updateProfile() {
            this.loading = true;

            try {
                await axios.put('/api/profile', this.form);
                this.$toast.success('Profile updated successfully!');
            } catch (error) {
                if (error.response?.data?.errors) {
                    const errors = error.response.data.errors;
                    Object.keys(errors).forEach(key => {
                        this.$toast.error(errors[key][0]);
                    });
                } else {
                    this.$toast.error('Profile update failed. Please try again.');
                }
            } finally {
                this.loading = false;
            }
        },
        async handleAvatarUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('avatar', file);

            try {
                const response = await axios.post('/api/profile/avatar', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                this.form.avatar = response.data.avatar_url;
                this.$toast.success('Avatar updated successfully!');
            } catch (error) {
                this.$toast.error('Avatar upload failed. Please try again.');
            }
        }
    }
}
</script>
