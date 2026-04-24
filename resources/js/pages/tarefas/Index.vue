<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { Edit2, Trash } from 'lucide-vue-next';
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import tarefaRoutes from '@/routes/tarefas';

const props = defineProps({
    tarefas: Array,
});

const deleteTarefa = (tarefa) => {
    if (confirm(`Tem certeza que deseja remover a tarefa "${tarefa.titulo}"?`)) {
        router.delete(tarefaRoutes.destroy.url(tarefa));
    }
};

</script>

<template>

    <Head title="Listagem de Tarefas" />

    <div v-if="$page.props.flash.success" class="mb-4 rounded-lg bg-green-100 p-4 text-sm text-green-700" role="alert">
        {{ $page.props.flash.success }}
    </div>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Tarefas</h1>
        <Link href="/tarefas/create"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            Nova Tarefa
        </Link>
    </div>

    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800">
        <Table>
            <TableCaption>Lista de todas as tarefas cadastradas.</TableCaption>
            <TableHeader>
                <TableRow>
                    <TableHead class="w-[100px]">ID</TableHead>
                    <TableHead>Título</TableHead>
                    <TableHead>Status</TableHead>
                    <TableHead>Usuários</TableHead>
                    <TableHead class="text-right">Ações</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="tarefa in tarefas" :key="tarefa.id">
                    <TableCell class="font-medium">{{ tarefa.id }}</TableCell>
                    <TableCell>{{ tarefa.titulo }}</TableCell>
                    <TableCell>
                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-zinc-100 dark:bg-zinc-800">
                            {{ tarefa.status?.nome }}
                        </span>
                    </TableCell>
                    <TableCell>
                        <div class="flex -space-x-2">
                            <span v-for="user in tarefa.users" :key="user.id"
                                class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-zinc-200 dark:bg-zinc-700 ring-2 ring-white dark:ring-zinc-900 text-[10px] font-medium"
                                :title="user.name">
                                {{ user.name.charAt(0) }}
                            </span>
                            <span v-if="!tarefa.users || tarefa.users.length === 0"
                                class="text-zinc-400 text-sm">Nenhum</span>
                        </div>
                    </TableCell>
                    <TableCell class="text-right">
                        <div class="flex justify-end gap-2">
                            <Link :href="`/tarefas/${tarefa.id}/edit`"
                                class="p-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg">
                                <Edit2 class="h-4 w-4 text-blue-600" />
                            </Link>
                            <button @click="deleteTarefa(tarefa)"
                                class="p-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg">
                                <Trash class="h-4 w-4 text-red-600" />
                            </button>
                        </div>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>
