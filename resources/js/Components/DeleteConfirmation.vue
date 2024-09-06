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
        <AlertDialogDescription v-if="$slots.subtitle || $slots.description">
          <div class="mb-3 mt-1 text-slate-800 font-medium text-md" v-if="$slots.subtitle">
            <slot name="subtitle"></slot>
          </div>
          <slot name="description" v-if="$slots.description"></slot>
        </AlertDialogDescription>
      </AlertDialogHeader>
      <slot name="content"></slot>
      <AlertDialogFooter>
        <AlertDialogCancel @click="$emit('close', true)">Cancel</AlertDialogCancel>
        <AlertDialogAction class="bg-red-600 hover:bg-red-500" @click="handleRoute">Continue</AlertDialogAction>
      </AlertDialogFooter>
    </AlertDialogContent>
  </AlertDialog>
</template>

<script>
import axios from 'axios';

export default {
    props: {
      useInertia: { type: Boolean, default: true },
      open: Boolean,
      routeName: String,
      method: String,
      id: [String, Number, Array],
      params: [String, Object],
    },
    emits: ['close', 'success'],
    methods: {
        handleRoute(){
          if(this.useInertia){
            if (this.routeName) {
              this.$inertia.visit(this.routeName && this.id ? route(this.routeName, this.id) : route(this.routeName), {
                data: this.params,
                method: this.method,
                preserveState: false,
                preserveScroll: true,
                onSuccess: () => {
                  this.$emit('close', true); 
                }
              })
            }
          }
          else{
            axios({
              method: this.method,
              url: this.id ? route(this.routeName, this.id) : route(this.routeName),
              data: this.params
            })
            .then((response)=>{
              this.$emit('close', true); 
              this.$emit('success', response);  // Emit success event
            })
          }
        }
    }
}
</script>