<template>
    <!-- Header -->
    <nav class="bg-gray-800 text-white p-4">
      <div class="container mx-auto flex justify-between items-center">
        <a href="/" class="text-lg font-semibold">Productivapp</a>
        <div class="">
          <a href="/login" class="px-4 py-2 hover:bg-gray-700 rounded">Se connecter</a>
          <a href="/register" class="bg-sky-600 hover:bg-sky-700 text-sky-100 rounded px-4 py-1 mx-auto text-xl ml-2">S'inscrire</a>
        </div>
      </div>
    </nav>
    <!-- Main Content -->
    <main class="">
        <slot />
    </main>
    <!-- Footer -->
    <div>
        <nav>

        </nav>
    </div>
  </template>
