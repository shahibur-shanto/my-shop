<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import logo from '../../Images/shanto_3.png'

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <div>
        <img alt="my logo" :src="logo" class="h-20 object-contain" />
    </div>
</template>
