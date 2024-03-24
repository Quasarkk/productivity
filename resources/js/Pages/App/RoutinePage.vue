<template>
    <AppLayoutVertical>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-8">Routines</h2>
            <BaseButton variant="primary" @click="openModal()">Create a routine</BaseButton>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Dynamically create routine cards -->
                <div v-for="routine in routines" :key="routine.id"
                    class="bg-white rounded-lg shadow overflow-hidden p-4 my-4">
                    <div class="flex flex-col">
                        <div class="flex justify-between">
                            <BaseButton variant="" @click="edit(routine)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                    <path d="M13.5 6.5l4 4" />
                                </svg>
                            </BaseButton>
                        </div>
                        <p>{{ routine.name }}</p>
                        <div class="flex-wrap flex my-2">
                            <span v-for="day in routine.frequency" :key="day" class="mr-1">{{ day }}</span>
                        </div>
                        <p v-if="routine.subobjective">Subobjective: {{ routine.subobjective.name }}</p>
                        <div v-if="routine.begin_hour">
                            {{ routine.begin_hour }} - {{ routine.end_hour }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Modal :is-open="isModalOpen" :title="modalTitle" @close="closeModal">
            <!-- Dynamic form content for creating or editing routines -->
            <div class="mt-3">
                <label class="block font-medium text-gray-700 capitalize">Name</label>
                <input
                    class="block mt-1 w-full rounded-md border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm"
                    v-model="currentForm.name" type="text">

                <!-- Frequency -->
                <label class="block mt-3 font-medium text-gray-700 capitalize-first">Frequency</label>
                <div class="flex items-center" v-for="day in days" :key="day">
                    <input class="rounded mr-1 focus:ring-0 focus:ring-offset-0" type="checkbox"
                        v-model="currentForm.frequency" :value="day">
                    <label class="capitalize-first">{{ day }}</label>
                </div>

                <!-- Subobjective -->
                <div class="mt-3">
                    <label class="block font-medium text-gray-700 capitalize-first">Subobjective</label>
                    <select
                        class="block mt-1 rounded-md border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm"
                        v-model="currentForm.subobjective_id">
                        <option v-for="subobjective in subobjectives" :key="subobjective.id" :value="subobjective.id">
                            {{ subobjective.name }} </option>
                    </select>
                </div>

                <!-- Begin and End Hours -->
                <div class="mt-3 flex">
                    <!-- Begin hour -->
                    <div class="mr-16">
                        <label class="block font-medium text-gray-700 capitalize-first">Begin hour</label>
                        <input v-model="currentForm.begin_hour" type="time"
                            class="rounded-md border-gray-300 shadow-sm">
                    </div>
                    <!-- End hour -->
                    <div>
                        <label class="block font-medium text-gray-700 capitalize-first">End hour</label>
                        <input v-model="currentForm.end_hour" type="time" class="rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>
            </div>

            <!-- Modal footer with action buttons -->
            <template v-slot:footer>
                <BaseButton variant="primary" @click="handleSubmit">
                    {{ modalActionText }}
                </BaseButton>
                <!-- Display Delete button only in edit mode -->
                <BaseButton v-if="isEditMode" variant="primary" @click="deleteCurrentRoutine">
                    Delete
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
        routines: Array,
        subobjectives: Array,
    },
    data() {
        return {
            days: ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
            isModalOpen: false,
            isEditMode: false,
            modalTitle: '',
            modalActionText: '',
            currentForm: {
                name: '',
                frequency: [],
                subobjective_id: null,
                begin_hour: '',
                end_hour: '',
            },
            selectedRoutine: null,
        };
    },
    methods: {
        openModal(routine = null) {
            this.isModalOpen = true;
            if (routine) {
                this.isEditMode = true;
                this.modalTitle = 'Edit Routine';
                this.modalActionText = 'Update';
                this.currentForm = { ...routine };
                this.selectedRoutine = routine;
            } else {
                this.isEditMode = false;
                this.modalTitle = 'Create Routine';
                this.modalActionText = 'Create';
                this.resetForm();
                this.selectedRoutine = null;
            }
        },
        closeModal() {
            this.isModalOpen = false;
            this.resetForm();
            this.selectedRoutine = null;
        },
        handleSubmit() {
            if (this.isEditMode && this.selectedRoutine) {
                this.$inertia.put(route('routines.update', { id: this.selectedRoutine.id }), this.currentForm, {
                    onSuccess: () => {
                        this.closeModal();
                    },
                });
            } else {
                this.$inertia.post(route('routines.store'), this.currentForm, {
                    onSuccess: () => {
                        this.closeModal();
                    },
                });
            }
        },
        deleteCurrentRoutine() {
            this.$inertia.delete(route('routines.destroy', { id: this.selectedRoutine.id }), {
                    onSuccess: () => {
                        this.closeModal();
                    },
                });
        },
        resetForm() {
            this.currentForm = {
                name: '',
                frequency: [],
                subobjective_id: null,
                begin_hour: '',
                end_hour: '',
            };
        },
        edit(routine) {
            this.openModal(routine);
        },
        create() {
            this.openModal();
        },
    },
};
</script>
