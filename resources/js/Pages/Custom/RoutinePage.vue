<template>
    <AppLayoutVertical>
        <h1>Routines</h1>
        <button @click="isOpenCreate = true" class="py-2 px-1  bg-red-400 rounded">Create a routine</button>

        <div class="flex flex-wrap justify-between my-8 mx-4">
            <div v-for="routine in routines" :key="routine.id" class="bg-orange-200 w-80 rounded p-4 my-4">
                <div class="flex flex-col">
                    <div class="flex justify-between">
                        <button @click="edit(routine)"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg></button>
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

        <!-- MODALE CREATE -->
        <div v-if="isOpenCreate"
            class="fixed top-0 bg-black/20 w-full h-full justify-center flex backdrop-blur-md overflow-auto">
            <!-- CREATE CARD -->
            <div class=" w-6/12 p-6 bg-white my-auto rounded-lg">
                <!-- CLOSE BUTTONS -->
                <div class="flex items-center justify-end mb-3">
                    <button @click="closeCreateModale" class="">
                        <svg class="w-6 h-6  fill-red-700 hover:fill-red-600" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 48 48">
                            <path
                                d="M 38.982422 6.9707031 A 2.0002 2.0002 0 0 0 37.585938 7.5859375 L 24 21.171875 L 10.414062 7.5859375 A 2.0002 2.0002 0 0 0 8.9785156 6.9804688 A 2.0002 2.0002 0 0 0 7.5859375 10.414062 L 21.171875 24 L 7.5859375 37.585938 A 2.0002 2.0002 0 1 0 10.414062 40.414062 L 24 26.828125 L 37.585938 40.414062 A 2.0002 2.0002 0 1 0 40.414062 37.585938 L 26.828125 24 L 40.414062 10.414062 A 2.0002 2.0002 0 0 0 38.982422 6.9707031 z" />
                        </svg>
                    </button>
                </div>
                <p>Create a routine</p>
                <!-- NAME -->
                <div class="mt-3">
                    <!-- <div v-if="errors.name" class="text-red-700 text-lg mx-auto flex justify-center">{{ errors.name }}
                    </div> -->
                    <label class="block font-medium text-gray-700 capitalize">Name</label>
                    <input
                        class="block mt-1 w-full rounded-md border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm"
                        v-model="form_create.name" type="text">
                </div>

                <!-- FREQUENCY -->
                <label class="block  mt-3 font-medium text-gray-700 capitalize-first">Frequency</label>
                <div class="flex items-center" v-for="day in days" :key="day">
                    <input class="rounded mr-1 focus:ring-0 focus:ring-offset-0" type="checkbox"
                        v-model="form_create.frequency" :value="day">
                    <label class="capitalize-first">{{ day }}</label>
                </div>

                <!-- SUBOBJECTIVE -->
                <div class="mt-3">
                    <label class="block font-medium text-gray-700 capitalize-first">Subobjective</label>
                    <select
                        class="block mt-1 rounded-md border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm"
                        v-model="form_create.subobjective_id">
                        <option v-for="subobjective in subobjectives" :key="subobjective.id" :value="subobjective.id">
                            {{ subobjective.name }} </option>
                    </select>
                </div>

                <!-- BEGIN AND END HOURS -->
                <div class="mt-3 flex">
                    <!-- Begin -->
                    <div class="mr-16">
                        <label class="block font-medium text-gray-700 capitalize-first">Begin hour</label>
                        <input v-model="form_create.begin_hour" type="time">
                    </div>
                    <!-- END -->
                    <div class="">
                        <label class="block font-medium text-gray-700 capitalize-first">End hour</label>
                        <input v-model="form_create.end_hour" type="time">
                    </div>
                </div>

                <!-- CREATE BUTTON  -->
                <button @click="create(form_create)"
                    class="mt-4 rounded border focus:ring-cyan-500 focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-50 active:bg-cyan-900 bg-cyan-800 hover:bg-cyan-700 font-medium w-full text-white px-2 py-1 uppercase">
                    Create a routine</button>

            </div>
        </div>

        <!-- MODALE EDIT -->
        <div v-if="isOpenEdit"
            class="fixed top-0 bg-black/20 w-full h-full justify-center flex backdrop-blur-md overflow-auto">
            <!-- EDIT CARD -->
            <div class=" w-6/12 p-6 bg-white my-auto rounded-lg">
                <!-- CLOSE BUTTONS -->
                <div class="flex justify-between mb-3">
                    <button @click="destroy(selectedRoutine)"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg></button>
                    <button @click="closeEditModale" class=""><svg class="w-6 h-6  fill-red-700 hover:fill-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path
                                d="M 38.982422 6.9707031 A 2.0002 2.0002 0 0 0 37.585938 7.5859375 L 24 21.171875 L 10.414062 7.5859375 A 2.0002 2.0002 0 0 0 8.9785156 6.9804688 A 2.0002 2.0002 0 0 0 7.5859375 10.414062 L 21.171875 24 L 7.5859375 37.585938 A 2.0002 2.0002 0 1 0 10.414062 40.414062 L 24 26.828125 L 37.585938 40.414062 A 2.0002 2.0002 0 1 0 40.414062 37.585938 L 26.828125 24 L 40.414062 10.414062 A 2.0002 2.0002 0 0 0 38.982422 6.9707031 z" />
                        </svg>
                    </button>
                </div>
                <p>Create a routine</p>
                <!-- NAME -->
                <div class="mt-3">
                    <label class="block font-medium text-gray-700 capitalize">Name</label>
                    <input
                        class="block mt-1 w-full rounded-md border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm"
                        v-model="form_update.name" type="text">
                </div>

                <!-- FREQUENCY -->
                <label class="block  mt-3 font-medium text-gray-700 capitalize-first">Frequency</label>
                <div class="flex items-center" v-for="day in days" :key="day">
                    <input class="rounded mr-1 focus:ring-0 focus:ring-offset-0" type="checkbox"
                        v-model="form_update.frequency" :value="day">
                    <label class="capitalize-first">{{ day }}</label>
                </div>

                <!-- SUBOBJECTIVE -->
                <div class="mt-3">
                    <label class="block font-medium text-gray-700 capitalize-first">Subobjective</label>
                    <select
                        class="block mt-1 rounded-md border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm"
                        v-model="form_update.subobjective_id">
                        <option v-for="subobjective in subobjectives" :key="subobjective.id" :value="subobjective.id">
                            {{ subobjective.name }} </option>
                    </select>
                </div>

                <!-- BEGIN AND END HOURS -->
                <div class="mt-3 flex">
                    <!-- Begin -->
                    <div class="mr-16">
                        <label class="block font-medium text-gray-700 capitalize-first">Begin hour</label>
                        <input v-model="form_update.begin_hour" type="time">
                    </div>
                    <!-- END -->
                    <div class="">
                        <label class="block font-medium text-gray-700 capitalize-first">End hour</label>
                        <input v-model="form_update.end_hour" type="time">
                    </div>
                </div>

                <!-- UPDATE BUTTON  -->
                <button @click="update(form_update)"
                    class="mt-4 rounded border focus:ring-cyan-500 focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-50 active:bg-cyan-900 bg-cyan-800 hover:bg-cyan-700 font-medium w-full text-white px-2 py-1 uppercase">
                    Update this routine
                </button>
            </div>
        </div>


    </AppLayoutVertical>
