<template>
	<Breadcrumb
		:home="props.breadCrumbsFirstItem"
		:model="props.breadCrumbsItems"
		class="mb-6"
		:pt="{
			root: { class: 'bg-primary-200 py-5 px-10' },
			list: { class: 'flex' },
		}"
	>
		<template #item="{ item, props }">
			<router-link
				v-if="item.route"
				v-slot="{ href, navigate }"
				:to="item.route"
				custom
			>
				<a :href="href" v-bind="props.action" @click="navigate">
					<span :class="[item.icon, 'text-color']" />
					<span class="text-black font-bold">{{ item.label }}</span>
				</a>
			</router-link>
			<a v-else :href="item.url" :target="item.target" v-bind="props.action">
				<span class="text-color">{{ item.label }}</span>
			</a>
		</template>
	</Breadcrumb>
</template>
<script setup lang="ts">
import Breadcrumb from "primevue/breadcrumb";

const props = defineProps(["breadCrumbsFirstItem", "breadCrumbsItems"]);
</script>
