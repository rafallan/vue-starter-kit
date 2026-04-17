<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import userRoutes from '@/routes/users';
import { Edit2, Trash } from 'lucide-vue-next';

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


import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';

defineProps({
    users: Array as any,
});

const deleteUser = (user: any) => {
    if (confirm(`Tem certeza que deseja remover o usuário ${user.name}?`)) {
        router.delete(userRoutes.destroy.url(user));
    }
};

</script>

<template>

    <Head title="Listagem dos usuários" />

    <div class="flex justify-end">
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
