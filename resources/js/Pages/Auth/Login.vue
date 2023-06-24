<script setup>
import LayoutButton from "@/Components/LayoutButton.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Log in" />

    <div class="w-full h-screen flex items-center justify-center">
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form class="w-80" @submit.prevent="submit">
            <div>
                <label for="email" value="Email" />

                <input
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <span class="mt-2 text-red-700" v-text="form.errors.email" />
            </div>

            <div class="mt-4">
                <label for="password" value="Password" />

                <input
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <span
                    v-if="form.errors.password"
                    class="mt-2 text-red-700"
                    v-text="form.errors.password"
                />
            </div>

            <div class="block mt-4">
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text font-bold text-slate-500"
                            >Remember me</span
                        >
                        <input
                            type="checkbox"
                            checked="checked"
                            class="checkbox"
                            v-model="form.remember"
                        />
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-between mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900"
                >
                    Esqueceu a senha?
                </Link>

                <LayoutButton
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    submit
                >
                    Logar
                </LayoutButton>
            </div>
        </form>
    </div>
</template>
