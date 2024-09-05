<script setup>
import { cn } from "@/Components/lib/utils";

const props = defineProps({
  class: { type: null, required: false },
});
</script>

<template>
  <div
    :class="
      cn(
        'flex flex-col-reverse gap-y-2 sm:flex-row sm:justify-end sm:gap-x-2 sm:gap-y-0',
        props.class,
      )
    "
  >
    <slot />
  </div>
</template>
