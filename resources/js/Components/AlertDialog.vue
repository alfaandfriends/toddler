<script setup>
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogTitle, AlertDialogHeader, AlertDialogTrigger } from '@/Components/ui/alert-dialog'
</script>

<template>
  <AlertDialog :open="open">
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle v-if="$slots.title" class="text-red-600">
            <slot name="title"></slot>
        </AlertDialogTitle>
        <AlertDialogDescription v-if="$slots.subtitle || $slots.description" class="text-red-500">
          <div class="text-slate-800 text-[15px] font-semibold underline mb-1 mt-3">
            <slot name="subtitle"></slot>
          </div>
          <div class="font-semibold">
            <slot name="description"></slot>
          </div>
        </AlertDialogDescription>
      </AlertDialogHeader>
      <slot name="content"></slot>
      <AlertDialogFooter>
        <AlertDialogCancel @click="$emit('close', true)">Close</AlertDialogCancel>
      </AlertDialogFooter>
    </AlertDialogContent>
  </AlertDialog>
</template>

<script>
import axios from 'axios';

export default {
    props: {
      open: Boolean,
    },
    emits: ['close'],
}
</script>