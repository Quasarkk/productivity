<template>
    <AppLayoutVertical>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-8">Pilliers</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Dynamically create pillar cards -->
                <div class="bg-white rounded-lg shadow overflow-hidden" v-for="pillar in pillars" :key="pillar.id">
                    <div class="px-4 py-5 sm:p-6 group">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ pillar.name }}</h3>
                            <div class="flex items-center">
                                <BaseButton variant="icon-blue" @click="openEditPillarModal(pillar)"
                                    class="opacity-0 group-hover:opacity-100">
                                    <svg class="ml-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                        <path d="M13.5 6.5l4 4" />
                                    </svg>
                                </BaseButton>
                            </div>
                        </div>
                        <div class="mt-6">
                            <BaseButton variant="primary" @click="openCreateSubpillarModal(pillar)"
                                class="group opacity-0 group-hover:opacity-100">
                                Ajouter Sous-Pillier
                            </BaseButton>
                        </div>
                    </div>
                    <!-- Subpillars -->
                    <div class="flex flex-col gap-4 ">
                        <div v-for="subpillar in pillar.subpillars"
                            class="flex flex-col group justify-center items-center border bg-orange-100 rounded-lg p-3 shadow ">
                            <div class="flex">
                                <h3 class="font-medium text-gray-900">{{ subpillar.name }}</h3>
                                <BaseButton variant="" @click="openEditSubpillarModal(subpillar)"
                                    class="opacity-0 group-hover:opacity-100">
                                    <svg class="ml-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                        <path d="M13.5 6.5l4 4" />
                                    </svg>
                                </BaseButton>
                            </div>
                            <!-- Bouton d'ajout d'Objectifs -->
                            <BaseButton variant="orange" @click="openCreateObjectiveModal(subpillar)"
                                class="opacity-0 group-hover:opacity-100">
                                Ajouter Objectif +
                            </BaseButton>
                            <!-- Objectives -->
                            <div v-for="objective in subpillar.objectives" :key="objective.id"
                                class="bg-yellow-100 rounded-md p-3 my-3 shadow-inner group w-full">
                                <div class="flex">
                                    <h4 class="font-medium text-gray-900">{{ objective.name }}</h4>
                                    <button @click="openEditObjectiveModal(objective)"
                                        class="opacity-0 group-hover:opacity-100 transition duration-100 ease-in-out">
                                        <svg class="ml-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                            <path d="M13.5 6.5l4 4" />
                                        </svg>
                                    </button>
                                </div>
                                <!-- Bouton d'ajout de Sous-Objectifs -->
                                <BaseButton variant="yellow" @click="openCreateSubobjectiveModal(objective)"
                                    class="opacity-0 group-hover:opacity-100">
                                    Ajouter Sous-Objectif +
                                </BaseButton>
                                <!-- Subobjectives -->
                                <div v-for="subobjective in objective.subobjectives" :key="subobjective.id"
                                    class="bg-green-100 rounded-md p-2 my-2">

                                    <div class="flex">
                                        <h5 class="font-medium text-gray-900">{{ subobjective.name }}</h5>
                                        <button @click="openEditSubobjectiveModal(subobjective)"
                                            class="opacity-0 group-hover:opacity-100">
                                            <svg class="ml-auto" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                                <path d="M13.5 6.5l4 4" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bouton d'ajout de Piliers -->
                <BaseButton variant="primary" @click="isOpenCreatePillar = true">
                    Ajouter Pilier +
                </BaseButton>
            </div>

            <!-- Modale Create Pillar -->
            <div v-if="isOpenCreatePillar"
                class="fixed top-0 bg-black/20 w-full h-full justify-center flex backdrop-blur-md overflow-auto">
                <!-- CREATE CARD -->
                <div class=" w-6/12 p-6 bg-white my-auto rounded-lg">
                    <!-- CLOSE BUTTONS -->
                    <div class="flex items-center justify-end mb-3">
                        <BaseButton variant="" @click="closeCreateModalePillar()" class="">
                            <svg class="w-6 h-6  fill-red-700 hover:fill-red-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 48 48">
                                <path
                                    d="M 38.982422 6.9707031 A 2.0002 2.0002 0 0 0 37.585938 7.5859375 L 24 21.171875 L 10.414062 7.5859375 A 2.0002 2.0002 0 0 0 8.9785156 6.9804688 A 2.0002 2.0002 0 0 0 7.5859375 10.414062 L 21.171875 24 L 7.5859375 37.585938 A 2.0002 2.0002 0 1 0 10.414062 40.414062 L 24 26.828125 L 37.585938 40.414062 A 2.0002 2.0002 0 1 0 40.414062 37.585938 L 26.828125 24 L 40.414062 10.414062 A 2.0002 2.0002 0 0 0 38.982422 6.9707031 z" />
                            </svg>
                        </BaseButton>
                    </div>
                    <p>Create a pillar</p>
                    <!-- NAME -->
                    <div class="mt-3">
                        <!-- <div v-if="errors.name" class="text-red-700 text-lg mx-auto flex justify-center">{{ errors.name }}
                        </div> -->
                        <label class="block font-medium text-gray-700 capitalize">Name</label>
                        <input
                            class="block mt-1 w-full rounded-md border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm"
                            v-model="form_createPillar.name" type="text">

                        <label class="block font-medium text-gray-700 capitalize">Description</label>
                        <input
                            class="block mt-1 w-full rounded-md border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm"
                            v-model="form_createPillar.description" type="text">
                    </div>


                    <!-- CREATE BUTTON  -->
                    <BaseButton variant="primary" @click="createPillar(form_createPillar)">
                        Create a pillar
                    </BaseButton>

                </div>
            </div>
            <!-- Modale Edit Pillar -->
            <div v-if="isOpenEditPillar"
                class="fixed top-0 bg-black/20 w-full h-full justify-center flex backdrop-blur-md overflow-auto">
                <div class="w-6/12 p-6 bg-white my-auto rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <button @click="deletePillar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7l16 0" />
                                <path d="M10 11l0 6" />
                                <path d="M14 11l0 6" />
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                            </svg>
                        </button>

                        <BaseButton variant="" @click="closeEditModalPillar">
                            <svg class="w-6 h-6  fill-red-700 hover:fill-red-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 48 48">
                                <path
                                    d="M 38.982422 6.9707031 A 2.0002 2.0002 0 0 0 37.585938 7.5859375 L 24 21.171875 L 10.414062 7.5859375 A 2.0002 2.0002 0 0 0 8.9785156 6.9804688 A 2.0002 2.0002 0 0 0 7.5859375 10.414062 L 21.171875 24 L 7.5859375 37.585938 A 2.0002 2.0002 0 1 0 10.414062 40.414062 L 24 26.828125 L 37.585938 40.414062 A 2.0002 2.0002 0 1 0 40.414062 37.585938 L 26.828125 24 L 40.414062 10.414062 A 2.0002 2.0002 0 0 0 38.982422 6.9707031 z" />
                            </svg>
                        </BaseButton>
                    </div>
                    <p>Edit a pillar</p>
                    <div class="mt-3">
                        <label class="block font-medium text-gray-700 capitalize">Name</label>
                        <input
                            class="block mt-1 w-full rounded-md border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm"
                            v-model="form_editPillar.name" type="text">

                        <label class="block font-medium text-gray-700 capitalize">Description</label>
                        <input
                            class="block mt-1 w-full rounded-md border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm"
                            v-model="form_editPillar.description" type="text">
                    </div>

                    <BaseButton variant="primary" @click="editPillar">
                        Update pillar
                    </BaseButton>
                </div>
            </div>



            <!-- Modale Create Subpillar -->
            <div v-if="isOpenCreateSubpillar"
                class="fixed top-0 left-0 bg-black/20 w-full h-full flex justify-center items-center backdrop-blur-md overflow-auto z-50">
                <div class="w-6/12 p-6 bg-white rounded-lg">
                    <!-- Close button & form similar to Create Pillar -->
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Créer un Sous-Pillier</h3>
                        <BaseButton variant="" @click="closeCreateModalSubpillar">
                            <svg class="w-6 h-6  fill-red-700 hover:fill-red-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 48 48">
                                <path
                                    d="M 38.982422 6.9707031 A 2.0002 2.0002 0 0 0 37.585938 7.5859375 L 24 21.171875 L 10.414062 7.5859375 A 2.0002 2.0002 0 0 0 8.9785156 6.9804688 A 2.0002 2.0002 0 0 0 7.5859375 10.414062 L 21.171875 24 L 7.5859375 37.585938 A 2.0002 2.0002 0 1 0 10.414062 40.414062 L 24 26.828125 L 37.585938 40.414062 A 2.0002 2.0002 0 1 0 40.414062 37.585938 L 26.828125 24 L 40.414062 10.414062 A 2.0002 2.0002 0 0 0 38.982422 6.9707031 z" />
                            </svg>
                        </BaseButton>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nom</label>
                            <input v-model="form_createSubpillar.name" type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <input v-model="form_createSubpillar.description" type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <input type="hidden" v-model="form_createSubpillar.pillar_id">
                        <BaseButton variant="primary" @click="createSubpillar">
                            Créer un sous-pillier
                        </BaseButton>
                    </div>
                </div>
            </div>
            <!-- Modale Edit Subpillar -->
            <div v-if="isOpenEditSubpillar"
                class="fixed top-0 bg-black/20 w-full h-full justify-center flex backdrop-blur-md overflow-auto">
                <div class="w-6/12 p-6 bg-white my-auto rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <BaseButton variant="" @click="deleteSubpillar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7l16 0" />
                                <path d="M10 11l0 6" />
                                <path d="M14 11l0 6" />
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                            </svg>
                        </BaseButton>
                        <BaseButton variant="" @click="closeEditModalSubpillar">
                            <svg class="w-6 h-6  fill-red-700 hover:fill-red-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 48 48">
                                <path
                                    d="M 38.982422 6.9707031 A 2.0002 2.0002 0 0 0 37.585938 7.5859375 L 24 21.171875 L 10.414062 7.5859375 A 2.0002 2.0002 0 0 0 8.9785156 6.9804688 A 2.0002 2.0002 0 0 0 7.5859375 10.414062 L 21.171875 24 L 7.5859375 37.585938 A 2.0002 2.0002 0 1 0 10.414062 40.414062 L 24 26.828125 L 37.585938 40.414062 A 2.0002 2.0002 0 1 0 40.414062 37.585938 L 26.828125 24 L 40.414062 10.414062 A 2.0002 2.0002 0 0 0 38.982422 6.9707031 z" />
                            </svg>
                        </BaseButton>
                    </div>
                    <p>Edit Subpillar</p>
                    <div class="mt-3">
                        <label class="block font-medium text-gray-700">Name</label>
                        <input class="block mt-1 w-full rounded-md border-gray-300 shadow-sm"
                            v-model="form_editSubpillar.name" type="text">

                        <label class="block font-medium text-gray-700">Description</label>
                        <input class="block mt-1 w-full rounded-md border-gray-300 shadow-sm"
                            v-model="form_editSubpillar.description" type="text">
                    </div>
                    <BaseButton variant="primary" @click="editSubpillar">
                        Update Subpillar
                    </BaseButton>
                </div>
            </div>



            <!-- Modale Create Objectives -->
            <div v-if="isOpenCreateObjective"
                class="fixed top-0 left-0 bg-black/20 w-full h-full flex justify-center items-center backdrop-blur-md overflow-auto z-50">
                <div class="w-6/12 p-6 bg-white rounded-lg">
                    <!-- Close button & form similar to Create Pillar -->
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Créer un Objectif</h3>
                        <BaseButton variant="" @click="closeCreateModalObjective">
                            <svg class="w-6 h-6  fill-red-700 hover:fill-red-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 48 48">
                                <path
                                    d="M 38.982422 6.9707031 A 2.0002 2.0002 0 0 0 37.585938 7.5859375 L 24 21.171875 L 10.414062 7.5859375 A 2.0002 2.0002 0 0 0 8.9785156 6.9804688 A 2.0002 2.0002 0 0 0 7.5859375 10.414062 L 21.171875 24 L 7.5859375 37.585938 A 2.0002 2.0002 0 1 0 10.414062 40.414062 L 24 26.828125 L 37.585938 40.414062 A 2.0002 2.0002 0 1 0 40.414062 37.585938 L 26.828125 24 L 40.414062 10.414062 A 2.0002 2.0002 0 0 0 38.982422 6.9707031 z" />
                            </svg>
                        </BaseButton>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nom</label>
                            <input v-model="form_createObjective.name" type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <input v-model="form_createObjective.description" type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deadline</label>
                            <input v-model="form_createObjective.deadline" type="date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <input type="hidden" v-model="form_createObjective.subpillar_id">

                        <BaseButton variant="primary" @click="createObjective">Créer
                        </BaseButton>
                    </div>
                </div>
            </div>
            <!-- Modale Edit Objective -->
            <div v-if="isOpenEditObjective"
                class="fixed top-0 bg-black/20 w-full h-full justify-center flex backdrop-blur-md overflow-auto">
                <div class="w-6/12 p-6 bg-white my-auto rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <button @click="deleteObjective()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7l16 0" />
                                <path d="M10 11l0 6" />
                                <path d="M14 11l0 6" />
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                            </svg>
                        </button>
                        <BaseButton variant="" @click="closeEditModalObjective()">
                            <svg class="w-6 h-6  fill-red-700 hover:fill-red-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 48 48">
                                <path
                                    d="M 38.982422 6.9707031 A 2.0002 2.0002 0 0 0 37.585938 7.5859375 L 24 21.171875 L 10.414062 7.5859375 A 2.0002 2.0002 0 0 0 8.9785156 6.9804688 A 2.0002 2.0002 0 0 0 7.5859375 10.414062 L 21.171875 24 L 7.5859375 37.585938 A 2.0002 2.0002 0 1 0 10.414062 40.414062 L 24 26.828125 L 37.585938 40.414062 A 2.0002 2.0002 0 1 0 40.414062 37.585938 L 26.828125 24 L 40.414062 10.414062 A 2.0002 2.0002 0 0 0 38.982422 6.9707031 z" />
                            </svg>
                        </BaseButton>
                    </div>
                    <p>Edit Objective</p>
                    <div class="mt-3">
                        <label class="block font-medium text-gray-700">Name</label>
                        <input class="block mt-1 w-full rounded-md border-gray-300 shadow-sm"
                            v-model="form_editObjective.name" type="text">

                        <label class="block font-medium text-gray-700">Description</label>
                        <input class="block mt-1 w-full rounded-md border-gray-300 shadow-sm"
                            v-model="form_editObjective.description" type="text">

                        <label class="block font-medium text-gray-700">Deadline</label>
                        <input class="block mt-1 w-full rounded-md border-gray-300 shadow-sm"
                            v-model="form_editObjective.deadline" type="date">
                    </div>
                    <BaseButton variant="primary" @click="editObjective">
                        Update Objective
                    </BaseButton>
                </div>
            </div>



            <!-- Modale Create Subobjective -->
            <div v-if="isOpenCreateSubobjective"
                class="fixed top-0 left-0 bg-black/20 w-full h-full flex justify-center items-center backdrop-blur-md overflow-auto z-50">
                <div class="w-6/12 p-6 bg-white rounded-lg">
                    <!-- Close button & form -->
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Créer un Sous-Objectif</h3>
                        <BaseButton variant="" @click="closeCreateModalSubobjective">
                            <svg class="w-6 h-6  fill-red-700 hover:fill-red-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 48 48">
                                <path
                                    d="M 38.982422 6.9707031 A 2.0002 2.0002 0 0 0 37.585938 7.5859375 L 24 21.171875 L 10.414062 7.5859375 A 2.0002 2.0002 0 0 0 8.9785156 6.9804688 A 2.0002 2.0002 0 0 0 7.5859375 10.414062 L 21.171875 24 L 7.5859375 37.585938 A 2.0002 2.0002 0 1 0 10.414062 40.414062 L 24 26.828125 L 37.585938 40.414062 A 2.0002 2.0002 0 1 0 40.414062 37.585938 L 26.828125 24 L 40.414062 10.414062 A 2.0002 2.0002 0 0 0 38.982422 6.9707031 z" />
                            </svg>
                        </BaseButton>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nom</label>
                            <input v-model="form_createSubobjective.name" type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <input v-model="form_createSubobjective.description" type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deadline</label>
                            <input v-model="form_createSubobjective.deadline" type="date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <input type="hidden" v-model="form_createSubobjective.objective_id">
                        <BaseButton variant="primary" @click="createSubobjective">
                            Créer
                        </BaseButton>
                    </div>
                </div>
            </div>
            <!-- Modale Edit Subobjective -->
            <div v-if="isOpenEditSubobjective"
                class="fixed top-0 bg-black/20 w-full h-full justify-center flex backdrop-blur-md overflow-auto">
                <div class="w-6/12 p-6 bg-white my-auto rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <BaseButton variant="" @click="deleteSubobjective()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7l16 0" />
                                <path d="M10 11l0 6" />
                                <path d="M14 11l0 6" />
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                            </svg>
                        </BaseButton>
                        <BaseButton variant="" @click="closeEditModalSubobjective()">
                            <svg class="w-6 h-6  fill-red-700 hover:fill-red-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 48 48">
                                <path
                                    d="M 38.982422 6.9707031 A 2.0002 2.0002 0 0 0 37.585938 7.5859375 L 24 21.171875 L 10.414062 7.5859375 A 2.0002 2.0002 0 0 0 8.9785156 6.9804688 A 2.0002 2.0002 0 0 0 7.5859375 10.414062 L 21.171875 24 L 7.5859375 37.585938 A 2.0002 2.0002 0 1 0 10.414062 40.414062 L 24 26.828125 L 37.585938 40.414062 A 2.0002 2.0002 0 1 0 40.414062 37.585938 L 26.828125 24 L 40.414062 10.414062 A 2.0002 2.0002 0 0 0 38.982422 6.9707031 z" />
                            </svg>
                        </BaseButton>
                    </div>
                    <p>Edit Subobjective</p>
                    <div class="mt-3">
                        <label class="block font-medium text-gray-700">Name</label>
                        <input class="block mt-1 w-full rounded-md border-gray-300 shadow-sm"
                            v-model="form_editSubobjective.name" type="text">

                        <label class="block font-medium text-gray-700">Description</label>
                        <input class="block mt-1 w-full rounded-md border-gray-300 shadow-sm"
                            v-model="form_editSubobjective.description" type="text">

                        <label class="block font-medium text-gray-700">Deadline</label>
                        <input class="block mt-1 w-full rounded-md border-gray-300 shadow-sm"
                            v-model="form_editSubobjective.deadline" type="date">
                    </div>
                    <BaseButton variant="primary" @click="editSubobjective">
                        Update Subobjective
                    </BaseButton>
                </div>
            </div>
        </div>
    </AppLayoutVertical>
