<script setup>
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogTitle, AlertDialogHeader, AlertDialogTrigger } from '@/Components/ui/alert-dialog'
</script>

<template>
  <AlertDialog :open="open">
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle v-if="$slots.title">
            <slot name="title"></slot>
        </AlertDialogTitle>
        <AlertDialogDescription>
            <slot name="description"></slot>
        </AlertDialogDescription>
      </AlertDialogHeader>
      <AlertDialogFooter>
        <AlertDialogCancel @click="$emit('close', true)">Cancel</AlertDialogCancel>
        <AlertDialogAction class="bg-red-600 hover:bg-red-500" @click="handleRoute">Continue</AlertDialogAction>
      </AlertDialogFooter>
    </AlertDialogContent>
  </AlertDialog>
</template>

<script>
export default {
    props: {
        open: Boolean,
        routeName: String,
        method: String,
        id: [String, Number]
    },
    emits: ['close'],
    methods: {
        handleRoute(){
          if (this.id && this.routeName) {
            this.$inertia.visit(route(this.routeName, this.id), {
              method: this.method,
              preserveState: false,
              preserveScroll: true,
              onSuccess: () => {
                this.$emit('close', true); 
              }
            })
          }
        }
    }
}
</script>