<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

const props = defineProps<{
    tarefa: any;
    statuses: any[];
    users: any[];
}>();

/**
 * Objeto de formulário reativo do Inertia preenchido com dados existentes.
 */
const form = useForm({
    titulo: props.tarefa.titulo,
    descricao: props.tarefa.descricao || '',
    status_id: props.tarefa.status_id,
    /**
     * Transforma a lista de objetos de usuários em um array de IDs numéricos.
     */
    user_ids: props.tarefa.users.map((u: any) => u.id) as number[],
});

const submit = () => {
    form.put(`/tarefas/${props.tarefa.id}`);
};

/**
 * Alterna a seleção de um usuário para a tarefa.
 */
const toggleUser = (userId: any) => {
    const id = Number(userId);
    const index = form.user_ids.indexOf(id);

    if (index > -1) {
        form.user_ids = form.user_ids.filter(i => i !== id);
    } else {
        form.user_ids = [...form.user_ids, id];
    }
};
</script>

<template>

    <Head title="Editar Tarefa" />

    <div class="max-w-7xl py-8 px-4">
        <div class="mb-6">
            <Link href="/tarefas"
                class="text-sm text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200">
                &larr; Voltar para listagem
            </Link>
            <h1 class="text-2xl font-semibold mt-2">Editar Tarefa</h1>
        </div>

        <form @submit.prevent="submit"
            class="space-y-6 bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <div class="space-y-2">
                <Label for="titulo">Título</Label>
                <Input id="titulo" v-model="form.titulo" placeholder="Digite o título da tarefa"
                    :class="{ 'border-red-500': form.errors.titulo }" />
                <InputError :message="form.errors.titulo" />
            </div>

            <div class="space-y-2">
                <Label for="descricao">Descrição</Label>
                <textarea id="descricao" v-model="form.descricao"
                    class="flex min-h-[80px] w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 dark:border-zinc-800 dark:bg-zinc-950 dark:ring-offset-zinc-950 dark:placeholder:text-zinc-400 dark:focus-visible:ring-zinc-300"
                    placeholder="Descreva a tarefa..."></textarea>
                <InputError :message="form.errors.descricao" />
            </div>

            <div class="space-y-2">
                <Label for="status_id">Status</Label>
                <select id="status_id" v-model="form.status_id"
                    class="flex h-10 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 focus-visible:ring-offset-2 dark:border-zinc-800 dark:bg-zinc-950 dark:ring-offset-zinc-950 dark:focus-visible:ring-zinc-300">
                    <option value="">Selecione um status</option>
                    <option v-for="status in statuses" :key="status.id" :value="status.id">
                        {{ status.nome }}
                    </option>
                </select>
                <InputError :message="form.errors.status_id" />
            </div>

            <!-- Seção de Seleção de Usuários para Edição (Relação Muitos-para-Muitos) -->
            <div class="space-y-3">
                <Label>Atribuir Usuários</Label>
                <div class="grid grid-cols-2 gap-4 border border-zinc-200 dark:border-zinc-800 p-4 rounded-md">
                    <div v-for="user in users" :key="user.id" class="flex items-center space-x-2">
                        <!-- 
                          Renderiza checkboxes para seleção de usuários.
                          Sincroniza o estado baseado na presença do ID no array form.user_ids.
                        -->
                        <input type="checkbox" :id="'user-' + user.id" :value="user.id"
                            :checked="form.user_ids.includes(user.id)" 
                            @change="toggleUser(user.id)"
                            class="h-4 w-4 rounded border-zinc-300 text-blue-600 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800" />
                        <label :for="'user-' + user.id" class="text-sm font-medium leading-none">
                            {{ user.name }}
                        </label>
                    </div>
                </div>
                <InputError :message="form.errors.user_ids" />
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <Link href="/tarefas"
                    class="px-4 py-2 text-sm font-medium text-zinc-700 bg-white border border-zinc-300 rounded-md hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-700 dark:hover:bg-zinc-700">
                    Cancelar
                </Link>
                <Button type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Salvando...' : 'Atualizar Tarefa' }}
                </Button>
            </div>
        </form>
    </div>
</template>
