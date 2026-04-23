<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

const props = defineProps<{
    statuses: any[];
    users: any[];
}>();

/**
 * Objeto de formulário reativo do Inertia.
 * Gerencia os campos da tarefa e a lista de usuários atribuídos.
 */
const form = useForm({
    titulo: '',
    descricao: '',
    status_id: '',
    // Inicializa como um array vazio para uma nova tarefa
    user_ids: [] as number[],
});

const submit = () => {
    console.log('Enviando formulário:', form.data());
    form.post('/tarefas', {
        onSuccess: () => form.reset(),
    });
};

/**
 * Alterna a seleção de um usuário para a tarefa.
 * Se o usuário já estiver selecionado, ele é removido; caso contrário, é adicionado.
 */
const toggleUser = (userId: any) => {
    const id = Number(userId);
    const index = form.user_ids.indexOf(id);

    if (index > -1) {
        // Remove o ID do array se ele já estiver presente
        form.user_ids = form.user_ids.filter(i => i !== id);
    } else {
        // Adiciona o ID ao array se ele não estiver presente
        form.user_ids = [...form.user_ids, id];
    }
    console.log('User IDs atuais:', form.user_ids);
};
</script>

<template>

    <Head title="Criar Tarefa" />

    <div class="max-w-7xl py-8 px-4">
        <div class="mb-6">
            <Link href="/tarefas"
                class="text-sm text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200">
                &larr; Voltar para listagem
            </Link>
            <h1 class="text-2xl font-semibold mt-2">Nova Tarefa</h1>
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

            <!-- Seção de Atribuição de Usuários (Relação Muitos-para-Muitos) -->
            <div class="space-y-3">
                <Label>Atribuir Usuários</Label>
                <div class="grid grid-cols-2 gap-4 border border-zinc-200 dark:border-zinc-800 p-4 rounded-md">
                    <div v-for="user in users" :key="user.id" class="flex items-center space-x-2">
                        <!--
                          O checkbox controla a presença do ID do usuário no array user_ids.
                          :checked verifica se o ID já está no array para manter a UI sincronizada.
                          @change chama toggleUser para adicionar ou remover o ID.
                        -->
                        <input type="checkbox" :id="'user-' + user.id" :value="user.id"
                            :checked="form.user_ids.includes(user.id)" @change="toggleUser(user.id)"
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
                    {{ form.processing ? 'Salvando...' : 'Criar Tarefa' }}
                </Button>
            </div>
        </form>
    </div>
</template>
