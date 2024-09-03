<template>
  <div>
    <Popover v-model:open="isOpen">
      <PopoverTrigger as-child @click="togglePopover">
        <Button variant="outline" class="w-full justify-between px-3 hover:bg-white disabled:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-100 disabled:text-slate-900" :disabled="disabled">
          <div class="flex items-center">
            <span :class="['truncate', selectedItem ? '' : 'text-gray-400 font-normal']">
              {{ multiple 
                ? `${selectedItems.length} selected` 
                : (selectedItem ? (isObjectItems ? selectedItem[labelProperty] : selectPlaceholder) : selectPlaceholder) 
              }}
            </span>
            <CrossCircledIcon class="ml-2 h-4 w-4 text-red-500 shrink-0 hover:text-red-600 font-semibold" v-if="canClear && modelValue" @click="[$emit('update:modelValue',''), this.$emit('select', '')]" />
          </div>
          <CaretSortIcon class="ml-2 h-4 w-4 shrink-0 opacity-50" />
        </Button>
      </PopoverTrigger>
      <PopoverContent class="flex w-full p-0 min-w-[var(--radix-popover-trigger-width)]">
        <Command>
          <CommandInput 
            type="text" 
            class="h-9" 
            :placeholder="searchPlaceholder" 
            v-model="searchQuery" 
            @input="handleInput"
          />
          <CommandEmpty class="py-4">
            {{ loading ? 'Searching...' : 'No results found.' }}
          </CommandEmpty>
          <CommandList>
            <CommandGroup>
              <!-- Select All Option -->
              <CommandItem @select="selectAll" v-if="multiple" value="null">
                <span class="font-bold">Select All</span>
              </CommandItem>
              <CommandItem
                v-for="item in filteredItems"
                :key="isObjectItems ? item[valueProperty] : item"
                :value="isObjectItems ? item[labelProperty] : item"
                @select="selectItem(item)"
              >
                {{ isObjectItems ? item[labelProperty] : item }}
                <CheckIcon
                  :class="[
                    'ml-auto h-4 w-4',
                    {
                      'opacity-100': multiple 
                        ? selectedItems.includes(isObjectItems ? item[this.valueProperty] : item)
                        : (isObjectItems ? selectedItem?.[valueProperty] === item[valueProperty] : selectedItem === item),
                      'opacity-0': !multiple 
                        ? !(isObjectItems ? selectedItem?.[valueProperty] === item[valueProperty] : selectedItem === item)
                        : !selectedItems.includes(isObjectItems ? item[this.valueProperty] : item),
                    },
                  ]"
                />
              </CommandItem>
            </CommandGroup>
          </CommandList>
        </Command>
      </PopoverContent>
    </Popover>
    <p class="mt-0.5 text-[0.8rem] font-medium text-destructive" v-if="error">
      This field is required.
    </p>
  </div>
</template>

<script>
import { CaretSortIcon, CheckIcon, CrossCircledIcon } from '@radix-icons/vue'
import { Command, CommandEmpty, CommandGroup, CommandInput, CommandItem, CommandList } from '@/Components/ui/command'
import { Popover, PopoverContent, PopoverTrigger } from '@/Components/ui/popover'

export default {
  emits: ['search', 'select', 'update:modelValue'],
  components: { 
    CaretSortIcon, CheckIcon, CrossCircledIcon, Command, CommandEmpty, CommandGroup, CommandInput, CommandItem, CommandList, Popover, PopoverContent, PopoverTrigger
  },
  props: {
    items: {
      type: Array,
      required: true,
    },
    modelValue: {
      type: [String, Number, Object],
      required: false,
    },
    labelProperty: {
      type: [String, Number], // Accept numbers as well
      default: 'name',
    },
    valueProperty: {
      type: [String, Number],
      default: 'id',
    },
    placeholder: {
      type: String,
      default: 'Select Country',
    },
    selectPlaceholder: {
      type: String,
      default: 'Select Option',
    },
    searchPlaceholder: {
      type: String,
      default: 'Search option...',
    },
    loading: {
      type: Boolean,
      default: false,
    },
    error: { type: [String, Boolean] },
    multiple: {
      type: Boolean,
      default: false,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    canClear: {
      type: Boolean,
      default: false,
    }
  },
  data() {
    return {
      isOpen: false,
      searchQuery: '',
      selectedItems: this.multiple ? (Array.isArray(this.modelValue) ? this.modelValue : []) : this.modelValue || null,
    };
  },
  watch: {
    modelValue(newValue) {
      this.selectedItems = this.multiple ? (Array.isArray(newValue) ? newValue : []) : newValue;
    },
  },
  computed: {
    isObjectItems() {
      return this.items.length > 0 && typeof this.items[0] === 'object';
    },
    selectedItem() {
      if (this.multiple) {
        return this.items.filter(item =>
          this.selectedItems.includes(this.isObjectItems ? item[this.valueProperty] : item) 
        );
      } else {
        if (this.isObjectItems) {
          return this.items.find(item => item[this.valueProperty] === this.modelValue);
        }
        return this.modelValue;
      }
    },
    filteredItems() {
      const searchQuery = this.searchQuery.trim().toLowerCase();

      return this.items.filter(item => {
        const labelValue = this.isObjectItems ? item[this.labelProperty] : item;

        if (typeof labelValue === 'number') {
          return labelValue.toString().includes(searchQuery);
        } else if (typeof labelValue === 'string') {
          return labelValue.toLowerCase().includes(searchQuery);
        }
        return false;
      });
    },
    allSelected() {
      return this.filteredItems.length > 0 && this.filteredItems.every(item =>
        this.selectedItems.includes(this.isObjectItems ? item[this.valueProperty] : item)
      );
    },
  },
  methods: {
    togglePopover() {
      this.isOpen = !this.isOpen;
    },
    selectItem(item) {
      const value = this.isObjectItems ? item[this.valueProperty] : item;
      if (this.multiple) {
        const index = this.selectedItems.indexOf(value);
        if (index === -1) {
          this.selectedItems.push(value);
        } else {
          this.selectedItems.splice(index, 1);
        }
        this.$emit('update:modelValue', this.selectedItems);
      } else {
        this.$emit('update:modelValue', value);
        this.isOpen = false;
      }
      this.$emit('select', item);
    },
    selectAll() {
      this.selectedItems = this.allSelected ? [] : this.filteredItems.map(item =>
        this.isObjectItems ? item[this.valueProperty] : item
      );
      this.$emit('update:modelValue', this.selectedItems);
    },
    handleInput(event) {
      this.searchQuery = event.target.value; // Update the search query
      this.$emit('search', event.target.value);
    },
  },
};
</script>

<style>
.popover-content-width-same-as-its-trigger {
  width: var(--radix-popover-trigger-width);
  max-height: var(--radix-popover-content-available-height);
}
</style>