</template>

<script>
import AppLayoutVertical from '@/Layouts/AppLayoutVertical.vue';

export default {
    props: {
        routines: Array,
        subobjectives: Array,
    },

    data() {
        return {
            days: ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
            isOpenCreate: false,
            isOpenEdit: false,
            selectedRoutine: null,
            form_create: {
                name: null,
                frequency: [],
                subobjective_id: [],
                begin_hour: null,
                end_hour: null,
            },
            form_update: {
                name: null,
                frequency: [],
                subobjective_id: [],
                begin_hour: null,
                end_hour: null,
            },
        }
    },

    watch: {
        selectedRoutine: {
            handler() {
                if (this.selectedRoutine) {
                    this.form_update.name = this.selectedRoutine.name;
                    this.form_update.frequency = this.selectedRoutine.frequency;
                    this.form_update.subobjective_id = this.selectedRoutine.subobjective_id;
                    this.form_update.begin_hour = this.selectedRoutine.begin_hour;
                }
            },
            deep: true,
            immediate: true
        }
    },
    components: {
        AppLayoutVertical,
    },
    methods: {
        closeCreateModale() {
            this.resetCreateForm();
            this.isOpenCreate = false;
        },
        closeEditModale() {
            this.isOpenEdit = false;
            this.resetUpdateForm();
        },
        resetCreateForm() {
            // reinitialize form
            // this.form_create.title = null;
            // this.form_create.content = null;
            // this.form_create.type = null;
            // this.form_create.url = null;
            // this.form_create.publication_date = null;
            // this.form_create.begin_date = null;
            // this.form_create.end_date = null;
            // this.form_create.status = null;
            // this.form_create.tags = [];

            // // reinitialize errors
            // this.errors.title = null;
            // this.errors.content = null;
            // this.errors.type = null;
            // this.errors.url = null;
            // this.errors.publication_date = null;
            // this.errors.begin_date = null;
            // this.errors.end_date = null;
            // this.errors.status = null;
            // this.errors.tags = null;
        },
        resetUpdateForm() {
        },
        edit(routine) {
            this.selectedRoutine = routine;
            this.isOpenEdit = true;
        },

        create() {
            this.$inertia.post(route('routines.store'), this.form_create, {
                onSuccess: () => this.isOpenCreate = false,
            })
        },
        update() {
            this.$inertia.put(route('routines.update', { routine: this.selectedRoutine.id }), this.form_update, {
                onSuccess: () => this.isOpenEdit = false,
            })
        },
        destroy(routine) {
            this.isOpenEdit = false;
            this.$inertia.delete(route('routines.destroy', routine));
        },
    },
}

</script>
