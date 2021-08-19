<template>
	<Viewer />
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import Viewer from './components/Viewer.vue';

export default defineComponent({
	name: 'App',
	components: {
		Viewer,
	},
});
</script>

<style lang="scss">
html {
	height: 100%;
}

body {
	background-color: #222;
	color: #fff;
	background-image: url('/assets/bg.jpg');
	background-position: 50% 0%;
	background-size: cover;
	margin: 0;
	padding: 0;
}

.vignette {
	position: fixed;
	z-index: 10;
	pointer-events: none;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	background-image: radial-gradient(circle, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 1) 100%);
	mix-blend-mode: soft-light;
	opacity: 0.75;
}

@media only screen and (max-width: 567px) {
}
</style>
