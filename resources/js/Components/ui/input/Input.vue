<script setup>
import { useVModel } from "@vueuse/core";
import { cn } from "@/Components/lib/utils";

const props = defineProps({
  defaultValue: { type: [String, Number], required: false },
  modelValue: { type: [String, Number], required: false },
  class: { type: null, required: false },
  error: { type: [String, Boolean], required: false },
});

const emits = defineEmits(["update:modelValue"]);

const modelValue = useVModel(props, "modelValue", emits, {
  passive: true,
  defaultValue: props.defaultValue,
});
</script>

<template>
  <div>
    <input
      v-bind="$attrs"
      v-model="modelValue"
      :class="
        cn(
          'flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring read-only:bg-slate-100 disabled:cursor-not-allowed disabled:bg-slate-100',
          props.class,
        )
      "
    />
    <span v-if="typeof error === 'string'" class="text-[0.8rem] font-medium text-destructive">
      {{ error }}
    </span>
    <span v-else-if="error" class="text-[0.8rem] font-medium text-destructive">
      This field is required.
    </span>
  </div>
</template>
