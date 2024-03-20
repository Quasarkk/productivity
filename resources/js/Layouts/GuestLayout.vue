<template>
    <!-- Header -->
    <nav class="bg-gray-800 text-white p-4">
      <div class="container mx-auto flex justify-between items-center">
        <a href="/" class="text-lg font-semibold">Productivapp</a>
        <div>
          <a href="/login" class="px-4 py-2 hover:bg-gray-700 rounded">Se connecter</a>
          <a href="/register" class="px-4 py-2 hover:bg-gray-700 rounded">S'inscrire</a>
        </div>
      </div>
    </nav>
    <!-- Main Content -->
    <main class="bg-red-100">
        <slot />
    </main>
    <!-- Footer -->
    <div>
        <nav>

        </nav>
    </div>
  </template>
