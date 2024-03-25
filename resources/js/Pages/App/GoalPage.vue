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
                                <BaseButton variant="icon-blue" @click="editItem('pillar', pillar)"
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
                            <BaseButton variant="primary" @click="createItem('subpillar', pillar)"
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
                                <BaseButton variant="" @click="editItem('subpillar', subpillar)"
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
                            <BaseButton variant="orange" @click="createItem('objective', subpillar)"
                                class="opacity-0 group-hover:opacity-100">
                                Ajouter Objectif +
                            </BaseButton>

                            <!-- Objectives -->
                            <div v-for="objective in subpillar.objectives" :key="objective.id"
                                class="bg-yellow-100 rounded-md p-3 my-3 shadow-inner group w-full">
                                <div class="flex">
                                    <h4 class="font-medium text-gray-900">{{ objective.name }}</h4>
                                    <button @click="editItem('objective', objective)"
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
                                <BaseButton variant="yellow" @click="createItem('subobjective', objective)"
                                    class="opacity-0 group-hover:opacity-100">
                                    Ajouter Sous-Objectif +
                                </BaseButton>
                                <!-- Subobjectives -->
                                <div v-for="subobjective in objective.subobjectives" :key="subobjective.id"
                                    class="bg-green-100 rounded-md p-2 my-2">

                                    <div class="flex">
                                        <h5 class="font-medium text-gray-900">{{ subobjective.name }}</h5>
                                        <button @click="editItem('subobjective', subobjective)"
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
                <BaseButton variant="primary" @click="createItem('pillar', pillar)">
                    Ajouter Pilier +
                </BaseButton>
            </div>
        </div>
        <Modal :is-open="isModalOpen" :title="modalTitle" @close="closeModal">
            <div class="mt-3">
              <!-- Name Field -->
              <label class="block font-medium text-gray-700">Nom</label>
              <input
                class="block mt-1 w-full rounded-md border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm"
                v-model="currentForm.name" type="text" />

              <!-- Description Field -->
              <label class="block mt-3 font-medium text-gray-700">Description</label>
              <textarea
                class="block mt-1 w-full rounded-md border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm"
                v-model="currentForm.description"></textarea>

              <!-- Deadline Field - Conditionally Displayed -->
              <div v-if="modalType === 'objective' || modalType === 'subobjective'">
                <label class="block mt-3 font-medium text-gray-700">Date limite</label>
                <input
                  class="block mt-1 w-full rounded-md border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm"
                  v-model="currentForm.deadline" type="date" />
              </div>
            </div>

            <!-- Modal Footer -->
            <template v-slot:footer>
              <BaseButton variant="primary" @click="handleSubmit">
                {{ currentAction === 'edit' ? 'Sauvegarder' : 'Créer' }}
              </BaseButton>
            </template>
          </Modal>

    </AppLayoutVertical>
</template>

<script>
import AppLayoutVertical from '@/Layouts/AppLayoutVertical.vue';
import BaseButton from '@/Components/Custom/BaseButton.vue';
import Modal from '@/Components/Custom/Modal.vue';

export default {
    components: {
        AppLayoutVertical,
        BaseButton,
        Modal,
    },
    props: {
        pillars: Array,
        subpillars: Array,
        objectives: Array,
        subobjectives: Array,
    },
    data() {
        return {
            isModalOpen: false,
            modalType: '',
            currentForm: {
                id: null,
                name: '',
                description: '',
                deadline: null,
                pillar_id: null,
                subpillar_id: null,
                objective_id: null,
            },
            currentAction: '',
        };
    },
    methods: {
        openModal(type, action, item = {}) {
      this.isModalOpen = true;
      this.modalType = type;
      this.currentAction = action;
      this.currentForm = { ...item };

      // Format the deadline if it exists and this is a subobjective being edited
      if (type === 'subobjective' && action === 'edit' && item.deadline) {
        // Supposons que item.deadline est une chaîne de caractères au format 'YYYY-MM-DD HH:MM:SS'
        // et nous avons besoin seulement de 'YYYY-MM-DD'
        const dateParts = item.deadline.split(' ')[0];
        this.currentForm.deadline = dateParts;
      }

      // Set the correct parent ID based on the modalType
      if (type === 'subpillar') {
        this.currentForm.pillar_id = item.pillar_id || null;
      } else if (type === 'objective') {
        this.currentForm.subpillar_id = item.subpillar_id || null;
      } else if (type === 'subobjective') {
        this.currentForm.objective_id = item.objective_id || null;
      }
    },


        closeModal() {
            this.isModalOpen = false;
            this.resetForm();
        },
        resetForm() {
            this.currentForm = {
                id: null,
                name: '',
                description: '',
                deadline: null,
                pillar_id: null,
                subpillar_id: null,
                objective_id: null,
            };
        },
        handleSubmit() {
            let routeName = '';
            const isEdit = this.currentAction === 'edit';

            switch (this.modalType) {
                case 'pillar':
                    routeName = isEdit ? 'pillars.update' : 'pillars.store';
                    break;
                case 'subpillar':
                    routeName = isEdit ? 'subpillars.update' : 'subpillars.store';
                    break;
                case 'objective':
                    routeName = isEdit ? 'objectives.update' : 'objectives.store';
                    break;
                case 'subobjective':
                    routeName = isEdit ? 'subobjectives.update' : 'subobjectives.store';
                    break;
            }

            const formData = { ...this.currentForm };
            // Assurez-vous que routeParams est bien formaté pour les besoins de votre backend, particulièrement pour les mises à jour.
            const routeParams = isEdit ? { id: this.currentForm.id } : {};

            // Determine if we're editing (PUT) or creating (POST)
            if (isEdit) {
                // For updates
                this.$inertia.put(this.route(routeName, routeParams), formData, {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeModal();
                        // Add any additional success handling
                    },
                    onError: errors => {
                        console.error('Form submission error:', errors);
                    }
                });
            } else {
                // For creations
                this.$inertia.post(this.route(routeName), formData, {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeModal();
                        // Add any additional success handling
                    },
                    onError: errors => {
                        console.error('Form submission error:', errors);
                    }
                });
            }
        },

        createItem(type, item = {}) {
      // On crée un nouvel objet pour le formulaire avec les attributs requis
      const newForm = {
        id: null,
        name: '',
        description: '',
        // On n'inclut pas deadline par défaut
      };

      // On ajoute les attributs parents selon le type d'élément
      if (type === 'subpillar') {
        newForm.pillar_id = item.id;
      } else if (type === 'objective') {
        newForm.subpillar_id = item.id;
      } else if (type === 'subobjective') {
        newForm.objective_id = item.id;
        // Pour les sous-objectifs, on inclut aussi la deadline
        newForm.deadline = '';
      }

      this.openModal(type, 'create', newForm);
    },
        editItem(type, item) {
            this.openModal(type, 'edit', item);
        },
        // Include methods for deleting items if necessary
    },
};
</script>