</template>

<script>
import AppLayoutVertical from '@/Layouts/AppLayoutVertical.vue';
import BaseButton from '@/Components/Custom/BaseButton.vue';

export default {
    components: {
        AppLayoutVertical,
        BaseButton,
    },
    props: {
        pillars: Array,
        subpillars: Array,
        objectives: Array,
        subobjectives: Array,
        routines: Array,
        tasks: Array,
    },

    data() {
        return {
            // pillars
            isOpenCreatePillar: false,
            form_createPillar: {
                name: null,
                description: null,
            },
            //edit
            selectedPillarForEdit: null,
            isOpenEditPillar: false,
            form_editPillar: {
                name: null,
                description: null,
            },
            //subpillars
            isOpenCreateSubpillar: false,
            form_createSubpillar: {
                name: null,
                description: null,
                pillar_id: null,
            },
            //edit
            isOpenEditSubpillar: false,
            selectedSubpillarForEdit: null,
            form_editSubpillar: {
                name: null,
                description: null,
                pillar_id: null, // Vous pouvez avoir besoin de l'ID du pilier parent pour la mise à jour
            },
            //objectives
            isOpenCreateObjective: false,
            form_createObjective: {
                name: null,
                description: null,
                deadline: null,
                subpillar_id: null,
            },
            //edit
            isOpenEditObjective: false,
            selectedObjectiveForEdit: null,
            form_editObjective: {
                name: null,
                description: null,
                deadline: null,
                subpillar_id: null,
            },
            // Subobjectives
            isOpenCreateSubobjective: false,
            form_createSubobjective: {
                name: null,
                description: null,
                deadline: null,
                objective_id: null,
            },
            //edit
            isOpenEditSubobjective: false,
            selectedSubobjectiveForEdit: null,
            form_editSubobjective: {
                name: null,
                description: null,
                deadline: null,
                objective_id: null,
            },
        }
    },
    methods: {
        //Pillar
        closeCreateModalePillar() {
            this.resetCreateFormPillar();
            this.isOpenCreatePillar = false;
        },
        resetCreateFormPillar() {
            this.form_createPillar.name = null;
            this.form_createPillar.description = null;
            //     // // reinitialize errors
            //     // this.errors.name = null;
        },
        createPillar() {
            this.$inertia.post(route('pillars.store'), this.form_createPillar, {
                onSuccess: () => this.isOpenCreatePillar = false,
            })
        },
        //edit
        openEditPillarModal(pillar) {
            this.selectedPillarForEdit = pillar;
            this.form_editPillar = { ...pillar };
            this.isOpenEditPillar = true;
        },
        closeEditModalPillar() {
            this.isOpenEditPillar = false;
        },
        editPillar() {
            console.log(this.form_editPillar);
            // Ici, vous pouvez appeler votre API pour mettre à jour le pilier
            // Par exemple, en utilisant this.$inertia.put ou post selon votre backend
            this.$inertia.put(route('pillars.update', this.selectedPillarForEdit.id), this.form_editPillar, {
                onSuccess: () => {
                    this.closeEditModalPillar();
                    // Mettez à jour l'UI ou rafraîchissez les données si nécessaire
                },
            });
        },
        //delete
        deletePillar() {
            if (!confirm("Are you sure you want to delete this pillar?")) return;

            this.$inertia.delete(route('pillars.destroy', this.selectedPillarForEdit.id), {
                onSuccess: () => {
                    this.closeEditModalPillar();
                },
            });
        },



        //Subpillars
        openCreateSubpillarModal(pillar) {
            this.selectedPillar = pillar; // Assurez-vous que cette ligne est correcte.
            this.isOpenCreateSubpillar = true;
            this.form_createSubpillar.pillar_id = this.selectedPillar.id; // Utilisez la propriété correcte ici.
        },
        closeCreateModalSubpillar() {
            this.resetCreateFormSubpillar();
            this.isOpenCreateSubpillar = false;
        },
        resetCreateFormSubpillar() {
            this.form_createSubpillar.name = null;
            this.form_createSubpillar.description = null;
            this.form_createSubpillar.pillar_id = null;
        },
        createSubpillar() {
            console.log(this.form_createSubpillar);
            this.$inertia.post(route('subpillars.store'), this.form_createSubpillar, {
                onSuccess: () => {
                    this.resetCreateFormSubpillar();
                    this.isOpenCreateSubpillar = false;
                },
            })
        },
        //edit
        openEditSubpillarModal(subpillar) {
            this.selectedSubpillarForEdit = subpillar;
            this.form_editSubpillar = { ...subpillar };
            this.isOpenEditSubpillar = true;
        },
        closeEditModalSubpillar() {
            this.isOpenEditSubpillar = false;
        },
        editSubpillar() {
            console.log(this.form_editSubpillar);
            // Implémentez la logique d'envoi ici, similaire à l'édition des piliers
            // Assurez-vous d'utiliser l'ID de selectedSubpillarForEdit pour la mise à jour
            this.$inertia.put(route('subpillars.update', this.selectedSubpillarForEdit.id), this.form_editSubpillar, {
                onSuccess: () => {
                    this.closeEditModalSubpillar();
                    // Mettez à jour l'UI ou rafraîchissez les données si nécessaire
                },
            });
        },
        //delete
        deleteSubpillar() {
            if (!confirm("Are you sure you want to delete this subpillar?")) return;

            this.$inertia.delete(route('subpillars.destroy', this.selectedSubpillarForEdit.id), {
                onSuccess: () => {
                    this.closeEditModalSubpillar();
                },
            });
        },



        //Objectives
        openCreateObjectiveModal(subpillar) {
            this.form_createObjective.subpillar_id = subpillar.id;
            this.isOpenCreateObjective = true;
        },
        closeCreateModalObjective() {
            this.isOpenCreateObjective = false;
            this.resetCreateFormObjective();
        },
        resetCreateFormObjective() {
            this.form_createObjective.name = null;
            this.form_createObjective.description = null;
            this.form_createObjective.deadline = null;
            this.form_createObjective.subpillar_id = null;

        },
        createObjective() {
            console.log(this.form_createObjective);
            // Implémentez la logique d'envoi ici, par exemple, à l'aide de $inertia.post
            this.$inertia.post(route('objectives.store'), this.form_createObjective, {
                onSuccess: () => {
                    this.closeCreateModalObjective();
                    // Vous pouvez ajouter des actions supplémentaires ici, comme rafraîchir les données
                },
            });
        },
        //edit
        openEditObjectiveModal(objective) {
            this.selectedObjectiveForEdit = objective;
            this.form_editObjective = { ...objective };
            this.isOpenEditObjective = true;
        },
        closeEditModalObjective() {
            this.isOpenEditObjective = false;
        },
        editObjective() {
            console.log(this.form_editObjective);
            // Implémentez la logique d'envoi ici
            // Assurez-vous d'utiliser l'ID de selectedObjectiveForEdit pour la mise à jour
            this.$inertia.put(route('objectives.update', this.selectedObjectiveForEdit.id), this.form_editObjective, {
                onSuccess: () => {
                    this.closeEditModalObjective();
                    // Mettez à jour l'UI ou rafraîchissez les données si nécessaire
                },
            });
        },
        //delete
        deleteObjective() {
            if (!confirm("Are you sure you want to delete this objective?")) return;

            this.$inertia.delete(route('objectives.destroy', this.selectedObjectiveForEdit.id), {
                onSuccess: () => {
                    this.closeEditModalObjective();
                },
            });
        },



        //Subobjectives
        openCreateSubobjectiveModal(objective) {
            this.form_createSubobjective.objective_id = objective.id;
            this.isOpenCreateSubobjective = true;
        },
        closeCreateModalSubobjective() {
            this.isOpenCreateSubobjective = false;
            this.resetCreateFormSubobjective();
        },
        resetCreateFormSubobjective() {
            this.form_createSubobjective = {
                name: null,
                description: null,
                objective_id: null,
            };
        },
        createSubobjective() {
            console.log(this.form_createSubobjective);
            // Implémentez la logique d'envoi ici, similaire à createObjective
            this.$inertia.post(route('subobjectives.store'), this.form_createSubobjective, {
                onSuccess: () => {
                    this.closeCreateModalSubobjective();
                    // Actions supplémentaires après la création
                },
            });
        },
        //edit
        openEditSubobjectiveModal(subobjective) {
            this.selectedSubobjectiveForEdit = subobjective;
            this.form_editSubobjective = { ...subobjective };
            this.isOpenEditSubobjective = true;
        },
        closeEditModalSubobjective() {
            this.isOpenEditSubobjective = false;
        },
        editSubobjective() {
            console.log(this.form_editSubobjective);
            // Implémentez la logique d'envoi ici, en utilisant par exemple this.$inertia.put ou post
            this.$inertia.put(route('subobjectives.update', this.selectedSubobjectiveForEdit.id), this.form_editSubobjective, {
                onSuccess: () => {
                    this.closeEditModalSubobjective();
                    // Mettez à jour l'UI ou rafraîchissez les données si nécessaire
                },
            });
        },
        //delete
        deleteSubobjective() {
            if (!confirm("Are you sure you want to delete this subobjective?")) return;

            this.$inertia.delete(route('subobjectives.destroy', this.selectedSubobjectiveForEdit.id), {
                onSuccess: () => {
                    this.closeEditModalSubobjective();
                },
            });
        },
    },

    watch: {
    },
}
</script>
