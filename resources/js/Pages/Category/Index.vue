<template>
	<Head title="Categorias" />
		<div class="flex-1 pt-12 px-6 text-[#1f295a]">
			<h1 class="flex items-center font-bold text-xl mb-6">
				<span>Lista de Categorias</span>

				<button class="w-8 h-8 ml-3 bg-cyan-300 text-white rounded-lg rounded-br-none">+</button>
			</h1>

			<div v-for="product in products" class=" bg-white rounded-2xl overflow-hidden mb-2 shadow-sm">
				<div class="flex space-x-4 border-l-4 border-green-400 p-3 ">
					<a href="#">
						<img class="w-20 h-20" src="https://picsum.photos/200/300" alt="Produto">
					</a>

					<div class="flex flex-col flex-1 justify-center">
						<h3 class="text-sm">{{ product.category }}</h3>
						<h2 class="font-bold">{{ product.name }}</h2>
					</div>
				</div>
			</div>
		</div>
</template>

<script setup>
const products = [
	{
		name: 'Product One',
		image: 'https://picsum.photos/200/300',
		category: 'Category test something One'
	},
	{
		name: 'Product Two',
		image: 'https://picsum.photos/200/300',
		category: 'Category test something Two'
	},
	{
		name: 'Product Three',
		image: 'https://picsum.photos/200/300',
		category: 'Category test something Three'
	},
];
</script>
