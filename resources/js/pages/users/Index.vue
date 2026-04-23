<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { useDebounceFn } from '@vueuse/core';
import { Edit2, Trash, Search } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import { dashboard } from '@/routes';
import userRoutes from '@/routes/users';
import { Input } from '@/components/ui/input';
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';

const props = defineProps({
    users: Array as any,
    filters: Object as any,
});

const search = ref(props.filters?.search || '');

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
        ],
    },
});

const deleteUser = (user: any) => {
    if (confirm(`Tem certeza que deseja remover o usuário ${user.name}?`)) {
        router.delete(userRoutes.destroy.url(user));
    }
};

const handleSearch = useDebounceFn((value: string) => {
    router.get(
        userRoutes.index.url(),
        { search: value },
        {
            preserveState: true,
            replace: true,
        }
    );
}, 300);

watch(search, (newValue) => {
    handleSearch(newValue);
});

</script>

<template>

    <Head title="Listagem dos usuários" />

    <div v-if="$page.props.flash.success">
        <div class="mb-4 rounded-lg bg-green-100 p-4 text-sm text-green-700" role="alert">
            {{ $page.props.flash.success }}
        </div>
    </div>

    <div class="flex justify-between items-center mb-6">
        <div class="relative w-full max-w-sm items-center">
            <Input v-model="search" type="text" placeholder="Pesquisar usuários..." class="pl-10" />
            <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
                <Search class="size-4 text-muted-foreground" />
            </span>
        </div>

        <Link :href="userRoutes.create.url()" class="border m-2 p-2 rounded-lg bg-blue-300 dark:text-white">Cadastrar
            Novo</Link>
    </div>

    <Table>
        <TableCaption>Lista de usuários</TableCaption>
        <TableHeader>
            <TableRow>
                <TableHead>
                    ID
                </TableHead>
                <TableHead>NOME</TableHead>
                <TableHead>E-MAIL</TableHead>
                <TableHead>Ações</TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="user in users" :key="user.id">
                <TableCell class="font-medium">
                    {{ user.id }}
                </TableCell>
                <TableCell>{{ user.name }}</TableCell>
                <TableCell>{{ user.email }}</TableCell>
                <TableCell class="text-right">
                    <div class="flex gap-2">
                        <Link :href="userRoutes.edit.url(user)">
                            <Edit2 class="h-4 w-4 text-green-800" />
                        </Link>

                        <button @click="deleteUser(user)" type="button">
                            <Trash class="h-4 w-4 text-red-600" />
                        </button>
                    </div>
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
