<script setup lang="ts">
import { Head } from '@inertiajs/vue3'

interface DomObject {
    id: number
    dom_id: number
    name: string
}

defineProps<{
    objects: DomObject[]
}>()
</script>

<template>
  <Head title="Объекты ЖК" />

  <div class="container py-5">
    <div class="row mb-4">
      <div class="col">
        <h1 class="display-6 fw-bold mb-1">Объекты ЖК</h1>
        <p class="text-muted">Парсер наш.дом.рф</p>
      </div>
    </div>

    <div class="card shadow-sm">
      <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Список объектов</h5>
          <span class="badge bg-primary">{{ objects.length }}</span>
        </div>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover table-striped mb-0">
            <thead class="table-light">
              <tr>
                <th class="py-3 px-4">ID</th>
                <th class="py-3 px-4">Dom ID</th>
                <th class="py-3 px-4">Название ЖК</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="obj in objects" :key="obj.dom_id">
                <td class="px-4 text-muted">{{ obj.id }}</td>
                <td class="px-4"><code class="bg-light px-2 py-1 rounded">{{ obj.dom_id }}</code></td>
                <td class="px-4 fw-medium">{{ obj.name }}</td>
              </tr>
              <tr v-if="objects.length === 0">
                <td colspan="3" class="px-4 py-5 text-center text-muted">
                  Нет данных. Запустите парсер: <code>php artisan parse:nash-dom</code>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="card-footer bg-light">
        <small class="text-muted">Всего записей: <strong>{{ objects.length }}</strong></small>
      </div>
    </div>
  </div>
</template>