<template>
    <button :class="buttonClass" @click="onClick">
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: 'BaseButton',
    props: {
        isDailyPlanning: Boolean,
        isWeeklyPlanning: Boolean,
        isMonthlyPlanning: Boolean,
        variant: {
            type: String,
            default: 'primary'
        }
    },
    computed: {
        buttonClass() {
            switch (this.variant) {
                case 'primary':
                    return 'px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600';

                // Calendar
                case 'Monthly':
                    return {
                        'px-4 py-2 text-gray-800 rounded shadow transition duration-150 ease-in-out': true,
                        'bg-blue-100 border border-blue-500 text-blue-800': this.isMonthlyPlanning,
                        'hover:bg-gray-200': !this.isMonthlyPlanning,
                    };
                case 'Weekly':
                    return {
                        'px-4 py-2 text-gray-800 rounded shadow transition duration-150 ease-in-out': true,
                        'bg-blue-100 border border-blue-500 text-blue-800': this.isWeeklyPlanning,
                        'hover:bg-gray-200': !this.isWeeklyPlanning,
                    };
                case 'Daily':
                    return {
                        'px-4 py-2 text-gray-800 rounded shadow transition duration-150 ease-in-out': true,
                        'bg-blue-100 border border-blue-500 text-blue-800': this.isDailyPlanning,
                        'hover:bg-gray-200': !this.isDailyPlanning,
                    };

                // Goal Page
                case 'icon-blue':
                    return 'text-indigo-600 hover:text-indigo-900';

                case 'orange':
                    return 'px-4 py-2 text-white bg-orange-400 border-orange-600 border-2 rounded hover:bg-orange-600';

                case 'yellow':
                    return 'px-4 py-2 text-white bg-yellow-500 border-yellow-700 border-2 rounded hover:bg-yellow-600';

                default:
                    return '';
            }
        }
    },
    methods: {
        onClick(event) {
            this.$emit('click', event);
        }
    }
};
</script>
