<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import userRoutes from '@/routes/users';
import { dashboard } from '@/routes';

const props = defineProps({
    user: Object,
});

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
            {
                title: 'Users',
                href: userRoutes.index.url(),
            },
            {
                title: 'Editar',
                href: userRoutes.index.url(),
            },
        ],
    },
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: ''
});

const submit = () => {
    form.put(userRoutes.update.url(props.user?.id));
};


</script>

<template>

    <Head title="Editar Usuário" />

    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
        <div class="max-w-6xl">

            <h1 class="text-bold">Editar Usuário</h1>

            <form @submit.prevent="submit">
                <input v-model="form.name" type="text" class="border border-2 w-full rounded-lg p-2 mt-3"
                    placeholder="Nome do usuário">
                <div v-if="form.errors.name" class="error">{{ form.errors.name }}</div>

                <input v-model="form.email" type="text" class="border border-2 w-full rounded-lg p-2 mt-3"
                    placeholder="E-mail do usuário">
                <div v-if="form.errors.email" class="error">{{ form.errors.email }}</div>

                <input v-model="form.password" type="password" class="border border-2 w-full rounded-lg p-2 mt-3"
                    placeholder="Senha do usuário (deixe em branco para não alterar)">
                <div v-if="form.errors.password" class="error">{{ form.errors.password }}</div>

                <input v-model="form.password_confirmation" type="password"
                    class="border border-2 w-full rounded-lg p-2 mt-3" placeholder="Confirmação da Senha do usuário">
                <div v-if="form.errors.password_confirmation" class="error">{{ form.errors.password_confirmation }}
                </div>

                <button type="submit" class="bg-blue-500 p-2 rounded-lg mt-4 dark:text-white"
                    :disabled="form.processing">
                    {{ form.processing ? 'Atualizando...' : 'Atualizar' }}
                </button>
            </form>
        </div>

    </div>
</template>


<style scoped>
.error {
    color: red;
}
</style>
